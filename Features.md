# Skillio – Project Roadmap

Skillio is a Laravel-based web platform for exam preparation, providing mock exams, quizzes, detailed analytics, and an admin panel to manage questions, users, and performance reports for up to ~400 users.

This roadmap is split into **Completed** and **To-Do** chapters to track progress.

---

## ✅ Completed Chapters

_None yet – project in initial setup phase._

---

## 📌 To-Do Chapters

### Chapter 1 — Environment & Project Setup

- Local development environment (Linux Mint):
  - Install PHP (version compatible with latest Laravel), Composer, Git
  - Install MySQL/MariaDB and create a dedicated database (e.g., `skillio`)
  - Ensure Node.js + npm are installed for asset bundling (Vite)
  - Set up DBeaver connection to the `skillio` database
- Laravel project bootstrap:
  - `laravel new skillio` or `composer create-project laravel/laravel skillio`
  - Configure `.env` (DB credentials, app name, debug mode)
  - Generate app key: `php artisan key:generate`
- Git & GitHub:
  - Initialize git repo and connect to GitHub
  - Add `.gitignore` (use default Laravel + any local-specific ignores)
  - Add base `README.md` and `FEATURED.md` (this file)
- Basic project structure confirmation:
  - Confirm `app/`, `routes/`, `database/`, `resources/`, `tests/` layout
  - Decide namespaces and folder structure for domain logic (e.g. `App/Models`, `App/Services`, `App/Http/Controllers/Admin`)

---

### Chapter 2 — Requirements Refinement & Data Modeling

- Finalize user roles and permissions:
  - Define `Student` and `Admin` roles (optional: `SuperAdmin`, `ContentManager`)
- Define core entities and relationships:
  - `User` (name, email, password, role, batch, exam_target_date, status)
  - `Question` (stem, options, correct_option, explanation, difficulty, category, tags, image_path)
  - `Exam` / `Quiz` (title, description, duration, total_questions, attempt_limit, is_timed, is_active)
  - Pivot tables:
    - `exam_question` (exam_id, question_id, order, weight)
    - `user_exam_attempt` (user_id, exam_id, started_at, completed_at, score, percentage)
    - `user_exam_answer` (attempt_id, question_id, selected_option, is_correct, time_spent)
  - Logs and analytics:
    - `login_log` (user_id, ip_address, user_agent, success_flag)
    - `security_log` (event_type, user_id, ip_address, details)
- Draw an ERD (can be sketched) and validate relationships
- Document model fields and constraints (NOT NULL, indexes, foreign keys)

---

### Chapter 3 — Database & Migrations

- Create Laravel migrations:
  - `users` (extend default to include batch, exam_target_date, role, status)
  - `questions`, `question_options` (if storing options in separate table), `categories`, `tags`
  - `exams` / `quizzes`, `exam_question`
  - `user_exam_attempts`, `user_exam_answers`
  - `login_logs`, `security_logs`, `backups` metadata table (optional)
- Add indexes:
  - On foreign keys (user_id, exam_id, question_id)
  - On frequently queried fields (category_id, difficulty, created_at)
- Run migrations and verify schema via DBeaver
- Seed minimal test data:
  - Test admin user
  - Few questions, categories, sample exam

---

### Chapter 4 — Authentication, Roles & User Profiles

- Use Laravel Breeze/Fortify/Jetstream (or manual) for auth:
  - Implement registration and login (email + password)
  - Password reset (via email or admin-only reset flow)
- Role & permission handling:
  - Add `role` field to `users` and define constants or enum
  - Middleware to restrict access (`admin`, `student`)
- Profile management:
  - Student profile page (name, email, batch, exam target date)
  - Allow user to update profile details (except email if policy requires)
- Admin user management:
  - Admin list of users (search, filter by batch, status)
  - Actions: add user, deactivate/activate, reset password

---

### Chapter 5 — Question Bank Module

- Question CRUD (Admin):
  - Create, edit, delete questions
  - Support 4–5 options for multiple choice
  - Mark one correct option
  - Explanation text field
  - Optional image upload (store in `storage/app/public` and serve via `public/storage`)
- Question metadata:
  - Categories/Topics table with CRUD
  - Difficulty levels (e.g. easy, medium, hard)
  - Tags (many-to-many via pivot table)
- Bulk import tool:
  - Define CSV/Excel format (columns: question, options A–E, correct_option, explanation, category, difficulty, tags)
  - Implement upload form and parsing (e.g. using Laravel Excel)
  - Validation of rows (missing fields, invalid correct_option)
  - Show summary: imported, skipped, errors (with downloadable error file)
- Question listing:
  - Paginated list with filters (category, difficulty, tag, created_by)
  - Inline indicators for usage (how many exams use this question)

---

### Chapter 6 — Exam/Quiz Engine

- Exam creation & management (Admin):
  - Create exam with title, description, duration (minutes), number of questions
  - Select questions by:
    - Manual selection
    - Filters (category, difficulty) with random pick
  - Set attempt rules: limited attempts vs. unlimited; allow re-attempt or not
  - Flag exam as timed vs. untimed
- Exam assignment:
  - Decide scoping: all students vs selected batches vs specific users
  - Store rules in DB for exam visibility
