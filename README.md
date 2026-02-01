# Event Management System

A Laravel-based application for managing events across different locations. This project features a full CRUD interface, user authentication, and a versioned JSON API.

## Features

### 1. User Authentication & Authorization

- **Public Access:** Guests can view the list of events and individual event details (Read-only).
- **Authenticated Access:** Only logged-in users can access the dashboard to create, update, or delete events.
- **Default Credentials:** The system is seeded with a test user:
- **Name:** `Test User`
- **Password:** `password`

### 2. Event Management (CRUD)

- **Create:** Dynamic form to select existing Spaces and set event schedules.
- **Validation:** Strict validation on incoming data:
- Title is required and capped at 100 characters.
- `start_date` must be a future date.
- `end_date` must occur after the `start_date`.
- `space_id` must exist in the database.

- **Update:** Edit existing event details with pre-populated form data and validation.
- **Delete:** Remove events.

### 3. Versioned JSON API

- **Endpoint:** `GET /api/v1/events`
- **Logic:** Returns only upcoming events (where `start_date > now`).
- **Structure:** Uses Laravel API Resources to provide a flattened JSON structure including space names and space addresses and formatted timestamps.

### 4. Rate limiter

- **Throttle Middleware** Used to protect the `/login` path from brute force and the `/api/v1/news` path from bots. Limitations defined in `/app/Providers/AppServiceProvider.php`

### 5. UI

- **Styling:** The frontend is built using Tailwind CSS with the daisyUI component library for a clean and consistent interface.

---

## Installation Instructions

### 1. Clone the Project

```bash
git clone git@github.com:NikEmman/laravel_event_manager.git
cd laravel_event_manager

```

### 2. Install Dependencies

```bash
composer install
npm install && npm run build

```

### 3. Environment Setup

```bash
cp .env.example .env
php artisan key:generate

```

_Note: Configure your `.env` file with your local database credentials (DB_DATABASE, DB_USERNAME, DB_PASSWORD)._

### 4. Database Migrations and Seeding

This will create the necessary tables, 3 default spaces, 1 test user, and several sample events.

```bash
php artisan migrate:fresh --seed

```

### 5. Start the Application

```bash
php artisan serve

```

The application will be available at `http://localhost:8000`.

---

## Testing

The project includes a comprehensive test suite covering Feature tests for both the Web interface and the API.

To execute all tests, run:

```bash
php artisan test

```

The test suite covers:

- Route protection (Guest vs. Authenticated).
- Validation logic for date constraints.
- Database integrity for CRUD operations.
- API response structure and filtering logic.
