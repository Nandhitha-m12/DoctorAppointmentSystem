CREATE DATABASE IF NOT EXISTS doctor_appointment;
USE doctor_appointment;

-- -----------------------
-- Admin Table
-- -----------------------
CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- -----------------------
-- Doctors Table
-- -----------------------
CREATE TABLE doctors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(20),
    specialization VARCHAR(100),
    qualification VARCHAR(150),
    image VARCHAR(255),
    experience INT,
    password VARCHAR(255) NOT NULL,
    status ENUM('Available','Unavailable') DEFAULT 'Available'
);

-- -----------------------
-- Patients Table
-- -----------------------
CREATE TABLE patients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(20),
    dob DATE,
    gender ENUM('Male','Female','Other'),
    address TEXT,
    password VARCHAR(255) NOT NULL
);

-- -----------------------
-- Appointments Table
-- -----------------------
CREATE TABLE appointments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT NOT NULL,
    doctor_id INT NOT NULL,
    appointment_date DATE NOT NULL,
    appointment_time TIME NOT NULL,
    symptoms TEXT,
    status ENUM('Pending','Approved','Completed','Cancelled')
           DEFAULT 'Pending',

    FOREIGN KEY (patient_id)
        REFERENCES patients(id)
        ON DELETE CASCADE,

    FOREIGN KEY (doctor_id)
        REFERENCES doctors(id)
        ON DELETE CASCADE
);