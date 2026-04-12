# ChMS (Church Management System)

Laravel 12 + PHP 8.2 + MySQL + TailwindCSS v4

## Commands

```bash
# Full dev environment (PHP server + queue + logs + Vite)
composer run dev

# Run tests
composer test
# or: php artisan test

# Linting (Laravel Pint)
./vendor/bin/pint

# Build assets
npm run build
```

## Setup

Initial setup: `php artisan app:setup` (creates database, runs migrations, seeds)

## Architecture

- **Menu System**: Add menus in `app/Libraries/Menus/` with `getActions()` and `getOrder()` methods; add translations in `lang/`
- **Services**: Business logic in `app/Services/`
- **Models**: Eloquent models in `app/Models/`

## Testing

Tests use SQLite in-memory (configured in phpunit.xml). Run individual tests: `./vendor/bin/phpunit --filter TestName`

## Notes

- Default locale is Indonesian (`id`) - check `lang/id.json`
- Telescope enabled locally for debugging
- Queue uses database driver