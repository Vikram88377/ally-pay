# Ally Pay

Ally Pay is an enterprise-level payment gateway and wallet platform built with Laravel 12.

## Features

- Laravel Passport authentication
- Admin, merchant and customer roles
- Wallet credit, debit and transfer
- Merchant onboarding and approval
- Merchant API keys
- Payment order creation and verification
- Webhooks with queues and retry
- Admin web dashboard
- Merchant web dashboard
- Audit logs
- Reports and CSV export
- Rate limiting
- Policies and secure API credentials
- Traits, helpers and custom exceptions

## Tech Stack

- Laravel 12
- PHP 8.2+
- MySQL
- Laravel Passport
- Spatie Laravel Permission
- Bootstrap 5
- Database Queue

## Installation

```bash
git clone YOUR_REPOSITORY_URL
cd ally-pay
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan passport:install
php artisan serve