# Setup Guide

## Prerequisites

- PHP 8.2 or higher
- Composer
- Node.js 18 or higher
- NPM

## Installation Steps

1. Clone the repository:
   ```
   git clone <repository-url>
   cd football-league-app
   ```

2. Install PHP dependencies:
   ```
   composer install
   ```

3. Install Node dependencies:
   ```
   npm install
   ```

4. Create environment file:
   ```
   cp .env.example .env
   ```

5. Generate application key:
   ```
   php artisan key:generate
   ```

6. Configure your database in the `.env` file

7. Run database migrations:
   ```
   php artisan migrate
   ```

8. Start the development server:
   ```
   php artisan serve
   ```

9. In another terminal, compile assets:
   ```
   npm run dev
   ```

## Development Workflow

1. Create a new branch for your feature:
   ```
   git checkout -b feature/your-feature-name
   ```

2. Make your changes

3. Run tests:
   ```
   php artisan test
   ```

4. Format your code:
   ```
   ./vendor/bin/pint
   ```

5. Run static analysis:
   ```
   ./vendor/bin/phpstan analyse
   ```

6. Commit your changes:
   ```
   git add .
   git commit -m "Description of changes"
   ```

7. Push to your branch:
   ```
   git push origin feature/your-feature-name
   ```

8. Create a pull request