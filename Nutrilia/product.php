<?php
require_once 'includes/config.php';

$productId = $_GET['id'] ?? '';

if (!$productId) {
    header('Location: /products.php');
    exit;
}

// Get product details
$pdo = getDBConnection();
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ? AND in_stock = 1");
$stmt->execute([$productId]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    header('Location: /products.php');
    exit;
}

// Get related products
$stmt = $pdo->prepare("SELECT * FROM products WHERE category = ? AND id != ? AND in_stock = 1 ORDER BY RAND() LIMIT 4");
$stmt->execute([$product['category'], $productId]);
$relatedProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);

$pageTitle = $product['name'];

include 'includes/header.php';
?>

<section class="product-detail">
    <div class="container">
        <nav style="margin-bottom: 2rem;">
            <a href="/products.php" style="color: #2d5a27; text-decoration: none;">← Back to Products</a>
        </nav>

        <div class="product-detail-content">
            <div class="product-image">
                <img src="<?php echo $product['image']; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="product-detail-image">
            </div>
            
            <div class="product-detail-info">
                <div class="product-detail-category"><?php echo ucfirst($product['category']); ?></div>
                <h1><?php echo htmlspecialchars($product['name']); ?></h1>
                <div class="product-detail-price"><?php echo formatPrice($product['price']); ?></div>
                <div class="product-detail-description">
                    <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
                </div>
                
                <div class="quantity-selector">
                    <label for="quantity">Quantity:</label>
                    <input type="number" id="quantity" class="quantity-input" value="1" min="1" max="10">
                </div>
                
                <div class="product-actions">
                    <button class="btn" onclick="addToCartWithQuantity()" style="padding: 1rem 2rem; font-size: 1.1rem;">
                        Add to Cart
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<?php if (!empty($relatedProducts)): ?>
<section class="related-products" style="padding: 3rem 0; background: white;">
    <div class="container">
        <h2 class="section-title">Related Products</h2>
        <div class="products-grid">
            <?php foreach ($relatedProducts as $relatedProduct): ?>
                <div class="product-card">
                    <img src="<?php echo $relatedProduct['image']; ?>" alt="<?php echo htmlspecialchars($relatedProduct['name']); ?>">
                    <div class="product-info">
                        <div class="product-category"><?php echo ucfirst($relatedProduct['category']); ?></div>
                        <h3 class="product-name"><?php echo htmlspecialchars($relatedProduct['name']); ?></h3>
                        <p class="product-description"><?php echo htmlspecialchars(substr($relatedProduct['description'], 0, 100)) . '...'; ?></p>
                        <div class="product-price"><?php echo formatPrice($relatedProduct['price']); ?></div>
                        <div class="product-actions">
                            <button class="add-to-cart" onclick="addToCart('<?php echo $relatedProduct['id']; ?>', '<?php echo htmlspecialchars($relatedProduct['name']); ?>', <?php echo $relatedProduct['price']; ?>, '<?php echo $relatedProduct['image']; ?>')">
                                Add to Cart
                            </button>
                            <a href="/product.php?id=<?php echo $relatedProduct['id']; ?>" class="view-product">View Details</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<script>
function addToCartWithQuantity() {
    const quantity = parseInt(document.getElementById('quantity').value);
    const productId = '<?php echo $product['id']; ?>';
    const productName = '<?php echo addslashes($product['name']); ?>';
    const productPrice = <?php echo $product['price']; ?>;
    const productImage = '<?php echo $product['image']; ?>';
    
    for (let i = 0; i < quantity; i++) {
        cart.addItem(productId, productName, productPrice, productImage);
    }
}
</script>

<?php include 'includes/footer.php'; ?>