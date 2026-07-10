# Ally Pay Deployment Guide


## Server Requirements

- PHP >= 8.2
- MySQL
- Composer
- Supervisor
- Nginx / Apache


## Deployment Steps


Clone Repository


git clone repo-url


Install Dependencies


composer install --no-dev


Environment


cp .env.example .env


Generate Key


php artisan key:generate


Database


php artisan migrate --seed


Passport Setup


php artisan passport:keys


Optimization


php artisan optimize


Storage


php artisan storage:link


Queue Worker


php artisan queue:work


Production Permissions


storage/
bootstrap/cache/

should be writable.


## Supervisor

Run queue worker permanently using Supervisor.


## Security

- APP_DEBUG=false
- Secure database password
- HTTPS enabled
- Rotate API keys regularly