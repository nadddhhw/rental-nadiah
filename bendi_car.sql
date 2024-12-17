CREATE DATABASE bendi_car_rental;
USE bendi_car_rental;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE,
    password VARCHAR(50),
    role VARCHAR(20)
);

CREATE TABLE customers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    identity_number VARCHAR(50),
    phone VARCHAR(20),
    address VARCHAR(255)
);

CREATE TABLE cars (
    id INT AUTO_INCREMENT PRIMARY KEY,
    brand VARCHAR(50),
    model VARCHAR(50),
    plate_number VARCHAR(20) UNIQUE,
    rental_price DECIMAL(10,2),
    driver_price DECIMAL(10,2)
);

CREATE TABLE rentals (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT,
    car_id INT,
    start_date DATE,
    end_date DATE,
    with_driver BOOLEAN,
    total_payment DECIMAL(10,2),
    FOREIGN KEY (customer_id) REFERENCES customers(id),
    FOREIGN KEY (car_id) REFERENCES cars(id)
);

CREATE TABLE returns (
    id INT AUTO_INCREMENT PRIMARY KEY,
    rental_id INT,
    return_date DATE,
    late_days INT,
    damage_fee DECIMAL(10,2),
    total_fee DECIMAL(10,2),
    FOREIGN KEY (rental_id) REFERENCES rentals(id)
);

INSERT INTO users (username, password, role) VALUES ('admin', 'admin123', 'admin');
