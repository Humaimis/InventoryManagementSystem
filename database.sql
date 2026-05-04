-- Create the database
CREATE DATABASE IF NOT EXISTS inventory_db;
USE inventory_db;

-- Table 1: products
CREATE TABLE IF NOT EXISTS products (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    quantity INT NOT NULL DEFAULT 0
);

-- Table 2: categories
CREATE TABLE IF NOT EXISTS categories (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description VARCHAR(255) NOT NULL
);

-- Table 3: contacts
CREATE TABLE IF NOT EXISTS contacts (
    contact_id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    subject VARCHAR(150) NOT NULL,
    message TEXT NOT NULL
);

-- Insert sample data into products
INSERT INTO products (name, price, quantity) VALUES
('Laptop',    500.00, 10),
('Phone',     300.00, 20),
('Tablet',    200.00, 15),
('Monitor',   150.00,  8),
('Keyboard',   25.00, 50);

-- Insert sample data into categories
INSERT INTO categories (name, description) VALUES
('Electronics',  'Devices and gadgets'),
('Furniture',    'Home and office items'),
('Clothing',     'Shirts, pants, and accessories'),
('Food',         'Perishable grocery items'),
('Stationery',   'Pens, notebooks, and office supplies');

-- Insert sample data into contacts
INSERT INTO contacts (full_name, email, subject, message) VALUES
('Ali Hassan',    'ali@example.com',   'Question',  'I have a question about the system.'),
('Sara Ahmed',    'sara@example.com',  'Feedback',  'Great system, very easy to use!'),
('Omar Salim',    'omar@example.com',  'Bug Report','The search feature does not work on mobile.'),
('Mona Khalid',   'mona@example.com',  'Request',   'Can you add export to Excel feature?'),
('Yusuf Nasser',  'yusuf@example.com', 'Other',     'I need help resetting my password.');
