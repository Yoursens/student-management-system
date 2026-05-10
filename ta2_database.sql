-- ============================================================
-- TA2: Student Information System with REST API
-- Database: ta2_student_system
-- CodeIgniter 4 — Terminal Assessment 2
-- ============================================================
-- Run this script from scratch safely — drops and recreates
-- the entire database each time.
-- ============================================================

DROP DATABASE IF EXISTS ta2_student_system;

CREATE DATABASE ta2_student_system
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE ta2_student_system;

-- ─── Disable FK checks during setup ──────────────────────────
SET FOREIGN_KEY_CHECKS = 0;

-- ─── Drop tables (safe order: children first) ─────────────────
DROP TABLE IF EXISTS audit_logs;
DROP TABLE IF EXISTS students;
DROP TABLE IF EXISTS ci_sessions;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS roles;

-- ─── Re-enable FK checks ──────────────────────────────────────
SET FOREIGN_KEY_CHECKS = 1;

-- ============================================================
-- TABLE DEFINITIONS
-- ============================================================

-- ─── Roles ────────────────────────────────────────────────────
CREATE TABLE roles (
    role_id   INT AUTO_INCREMENT PRIMARY KEY,
    role_name VARCHAR(50) NOT NULL UNIQUE
);

-- ─── Users ────────────────────────────────────────────────────
CREATE TABLE users (
    user_id    INT AUTO_INCREMENT PRIMARY KEY,
    full_name  VARCHAR(100) NOT NULL,
    email      VARCHAR(100) NOT NULL UNIQUE,
    password   VARCHAR(255) NOT NULL,
    role_id    INT NOT NULL,
    status     ENUM('active','inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (role_id) REFERENCES roles(role_id)
);

-- ─── Students ─────────────────────────────────────────────────
CREATE TABLE students (
    student_id  INT AUTO_INCREMENT PRIMARY KEY,
    student_no  VARCHAR(30)  NOT NULL UNIQUE,
    first_name  VARCHAR(50)  NOT NULL,
    last_name   VARCHAR(50)  NOT NULL,
    middle_name VARCHAR(50),
    sex         ENUM('Male','Female','Other') NOT NULL,
    birthdate   DATE,
    program     VARCHAR(100),
    year_level  INT,
    section     VARCHAR(50),
    email       VARCHAR(100),
    contact_no  VARCHAR(20),
    address     TEXT,
    photo       VARCHAR(255),
    created_by  INT,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(user_id)
);

-- ─── Audit Logs ───────────────────────────────────────────────
CREATE TABLE audit_logs (
    log_id      INT AUTO_INCREMENT PRIMARY KEY,
    user_id     INT,
    action      VARCHAR(100) NOT NULL,
    description TEXT,
    ip_address  VARCHAR(45),
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE SET NULL
);

-- ─── CI4 Sessions ─────────────────────────────────────────────
CREATE TABLE ci_sessions (
    id         VARCHAR(128) NOT NULL,
    ip_address VARCHAR(45)  NOT NULL,
    timestamp  TIMESTAMP    DEFAULT CURRENT_TIMESTAMP NOT NULL,
    data       BLOB         NOT NULL,
    PRIMARY KEY (id),
    KEY `ci_sessions_timestamp` (timestamp)
);

-- ============================================================
-- SEED DATA
-- ============================================================

-- ─── Seed: Roles ──────────────────────────────────────────────
INSERT INTO roles (role_name) VALUES
  ('Admin'),
  ('Staff');

-- ─── Seed: Users ──────────────────────────────────────────────
-- Passwords: Admin@1234 | Staff@1234 (bcrypt, cost 12)
INSERT INTO users (full_name, email, password, role_id, status) VALUES
(
    'System Admin',
    'admin@studentsys.com',
    '$2y$12$hDgAL9xiR3XaGSGxqRmjc../HBvFoGwEOSPk3l4HBc17K4hYlq.0y',
    1,
    'active'
),
(
    'Registrar Staff',
    'staff@studentsys.com',
    '$2y$12$JiMZDnRztOxzlbbQqBP7q.UIGNWV8ZusnV0vXSjUo6hBPlDb2BtBS',
    2,
    'active'
);

-- ─── Seed: Students ───────────────────────────────────────────
INSERT INTO students
  (student_no, first_name, last_name, middle_name, sex, birthdate,
   program, year_level, section, email, contact_no, created_by)
VALUES
('2024-0001','Maria',  'Santos',     'Cruz',       'Female','2002-03-15','BS Computer Science',       3,'A','msantos@email.com',      '09171234567',1),
('2024-0002','Juan',   'Dela Cruz',  'Reyes',      'Male',  '2001-07-22','BS Information Technology', 4,'B','jdelacruz@email.com',    '09181234567',1),
('2024-0003','Ana',    'Garcia',     'Lopez',      'Female','2003-01-10','BS Computer Engineering',   2,'A','agarcia@email.com',      '09191234567',2),
('2024-0004','Pedro',  'Reyes',      'Santos',     'Male',  '2002-11-05','BS Computer Science',       3,'C','preyes@email.com',       '09201234567',2),
('2024-0005','Luz',    'Flores',     'Mendoza',    'Female','2001-09-18','BS Information Systems',    4,'A','lflores@email.com',      '09211234567',1),
('2024-0006','Carlo',  'Mendoza',    'Bautista',   'Male',  '2003-04-25','BS Computer Science',       2,'B','cmendoza@email.com',     '09221234567',1),
('2024-0007','Rosa',   'Bautista',   'Torres',     'Female','2002-06-12','BS Information Technology', 3,'A','rbautista@email.com',    '09231234567',2),
('2024-0008','Jose',   'Torres',     'Villanueva', 'Male',  '2001-12-30','BS Computer Engineering',   4,'C','jtorres@email.com',      '09241234567',1),
('2024-0009','Elena',  'Villanueva', 'Espinosa',   'Female','2003-08-07','BS Computer Science',       1,'A','evillanueva@email.com',  '09251234567',2),
('2024-0010','Miguel', 'Espinosa',   'Ramos',      'Male',  '2002-02-14','BS Information Technology', 2,'B','mespinosa@email.com',    '09261234567',1);

-- ─── Seed: Audit Logs ─────────────────────────────────────────
INSERT INTO audit_logs (user_id, action, description) VALUES
(1, 'LOGIN',          'User System Admin logged in.'),
(1, 'CREATE_STUDENT', 'Added student #2024-0001'),
(1, 'CREATE_STUDENT', 'Added student #2024-0002'),
(2, 'LOGIN',          'User Registrar Staff logged in.'),
(2, 'CREATE_STUDENT', 'Added student #2024-0003'),
(1, 'UPDATE_STUDENT', 'Updated student ID #3'),
(1, 'CREATE_USER',    'Created user: staff@studentsys.com');

-- ============================================================
-- DONE — ta2_student_system is ready.
-- ============================================================