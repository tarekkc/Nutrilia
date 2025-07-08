<?php
require_once 'includes/config.php';

$orderId = $_GET['id'] ?? '';

if (!$orderId) {
    header('Location: /');
    exit;
}

// Get order details
$pdo = getDBConnection();
$stmt = $pdo->prepare("SELECT * FROM orders WHERE id = ?");
$stmt->execute([$orderId]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    header('Location: /');
    exit;
}

// Get order items
$stmt = $pdo->prepare("SELECT * FROM order_items WHERE order_id = ?");
$stmt->execute([$orderId]);
$orderItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

$pageTitle = 'Order Confirmation';

include 'includes/header.php';
?>

<section class="order-success" style="padding: 4rem 0; text-align: center;">
    <div class="container">
        <div style="max-width: 600px; margin: 0 auto;">
            <div style="font-size: 4rem; color: #27ae60; margin-bottom: 2rem;">✅</div>
            
            <h1 style="color: #2d5a27; margin-bottom: 1rem;">Order Placed Successfully!</h1>
            
            <p style="font-size: 1.2rem; color: #666; margin-bottom: 2rem;">
                Thank you for your order! We'll contact you soon to confirm your purchase.
            </p>
            
            <div class="order-details" style="background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); margin-bottom: 2rem; text-align: left;">
                <h3 style="color: #2d5a27; margin-bottom: 1rem;">Order Details</h3>
                
                <div style="margin-bottom: 1rem;">
                    <strong>Order ID:</strong> #<?php echo $order['id']; ?>
                </div>
                
                <div style="margin-bottom: 1rem;">
                    <strong>Customer:</strong> <?php echo htmlspecialchars($order['customer_name']); ?>
                </div>
                
                <div style="margin-bottom: 1rem;">
                    <strong>Wilaya:</strong> <?php echo htmlspecialchars($order['wilaya']); ?>
                </div>
                
                <div style="margin-bottom: 1rem;">
                    <strong>Phone:</strong> <?php echo htmlspecialchars($order['phone']); ?>
                </div>
                
                <div style="margin-bottom: 1rem;">
                    <strong>Order Date:</strong> <?php echo date('F j, Y, g:i a', strtotime($order['created_at'])); ?>
                </div>
                
                <div style="margin-bottom: 1rem;">
                    <strong>Status:</strong> 
                    <span style="color: #f39c12; font-weight: 600;"><?php echo ucfirst($order['status']); ?></span>
                </div>
                
                <h4 style="margin: 1.5rem 0 1rem; color: #2d5a27;">Items Ordered:</h4>
                
                <?php foreach ($orderItems as $item): ?>
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.5rem 0; border-bottom: 1px solid #eee;">
                        <div>
                            <strong><?php echo htmlspecialchars($item['product_name']); ?></strong><br>
                            <small>Quantity: <?php echo $item['quantity']; ?></small>
                        </div>
                        <div style="font-weight: 600;">
                            <?php echo formatPrice($item['price'] * $item['quantity']); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
                
                <div style="margin-top: 1rem; padding-top: 1rem; border-top: 2px solid #2d5a27;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <strong style="font-size: 1.2rem;">Total:</strong>
                        <strong style="font-size: 1.2rem; color: #2d5a27;">
                            <?php echo formatPrice($order['total']); ?>
                        </strong>
                    </div>
                </div>
            </div>
            
            <div style="background: #e8f4f8; padding: 1.5rem; border-radius: 8px; margin-bottom: 2rem;">
                <h4 style="margin-bottom: 1rem; color: #2d5a27;">What's Next?</h4>
                <p style="color: #666; margin-bottom: 0.5rem;">
                    📞 We'll call you within 24 hours to confirm your order
                </p>
                <p style="color: #666; margin-bottom: 0.5rem;">
                    🚚 Your order will be shipped within 2-3 business days
                </p>
                <p style="color: #666;">
                    💳 Payment is due upon delivery (Cash on Delivery)
                </p>
            </div>
            
            <div style="display: flex; gap: 1rem; justify-content: center;">
                <a href="/products.php" class="btn">Continue Shopping</a>
                <a href="/" class="btn btn-outline">Back to Home</a>
            </div>
        </div>
    </div>
</section>

<script>
// Clear cart after successful order
localStorage.removeItem('cart');
localStorage.removeItem('checkoutCart');

// Update cart display
if (typeof cart !== 'undefined') {
    cart.clearCart();
}
</script>

<?php include 'includes/footer.php'; ?>