<?php
require_once 'includes/config.php';

$pageTitle = 'Checkout';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customerName = trim($_POST['customer_name'] ?? '');
    $wilaya = $_POST['wilaya'] ?? '';
    $phone = trim($_POST['phone'] ?? '');
    $cartData = json_decode($_POST['cart_data'] ?? '[]', true);
    
    $errors = [];
    
    // Validation
    if (empty($customerName)) {
        $errors[] = 'Full name is required';
    }
    
    if (empty($wilaya)) {
        $errors[] = 'Wilaya is required';
    }
    
    if (empty($phone)) {
        $errors[] = 'Phone number is required';
    }
    
    if (empty($cartData)) {
        $errors[] = 'Cart is empty';
    }
    
    if (empty($errors)) {
        try {
            $pdo = getDBConnection();
            $pdo->beginTransaction();
            
            // Calculate total
            $total = 0;
            foreach ($cartData as $item) {
                $total += $item['price'] * $item['quantity'];
            }
            
            // Insert order
            $stmt = $pdo->prepare("INSERT INTO orders (customer_name, wilaya, phone, total, status) VALUES (?, ?, ?, ?, 'pending')");
            $stmt->execute([$customerName, $wilaya, $phone, $total]);
            $orderId = $pdo->lastInsertId();
            
            // Insert order items
            $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, product_name, quantity, price) VALUES (?, ?, ?, ?, ?)");
            foreach ($cartData as $item) {
                $stmt->execute([$orderId, $item['productId'], $item['name'], $item['quantity'], $item['price']]);
            }
            
            $pdo->commit();
            
            // Redirect to success page
            header("Location: /order-success.php?id=$orderId");
            exit;
            
        } catch (Exception $e) {
            $pdo->rollback();
            $errors[] = 'An error occurred while processing your order. Please try again.';
        }
    }
}

// Algerian Wilayas
$wilayas = [
    'Adrar', 'Chlef', 'Laghouat', 'Oum El Bouaghi', 'Batna', 'Béjaïa', 'Biskra', 'Béchar',
    'Blida', 'Bouira', 'Tamanrasset', 'Tébessa', 'Tlemcen', 'Tiaret', 'Tizi Ouzou', 'Algiers',
    'Djelfa', 'Jijel', 'Sétif', 'Saïda', 'Skikda', 'Sidi Bel Abbès', 'Annaba', 'Guelma',
    'Constantine', 'Médéa', 'Mostaganem', 'MSila', 'Mascara', 'Ouargla', 'Oran', 'El Bayadh',
    'Illizi', 'Bordj Bou Arréridj', 'Boumerdès', 'El Tarf', 'Tindouf', 'Tissemsilt', 'El Oued',
    'Khenchela', 'Souk Ahras', 'Tipaza', 'Mila', 'Aïn Defla', 'Naâma', 'Aïn Témouchent',
    'Ghardaïa', 'Relizane'
];

include 'includes/header.php';
?>

<section class="checkout-section" style="padding: 3rem 0;">
    <div class="container">
        <h1 class="section-title">Checkout</h1>
        
        <?php if (!empty($errors)): ?>
            <div class="alert alert-error">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; align-items: start;">
            <!-- Order Form -->
            <div class="order-form">
                <h3 style="margin-bottom: 1.5rem; color: #2d5a27;">Order Information</h3>
                
                <form method="POST" id="checkout-form">
                    <div class="form-group">
                        <label for="customer_name">Full Name *</label>
                        <input type="text" id="customer_name" name="customer_name" required 
                               value="<?php echo htmlspecialchars($customerName ?? ''); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="wilaya">Wilaya *</label>
                        <select id="wilaya" name="wilaya" required>
                            <option value="">Select Wilaya</option>
                            <?php foreach ($wilayas as $wilaya): ?>
                                <option value="<?php echo $wilaya; ?>" <?php echo ($wilaya ?? '') == $wilaya ? 'selected' : ''; ?>>
                                    <?php echo $wilaya; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="phone">Phone Number *</label>
                        <input type="tel" id="phone" name="phone" required 
                               value="<?php echo htmlspecialchars($phone ?? ''); ?>"
                               placeholder="0555 000 000">
                    </div>
                    
                    <input type="hidden" name="cart_data" id="cart_data">
                    
                    <button type="submit" class="btn" style="width: 100%; padding: 1rem;">
                        Place Order
                    </button>
                </form>
            </div>
            
            <!-- Order Summary -->
            <div class="order-summary">
                <h3>Order Summary</h3>
                <div id="order-items">
                    <p class="empty-cart">Loading order items...</p>
                </div>
                <div class="order-total">
                    <strong>Total: <span id="order-total">0.00 DA</span></strong>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get cart data from localStorage
    const checkoutCart = JSON.parse(localStorage.getItem('checkoutCart') || '[]');
    
    if (checkoutCart.length === 0) {
        alert('Your cart is empty!');
        window.location.href = '/products.php';
        return;
    }
    
    // Update cart data in form
    document.getElementById('cart_data').value = JSON.stringify(checkoutCart);
    
    // Display order items
    const orderItemsContainer = document.getElementById('order-items');
    const orderTotalElement = document.getElementById('order-total');
    
    let total = 0;
    const itemsHTML = checkoutCart.map(item => {
        const itemTotal = item.price * item.quantity;
        total += itemTotal;
        
        return `
            <div class="order-item">
                <div>
                    <strong>${item.name}</strong><br>
                    <small>Quantity: ${item.quantity}</small>
                </div>
                <div>${formatPrice(itemTotal)}</div>
            </div>
        `;
    }).join('');
    
    orderItemsContainer.innerHTML = itemsHTML;
    orderTotalElement.textContent = formatPrice(total);
    
    // Form submission
    document.getElementById('checkout-form').addEventListener('submit', function(e) {
        const button = e.target.querySelector('button[type="submit"]');
        const hideLoading = showLoading(button);
        
        // The form will submit normally, so we don't need to prevent default
        setTimeout(() => {
            hideLoading();
        }, 3000);
    });
});

function formatPrice(price) {
    return new Intl.NumberFormat('en-US', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    }).format(price) + ' DA';
}

function showLoading(button) {
    const originalText = button.textContent;
    button.textContent = 'Processing...';
    button.disabled = true;
    
    return function() {
        button.textContent = originalText;
        button.disabled = false;
    };
}
</script>

<?php include 'includes/footer.php'; ?>