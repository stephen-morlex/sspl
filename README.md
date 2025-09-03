# Football League Web Application

This is a football league web application built with Laravel that provides matchday live scores, team and player profiles, real-time notifications, AI-powered match summaries, and a fantasy football module.

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

## Documentation

- [Setup Guide](docs/SETUP.md) - Instructions for setting up the development environment
- [Development Guide](docs/DEVELOPMENT.md) - Information about development tools and workflow
- [API Documentation](docs/API.md) - API endpoints documentation (to be created)
- [Architecture](docs/ARCHITECTURE.md) - System architecture documentation (to be created)

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

## Development

### Code Quality

- Run code formatting with `./vendor/bin/pint`
- Run static analysis with `./vendor/bin/phpstan analyse`
- Run tests with `php artisan test`

### Testing

Run tests with `php artisan test`

## CI/CD

The project includes GitHub Actions workflows for continuous integration and deployment.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
##"Build a module that ingests match events (teams, score, timestamped key events) and uses an LLM to generate concise and accurate match summaries. Start with a prompt-based GPT-3.5 integration. Later, support structured input and explore fine-tuning for better reliability."
# sspl
