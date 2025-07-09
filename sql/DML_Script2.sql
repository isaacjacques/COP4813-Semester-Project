/* Insert Test Data for Analytics dashboard
    Users: 10 users (admins and non-admins, active/inactive) with varied creation dates.
    Projects: Two new projects (“Marketing Campaign” and “Website Redesign”) tied to users.
    Project Users: Assignments of users to these projects.
    Stages: Multiple stages per project with deadlines, budgets, and colors.
    Invoices: Detailed invoices per stage with dates.
    Page Visits: Manual and random visit records over the last 30 days across key pages.
*/
USE project_wizard;

INSERT INTO users (username, email, password_hash, is_admin, is_active, created_at) VALUES
  ('alice',   'alice@example.com',   MD5('alice123'), 1, 1, '2025-01-10 08:15:00'),
  ('bob',     'bob@example.com',     MD5('bob123'),   0, 1, '2025-02-05 10:30:00'),
  ('carol',   'carol@example.com',   MD5('carol123'), 0, 0, '2025-03-12 14:45:00'),
  ('dave',    'dave@example.com',    MD5('dave123'),  0, 1, '2025-04-20 09:20:00'),
  ('eve',     'eve@example.com',     MD5('eve123'),   1, 1, '2025-05-22 11:05:00'),
  ('frank',   'frank@example.com',   MD5('frank123'), 0, 1, '2025-06-15 16:00:00'),
  ('grace',   'grace@example.com',   MD5('grace123'), 0, 1, '2025-07-01 12:00:00'),
  ('heidi',   'heidi@example.com',   MD5('heidi123'), 0, 0, '2025-07-08 17:30:00'),
  ('ivan',    'ivan@example.com',    MD5('ivan123'),  0, 1, '2025-07-09 14:00:00'),
  ('judy',    'judy@example.com',    MD5('judy123'),  0, 1, '2025-07-09 15:30:00');

INSERT INTO projects (title, description, total_budget, created_at) VALUES
  ('Marketing Campaign', 'Design and launch summer marketing campaign', 50000.00, '2025-03-01 09:00:00'),
  ('Website Redesign',   'Full redesign of corporate website',      75000.00, '2025-04-10 13:30:00');

SET @proj_mkt = LAST_INSERT_ID() - 1;
SET @proj_web = LAST_INSERT_ID();

INSERT INTO project_users (project_id, user_id) VALUES
  (@proj_mkt, (SELECT user_id FROM users WHERE username='bob')),
  (@proj_mkt, (SELECT user_id FROM users WHERE username='carol')),
  (@proj_web, (SELECT user_id FROM users WHERE username='dave')),
  (@proj_web, (SELECT user_id FROM users WHERE username='eve'));

INSERT INTO stages (project_id, name, deadline, budget, color, created_at) VALUES
  (@proj_mkt, 'Planning',        '2025-03-15', 10000.00, '#FFEDD5', '2025-03-01 10:00:00'),
  (@proj_mkt, 'Creative Design', '2025-04-01', 15000.00, '#DBEAFE', '2025-03-16 11:00:00'),
  (@proj_mkt, 'Execution',       '2025-05-01', 20000.00, '#D1FAE5', '2025-04-02 14:00:00');
SET @mkt_stage1 = LAST_INSERT_ID() - 2;
SET @mkt_stage2 = LAST_INSERT_ID() - 1;
SET @mkt_stage3 = LAST_INSERT_ID();

INSERT INTO stages (project_id, name, deadline, budget, color, created_at) VALUES
  (@proj_web, 'Requirements', '2025-04-20', 12000.00, '#FDE68A', '2025-04-10 14:00:00'),
  (@proj_web, 'Mockups',      '2025-05-10', 20000.00, '#FECACA', '2025-04-21 09:00:00'),
  (@proj_web, 'Development',  '2025-06-20', 30000.00, '#E0E7FF', '2025-05-11 13:00:00');
SET @web_stage1 = LAST_INSERT_ID() - 2;
SET @web_stage2 = LAST_INSERT_ID() - 1;
SET @web_stage3 = LAST_INSERT_ID();

INSERT INTO invoices (stage_id, amount, description, date_issued) VALUES
  (@mkt_stage1, 5000.00, 'Initial planning payment',            '2025-03-05'),
  (@mkt_stage1, 1200.00, 'Work payment 2',                      '2025-03-05'),
  (@mkt_stage1, 4500.00, 'Planning completion payment',         '2025-03-14'),
  (@mkt_stage2, 10000.00,'Design kickoff fee',                  '2025-03-20'),
  (@mkt_stage2, 12000.00,'Design completion fee',               '2025-04-01'),
  (@mkt_stage3, 20000.00,'Execution milestone payment 1',        '2025-05-01'),
  (@mkt_stage3, 20000.00,'Execution milestone payment 2',        '2025-05-01'),
  (@mkt_stage3, 20000.00,'Execution milestone payment 3',        '2025-05-01');

INSERT INTO invoices (stage_id, amount, description, date_issued) VALUES
  (@web_stage1, 6000.00, 'Requirements gathering invoice',      '2025-04-12'),
  (@web_stage2, 15000.00,'Mockup delivery invoice',             '2025-05-12'),
  (@web_stage3, 25000.00,'Development phase invoice',          '2025-06-01'),
  (@web_stage3, 5000.00, 'Final review & launch invoice',        '2025-06-20');

INSERT INTO page_visits (user_id, page, visited_at) VALUES
  ((SELECT user_id FROM users WHERE username='alice'),   '/dashboard',  '2025-07-01 08:00:00'),
  ((SELECT user_id FROM users WHERE username='bob'),     '/projects',   '2025-07-02 09:15:00'),
  ((SELECT user_id FROM users WHERE username='carol'),   '/dashboard',  '2025-07-02 10:30:00'),
  ((SELECT user_id FROM users WHERE username='dave'),    '/stages',     '2025-07-03 11:00:00'),
  ((SELECT user_id FROM users WHERE username='eve'),     '/analytics',  '2025-07-04 12:45:00'),
  ((SELECT user_id FROM users WHERE username='frank'),   '/dashboard',  '2025-07-05 14:20:00'),
  ((SELECT user_id FROM users WHERE username='grace'),   '/reports',    '2025-07-06 15:10:00'),
  ((SELECT user_id FROM users WHERE username='heidi'),   '/dashboard',  '2025-07-07 16:30:00'),
  ((SELECT user_id FROM users WHERE username='ivan'),    '/projects',   '2025-07-08 17:00:00'),
  ((SELECT user_id FROM users WHERE username='judy'),    '/dashboard',  '2025-07-09 18:00:00');

INSERT INTO page_visits (user_id, page, visited_at)
SELECT user_id,
       ELT(FLOOR(RAND()*5)+1, '/dashboard','/projects','/stages','/reports','/analytics'),
       TIMESTAMP(DATE_SUB('2025-07-09', INTERVAL FLOOR(RAND()*29) DAY),
                 CONCAT(FLOOR(RAND()*23),':',FLOOR(RAND()*59),':',FLOOR(RAND()*59)))
FROM users
WHERE is_active = 1
LIMIT 50;
