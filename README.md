# Setup project

## User credentials for test:
```json
{
    "email": "admin@example.com",
    "password": "password"
}
```

## Backend

- Requirements:
    - Composer
    - Docker

> Download [Postman collection](./football-api/etc/LARAVEL-FOOTBALL-API.postman_collection.json)

#### Follow the steps
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
```
#### Open a new terminal and follow the next steps

```bash
# Run migrations
./vendor/bin/sail php artisan migrate --seed

# Configure passport
./vendor/bin/sail php artisan passport:client --password
# Set env vars with the results...
# PASSPORT_PASSWORD_CLIENT_ID=
# PASSPORT_PASSWORD_CLIENT_SECRET=

./vendor/bin/sail php artisan passport:keys
```

## Frontend

- Requirements:
    - Node
    - NPM

> Open [Vue app link](http://localhost:5173) 

#### Follow the steps
```bash
npm i

npm run dev
```