- Exam-taking workflow (Student):
  - Exam list page (available, upcoming, completed)
  - Exam instruction page before start (duration, number of questions, attempt rules)
  - On start: load questions with:
    - Optional shuffle of questions
    - Optional shuffle of answer options
- Timed exam behavior:
  - Countdown timer (JS + backend fail-safe)
  - Auto-save answers periodically (AJAX) and on each question navigation
  - Auto-submit when time ends (server-side cutoff check)
- Untimed exam behavior:
  - No countdown, but save progress
  - Explicit “Submit exam” button

---

### Chapter 7 — Attempts, Scoring & Storage

- Answer recording:
  - Save each selected answer to `user_exam_answers`
  - Track time spent per question (difference between timestamps)
  - Handle revisiting questions (update last answer)
- Submission logic:
  - On submit or time expiry:
    - Compute total correct, incorrect, skipped
    - Calculate percentage score
    - Save summary in `user_exam_attempts`
  - Ensure re-attempt rules are respected (check attempt count)
- Prevent tampering:
  - Server-side validation that exam is active and within allowed time
  - Ensure user cannot access questions after submission (if forbidden)

---

### Chapter 8 — Results & Analytics

- Student-facing analytics:
  - Exam result page:
    - Score summary (raw score, percentage)
    - Correct/Wrong/Skipped list
    - Time per question
  - Topic-wise breakdown:
    - Group by category/topic with percentage correct
    - Highlight strengths & weaknesses
  - Progress over time:
    - Line chart or bar chart of exam scores over time
    - Summary of attempts count, average score
  - Access previous exam attempts:
    - List of past attempts with date, score, exam name
- Admin-facing analytics:
  - Attempt logs:
    - Table: user, exam, attempt date, duration, score, percentage
    - Filters: date range, exam, batch, score range
  - Per-question statistics:
    - Number of times a question was attempted
    - Percentage of correct responses (difficulty index proxy)
    - Flag questions with very low or very high success rate
  - Export:
    - CSV/Excel exports for attempts, per-question stats, user performance
- Performance considerations:
  - Add queries optimized with eager loading and indexes
  - Use background jobs if heavy analytics aggregation becomes needed (optional)

---

### Chapter 9 — Admin Panel & UX

- Admin dashboard:
  - Overview cards: total users, total exams, total questions, recent attempts
  - Quick links to “Create Exam”, “Import Questions”
- Admin UI structure:
  - Sidebar navigation: Dashboard, Questions, Exams, Users, Analytics, Logs, Settings
  - Consistent layout using a CSS framework (Bootstrap/Tailwind)
- Student dashboard:
  - Upcoming/available exams
  - Recent scores and progress snapshot
  - Shortcuts to “Continue last exam” if in-progress
- Mobile responsiveness:
  - Ensure dashboards, question pages, and forms are usable on mobile and tablet
  - Test with common breakpoints

---

### Chapter 10 — Security, Logging & Backups

- Security basics:
  - Force HTTPS in production
  - Use Laravel’s CSRF protection, form validation, and password hashing
  - Rate-limiting login attempts (Laravel throttle middleware)
- Brute-force and IP/device logging:
  - Record login attempts and outcomes (`login_logs`)
  - Detect multiple failed attempts from same IP (log security event)
- Admin access control:
  - Restrict admin routes via middleware and guards
  - Optional finer-grained roles (SuperAdmin vs regular Admin)
- Audit & security logs:
  - Log key events: login failure, password reset, new admin created, question bulk import
- Backups:
  - Configure daily DB backup via server cron (mysqldump or Laravel backup package)
  - Store backup path and status in a small `backups` table (optional)

---

### Chapter 11 — Hosting, Deployment & Staging

- Server selection:
  - VPS with ~2 vCPU, 4–8 GB RAM, 50–100 GB SSD
  - OS choice (e.g. Ubuntu LTS)
- Production setup:
  - Install PHP, Nginx/Apache, MySQL/MariaDB, Composer, Node.js
  - Clone GitHub repo and set up `.env` for production
  - Configure web server to point to `public/` directory
  - Run `php artisan migrate --force` and seed required data
  - Build front-end assets with Vite (`npm run build`)
- Staging environment:
  - Create a staging subdomain and database
  - Deploy `develop` or staging branch there for testing
- Performance tuning:
  - Enable PHP opcode cache
  - Configure caching (config cache, route cache, view cache)
  - Consider query optimization and pagination defaults
- Monitoring:
  - Basic uptime checks
  - Error logging via Laravel logs and server logs

---

### Chapter 12 — Testing, QA & Documentation

- Testing:
  - Write feature tests for:
    - Registration, login, role-based access
    - Exam creation and taking flow
    - Question import
  - Unit tests for scoring calculations and analytics logic
- Manual QA checklist:
  - Cross-browser and mobile testing
  - Testing timed vs untimed exams
  - Testing limited vs unlimited attempts
  - Validation and error messages
- Documentation:
  - Admin guide:
    - How to add questions and categories
    - How to bulk import questions
    - How to create/manage exams and assign them
    - How to manage users and reset passwords
  - Student guide:
    - How to register, take exams, and view results
  - Technical docs:
    - High-level architecture
    - Deployment instructions
    - Backup and restore steps
- Warranty & maintenance:
  - Define 1–3 month bug-fix process (issue tracking via GitHub)
  - Outline optional maintenance plan (update schedule, backup policy)

---
