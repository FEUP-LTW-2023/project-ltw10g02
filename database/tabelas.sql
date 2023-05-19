.headers on
.mode columns

DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS user_department;
DROP TABLE IF EXISTS tickets;
DROP TABLE IF EXISTS ticket_history;
DROP TABLE IF EXISTS ticket_hashtags;

DROP TABLE IF EXISTS hashtags;
DROP TABLE IF EXISTS departments;
DROP TABLE IF EXISTS faqs;
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS comments;

-- Users table stores information about registered users
CREATE TABLE users (
  id INTEGER PRIMARY KEY,
  name TEXT NOT NULL,
  username TEXT NOT NULL UNIQUE,
  pass TEXT NOT NULL,
  email TEXT NOT NULL UNIQUE,
  category TEXT NOT NULL
);

CREATE TABLE user_department (
  user_id INTEGER NOT NULL,
  department_id INTEGER NOT NULL,
  PRIMARY KEY (user_id, department_id),
  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (department_id) REFERENCES departments(id)
);


-- Departments table stores information about support departments
CREATE TABLE departments (
  id INTEGER PRIMARY KEY,
  name TEXT NOT NULL UNIQUE,
  description TEXT
);

-- FAQs table stores information about frequently asked questions
CREATE TABLE faqs (
  id INTEGER PRIMARY KEY,
  question TEXT NOT NULL UNIQUE,
  answer TEXT NOT NULL
);

-- Categories table stores information about clothing categories
CREATE TABLE categories (
  id INTEGER PRIMARY KEY,
  name TEXT NOT NULL UNIQUE
);

-- Products table stores information about clothing products
CREATE TABLE products (
  id INTEGER PRIMARY KEY,
  name TEXT NOT NULL,
  price REAL NOT NULL,
  size TEXT NOT NULL,
  category_id INTEGER NOT NULL,
  inventory INTEGER NOT NULL DEFAULT 0,
  FOREIGN KEY (category_id) REFERENCES categories(id)
);

-- Tickets table stores information about support tickets
CREATE TABLE tickets (
  id INTEGER PRIMARY KEY,
  subject TEXT NOT NULL,
  description TEXT NOT NULL,
  status TEXT NOT NULL DEFAULT 'Open',
  priority TEXT,
  client_id INTEGER NOT NULL,
  department_id INTEGER NOT NULL,
  agent_id INTEGER,
  faq_id INTEGER,
  product_id INTEGER,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (client_id) REFERENCES users(id),
  FOREIGN KEY (department_id) REFERENCES departments(id),
  FOREIGN KEY (agent_id) REFERENCES users(id),
  FOREIGN KEY (faq_id) REFERENCES faqs(id),
  FOREIGN KEY (product_id) REFERENCES products(id)
);

CREATE TABLE ticket_history (
  id INTEGER PRIMARY KEY,
  ticket_id INTEGER NOT NULL,
  subject TEXT,
  description TEXT,
  status TEXT,
  priority TEXT,
  department_id INTEGER,
  agent_id INTEGER,
  faq_id INTEGER,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (ticket_id) REFERENCES tickets(id),
  FOREIGN KEY (department_id) REFERENCES departments(id),
  FOREIGN KEY (agent_id) REFERENCES users(id),
  FOREIGN KEY (faq_id) REFERENCES faqs(id)
);

-- Hashtags table stores information about hashtags used in tickets
CREATE TABLE hashtags (
  id INTEGER PRIMARY KEY,
  name TEXT NOT NULL UNIQUE
);

-- Ticket_hashtags table stores the relationship between tickets and hashtags
CREATE TABLE ticket_hashtags (
  ticket_id INTEGER NOT NULL,
  hashtag_id INTEGER NOT NULL,
  PRIMARY KEY (ticket_id, hashtag_id),
  FOREIGN KEY (ticket_id) REFERENCES tickets(id),
  FOREIGN KEY (hashtag_id) REFERENCES hashtags(id)
);

