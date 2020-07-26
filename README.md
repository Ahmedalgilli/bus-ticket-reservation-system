# Bus Ticket Reservation System

## Installation

Clone the repo locally:

```sh
git clone https://github.com/btrs BTRS
cd BTRS
```

Install PHP dependencies:

```sh
composer install
```

Install NPM dependencies:

```sh
npm ci
```

Build assets:

```sh
npm run dev
```

Setup configuration:

```sh
cp .env.example .env
```

Generate application key:

```sh
php artisan key:generate
```

Create an SQLite database. You can also use another database (MySQL, Postgres), simply update your configuration accordingly.

```sh
touch database/database.sqlite
```

Run database migrations:

```sh
php artisan migrate
```

Run database seeder:

```sh
php artisan db:seed
```

Serving Laravel:

```sh
php artisan serve
```

You're ready to go! Visit BTRS in your browser, and login with:

## Admin User
- **Email:** admin@admin.com
- **Password:** password
- **Visit** http://localhost:8000/admin/users

## Manager User
- **Email:** manager@manager.com
- **Password:** password
**Visit** http://localhost:8000

## Employee User
- **Email:** employee@employee.com
- **Password:** password
**Visit** http://localhost:8000

## Customer User
- **Visit** http://localhost:8000/landing
