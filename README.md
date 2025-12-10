# Skillio

Skillio is a Laravel-based exam preparation platform offering mock exams, quizzes, performance analytics, and content management tools for students and administrators.

## Features

### Students
- Register and manage profile
- Take timed or untimed exams
- Auto-save and resume progress
- View results and explanations
- Topic-wise strengths and weaknesses
- Track performance over time

### Admins
- Create, edit, and delete questions
- Bulk import via CSV/Excel
- Create and manage exams/quizzes
- Shuffle questions and answer options
- View student attempts and analytics
- Export reports (CSV/Excel)
- Manage users and security logs

## Technology Stack
- Laravel (PHP)
- MySQL / MariaDB
- Blade + Tailwind/Bootstrap + Vite

## Installation

```bash
git clone https://github.com/yourusername/skillio.git
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
npm run dev
```

## Project Structure
- /app — application logic
- /resources/views — UI templates
- /database/migrations — schema definitions
- /routes — route definitions

## Roadmap
See FEATURED.md for the full development roadmap.

## License
Proprietary — not for redistribution.
