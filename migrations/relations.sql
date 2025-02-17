-- CREATE DATABASE home_care;
-- \c home_care;

CREATE TABLE Customer (
    id SERIAL PRIMARY KEY,
    firstname VARCHAR(50) NOT NULL,
    lastname VARCHAR(50) NOT NULL,
    phone VARCHAR(20) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    address TEXT NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE Manager (
    id SERIAL PRIMARY KEY,
    firstname VARCHAR(50) NOT NULL,
    lastname VARCHAR(50) NOT NULL,
    phone VARCHAR(20) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE Service (
    id SERIAL PRIMARY KEY,
    service_name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL
);

CREATE TABLE Worker (
    id SERIAL PRIMARY KEY,
    firstname VARCHAR(50) NOT NULL,
    lastname VARCHAR(50) NOT NULL,
    phone VARCHAR(20) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    status VARCHAR(20) CHECK (status IN ('assigned', 'on-site', 'available')) DEFAULT 'available',
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    service_id INT NOT NULL,
    FOREIGN KEY (service_id) REFERENCES Service(id) ON DELETE CASCADE
);

CREATE TABLE Request (
    id SERIAL PRIMARY KEY,
    subject VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    urgency VARCHAR(20) CHECK (urgency IN ('low', 'medium', 'high')) NOT NULL,
    instruction TEXT,
    status VARCHAR(20) CHECK (status IN ('pending', 'assigned', 'in-progress', 'completed', 'cancelled')) DEFAULT 'pending',
    requested_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    customer_id INT NOT NULL,
    service_id INT NOT NULL,
    manager_id INT,
    FOREIGN KEY (customer_id) REFERENCES Customer(id) ON DELETE CASCADE,
    FOREIGN KEY (service_id) REFERENCES Service(id) ON DELETE CASCADE,
    FOREIGN KEY (manager_id) REFERENCES Manager(id) ON DELETE SET NULL
);

CREATE TABLE Assignment (
    request_id INT NOT NULL,
    worker_id INT NOT NULL,
    assigned_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (request_id, worker_id),
    FOREIGN KEY (request_id) REFERENCES Request(id) ON DELETE CASCADE,
    FOREIGN KEY (worker_id) REFERENCES Worker(id) ON DELETE CASCADE
);
