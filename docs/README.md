# Football League Application

This is a football league web application built with Laravel.

## Features

- Matchday live scores and fixtures
- Team and player profiles
- Real-time notifications for user-selected clubs
- AI-powered match summaries and stats
- Fantasy football module with AI recommendations

## Tech Stack

- Frontend: Laravel Livewire with Tailwind CSS v4
- Backend: Laravel 12 & Filament Admin v4
- Database: SQLite
- Real-time: Laravel Reverb

## Requirements

- PHP 8.2+
- Composer
- Node.js 18+
- NPM

## Installation

1. Clone the repository
2. Run `composer install`
3. Run `npm install`
4. Copy `.env.example` to `.env` and configure your database
5. Run `php artisan key:generate`
6. Run `php artisan migrate`
7. Run `npm run dev` to compile assets

## Testing

Run tests with `php artisan test`

## Code Quality

Run code formatting with `./vendor/bin/pint`
Run static analysis with `./vendor/bin/phpstan analyse`