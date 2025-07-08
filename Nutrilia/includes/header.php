<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle . ' - ' . SITE_NAME : SITE_NAME . ' - ' . SITE_SLOGAN; ?></title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="nav-wrapper">
                <div class="logo">
                    <a href="/">
                        <span class="logo-icon">🌿</span>
                        <span class="logo-text">Nutrilia</span>
                    </a>
                </div>
                
                <nav class="nav">
                    <ul class="nav-menu">
                        <li><a href="/" class="nav-link">Home</a></li>
                        <li><a href="/products.php?category=supplements" class="nav-link">Supplements</a></li>
                        <li><a href="/products.php?category=cosmetics" class="nav-link">Cosmetics</a></li>
                        <li><a href="/products.php" class="nav-link">All Products</a></li>
                    </ul>
                </nav>

                <div class="nav-actions">
                    <button class="cart-btn" onclick="toggleCart()">
                        <span class="cart-icon">🛒</span>
                        <span class="cart-count" id="cart-count">0</span>
                    </button>
                    <button class="menu-toggle" onclick="toggleMenu()">☰</button>
                </div>
            </div>
        </div>
    </header>

    <!-- Cart Sidebar -->
    <div class="cart-sidebar" id="cart-sidebar">
        <div class="cart-header">
            <h3>Shopping Cart</h3>
            <button class="close-cart" onclick="toggleCart()">×</button>
        </div>
        <div class="cart-items" id="cart-items">
            <p class="empty-cart">Your cart is empty</p>
        </div>
        <div class="cart-footer">
            <div class="cart-total">
                <strong>Total: <span id="cart-total">0.00 DA</span></strong>
            </div>
            <button class="checkout-btn" onclick="checkout()">Checkout</button>
        </div>
    </div>

    <div class="cart-overlay" id="cart-overlay" onclick="toggleCart()"></div>

    <main class="main-content">