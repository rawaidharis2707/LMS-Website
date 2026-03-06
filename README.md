# Lumina International Academy – Learning Management System (LMS)

A comprehensive, full-stack Learning Management System built with **Laravel 12** and a modern JavaScript frontend. It provides dedicated portals for **Students**, **Teachers**, **Admins**, and **Super Admins** to manage every aspect of academic operations — from admissions and attendance to quizzes, grades, fees, and salary management.

---

## Table of Contents

- [Features](#features)
- [Tech Stack](#tech-stack)
- [Project Structure](#project-structure)
- [Installation & Setup](#installation--setup)
- [Login Credentials](#login-credentials)
- [User Roles & Portals](#user-roles--portals)
  - [Student Portal](#student-portal)
  - [Teacher Portal](#teacher-portal)
  - [Admin Portal](#admin-portal)
  - [Super Admin Portal](#super-admin-portal)
- [API Endpoints](#api-endpoints)
- [Database Schema](#database-schema)
- [Frontend Architecture](#frontend-architecture)
- [Screenshots](#screenshots)
- [License](#license)

---

## Features

### Core Capabilities
- **Multi-Role Authentication** — Four distinct user roles (student, teacher, admin, superadmin) with role-based middleware and access control
- **Responsive Design** — Fully responsive UI built with Bootstrap 5, optimized for desktop, tablet, and mobile
- **Real-Time Data Management** — Dynamic CRUD operations via RESTful API endpoints with localStorage fallback
- **Modern UI/UX** — Clean, professional interface with smooth animations, toast notifications, and interactive dashboards

### Academic Management
- **Admissions** — Online admission form with document upload, status tracking, and admin review/approval workflow
- **Class & Subject Management** — Create, assign, and manage classes, sections, and subjects
- **Timetable** — Visual timetable builder and viewer for students and teachers
- **Attendance Tracking** — Batch attendance input for teachers, individual attendance view for students, and teacher attendance monitoring by super admins
- **Assignments** — Upload, submit, and grade assignments with file attachment support
- **Quizzes** — Create quizzes with multiple-choice questions, auto-grading, and result tracking
- **Notes & Lectures** — Upload and share study materials and video lecture links
- **Marks & Results** — Enter marks per subject/exam, automatic grade calculation, and result viewing
- **Student Remarks** — Teachers can add behavioral or academic remarks per student

### Financial Management
- **Fee Vouchers** — Generate, view, and print fee vouchers with payment status tracking
- **Fines** — Issue and manage student fines by category (discipline, library, late fee, damage)
- **Discounts** — Apply and manage fee discounts per student
- **Finance Transactions** — Record and track all financial transactions
- **Salary Management** — Super admin salary processing for staff with payment history

### Administrative Tools
- **Announcements** — Post school-wide announcements visible across portals
- **Student Promotion** — Bulk promote students to the next class/session
- **Data Correction** — Admin tools for correcting student records
- **Activity Logs** — Track all system activities with timestamps and user attribution
- **Role Distribution** — Super admin overview of user distribution across roles
- **Reports** — Generate academic and financial reports

---

## Tech Stack

| Layer        | Technology                                              |
|------------- |---------------------------------------------------------|
| **Backend**  | PHP 8.2+, Laravel 12                                    |
| **Database** | SQLite (default), MySQL/PostgreSQL compatible            |
| **Frontend** | HTML5, CSS3, JavaScript ES6+                            |
| **UI**       | Bootstrap 5.3, Font Awesome 6.4, Chart.js               |
| **Auth**     | Laravel built-in authentication with session management  |
| **Build**    | Vite, npm                                               |
| **Testing**  | PHPUnit 11                                              |

---

## Project Structure

```
my-laravel-app/
├── app/
│   ├── Http/
│   │   ├── Controllers/          # 21 controllers
│   │   │   ├── AuthController.php
│   │   │   ├── DashboardController.php
│   │   │   ├── AdmissionController.php
│   │   │   ├── AttendanceController.php
│   │   │   ├── MarkController.php
│   │   │   ├── QuizController.php
│   │   │   ├── SchoolContentController.php
│   │   │   ├── FeeVoucherController.php
│   │   │   ├── FineController.php
│   │   │   ├── SalaryController.php
│   │   │   └── ... (11 more)
│   │   └── Requests/             # Form request validation
│   └── Models/                   # 20 Eloquent models
│       ├── User.php
│       ├── SchoolClass.php
│       ├── Subject.php
│       ├── Attendance.php
│       ├── Quiz.php
│       ├── Mark.php
│       ├── FeeVoucher.php
│       └── ... (13 more)
├── database/
│   ├── migrations/               # 24 migration files
│   └── seeders/                  # Sample data seeders
├── public/
│   └── assets/
│       ├── css/style.css         # Main stylesheet
│       ├── js/                   # Frontend JavaScript modules
│       │   ├── auth.js           # Authentication & session management
│       │   ├── main.js           # Core UI functionality
│       │   ├── class-functions.js
│       │   ├── student-functions.js
│       │   ├── finance-functions.js
│       │   ├── assignment-functions.js
│       │   ├── fines-functions.js
│       │   └── ... (more modules)
│       └── images/               # Logo, icons, assets
├── resources/views/
│   ├── home.blade.php            # Public homepage
│   ├── admission.blade.php       # Public admission form
│   ├── layouts/                  # Shared layouts (navbar, footer, login modal)
│   ├── student/                  # 15 student views
│   ├── teacher/                  # 11 teacher views
│   ├── admin/                    # 12 admin views
│   └── superadmin/               # 8 super admin views
├── routes/
│   └── web.php                   # All routes (120+ endpoints)
├── composer.json
└── .env
```

---

## Installation & Setup

### Prerequisites
- **PHP** >= 8.2
- **Composer** >= 2.x
- **Node.js** >= 18.x & npm
- **SQLite** (default) or MySQL/PostgreSQL

### Quick Start

```bash
# 1. Clone the repository
git clone <repository-url>
cd my-laravel-app

# 2. Install PHP dependencies
composer install

# 3. Environment setup
cp .env.example .env
php artisan key:generate

# 4. Database setup (SQLite by default)
touch database/database.sqlite
php artisan migrate

# 5. Seed sample data (optional)
php artisan db:seed

# 6. Install frontend dependencies
npm install
npm run build

# 7. Start the development server
php artisan serve
```

The application will be available at **http://127.0.0.1:8000**

### One-Command Setup (Alternative)

```bash
composer run setup
composer run dev
```

---

## Login Credentials

| Role          | Email                  | Password   |
|---------------|------------------------|------------|
| **Student**   | student@demo.com       | password   |
| **Teacher**   | teacher@demo.com       | password   |
| **Admin**     | admin@demo.com         | password   |
| **Super Admin** | superadmin@demo.com | password   |

---

## User Roles & Portals

### Student Portal
**URL**: `/student/dashboard`

| Page             | Route                     | Description                                  |
|------------------|---------------------------|----------------------------------------------|
| Dashboard        | `/student/dashboard`      | Overview with stats, recent activities, events |
| Profile          | `/student/profile`        | View and edit personal information            |
| Subjects         | `/student/subjects`       | View enrolled subjects and materials          |
| Timetable        | `/student/timetable`      | Weekly class schedule                         |
| Attendance       | `/student/attendance`     | View attendance records and percentage        |
| Results          | `/student/results`        | Academic grades and performance reports       |
| Assignments      | `/student/assignments`    | View assignments and submit work              |
| Quizzes          | `/student/quizzes`        | Take quizzes and view results                 |
| Notes            | `/student/notes`          | Access uploaded study materials               |
| Lectures         | `/student/lectures`       | Watch video lectures                          |
| Announcements    | `/student/announcements`  | View school announcements                     |
| Fees             | `/student/fees`           | Fee details and payment status                |
| Fines            | `/student/fines`          | View issued fines and payment status          |
| Fee Vouchers     | `/student/fee-vouchers`   | View and download fee vouchers                |
| Print Voucher    | `/student/print-voucher`  | Print-friendly voucher view                   |

### Teacher Portal
**URL**: `/teacher/dashboard`

| Page               | Route                         | Description                              |
|--------------------|-------------------------------|------------------------------------------|
| Dashboard          | `/teacher/dashboard`          | Class overview, schedule, quick actions   |
| Marks Input        | `/teacher/marks-input`        | Enter and manage student grades           |
| Remarks            | `/teacher/remarks`            | Add academic/behavioral remarks           |
| Upload Assignments | `/teacher/upload-assignments` | Create and upload assignments             |
| Upload Notes       | `/teacher/upload-notes`       | Share study materials                     |
| Upload Lectures    | `/teacher/upload-lectures`    | Share video lecture links                 |
| Create Quiz        | `/teacher/create-quiz`        | Build quizzes with questions              |
| Attendance Input   | `/teacher/attendance-input`   | Mark daily class attendance               |
| My Attendance      | `/teacher/my-attendance`      | View own attendance records               |
| Timetable          | `/teacher/timetable`          | View teaching schedule                    |
| Announcements      | `/teacher/announcements`      | Post class/school announcements           |

### Admin Portal
**URL**: `/admin/dashboard`

| Page                 | Route                          | Description                            |
|----------------------|--------------------------------|----------------------------------------|
| Dashboard            | `/admin/dashboard`             | School-wide statistics and overview    |
| Admissions           | `/admin/admissions`            | Review and process admission requests  |
| Announcements        | `/admin/announcements`         | Manage school announcements            |
| Class Management     | `/admin/class-management`      | Create and manage classes/sections     |
| Subject Assignment   | `/admin/subject-assignment`    | Assign teachers to subjects/classes    |
| Timetable Input      | `/admin/timetable-input`       | Build class timetables                 |
| Teacher Attendance   | `/admin/teacher-attendance`    | Monitor teacher attendance             |
| Fee Vouchers         | `/admin/fee-vouchers`          | Generate and manage fee vouchers       |
| Fines                | `/admin/fines`                 | Issue and manage student fines         |
| Discount Management  | `/admin/discount-management`   | Apply fee discounts                    |
| Student Promotion    | `/admin/student-promotion`     | Promote students to next class         |
| Data Correction      | `/admin/data-correction`       | Correct student records                |

### Super Admin Portal
**URL**: `/superadmin/dashboard`

| Page                | Route                              | Description                          |
|---------------------|------------------------------------|--------------------------------------|
| Dashboard           | `/superadmin/dashboard`            | System-wide overview and metrics     |
| Announcements       | `/superadmin/announcements`        | Manage global announcements          |
| Role Distribution   | `/superadmin/role-distribution`    | User distribution across roles       |
| Finance             | `/superadmin/finance`              | Financial overview and transactions  |
| Salary              | `/superadmin/salary`               | Staff salary processing and history  |
| Teacher Attendance  | `/superadmin/teacher-attendance`   | Monitor teacher attendance records   |
| Reports             | `/superadmin/reports`              | Generate system reports              |
| Activity Logs       | `/superadmin/activity-logs`        | View system activity history         |

---

## API Endpoints

All API routes are prefixed with `/api` and require authentication.

### Authentication
| Method | Endpoint        | Description            |
|--------|-----------------|------------------------|
| POST   | `/login`        | User login             |
| POST   | `/logout`       | User logout            |
| GET    | `/user`         | Get authenticated user |

### Classes & Subjects
| Method | Endpoint              | Description            |
|--------|-----------------------|------------------------|
| GET    | `/api/classes`        | List all classes       |
| POST   | `/api/classes`        | Create a class         |
| DELETE | `/api/classes/{id}`   | Delete a class         |
| GET    | `/api/subjects`       | List subjects          |
| POST   | `/api/subjects`       | Create a subject       |
| DELETE | `/api/subjects/{id}`  | Delete a subject       |

### Users
| Method | Endpoint           | Description                        |
|--------|--------------------|------------------------------------|
| GET    | `/api/users`       | List users (filter by role/class)  |
| GET    | `/api/teachers`    | List all teachers                  |
| GET    | `/api/students`    | List students (filter by class)    |

### Attendance
| Method | Endpoint                | Description              |
|--------|-------------------------|--------------------------|
| GET    | `/api/attendance`       | Get attendance records   |
| POST   | `/api/attendance/batch` | Submit batch attendance  |

### Marks
| Method | Endpoint        | Description          |
|--------|-----------------|----------------------|
| GET    | `/api/marks`    | Get marks records    |
| POST   | `/api/marks`    | Submit marks         |

### Content (Notes, Assignments, Lectures)
| Method | Endpoint             | Description            |
|--------|----------------------|------------------------|
| GET    | `/api/content`       | List content items     |
| POST   | `/api/content`       | Upload content         |
| DELETE | `/api/content/{id}`  | Delete content         |

### Quizzes
| Method | Endpoint                   | Description            |
|--------|----------------------------|------------------------|
| GET    | `/api/quizzes`             | List quizzes           |
| POST   | `/api/quizzes`             | Create a quiz          |
| POST   | `/api/quizzes/{id}/submit` | Submit quiz answers    |
| GET    | `/api/quizzes/results`     | Get quiz results       |

### Submissions
| Method | Endpoint                       | Description                |
|--------|--------------------------------|----------------------------|
| GET    | `/api/submissions`             | List submissions           |
| POST   | `/api/submissions`             | Submit assignment           |
| PATCH  | `/api/submissions/{id}/grade`  | Grade a submission         |

### Financial
| Method | Endpoint                          | Description                |
|--------|-----------------------------------|----------------------------|
| GET    | `/api/fees`                       | List fee vouchers          |
| POST   | `/api/fees`                       | Create fee voucher         |
| PATCH  | `/api/fees/{id}`                  | Update fee voucher         |
| PATCH  | `/api/fees/{id}/toggle-status`    | Toggle payment status      |
| DELETE | `/api/fees/{id}`                  | Delete fee voucher         |
| GET    | `/api/fines`                      | List fines                 |
| POST   | `/api/fines`                      | Issue a fine               |
| PATCH  | `/api/fines/{id}`                 | Update a fine              |
| DELETE | `/api/fines/{id}`                 | Delete a fine              |
| GET    | `/api/discounts`                  | List discounts             |
| POST   | `/api/discounts`                  | Create discount            |
| PATCH  | `/api/discounts/{id}`             | Update discount            |
| DELETE | `/api/discounts/{id}`             | Delete discount            |
| GET    | `/api/transactions`               | List transactions          |
| POST   | `/api/transactions`               | Create transaction         |
| PATCH  | `/api/transactions/{id}`          | Update transaction         |
| DELETE | `/api/transactions/{id}`          | Delete transaction         |

### Salary
| Method | Endpoint              | Description            |
|--------|-----------------------|------------------------|
| GET    | `/api/salaries`       | List salary records    |
| POST   | `/api/salaries`       | Create salary entry    |
| PATCH  | `/api/salaries/{id}`  | Update salary          |
| DELETE | `/api/salaries/{id}`  | Delete salary record   |

### Other
| Method | Endpoint                  | Description             |
|--------|---------------------------|-------------------------|
| GET    | `/api/announcements`      | List announcements      |
| POST   | `/api/announcements`      | Create announcement     |
| DELETE | `/api/announcements/{id}` | Delete announcement     |
| GET    | `/api/timetable`          | Get timetable           |
| POST   | `/api/timetable`          | Create timetable entry  |
| DELETE | `/api/timetable/{id}`     | Delete timetable entry  |
| GET    | `/api/remarks`            | List remarks            |
| POST   | `/api/remarks`            | Add remark              |
| DELETE | `/api/remarks/{id}`       | Delete remark           |
| GET    | `/api/activity-logs`      | Get activity logs       |
| POST   | `/api/promote`            | Promote students        |

---

## Database Schema

The application uses **24 migrations** defining the following tables:

| Table                  | Description                                      |
|------------------------|--------------------------------------------------|
| `users`                | All users with role field (student/teacher/admin/superadmin) |
| `admission_requests`   | Admission applications with document paths       |
| `school_classes`       | Classes/sections (e.g., 10-A, 9-B)               |
| `subjects`             | Academic subjects                                |
| `attendances`          | Daily attendance records                         |
| `marks`                | Student marks per subject/exam                   |
| `school_contents`      | Notes, assignments, lectures (polymorphic content)|
| `submissions`          | Student assignment submissions                   |
| `quizzes`              | Quiz definitions with settings                   |
| `questions`            | Quiz questions (multiple choice)                 |
| `quiz_results`         | Student quiz scores                              |
| `timetables`           | Class timetable entries                          |
| `fee_vouchers`         | Fee vouchers with payment tracking               |
| `fines`                | Student fines                                    |
| `discounts`            | Fee discounts                                    |
| `finance_transactions` | Financial transaction records                    |
| `salaries`             | Staff salary records                             |
| `announcements`        | School announcements                             |
| `remarks`              | Student behavioral/academic remarks              |
| `activity_logs`        | System activity audit trail                      |

---

## Frontend Architecture

The frontend uses a **modular JavaScript architecture** with dedicated function files for each domain:

| Module                            | Purpose                                      |
|-----------------------------------|----------------------------------------------|
| `auth.js`                         | Login, logout, session management, page protection |
| `main.js`                         | Core UI — sidebar, tooltips, toast notifications   |
| `class-functions.js`              | Class/subject CRUD and teacher listing        |
| `student-functions.js`            | Student data operations                       |
| `finance-functions.js`            | Fee and financial calculations                |
| `fines-functions.js`              | Fine management                               |
| `assignment-functions.js`         | Assignment CRUD                               |
| `subject-assignment-functions.js` | Teacher-subject mapping                       |
| `activity-functions.js`           | Activity log operations                       |
| `charts.js`                       | Dashboard chart rendering (Chart.js)          |
| `notifications.js`                | Toast and alert notifications                 |
| `search.js`                       | Global search functionality                   |
| `storage.js`                      | LocalStorage management and data seeding      |
| `enhancements.js`                 | UI animations and progressive enhancements    |

Each module follows a consistent pattern:
1. **Initialization** — Seed localStorage with default data if empty
2. **CRUD Functions** — API-first with localStorage fallback
3. **Global Exports** — Functions attached to `window` for cross-module access

---

## Security

- **Role-Based Middleware** — Routes are protected with `auth` and `role:{role}` middleware
- **CSRF Protection** — All forms include CSRF tokens
- **Password Hashing** — Bcrypt hashing via Laravel's built-in authentication
- **Input Validation** — Server-side validation via Form Request classes
- **Session Management** — Secure session handling with automatic timeout

---

## License

This project is licensed under the **MIT License**.
