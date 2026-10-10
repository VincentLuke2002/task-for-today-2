# Tasks for Today Management System TSA2

A CodeIgniter 4 task-management application with public read-only pages and authenticated task management. TSA2 adds full CRUD, form validation, session authentication, and soft deletion to the original project.

## Requirements

- PHP 8.2 or newer with `intl`, `mbstring`, and `mysqli`
- Composer 2
- MySQL or MariaDB

## Setup

1. Clone or extract the project.
2. Run `composer install`.
3. Copy `env` to `.env`.
4. Create a MySQL database named `tasks_for_today_2`.
5. Check the database settings in `.env`.
6. Create and populate the tables:

```bash
php spark migrate
php spark db:seed DatabaseSeeder
```

7. Start the development server:

```bash
php spark serve
```

Open `http://localhost:8080`.

## Demo login

- Username: `demo.user`
- Password: `Password123!`

The password is stored as a secure hash produced by `password_hash()` and checked during login with `password_verify()`.

## Public pages

| Route | Purpose |
|---|---|
| `/` | Displays active tasks scheduled for today |
| `/tasks` | Displays all active tasks grouped by date |
| `/profile` | Displays the demo user profile |
| `/about` | Identifies the developer and explains the project |
| `/login` | Accepts the demo username and password |

## Protected task actions

| Route | Purpose |
|---|---|
| `/tasks/new` | Create a task with validated title and date fields |
| `/tasks/{id}/edit` | Edit an existing active task |
| `/tasks/{id}/toggle` | Complete or reopen a task |
| `/tasks/{id}/delete` | Soft-delete a task by setting `is_archived` to `1` |
| `/logout` | Destroy the authenticated session |

Logged-out visitors are redirected to `/login` when they request a protected action. Archived tasks remain in the database but are excluded from the Today and Task List pages.

## Database options

The recommended setup uses the migrations and `DatabaseSeeder`. A MySQL export is also included at `database/tasks_for_today.sql`. Both options create ten sample tasks and one demo user.

## Project structure

- `app/Controllers/Auth.php` handles login and logout.
- `app/Filters/AuthFilter.php` protects task management routes.
- `app/Controllers/Tasks.php` handles task listing, creation, editing, status changes, and archiving.
- `app/Models` contains `TaskModel` and `UserModel`.
- `app/Database/Migrations` defines the original schema and TSA2 fields.
- `app/Database/Seeds/DatabaseSeeder.php` creates sample data and the hashed demo password.
- `public/assets` contains the responsive interface.
