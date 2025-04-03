# Project Setup Instructions

Follow these steps to set up and run the project locally:

## Prerequisites

Ensure you have the following installed on your system:
- PHP 8.2 or higher
- Composer

---

## Step 1: Clone the Repository

Clone the project repository to your local machine:

```bash
git clone https://github.com/Behnamfe76/todolist-api
cd todolist-api
```

## Step 2: Install PHP Dependencies
Install the required PHP dependencies using Composer:
```bash
composer install
```

## Step 3: Set Up Environment Variables
Copy the .env.example file to .env and configure the environment variables:
```bash
cp .env.example .env
```

* Update the following variables in the .env file as needed:
APP_NAME
APP_URL
FRONTEND_URL
DB_CONNECTION, DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD

## Step 4: Generate Application Key
Generate the application key:
```bash
php artisan key:generate
```

## Step 5: Set Up the Database
* Create a database in your MySQL or other supported database system.

Run the migrations to set up the database schema:
```bash
php artisan migrate
```

Seed the database with initial data (optional):
```bash
php artisan db:seed
```