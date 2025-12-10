# Skillio – Install & Usage Guide

This document describes how to run Skillio locally using Laravel Sail on Linux Mint (or similar).

---

## 1. Requirements

- Docker & Docker Compose
- Git
- PHP CLI (optional)
- Node.js & npm (optional, if running Vite outside Sail)

---

## 2. Clone the repository

```bash
git clone <YOUR_REPO_URL> skillio
cd skillio
```

---

## 3. Environment setup

Copy the example environment file:

```bash
cp .env.example .env
```

Required values:

```env
APP_NAME="Skillio"
APP_ENV=local
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=sail
DB_PASSWORD=password
```

---

## 4. Start Laravel Sail

```bash
./vendor/bin/sail up -d
```

or if aliased:

```bash
sail up -d
```

---

## 5. Run migrations & storage link

```bash
sail artisan migrate
sail artisan storage:link
```

---

## 6. Install frontend dependencies (Vite)

```bash
sail npm install
sail npm run dev
```

---

## 7. User roles

All new users are **students** by default.

To create an **admin**, update the `role` field:

```sql
UPDATE users
SET role = 'admin'
WHERE email = 'admin@example.com';
```

Admin tools:

- /admin/questions
- /admin/exams
- /admin/stats/questions

Student tools:

- /dashboard
- /exams
- /results
- /results/topics

---

## 8. Running tests

```bash
sail artisan test
```

---

## 9. Stop containers

```bash
sail down
```

Skillio runs at:

```
http://localhost
```
