# Setup project

## Backend

- Requirements:
    - Composer
    - Laravel 11
    - PHP 8.4

#### Run services
```bash
# Place in the API root directory
cd football-api

# Install dependencies
composer install

# Create database.sqlite file
touch database/database.sqlite

# For Linux with Docker Desktop (Optional)
docker context use default

# Create sail alias (Optional)
alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'

# Start backend services
#./vendor/bin/sail up
./vendor/bin/sail up --build

# Run migrations
./vendor/bin/sail php artisan migrate --seed

# Configure passport
./vendor/bin/sail php artisan passport:client --password
# Set env vars...
# PASSPORT_PASSWORD_CLIENT_ID=
# PASSPORT_PASSWORD_CLIENT_SECRET=

./vendor/bin/sail php artisan passport:keys
```

## Frontend

- Requirements:
    - Node
    - NPM

#### Follow the steps
```bash
# Place in the SPA root directory
cd football-api

# Install dependencies
npm i

# Run project in dev mode
npm run dev
```