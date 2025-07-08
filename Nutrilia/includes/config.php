<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'nutrilia');

// Site configuration
define('SITE_NAME', 'Nutrilia');
define('SITE_SLOGAN', 'Your Natural Beauty & Wellness Partner');

// Start session
session_start();

// Database connection
function getDBConnection() {
    try {
        $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch(PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
}

// Format price function
function formatPrice($price) {
    return number_format($price, 2) . ' DA';
}

// Check if user is admin
function isAdmin() {
    return isset($_SESSION['admin_id']) && $_SESSION['admin_id'];
}

// Redirect if not admin
function requireAdmin() {
    if (!isAdmin()) {
        header('Location: /admin/login.php');
        exit;
    }
}
?>