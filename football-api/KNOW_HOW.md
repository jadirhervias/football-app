# Setup project

- Requirements:
    - Composer
    - Laravel 11
    - PHP 8.4

#### Setup environment

```bash
# Create laravel project
composer global require laravel/installer

laravel new footballl-api

cd footballl-api
```

#### Setup application container using Docker for production (via Laravel Sail)
* See [Laravel docs - Sail](https://laravel.com/docs/11.x/sail#installation)

```bash
# Install composer dependencies
composer require laravel/sail --dev

# Publish docker-compose.yml file in the root if the application and enable volumes for develop inside the container
php artisan sail:install --with mailpit

# For Linux with Docker Desktop
docker context use default

# Create sail alias
alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'
```

#### Setup dev database using sqlite

```bash
touch database/database.sqlite

# .env file
DB_CONNECTION=sqlite
```

#### Run default migrations

```bash
sail php artisan migrate
```

#### Install Laravel Passport
```bash
sail php artisan install:api --passport
```
