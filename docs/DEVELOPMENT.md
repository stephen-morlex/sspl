# Development Environment Configuration

This file contains configuration for development tools and environment setup.

## PHP Configuration

For development, ensure your PHP installation has the following extensions enabled:
- openssl
- pdo
- mbstring
- tokenizer
- xml
- ctype
- json
- fileinfo

## Database Configuration

For local development, SQLite is recommended. The database file will be created at:
`database/database.sqlite`

To use MySQL instead, update your .env file with:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=football_league
DB_USERNAME=root
DB_PASSWORD=
```

## Code Quality Tools

### Laravel Pint (Code Formatting)
Run `./vendor/bin/pint` to format your code according to Laravel standards.

Configuration file: `pint.json`

### PHPStan (Static Analysis)
Run `./vendor/bin/phpstan analyse` to perform static analysis.

Configuration file: `phpstan.neon`

### PHPUnit (Testing)
Run `php artisan test` to run all tests.

Configuration file: `phpunit.xml`

## IDE Configuration

### VS Code
Recommended extensions:
- PHP Intelephense
- Laravel Extra Intellisense
- Tailwind CSS IntelliSense
- EditorConfig for VS Code

### PHPStorm
- Enable Laravel plugin
- Enable .env files support

## Environment Variables

The following environment variables are important for development:

APP_ENV=local
APP_DEBUG=true
LOG_LEVEL=debug

## Asset Compilation

For development, run:
```
npm run dev
```

For production builds, run:
```
npm run build
```