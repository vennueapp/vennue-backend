# Prerequisites
Docker Desktop running Docker Engine >= V20

# Setup

## 1. Copy base files
### These files differ per environment, the .dev variants provide dev-ready versions
```bash
$ cp code/.env.dev code/.env # Copy the Laravel dotenv dev base
$ cp .env.dev .env # Copy the Docker compose dotenv dev base
$ cp docker-compose.yml.dev docker-compose.yml # Copy the Docker compose spec dev base
```

## 2. Build images
```bash
$ docker compose build # Builds images as specified in docker-compose.yml
```

## 3. Up container network
```bash
$ docker compose up -d # -d 'detached' Ups the network in the background
```

## 4. Init Laravel
```bash
$ docker compose exec workspace sh # Open a shell inside the workspace container
```
```sh
$ composer install # Install the packages specified by composer.json
$ php artisan migrate # Run the database migrations
$ php artisan key:generate # Generate the application key
$ php artisan pasport:install # Generate Passport keys and clients
```
