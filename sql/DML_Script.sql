USE project_wizard;
INSERT INTO users (username, email, password_hash)
VALUES ('admin', 'admin@example.com', MD5('password123'));