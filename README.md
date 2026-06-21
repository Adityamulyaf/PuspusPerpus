# PuspusPerpus 📚

A modern, secure, and beautiful Library Book Management Web Application built with OOP PHP Native and MySQL.

## Features

- **Book CRUD**: Fully functional Create, Read, Update, and Delete operations for library books.
- **Category CRUD**: Manage book categories with cascade deletions.
- **Security Protections**:
  - Robust client-side and server-side validation rules.
  - CSRF (Cross-Site Request Forgery) protection for all form submissions.
  - Input sanitization to prevent Cross-Site Scripting (XSS).
  - Secure password hashing using `password_hash()`.
  - PDO Prepared Statements to prevent SQL Injection.
- **Modern UI/UX**: Sleek Navy-Slate theme designed with premium custom CSS, fully responsive, and enhanced with **GSAP (GreenSock)** micro-animations for page entries and form validation feedback.

---

## Tech Stack

- **Backend**: PHP (Object-Oriented Programming, Native PHP)
- **Database**: MySQL / MariaDB (utilizing PDO wrapper)
- **Frontend**: HTML5, Vanilla CSS3 (Custom Design System), Vanilla JavaScript (ES6)
- **Animations**: GSAP (GreenSock Animation Platform)

---

## Installation & Setup

Follow these steps to run the project locally on your machine (e.g., using Laragon or XAMPP):

### 1. Clone the Repository
Clone this repository to your local web server root directory (e.g., `C:/laragon/www/` or `C:/xampp/htdocs/`):
```bash
git clone https://github.com/Adityamulyaf/PuspusPerpus.git
cd PuspusPerpus
```

### 2. Import Database
1. Start your MySQL database server (Laragon or XAMPP Control Panel).
2. Open your database administration tool (such as **phpMyAdmin**, DBeaver, or HeidiSQL).
3. Create a new database named `puspusperpus`.
4. Import the provided schema file: [schema.sql](schema.sql).

### 3. Configure Database Credentials
Open the file [Database.php](config/Database.php) and adjust the connection properties if yours differ from default local settings:
```php
private static $host = 'localhost';
private static $db_name = 'puspusperpus';
private static $username = 'root';
private static $password = ''; // Add password if required
```

### 4. Running the App
Open your web browser and navigate to your local environment address:
- If using Laragon: `http://puspusperpus.test`
- If using XAMPP: `http://localhost/PuspusPerpus`

---

## Default Admin Credentials

When the database is connected successfully, the application automatically seeds a default administrator account if the `users` table is empty:

*   **Email**: `admin@puspusperpus.com`
*   **Password**: `password123`

You can use these credentials to log in and access the dashboard.
