# SPP Management System

A Laravel-based school fee management application for managing students, SPP billing, payments, financial reports, and student payment visibility. The system is designed around two main roles: administrators who manage operational data and students who can view their own SPP profile and outstanding bills.

## Overview

This project helps schools manage SPP and related financial workflows in one place. Administrators can maintain student records, generate SPP bills for selected classes, record payments, monitor cash flow, import student data from Excel or CSV files, and export PDF reports. Students can log in using their NIS and view their own billing information.

## Main Features

- Role-based access control for `admin` and `siswa` users.
- Student data management with NIS-based login accounts.
- Student filtering by class, generation year, and keyword search.
- Excel/CSV student import using Laravel Excel.
- Bulk class promotion from X to XI, XI to XII, and XII to Alumni.
- SPP master data management for monthly, yearly, and other billing types.
- Automatic bill generation for students in a selected class.
- Optional wave-based billing support for class X students.
- WhatsApp notification queue for newly generated SPP bills.
- Payment recording with automatic outstanding balance updates.
- Automatic financial income entry when a payment is recorded.
- Financial cash flow management for income and expenses.
- Daily, monthly, and yearly report filters.
- PDF export for payment and financial reports.
- Authentication scaffold based on Laravel Breeze.

## Tech Stack

- PHP `^8.2`
- Laravel `^12.0`
- MySQL or compatible database
- Laravel Breeze
- Spatie Laravel Permission
- Laravel Excel
- Laravel DomPDF
- Tailwind CSS
- Alpine.js
- Vite
- Pest / PHPUnit

## Project Structure

```text
app/
  Console/Commands/ImportSiswaCommand.php
  Http/Controllers/
  Imports/SiswaImport.php
  Jobs/SendWaNotificationJob.php
  Models/
database/
  migrations/
  seeders/
resources/
  css/
  js/
  views/
routes/
  web.php
  auth.php
tests/
```

Key modules:

- `SiswaController` handles student CRUD, import, student profile, and class promotion.
- `SppController` handles SPP master records and mass billing generation.
- `PembayaranController` handles payment transactions and payment reports.
- `KeuanganController` handles financial cash flow and financial reports.
- `NotificationController` handles in-app notification reads.
- `SendWaNotificationJob` sends WhatsApp billing notifications through the Fonnte API.
- `ImportSiswaCommand` imports student data from Excel or CSV through the command line.

## Requirements

Make sure these tools are installed before setting up the project:

- PHP 8.2 or newer
- Composer
- Node.js and npm
- MySQL or MariaDB
- Git

Recommended PHP extensions:

- BCMath
- Ctype
- cURL
- DOM
- Fileinfo
- JSON
- Mbstring
- OpenSSL
- PDO
- PDO MySQL
- Tokenizer
- XML
- Zip

## Installation

Clone the repository and enter the project directory:

```bash
git clone <repository-url>
cd spp
```

Install PHP dependencies:

```bash
composer install
```

Install JavaScript dependencies:

```bash
npm install
```

Create the environment file:

```bash
cp .env.example .env
```

Generate the application key:

```bash
php artisan key:generate
```

Create a database, then update these values in `.env`:

```env
APP_NAME="SPP Management System"
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=spp
DB_USERNAME=root
DB_PASSWORD=

QUEUE_CONNECTION=database
SESSION_DRIVER=database
CACHE_STORE=database
```

Run database migrations:

```bash
php artisan migrate
```

Seed the default roles and users:

```bash
php artisan db:seed
```

Build frontend assets:

```bash
npm run build
```

Start the Laravel development server:

```bash
php artisan serve
```

For local development with Vite hot reload, run this in another terminal:

```bash
npm run dev
```

The application will be available at:

```text
http://127.0.0.1:8000
```

## Default Accounts

The default seeder creates these users:

| Role | NIS | Password |
| --- | --- | --- |
| Admin | `5599` | `password` |
| Siswa | `2024001` | `password` |

The application uses NIS as the main login identifier.

## Running All Development Services

The project includes a Composer script that can run the Laravel server, queue listener, logs, and Vite together:

```bash
composer run dev
```

This command starts:

- `php artisan serve`
- `php artisan queue:listen --tries=1`
- `php artisan pail --timeout=0`
- `npm run dev`

## Queue Worker

This project uses database queues for background jobs, including WhatsApp billing notifications. If you do not use `composer run dev`, start the queue worker manually:

```bash
php artisan queue:work
```

Failed queue jobs can be inspected in the `failed_jobs` table.

## WhatsApp Notification Setup

New SPP billing records can dispatch WhatsApp notification jobs through the Fonnte API. The current job sends requests to:

```text
https://api.fonnte.com/send
```

The API token is configured through `.env` and read from `config/services.php`. Keep this value out of source code and use a different token for each environment.

Environment variables:

```env
FONNTE_TOKEN=your-fonnte-token
FONNTE_URL=https://api.fonnte.com/send
```

## Student Import

Student data can be imported from the web interface or through Artisan.

Command-line import:

```bash
php artisan siswa:import storage/app/import/siswa.xlsx
```

Supported file types are handled by Laravel Excel, including `.xlsx`, `.xls`, and `.csv`.

## PDF Reports

The application can export:

- Payment reports from the payment module.
- Financial cash flow reports from the finance module.

Reports support daily, monthly, and yearly filters depending on the selected page.

## Main Routes

| Area | Route Prefix | Access |
| --- | --- | --- |
| Dashboard | `/dashboard` | Authenticated users |
| Profile | `/profile` | Authenticated users |
| Admin students | `/admin/siswa` | Admin |
| Admin SPP | `/admin/spp` | Admin |
| Admin payments | `/admin/pembayaran` | Admin |
| Admin finance | `/admin/keuangan` | Admin |
| Student SPP profile | `/siswa/spp` | Siswa |
| Notifications | `/notifications` | Authenticated users |

## Testing

Run the automated test suite:

```bash
php artisan test
```

Or use the Composer script:

```bash
composer test
```

## Useful Commands

Clear cached configuration:

```bash
php artisan config:clear
```

Clear application cache:

```bash
php artisan cache:clear
```

Run migrations from scratch and seed default data:

```bash
php artisan migrate:fresh --seed
```

Build production assets:

```bash
npm run build
```

Format PHP code with Laravel Pint:

```bash
./vendor/bin/pint
```

## Deployment Notes

For production deployment:

- Set `APP_ENV=production`.
- Set `APP_DEBUG=false`.
- Configure a production database.
- Configure a persistent queue worker.
- Run `php artisan migrate --force`.
- Run `npm run build`.
- Configure the web server document root to the `public` directory.
- Store third-party API tokens in `.env`, not in source code.
- Ensure `storage` and `bootstrap/cache` are writable by the web server user.

Common production optimization commands:

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## License

This project is built on Laravel. Review the repository license or project owner policy before redistribution or commercial use.
