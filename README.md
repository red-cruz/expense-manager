# Laravel Expense Manager

A simple Laravel application that tracks expenses.

## Default Admin Account

For your convenience, a default admin account has been set up with the following credentials:

- **Email:** admin@email.com
- **Password:** Pass@123

Please use these credentials to access the administrator privileges and manage the application as specified in the requirements.

## Tech Stack

### Backend

- Laravel 10

### Frontend

- Vue 3 with Vite
- Inertia

## Features

- User Management
- User Roles and Permissions
- Expense Management
- Keeps track of user’s expenses
- Dashboard
- Display chart of total expense per category

> **Note:** When adding a new user, the default password is set to **Pass@1234**. This is set because the requirements and the UI did not contain a password field.

> **Important:** Deleting an expense category will throw an error if there is an expense currently using it as a category. In such cases, the expense category that is being used must be deleted or updated to a different category before the original category can be deleted. Please ensure that you handle this situation accordingly to maintain data integrity.

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

## How to Use

1. Clone the repository from GitHub.
2. Install the dependencies using `composer install` and `npm install`.
3. Create a database and configure the database connection in `.env` file.
4. Run the migrations using `php artisan migrate`.
5. Seed the database with dummy data using `php artisan db:seed`.
6. Start the development server using `php artisan serve` and `npm start`.
