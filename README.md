# Task Management System

A simple, single-user Task Management System built with **Laravel 11**, **TailwindCSS**, and **MySQL/SQLite**.

## Features

- **Responsive Dashboard**: Beautiful UI built with TailwindCSS.
- **Task Management**: Create, Read, Update, and Delete tasks.
- **Status Toggle**: Easily mark tasks as pending or completed.
- **Prioritization**: Assign priority levels (Low, Medium, High).
- **Validation**: Robust server-side validation.

## Requirements

- PHP 8.2 or higher
- Composer
- Node.js & NPM (Optional, for building assets if modifying CSS)
- MySQL or SQLite

## Installation

1.  **Clone the repository**
    ```bash
    git clone <repository-url>
    cd task-management-system
    ```

2.  **Install Dependencies**
    ```bash
    composer install
    ```

3.  **Environment Setup**
    Copy the example environment file and configure your database (default is SQLite).
    ```bash
    cp .env.example .env
    ```
    *If using MySQL, update `DB_CONNECTION`, `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD` in `.env`.*

4.  **Generate App Key**
    ```bash
    php artisan key:generate
    ```

5.  **Run Migrations**
    ```bash
    php artisan migrate
    ```

6.  **Serve Application**
    ```bash
    php artisan serve
    ```
    Visit `http://localhost:8000` in your browser.

## Testing

Run the feature tests to verify functionality:
```bash
php artisan test
```

## Technologies

- **Framework**: Laravel 11
- **Styling**: TailwindCSS (via CDN)
- **Database**: SQLite / MySQL
