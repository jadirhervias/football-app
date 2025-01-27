const { exec, spawn } = require("child_process");
const path = require("path");
const os = require('os');

const LARAVEL_API_DIR = path.join(__dirname, "football-api");
const VUE_SPA_DIR = path.join(__dirname, "football-spa");

// Function to run a shell command and wait for the result
async function runCommand(command, options = {}) {
    return new Promise((resolve, reject) => {
        const cmd = spawn(command, { shell: true, stdio: "inherit", ...options });

        cmd.on("exit", (code) => {
            if (code === 0) resolve();
            else reject(new Error('Command "' + command + '" failed with code ' + code));
        });
    });
}

// Function to wait until a process (Sail) starts running
async function waitForSail() {
    return new Promise((resolve, reject) => {
        const interval = setInterval(() => {
            exec('docker ps', (error, stdout) => {
                if (stdout.includes('football-api')) {
                    clearInterval(interval);
                    resolve();
                }
            });
        }, 2000); // Check every 2 seconds
    });
}

async function setup() {
    try {
        console.log("\n########## INIT LARAVEL API SETUP ##########\n");

        console.log("Moving to api directory...");
        process.chdir(LARAVEL_API_DIR);

        console.log("Installing dependencies...");
        await runCommand("composer install");

        console.log("Creating SQLite database file...");
        await runCommand("touch database/database.sqlite");

        // Check for Linux platform and set Docker context if needed
        if (os.platform() === 'linux') {
            console.log('Setting Docker context for Linux...');
            await runCommand('docker context use default');
        }

        console.log("Starting Docker services...");
        const sailProcess = spawn("./vendor/bin/sail up --build -d", { shell: true });

        // Wait until the containers are up
        console.log("Waiting for Docker containers to start...");
        await waitForSail();

        console.log("Running migrations and seeding database...");
        await runCommand("./vendor/bin/sail php artisan migrate --seed");

        console.log("Configuring Laravel Passport...");
        await runCommand('./vendor/bin/sail php artisan passport:client --password --name="Default Password Grant Client" --quiet');

        const apiPort = process.env.APP_PORT || 6000;
        const apiUrl = "http://localhost:" + apiPort;

        console.log("\n\t\tLaravel API setup completed!");
        console.log("\n\t\tLocal API server: " + apiUrl + "\n");

        console.log("\n########## INIT VUE SPA SETUP ##########\n\n");

        console.log("Moving to Vue SPA directory...");
        process.chdir(VUE_SPA_DIR);

        console.log("Install dependencies...");
        await runCommand('npm install');

        console.log("Start development server...");
        await runCommand('npm run dev');

        // Listen for termination signals (CTRL + C)
        process.on("SIGINT", async () => {
            console.log("\nStopping Docker services...");
            await runCommand("./vendor/bin/sail down");
            process.exit(0);  // Clean exit
        });

        process.on("SIGTERM", async () => {
            console.log("\nStopping Docker services...");
            await runCommand("./vendor/bin/sail down");
            process.exit(0);  // Clean exit
        });

        // Keep the process alive to listen to user input
        sailProcess.stdout.pipe(process.stdout);
        sailProcess.stderr.pipe(process.stderr);
        sailProcess.on("close", (code) => {
            process.exit(code);
        });

    } catch (error) {
        console.error("Setup failed:", error.message);
        process.exit(1);
    }
}

setup();
