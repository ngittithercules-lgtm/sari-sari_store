# Sari Sari Store Web Application System

Full-stack web application developed for the Web Application Development final project. It features user authentication, a responsive Tailwind CSS dashboard layout, and full CRUD operations connected to a MySQL database.

## Technical Stack
- **Frontend**: HTML5, Tailwind CSS, FontAwesome Icons, Vanilla JavaScript
- **Backend**: PHP 8+
- **Database**: MySQL / MariaDB (PDO)

## Features Implemented
1. **User Authentication**: Secure user registration and login with password hashing (`password_hash`) and PHP session management.
2. **Dashboard & Metrics**: Dynamic KPI blocks showing total revenue metrics, live product counts, and low-stock indicators matching modern sari-sari store point-of-sale workflows.
3. **Full CRUD Operations**:
   - **Create**: Add new store merchandise with stock and pricing.
   - **Read**: Live table viewing inventory data directly queried from MySQL.
   - **Update**: Modify product details through dedicated editing interfaces.
   - **Delete**: Remove obsolete entries securely with confirmation prompts.
4. **Security**: Prepared Statements protecting against SQL Injection.

## Default Admin Credentials
- **Username**: `admin`
- **Password**: `admin123`

## Setup Instructions
1. Import the database schema located in `sariapp_db.sql` (on InfinityFree, import it into your existing `if0_..._sariapp_db` database; do not run CREATE DATABASE) into your local MySQL server (e.g., via phpMyAdmin).
2. Configure your database credentials inside `connection.php` if necessary.
3. Host the folder on a local server environment (like XAMPP/WAMP) or deploy to a live PHP hosting provider (such as InfinityFree).
