# 📘 Laravel 11 Employee Management API

A secure and lightweight RESTful API built using **Laravel 11**, **JWT Authentication**, and **Role-Based Access Control (RBAC)**. This API enables two types of users — `admin` and `user` — with scoped permissions to manage employees.

---

## 🔑 Features

- ✅ Laravel 11 RESTful API
- 🔐 JWT Authentication using `tymon/jwt-auth`
- 🛡️ Role-based middleware (Admin/User)
- 👨‍💼 Admin can Create, Read, Update, Delete employees
- 👨‍💻 Regular users can only view employees
- 📮 Postman collection included
- ☁️ GitHub-ready setup (ignores `.env`, `vendor`, etc.)

---

## 🧑‍💻 Roles

| Role  | Permissions                                   |
|-------|-----------------------------------------------|
| Admin | Create, Read, Update, Delete all employees    |
| User  | View all employees (read-only)                |

---

## 🛠️ Requirements

- PHP >= 8.2
- Composer
- MySQL
- Laravel 11
- Git (for version control)

---

## 🚀 Installation (From Scratch)

### 1. Clone the Repository

```bash
git clone https://github.com/your-username/employee-management-api.git
cd employee-management-api
