-- Nutrilia Database Schema
CREATE DATABASE IF NOT EXISTS nutrilia;
USE nutrilia;

-- Products table
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    category ENUM('supplements', 'cosmetics') NOT NULL,
    image VARCHAR(255),
    in_stock BOOLEAN DEFAULT TRUE,
    featured BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Orders table
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(255) NOT NULL,
    wilaya VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    status ENUM('pending', 'processing', 'completed', 'cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Order items table
CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    product_name VARCHAR(255) NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- Admin users table
CREATE TABLE admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'super_admin') DEFAULT 'admin',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Sample data
INSERT INTO products (name, description, price, category, image, featured) VALUES
('Vitamin D3 + K2', 'High-quality vitamin D3 with K2 for optimal bone health and immune support. Each capsule contains 2000 IU of vitamin D3 and 100mcg of vitamin K2.', 2500.00, 'supplements', 'https://images.pexels.com/photos/3683098/pexels-photo-3683098.jpeg?auto=compress&cs=tinysrgb&w=400', TRUE),
('Omega-3 Fish Oil', 'Premium omega-3 fish oil with EPA and DHA for heart health and brain function. Molecularly distilled for purity.', 3200.00, 'supplements', 'https://images.pexels.com/photos/3683098/pexels-photo-3683098.jpeg?auto=compress&cs=tinysrgb&w=400', TRUE),
('Collagen Peptides', 'Hydrolyzed collagen peptides for skin, hair, and joint health. Unflavored powder mixes easily in any beverage.', 4500.00, 'supplements', 'https://images.pexels.com/photos/3683098/pexels-photo-3683098.jpeg?auto=compress&cs=tinysrgb&w=400', FALSE),
('Hyaluronic Acid Serum', 'Intensive hydrating serum with pure hyaluronic acid for plump, youthful skin. Reduces fine lines and improves skin texture.', 3800.00, 'cosmetics', 'https://images.pexels.com/photos/3685530/pexels-photo-3685530.jpeg?auto=compress&cs=tinysrgb&w=400', TRUE),
('Vitamin C Face Cream', 'Brightening face cream with stabilized vitamin C, hyaluronic acid, and peptides. Evens skin tone and provides antioxidant protection.', 4200.00, 'cosmetics', 'https://images.pexels.com/photos/3685530/pexels-photo-3685530.jpeg?auto=compress&cs=tinysrgb&w=400', TRUE),
('Retinol Night Serum', 'Gentle retinol serum for overnight skin renewal. Helps reduce signs of aging and improve skin texture.', 3600.00, 'cosmetics', 'https://images.pexels.com/photos/3685530/pexels-photo-3685530.jpeg?auto=compress&cs=tinysrgb&w=400', FALSE),
('Probiotics Complex', 'Multi-strain probiotic supplement with 50 billion CFUs for digestive and immune health support.', 2800.00, 'supplements', 'https://images.pexels.com/photos/3683098/pexels-photo-3683098.jpeg?auto=compress&cs=tinysrgb&w=400', FALSE),
('Niacinamide Serum', 'Pore-minimizing serum with 10% niacinamide to control oil production and improve skin texture.', 2900.00, 'cosmetics', 'https://images.pexels.com/photos/3685530/pexels-photo-3685530.jpeg?auto=compress&cs=tinysrgb&w=400', FALSE);

-- Default admin user (password: admin123)
INSERT INTO admin_users (username, password, role) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'super_admin');