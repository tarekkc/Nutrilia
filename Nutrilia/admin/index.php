<?php
require_once '../includes/config.php';
requireAdmin();

$pageTitle = 'Admin Dashboard';

// Get statistics
$pdo = getDBConnection();

// Total products
$stmt = $pdo->query("SELECT COUNT(*) FROM products");
$totalProducts = $stmt->fetchColumn();

// Total orders
$stmt = $pdo->query("SELECT COUNT(*) FROM orders");
$totalOrders = $stmt->fetchColumn();

// Pending orders
$stmt = $pdo->query("SELECT COUNT(*) FROM orders WHERE status = 'pending'");
$pendingOrders = $stmt->fetchColumn();

// Total revenue
$stmt = $pdo->query("SELECT SUM(total) FROM orders WHERE status != 'cancelled'");
$totalRevenue = $stmt->fetchColumn() ?: 0;

// Recent orders
$stmt = $pdo->query("SELECT * FROM orders ORDER BY created_at DESC LIMIT 5");
$recentOrders = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Low stock products
$stmt = $pdo->query("SELECT * FROM products WHERE in_stock = 0");
$outOfStockProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);

include 'includes/admin_header.php';
?>

<div class="admin-main">
    <div class="container">
        <h1>Dashboard</h1>
        
        <!-- Statistics -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-value"><?php echo number_format($totalProducts); ?></div>
                <div class="stat-label">Total Products</div>
            </div>
            <div class="stat-card">
                <div class="stat-value"><?php echo number_format($totalOrders); ?></div>
                <div class="stat-label">Total Orders</div>
            </div>
            <div class="stat-card">
                <div class="stat-value"><?php echo number_format($pendingOrders); ?></div>
                <div class="stat-label">Pending Orders</div>
            </div>
            <div class="stat-card">
                <div class="stat-value"><?php echo formatPrice($totalRevenue); ?></div>
                <div class="stat-label">Total Revenue</div>
            </div>
        </div>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
            <!-- Recent Orders -->
            <div class="admin-card">
                <h3>Recent Orders</h3>
                <?php if (empty($recentOrders)): ?>
                    <p>No orders yet.</p>
                <?php else: ?>
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recentOrders as $order): ?>
                                <tr>
                                    <td>#<?php echo $order['id']; ?></td>
                                    <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                                    <td><?php echo formatPrice($order['total']); ?></td>
                                    <td>
                                        <span class="text-<?php echo $order['status'] === 'pending' ? 'warning' : ($order['status'] === 'completed' ? 'success' : 'danger'); ?>">
                                            <?php echo ucfirst($order['status']); ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
                <div style="margin-top: 1rem;">
                    <a href="/admin/orders.php" class="btn btn-small">View All Orders</a>
                </div>
            </div>
            
            <!-- Out of Stock Products -->
            <div class="admin-card">
                <h3>Out of Stock Products</h3>
                <?php if (empty($outOfStockProducts)): ?>
                    <p class="text-success">All products are in stock!</p>
                <?php else: ?>
                    <ul>
                        <?php foreach ($outOfStockProducts as $product): ?>
                            <li style="padding: 0.5rem 0; border-bottom: 1px solid #eee;">
                                <strong><?php echo htmlspecialchars($product['name']); ?></strong><br>
                                <small><?php echo ucfirst($product['category']); ?></small>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
                <div style="margin-top: 1rem;">
                    <a href="/admin/products.php" class="btn btn-small">Manage Products</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/admin_footer.php'; ?>