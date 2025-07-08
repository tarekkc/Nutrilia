<?php
require_once 'includes/config.php';

$pageTitle = 'Home';

// Get featured products
$pdo = getDBConnection();
$stmt = $pdo->prepare("SELECT * FROM products WHERE featured = 1 AND in_stock = 1 ORDER BY created_at DESC LIMIT 6");
$stmt->execute();
$featuredProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get product categories
$stmt = $pdo->prepare("SELECT category, COUNT(*) as count FROM products WHERE in_stock = 1 GROUP BY category");
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

include 'includes/header.php';
?>
<link rel="stylesheet" href="assets/css/style.css">

<section class="hero">
    <div class="container">
        <div class="hero-content">
            <h1>Welcome to <?php echo SITE_NAME; ?></h1>
            <p><?php echo SITE_SLOGAN; ?></p>
            <div class="hero-actions">
                <a href="/products.php" class="btn">Shop Now</a>
                <a href="/products.php?category=supplements" class="btn btn-outline">Supplements</a>
            </div>
        </div>
    </div>
</section>

<section class="products-section">
    <div class="container">
        <h2 class="section-title">Featured Products</h2>
        
        <div class="category-filter">
            <button class="filter-btn active" data-filter="all">All Products</button>
            <?php foreach ($categories as $category): ?>
                <button class="filter-btn" data-filter="<?php echo $category['category']; ?>">
                    <?php echo ucfirst($category['category']); ?> (<?php echo $category['count']; ?>)
                </button>
            <?php endforeach; ?>
        </div>

        <div class="products-grid">
            <?php foreach ($featuredProducts as $product): ?>
                <div class="product-card" data-category="<?php echo $product['category']; ?>">
                    <img src="<?php echo $product['image']; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                    <div class="product-info">
                        <div class="product-category"><?php echo ucfirst($product['category']); ?></div>
                        <h3 class="product-name"><?php echo htmlspecialchars($product['name']); ?></h3>
                        <p class="product-description"><?php echo htmlspecialchars(substr($product['description'], 0, 100)) . '...'; ?></p>
                        <div class="product-price"><?php echo formatPrice($product['price']); ?></div>
                        <div class="product-actions">
                            <button class="add-to-cart" onclick="addToCart('<?php echo $product['id']; ?>', '<?php echo htmlspecialchars($product['name']); ?>', <?php echo $product['price']; ?>, '<?php echo $product['image']; ?>')">
                                Add to Cart
                            </button>
                            <a href="/product.php?id=<?php echo $product['id']; ?>" class="view-product">View Details</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="text-center">
            <a href="products.php" class="btn">View All Products</a>
        </div>
    </div>
</section>

<section class="features-section" style="background: white; padding: 4rem 0;">
    <div class="container">
        <div class="features-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem;">
            <div class="feature-card" style="text-align: center; padding: 2rem;">
                <div style="font-size: 3rem; margin-bottom: 1rem;">🌿</div>
                <h3 style="margin-bottom: 1rem; color: #2d5a27;">Natural Ingredients</h3>
                <p style="color: #666;">All our products are made with premium natural ingredients for your health and beauty.</p>
            </div>
            <div class="feature-card" style="text-align: center; padding: 2rem;">
                <div style="font-size: 3rem; margin-bottom: 1rem;">🚚</div>
                <h3 style="margin-bottom: 1rem; color: #2d5a27;">Fast Delivery</h3>
                <p style="color: #666;">Quick and reliable delivery across Algeria. Get your products delivered to your door.</p>
            </div>
            <div class="feature-card" style="text-align: center; padding: 2rem;">
                <div style="font-size: 3rem; margin-bottom: 1rem;">💯</div>
                <h3 style="margin-bottom: 1rem; color: #2d5a27;">Quality Guaranteed</h3>
                <p style="color: #666;">We ensure the highest quality standards for all our supplements and cosmetics.</p>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>