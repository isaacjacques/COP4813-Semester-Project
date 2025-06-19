CREATE DATABASE IF NOT EXISTS project_wizard;
USE project_wizard;

CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(20) NOT NULL UNIQUE,
    email VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(50) NOT NULL
);

CREATE TABLE projects (
    project_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(50) NOT NULL,
    description TEXT,
    total_budget DECIMAL(10,2) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
        ON DELETE CASCADE
);

CREATE TABLE stages (
    stage_id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT NOT NULL,
    name VARCHAR(50) NOT NULL,
    deadline DATE NOT NULL,
    budget DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (project_id) REFERENCES projects(project_id)
        ON DELETE CASCADE
);

CREATE TABLE invoices (
    invoice_id INT AUTO_INCREMENT PRIMARY KEY,
    stage_id INT NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    description TEXT,
    date_issued DATE NOT NULL,
    FOREIGN KEY (stage_id) REFERENCES stages(stage_id)
        ON DELETE CASCADE
);