-- Comments table
CREATE TABLE comments (
  id INTEGER PRIMARY KEY, 
  ticket_id INTEGER NOT NULL,
  user_id INTEGER NOT NULL,
  body TEXT NOT NULL,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (ticket_id) REFERENCES tickets(id),
  FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Triggers for populating ticket_history table
.read add_history_trigger.sql
.read update_ticket_trigger.sql


-- Insert sample data for categories table
INSERT INTO categories (name) VALUES 
    ('T-shirts'),
    ('Jeans'),
    ('Dresses');

-- Insert sample data for products table
INSERT INTO products (name, price, size, category_id, inventory) VALUES 
    ('White T-shirt', 9.99, 'M', 1, 100),
    ('Blue Jeans', 29.99, 'M', 2, 50),
    ('Floral Summer Dress', 49.99, 'S', 3, 25),
    ('Blue Shirt', 20.0, 'M', 1, 10),
    ('Red Shirt', 22.5, 'L', 1, 15),
    ('Black Pants', 30.0, 'S', 2, 5),
    ('Blue Shoes', 50.0, '10', 3, 2),
    ('Brown Shoes', 55.0, '9', 3, 3);

-- Insert departments
INSERT INTO departments (name, description) VALUES
    ('Sales', 'Handles sales inquiries and issues'),
    ('Billing', 'Handles billing inquiries and issues'),
    ('Technical Support', 'Handles technical support inquiries and issues'),
    ('Exchanges and Returns',  'Handles inquiries and issues related to exchanges and returns');

-- Insert users
INSERT INTO users (name, username, pass, email, category) VALUES
  ('Maria Rabelo', 'mariaarabelo', '$2y$10$W7ohksgUA9VA3t.0s72TwOfoPcXBgJkKdQO3dnXF/EJ5Pxr7MZ/jO', 'maria@example.com', 'client'),
  ('Matheus Utino', 'utino', '$2y$10$Y3f3NGEOzdOlDU2Xdqa.Ve6H5iglAOz73Ncbjy2h7BiCVPOOmhBZO', 'matheus@example.com', 'client'),
  ('Sofia Sousa', 'ssousa', '$2y$10$PPhZnOq6BWwWzjxnreus0ebM5OL4lex6o4hhAjc8yudy2AwgMhLwK', 'sofia@example.com', 'agent'),
  ('Devezas', 'devezas', '$2y$10$GeH80VA.nE5fBIup8z0yn.hhv/6aGpfzkKwTJoP1IL5dE.tGLtRIm', 'devezas@example.com', 'agent'),
  ('Andre Restivo', 'arestivo', '$2y$10$GmEwMtS.bW4TWcZ7s11C0.y3CABbl07mSQhZ9XEvKF3Nej0a.RnT2', 'restivo@example.com', 'admin');

INSERT INTO user_department (user_id, department_id) VALUES
  (3, 1), --Sofia
  (3, 2),
  (4, 3), --Devezas
  (4, 4);
  
-- Insert FAQs
INSERT INTO faqs (question, answer) VALUES
    ('How do I reset my password?', 'You can reset your password by clicking on the "Forgot password" link on the login page.'),
    ('How can I contact customer support?', 'You can contact customer support by submitting a ticket through the website.'),
    ('What is your return policy?', 'You can return items within 30 days of purchase for a full refund.'),
    ('How long does shipping take?', 'Shipping takes 3-5 business days.'),
    ('How do I change my email address?', 'You can change your email address by editing your profile information.');

-- Insert tickets
INSERT INTO tickets (subject, description, client_id, department_id, agent_id, faq_id, product_id)
VALUES
    ('Defective T-shirt', 'Received a t-shirt with a hole in it', 1, 4, 3, NULL, 1),
    ('Billing Inquiry', 'Need clarification on a charge', 2, 2, 4, NULL, NULL),
    ('Jeans sizing', 'Are these jeans true to size?', 1, 3, 3, NULL, 2),
    ('How do I change my password?', 'I would like to change my password but I don''t know how', 1, 3, NULL, 1, NULL),
    ('Wrong size product', 'My shirt does not fit me',  3, 4, 1, 3, 4),
    ('Refund request', 'I would like to request a refund for my recent purchase', 2, 4, 1, NULL, 2),
    ('Account Access Issue', 'I am unable to log into my account. It says my password is incorrect.', 2, 1, 5, NULL, NULL),
    ('Product Return Request', 'I would like to return a product I recently purchased as it arrived damaged.', 3, 4, 5, NULL, 4),
    ('Order Modification', 'I need to update the shipping address for my order #123456.', 1, 2, 5, NULL, 3),
    ('Technical Issue', 'Im experiencing an error message when trying to submit a form on the website.', 2, 3, 5, NULL, NULL),
    ('Product Availability Inquiry', 'Is the XYZ product currently in stock? I would like to place an order.', 3, 4, 5, NULL, 5);
    


-- Insert hashtags
INSERT INTO hashtags (name) VALUES
  ('password'),
  ('billing'),
  ('login'),
  ('email'),
  ('defective'),
  ('sizing'),
  ('technical');

-- Insert ticket_hashtags
INSERT INTO ticket_hashtags (ticket_id, hashtag_id) 
VALUES 
  (1, 5),
  (2, 2),
  (3, 6),
  (4, 1),
  (5, 7),
  (6, 1),
  (6, 2);

INSERT INTO comments (ticket_id, user_id, body)
VALUES
  (6, 1, 'Can someone help me with my refund?');

