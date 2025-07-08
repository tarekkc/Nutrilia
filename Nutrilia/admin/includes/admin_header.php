<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?> - <?php echo SITE_NAME; ?> Admin</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <header class="admin-header">
        <div class="container">
            <nav class="admin-nav">
                <div class="logo">
                    <a href="/admin/" style="color: white; text-decoration: none;">
                        🌿 <?php echo SITE_NAME; ?> Admin
                    </a>
                </div>
                
                <ul>
                    <li><a href="/admin/">Dashboard</a></li>
                    <li><a href="/admin/products.php">Products</a></li>
                    <li><a href="/admin/orders.php">Orders</a></li>
                    <li><a href="/admin/users.php">Users</a></li>
                </ul>
                
                <div>
                    <span style="margin-right: 1rem;">Welcome, <?php echo htmlspecialchars($_SESSION['admin_username']); ?></span>
                    <a href="/admin/logout.php" style="color: white; text-decoration: none;">Logout</a>
                </div>
            </nav>
        </div>
    </header>