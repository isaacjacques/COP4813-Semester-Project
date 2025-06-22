USE project_wizard;

INSERT INTO users (username, email, password_hash)
VALUES ('admin', 'admin@email.com', MD5('password'));
SET @new_user_id = LAST_INSERT_ID();

INSERT INTO projects (user_id, title, description, total_budget)
VALUES
  (@new_user_id, 'Shipping System', 'Develop and integrate a new shipping and manifesting system', 250000.00);
SET @new_project_id = LAST_INSERT_ID();

INSERT INTO projects (user_id, title, description, total_budget)
VALUES
  (@new_user_id, 'Test Project 2', 'Testing project selection', 20000.00)
  ,(@new_user_id, 'Test Project 3', 'Testing project selection', 30000.00)
  ,(@new_user_id, 'Test Project 4', 'Testing project selection', 40000.00);


INSERT INTO stages (project_id, name, deadline, budget, color)
VALUES (@new_project_id, 'Requirement Gathering', '2025-06-01', 10000.00, '#A7F3D0');
SET @stage1_id = LAST_INSERT_ID();

INSERT INTO stages (project_id, name, deadline, budget, color)
VALUES (@new_project_id, 'Project Proposal', '2025-07-01', 20000.00, '#5EEAD4');
SET @stage2_id = LAST_INSERT_ID();

INSERT INTO stages (project_id, name, deadline, budget, color)
VALUES (@new_project_id, 'Design', '2025-08-01', 30000.00, '#BFDBFE');
SET @stage3_id = LAST_INSERT_ID();

INSERT INTO stages (project_id, name, deadline, budget, color)
VALUES (@new_project_id, 'Development', '2025-09-01', 50000.00, '#E9D5FF');
SET @stage4_id = LAST_INSERT_ID();

INSERT INTO stages (project_id, name, deadline, budget, color)
VALUES (@new_project_id, 'Integration Testing', '2025-10-01', 20000.00, '#FECACA');
SET @stage5_id = LAST_INSERT_ID();

INSERT INTO stages (project_id, name, deadline, budget, color)
VALUES (@new_project_id, 'Client Handoff', '2025-11-15', 10000.00, '#DDD6FE');
SET @stage6_id = LAST_INSERT_ID();


INSERT INTO invoices (stage_id, amount, description, date_issued)
VALUES
  (@stage1_id,  5000.00, 'Partial invoice for Requirement Gathering',      '2025-06-05'),
  (@stage1_id,  4500.00, 'Final invoice for Requirement Gathering',        '2025-06-25'),

  (@stage2_id, 10000.00, 'Downpayment for Project Proposal',              '2025-07-10'),
  (@stage2_id,  9000.00, 'Remaining for Project Proposal',                '2025-07-30'),

  (@stage3_id, 15000.00, 'Design kickoff invoice',                        '2025-08-05'),
  (@stage3_id, 16000.00, 'Design completion invoice',                     '2025-08-20'),

  (@stage4_id, 25000.00, 'Mid-development milestone invoice',            '2025-09-01'),
  (@stage4_id, 23000.00, 'Final development invoice',                     '2025-09-15'),

  (@stage5_id, 10000.00, 'Initial testing invoice',                      '2025-10-05'),
  (@stage5_id, 10500.00, 'Final testing invoice',                        '2025-10-25'),

  (@stage6_id,  5000.00, 'Pre-handoff invoice',                         '2025-11-10'),
  (@stage6_id,  5500.00, 'Final handoff invoice',                       '2025-11-20');