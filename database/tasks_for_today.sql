CREATE DATABASE IF NOT EXISTS tasks_for_today_2
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_general_ci;

USE tasks_for_today_2;

DROP TABLE IF EXISTS tasks;
DROP TABLE IF EXISTS users;

CREATE TABLE tasks (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(150) NOT NULL,
  status VARCHAR(20) NOT NULL DEFAULT 'pending',
  is_archived TINYINT(1) NOT NULL DEFAULT 0,
  task_date DATE NOT NULL,
  created_at DATETIME NOT NULL,
  INDEX idx_tasks_task_date (task_date)
);

CREATE TABLE users (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  full_name VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL,
  password VARCHAR(255) NOT NULL,
  created_at DATETIME NOT NULL
);

INSERT INTO tasks (title, status, is_archived, task_date, created_at) VALUES
('Review project brief and success criteria', 'completed', 0, DATE_SUB(CURDATE(), INTERVAL 2 DAY), NOW()),
('Sketch the dashboard information hierarchy', 'completed', 0, DATE_SUB(CURDATE(), INTERVAL 2 DAY), NOW()),
('Prepare the task and user migrations', 'in_progress', 0, DATE_SUB(CURDATE(), INTERVAL 1 DAY), NOW()),
('Connect models to the shared data layer', 'pending', 0, DATE_SUB(CURDATE(), INTERVAL 1 DAY), NOW()),
('Check the daily priorities with the team', 'in_progress', 0, CURDATE(), NOW()),
('Finish the responsive task dashboard', 'pending', 0, CURDATE(), NOW()),
('Validate every application route', 'pending', 0, CURDATE(), NOW()),
('Write the setup guide for the repository', 'pending', 0, DATE_ADD(CURDATE(), INTERVAL 1 DAY), NOW()),
('Run a final mobile layout review', 'pending', 0, DATE_ADD(CURDATE(), INTERVAL 1 DAY), NOW()),
('Prepare the hosted demonstration', 'pending', 0, DATE_ADD(CURDATE(), INTERVAL 2 DAY), NOW());

INSERT INTO users (username, full_name, email, password, created_at) VALUES
('demo.user', 'Vincent Luke Elpedez', 'elpedezvincent@gmail.com', '$2y$12$6sPdbPsT9xwDFSI.9Xp3Pe0yqCOz0bhUqcYsDZ.3AshImQbhYk3K.', NOW());
