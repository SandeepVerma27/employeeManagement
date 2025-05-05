# 📘 Laravel 11 Employee Management API (JWT + Role-Based)

A powerful Laravel 11 REST API for managing employees, secured with **JWT authentication** and **role-based access**. Includes full CRUD support for `admin` users and view-only access for `user` roles. Built with Laravel 11 and follows clean code principles.

---

## 🧩 Features

-   ✅ Built on Laravel 11.x
-   🔐 Authentication using `tymon/jwt-auth`
-   🧑‍💻 Two user roles: `admin`, `user`
-   🔧 Admins: Full CRUD on employees
-   👁️ Users: Read-only employee access
-   🔁 Middleware-based route protection
-   📮 Postman collection included
-   🚀 GitHub-ready setup

---

## 🔐 Roles & Permissions

| Role  | Access Type | Description                            |
| ----- | ----------- | -------------------------------------- |
| Admin | Full Access | Create, read, update, delete employees |
| User  | Read-Only   | View list of employees only            |

---

## 🛠 Requirements

-   PHP 8.2+
-   Composer
-   Laravel 11
-   MySQL
-   Git

---

## 🚀 Setup Instructions (From Scratch)

### 1. Clone the repository

```bash
git clone https://github.com/your-username/employee-management-api.git
cd employee-management-api



composer install

php artisan key:generate
php artisan jwt:secret

php artisan migrate

php artisan serve


## Register Payload:
{
  "name": "Admin One",
  "email": "admin1@example.com",
  "password": "password123",
  "role": "admin"
}


## Login Payload 
{
  "email": "admin1@example.com",
  "password": "password123"
}

```

🧑‍💼 Admin Routes (Requires Bearer Token + role:admin)


| Method | URI                   | Description              |
| ------ | --------------------- | ------------------------ |
| GET    | `/api/employees`      | Get list of employees    |
| GET    | `/api/employees/{id}` | View single employee     |
| POST   | `/api/employees`      | Create new employee      |
| PUT    | `/api/employees/{id}` | Update existing employee |
| DELETE | `/api/employees/{id}` | Delete employee          |


## Create Employee Payload 
{
  "employee_id": "EMP101",
  "name": "Jane Doe",
  "email": "jane.doe@example.com",
  "dob": "1990-04-25",
  "doj": "2023-01-15"
}


## Update Employee Paylaod
{
  "employee_id": "EMP101",
  "name": "Jane Smith",
  "email": "jane.smith@example.com",
  "dob": "1990-04-25",
  "doj": "2023-01-15"
}



👤 User Routes (Requires Bearer Token + role:user)

| Method | URI              | Description        |
| ------ | ---------------- | ------------------ |
| GET    | `/api/employees` | View all employees |


