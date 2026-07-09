# Gym Membership System

A web-based **Gym Membership System** developed using **Laravel** that helps gym administrators efficiently manage members, trainers, memberships, payments, workouts, and reports. The system also provides members with access to their own dashboard where they can view their membership details and assigned workout plans.

---

## Project Overview

The Gym Membership System is designed to simplify the daily operations of a gym by digitizing member registration, membership management, payment tracking, workout scheduling, and report generation.

The system supports two user roles:

- **Administrator**
- **Member**

---

## Features

### Administrator

- Secure Login
- Dashboard Overview
- Manage Members
- Manage Trainers
- Manage Membership Plans
- Approve Membership Requests
- Manage Workout Plans
- Generate Weekly Workout Schedules
- Record Member Payments
- BMI Calculator
- Generate Reports
- Analytics Dashboard

### Member

- Secure Login
- View Profile
- View Membership Information
- View Payment History
- View Assigned Workout Plan
- Submit Membership Request
- BMI Calculator

---

## Built With

- **Laravel**
- PHP
- MySQL
- Blade Templates
- Bootstrap
- JavaScript
- HTML5
- CSS3

---

## System Modules

- Authentication
- Dashboard
- Member Management
- Trainer Management
- Membership Management
- Membership Requests
- Payment Management
- Workout Management
- BMI Calculator
- Reports
- Analytics

---

## Workflow

1. User registers an account.
2. User submits a membership request.
3. Administrator reviews and approves the request.
4. Administrator assigns a membership plan.
5. Payments are recorded.
6. Workout plans are assigned.
7. Members can monitor their membership and workouts through their dashboard.
8. Administrators generate reports for monitoring gym operations.

---

## Installation Guide

### Requirements

- PHP 8.x
- Composer
- MySQL
- Node.js & NPM
- XAMPP/Laragon

### Clone the repository

```bash
git clone https://github.com/yourusername/gym-membership-system.git
```

### Go to the project directory

```bash
cd gym-membership-system
```

### Install PHP dependencies

```bash
composer install
```

### Install Node dependencies

```bash
npm install
```

### Copy the environment file

```bash
cp .env.example .env
```

### Generate application key

```bash
php artisan key:generate
```

### Configure the database

Update the `.env` file with your database credentials.

Example:

```env
DB_DATABASE=gym_membership
DB_USERNAME=root
DB_PASSWORD=
```

### Run database migrations

```bash
php artisan migrate
```

If your project includes seeders:

```bash
php artisan db:seed
```

### Compile assets

```bash
npm run dev
```

### Start the development server

```bash
php artisan serve
```

Open your browser:

```
http://127.0.0.1:8000
```

---

## Default Login

### Administrator

```
Email:
Password:
```

### Member

```
Email:
Password:
```

*(Replace these with your actual demo accounts.)*

---

## Project Structure

```
app/
bootstrap/
config/
database/
public/
resources/
routes/
storage/
```

---

## Screenshots

You may include screenshots here.

Example:

```
docs/
├── login.png
├── dashboard.png
├── members.png
├── payments.png
└── reports.png
```

---

## Developers

- Member 1
- Member 2
- Member 3
- Member 4

---

## Academic Information

**Project Title:** Gym Membership System

**Course:** *Bachelor of Science in Information Technology*

**Subject:** * Elective 1 (Web Systems and Technologies 2) *

**Instructor:** *Carl Gustaf Patrik Ferrer*

**School:** *Pangasinan State University - Lingayen Campus*

**Academic Year:** 2026–2027

---

## License

This project was developed for educational purposes only.

Commercial use is not permitted without permission from the developers.

---

