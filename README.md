# 🧩 Task & Inventory Management System — Laravel + Vue + Inertia + API (JWT + Swagger)

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
├── Adminend # Admin Dashboard Code
├── Fronted # User Dashboard Code
```

# 🧩 Setup Instructions

### 1️⃣ Clone the Repository

```bash
git clone https://github.com/shakib53626/6amTech.git
```
### 2️⃣ Move to Project Directory

```bash
cd 6amTech
```
### 3️⃣ Install PHP Dependencies

```bash
composer install
```

### 4️⃣ Install NPM Packages
```bash
npm install
```

### 5️⃣ Create and Configure .env
```bash
cp .env.example .env
```

Then configure the following in .env:
-Database connection
-JWT Secret:
-Generate it via:
```bash
php artisan jwt:secret
```

### 6️⃣ Generate App Key
```bash
php artisan key:generate
```

### 7️⃣ Migrate your database
```bash
php artisan migrate:fresh --seed
```

### 8️⃣ Start the application

You can run the project using either of the following methods:

- **Method 1:** Run Laravel backend and frontend separately  
```bash
php artisan serve
npm run dev
```

- **Method 2:** Run Laravel backend and frontend a single command  
```bash
composer run dev
```
Or
```bash
composer dev
```
## After running, visit in your browser
```bash
http://localhost:8000
```

# 🧩 Environment configuration details
### Database Configuration
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=6amtech
DB_USERNAME=root
DB_PASSWORD=
```

### Swagger configuration

```bash
L5_SWAGGER_CONST_HOST=http://localhost:8000
```

### JWT Authenticaton Environment
```bash
JWT_SECRET=I3qd3uDP2JEKZYStxkUcpAiNi6wWJzhKtVcKM3iijTtdLN90kJTgyBL0crYfyyDd
```
Or
```bash
php artisan jwt:secret
```

# 🧩 Optimization Techniques (Task 3)
To improve the performance of the Inventory Management System, the following optimization strategies were applied:

## 1️⃣ Eager Loading (with with())
Instead of using lazy loading, I used eager loading to prevent N+1 query problems.
```bash
    public function index($request)
    {
        $paginateSize = $request->input('paginate_size') ?? 50;

        $query = Product::query()->with('category');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%')
                  ->orWhere('sku', 'like', '%' . $request->input('search') . '%');
        }

        $products = $query->orderBy('created_at', 'desc')->paginate($paginateSize);

        return [
            'products'   => $products,
            'categories' => Category::select('id', 'name')->get(),
        ];
    }
```
## 2️⃣ Indexing (on searchable fields)
I added database indexes on frequently queried columns such as:
```base
$table->string('name')->index();
```
