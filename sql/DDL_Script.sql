CREATE DATABASE IF NOT EXISTS project_wizard;
USE project_wizard;

DROP TABLE IF EXISTS invoices;
DROP TABLE IF EXISTS stages;
DROP TABLE IF EXISTS project_users;
DROP TABLE IF EXISTS page_visits;
DROP TABLE IF EXISTS projects;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(20) NOT NULL UNIQUE,
    email VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(50) NOT NULL,
    is_admin TINYINT(1) NOT NULL,
    is_active TINYINT(1) NOT NULL
);

CREATE TABLE projects (
    project_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(50) NOT NULL,
    description TEXT,
    total_budget DECIMAL(10,2) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE stages (
    stage_id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT NOT NULL,
    name VARCHAR(50) NOT NULL,
    deadline DATE NOT NULL,
    budget DECIMAL(10,2) NOT NULL,
    color CHAR(7),
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

CREATE TABLE project_users (
    project_id INT NOT NULL,
    user_id    INT NOT NULL,
    PRIMARY KEY (project_id, user_id),
    CONSTRAINT fk_projectusers_project
      FOREIGN KEY (project_id)
      REFERENCES projects (project_id)
      ON DELETE CASCADE
      ON UPDATE CASCADE,
    CONSTRAINT fk_projectusers_user
      FOREIGN KEY (user_id)
      REFERENCES users (user_id)
      ON DELETE CASCADE
      ON UPDATE CASCADE
);

CREATE TABLE page_visits (
  id           INT AUTO_INCREMENT PRIMARY KEY,
  user_id      INT          NULL,
  page         VARCHAR(255) NOT NULL,
  visited_at   DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_page_visits_user
      FOREIGN KEY (user_id)
      REFERENCES users (user_id)
      ON DELETE CASCADE
      ON UPDATE CASCADE
);