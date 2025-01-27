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

> Open [Vue SPA link](http://localhost:5173)

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