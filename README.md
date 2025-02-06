# Home Care Service API

A simple home care service management system built with **Vanilla PHP** and **PostgreSQL**. This project allows customers to request home maintenance services, managers to oversee service requests, and workers to be assigned tasks.

## Features
- User authentication for Customers, Managers, and Workers.
- CRUD operations for services, requests, and assignments.
- Role-based access control.
- Request tracking with status updates.
- PostgreSQL database for structured data management.
- A simple **custom PHP router** for handling routes.

## Tech Stack
- **Backend:** Vanilla PHP (No frameworks)
- **Database:** PostgreSQL
- **Routing:** Custom PHP Router

## Installation
### 1. Clone the Repository
```sh
git clone https://github.com/YakuBrangJa/home_care_server.git
cd home_care_server
```

### 2. Set Up the Database
Make sure **PostgreSQL** is installed and running. Then, execute the schema SQL file:
```sh
psql -U your_user -d postgres -f database/schema.sql
```
Or manually:
```sql
CREATE DATABASE home_care;
\c home_care;
-- Run the SQL schema from schema.sql
```

### 3. Configure Environment Variables
Rename `.env.example.php` to `.env.php` and configure database credentials:
```env
DB_HOST=localhost
DB_PORT=5432
DB_NAME=home_care
DB_USER=your_user
DB_PASSWORD=your_password
```

### 4. Start the PHP Development Server
Run the built-in PHP server:
```sh
php -S localhost:9000 -t public/
```
Access the API at `http://localhost:9000`

## API Routes
### Public Routes
| Method | Endpoint          | Description            |
|--------|------------------|------------------------|
| POST   | `/register`      | Customer registration  |
| POST   | `/login`         | User authentication    |

### Protected Routes (Require Authentication)
| Method | Endpoint             | Description                  |
|--------|----------------------|------------------------------|
| GET    | `/services`          | List available services      |
| POST   | `/request`           | Create a new service request |
| GET    | `/request/:id`       | View a request's details     |
| PUT    | `/request/:id`       | Update a request's status    |
| POST   | `/assign/:requestId` | Assign a worker to request   |


