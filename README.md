# 🧩 Task & Inventory Management System — Laravel + Vue + API (JWT + Swagger)

This repository contains a complete full-stack solution for a **Task & Inventory Management System**, built using **Laravel (backend)** and **Vue.js + Inertia.js (frontend)**. The project demonstrates advanced features including custom role-based authentication, JWT-secured API, optimized database queries, and a pixel-perfect UI based on a provided Figma design.

---

## 🚀 Project Overview

This project was built as part of the 6AMTECH interview assessment. It includes:

- Secure **custom user authentication** (no Breeze/Jetstream).
- **Role-based dashboard** system:
  - `Admin` can manage users, tasks, and inventory.
  - `User` can see reports, manage assigned tasks.
- **JWT-based RESTful API** with:
  - Task CRUD operations
  - Laravel API Resources
  - Swagger/OpenAPI docs
- **Inventory module** with optimized Eloquent queries:
  - Products, Categories, Transactions
  - Indexed & eager loaded for high performance
- **Vue.js + Inertia.js** frontend with pixel-perfect Figma integration.

---

## 📁 Folder Structure (Highlights)

```bash
app/
├── Http/
│   ├── Controllers/Api/         # API controllers (JWT)
│   ├── Controllers/             # Web/Inertia controllers
│   ├── Requests/                # Form validation
│   ├── Resources/               # API resources
│
├── Models/
│   ├── Task.php
│   ├── Product.php
│   └── Category.php
│
resources/js/                   # Vue 3 + Inertia frontend
resources/js/                   # Vue 3 + Inertia frontend
├── Adminend # Admin Dashboard Code
├── Fronted # User Dashboard Code
```

### 🧩 Setup Instructions

# 1️⃣ Clone the Repository

```bash
git clone https://github.com/shakib53626/6amTech.git
cd 6amTech
