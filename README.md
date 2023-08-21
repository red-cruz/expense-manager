# Laravel Expense Manager

A simple Laravel application that tracks expenses.

## Features

- User Management
- User Roles and Permissions
- Expense Management
- Keeps track of user’s expenses
- Dashboard
- Display chart of total expense per category

## Roles (Default)

1. Administrator

   - Can create/update/delete user
   - Can create/update/delete Expense Category
   - Can create/update/delete new Expense
   - Can access User Management

2. User
   - Can change password
   - Can create/update/delete own expenses

## Dashboard

- Displays all categories and total per category
- Accessible by all user roles

## User Management > Roles

- Clicking an item in the table will show Update Role modal
- Administrator Role cannot be updated/deleted
- Only Administrator can access this functionality
- Adding a new role should have default functionality same as User role

## User Management > Users

- Clicking an item in the table will show Update Users modal
- Administrator Role cannot be updated/deleted
- Only Administrator can access this functionality

## Expense Management > Expense Categories

- Clicking an item in the table will show Update Category modal
- Only Administrator can access this functionality

## Expense Management > Expenses

- Clicking an item in the table will show Update Expense modal
- Accessible by all user roles
- If default user, only their expenses will be shown
- Add validations for fields

## Tech Stack

### Backend

- Laravel 10

### Frontend

- Vue 3 with Vite
- Inertia

## How to Use

1. Clone the repository from GitHub.
2. Install the dependencies using `composer install` and `npm install`.
3. Create a database and configure the database connection in `.env` file.
4. Run the migrations using `php artisan migrate`.
5. Seed the database with dummy data using `php artisan db:seed`.
6. Start the development server using `php artisan serve` and `npm start`.
