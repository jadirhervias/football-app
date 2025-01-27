# Setup project

## Requirements:
  - Composer (v2.7.7 o mayor)
  - Docker (v27.4.0 o mayor)
  - Node (v22.12.0 o mayor)
  - NPM (v10.9.0 o mayor)

## Setup all at once using Node

```bash
node setup.js
```

## User credentials for test:
```json
{
    "email": "admin@example.com",
    "password": "password"
}
```

> Download [API Postman collection](./football-api/etc/LARAVEL-FOOTBALL-API.postman_collection.json)

> Laravel API Server: http://localhost:6000

> Local Vue SPA: http://localhost:5173

## Considerations about my proposed solution:
- `DDD` approach to isolate Domain logic from Laravel framework.
- `SOLID principles`, `Hexagonal Architecture` and `Design Patterns` like Repository Pattern.
- [Laravel Sail](https://laravel.com/docs/11.x/sail) package to simplify API setup (Sail uses `docker` and [docker-compose](./football-api/docker-compose.yml)).
- Laravel API [.env](./football-api/.env) file published in GitHub repo for local setup simplicity.
- `Monorepo` approach with a [setup.js](./setup.js) script file that helps to start the app.
- `SQLite database` for simplicity during local development.
- Laravel [migrations](https://laravel.com/docs/11.x/migrations) and [seeding](https://laravel.com/docs/11.x/seeding) to let database ready.
- Automatically seed database `Teams` and `Players` data when `Competitions` are fetched from the external [Football API](https://www.football-data.org).
- [Laravel Passport](https://laravel.com/docs/11.x/passport) to issue `short-lived access tokens` via the `password grant strategy`, this helps to simplify stateless authentication without affecting security aspects.
- Use of [Spatie laravel-permission package](https://spatie.be/docs/laravel-permission/v6/introduction) to handle `ACL strategy` for user roles and permissions.
- The [API project](./football-api) in this monorepo follows the Hexagonal Architecture pattern. Also, it's structured using `modules`.
With this, we can see that the current structure inside `src` directory is:

```scala
$ tree -L 4 src

src
|-- Team // Some Module
|   |-- Application
|   |   |-- Create // Inside the application layer all is structured by actions
|   |   |   |-- CreateTeamRequest.php
|   |   |   `-- TeamCreator.php
|   |   |-- Find
|   |   `-- FindAll
|   |-- Domain
|   |   |-- Team.php // The Aggregate of the Module
|   |   |-- TeamNotExists.php // A Domain error
|   |   `-- TeamsRepository.php // The `Interface` of the repository is inside Domain
|   `-- Infrastructure // The infrastructure of our module
|       |-- FootballApi
|       `-- Persistence
|           `-- Eloquent
|               `--EloquentTeamsRepository.php // An implementation of the repository
`-- Shared // Shared Kernel: Common infrastructure and domain shared between the different modules
    |-- Domain
    `-- Infrastructure
```

## Setup Laravel API manually

```bash
# Place in the API root directory
cd football-api

# Install dependencies
composer install

# Create database.sqlite file
touch database/database.sqlite

# For Linux with Docker Desktop (Optional)
docker context use default

# Start backend services
./vendor/bin/sail up --build -d

# Once docker services are up, run migrations and seed database
./vendor/bin/sail php artisan migrate --seed

# Configure passport
./vendor/bin/sail php artisan passport:client --password --name="Default Password Grant Client" --quiet
```

## Setup Vue SPA manually

```bash
# Place in the Vue SPA root directory
cd football-spa

npm i

npm run dev
```