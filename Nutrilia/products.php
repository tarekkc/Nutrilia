<?php
require_once 'includes/config.php';

$pageTitle = 'Products';

// Get filter parameters
$category = $_GET['category'] ?? '';
$featured = $_GET['featured'] ?? '';
$search = $_GET['search'] ?? '';

// Build query
$whereConditions = ["in_stock = 1"];
$params = [];

if ($category) {
    $whereConditions[] = "category = ?";
    $params[] = $category;
}

if ($featured) {
    $whereConditions[] = "featured = 1";
}

if ($search) {
    $whereConditions[] = "(name LIKE ? OR description LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

$whereClause = implode(' AND ', $whereConditions);

// Get products
$pdo = getDBConnection();
$stmt = $pdo->prepare("SELECT * FROM products WHERE $whereClause ORDER BY created_at DESC");
$stmt->execute($params);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get categories for filter
$stmt = $pdo->prepare("SELECT category, COUNT(*) as count FROM products WHERE in_stock = 1 GROUP BY category");
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

include 'includes/header.php';
?>
<link rel="stylesheet" href="assets/css/style.css">

<section class="products-section">
    <div class="container">
        <h1 class="section-title">
            <?php 
            if ($category) {
                echo ucfirst($category);
            } elseif ($featured) {
                echo 'Featured Products';
            } elseif ($search) {
                echo 'Search Results for "' . htmlspecialchars($search) . '"';
            } else {
                echo 'All Products';
            }
            ?>
        </h1>

        <!-- Search Form -->
        <div class="search-section" style="margin-bottom: 2rem; text-align: center;">
            <form action="/products.php" method="GET" style="display: inline-block;">
                <input type="text" name="search" placeholder="Search products..." value="<?php echo htmlspecialchars($search); ?>" 
                       style="padding: 0.75rem 1rem; border: 2px solid #ddd; border-radius: 25px; width: 300px; margin-right: 1rem;">
                <button type="submit" class="btn" style="border-radius: 25px;">Search</button>
            </form>
        </div>

        <!-- Category Filter -->
        <div class="category-filter">
            <a href="/products.php" class="filter-btn <?php echo !$category ? 'active' : ''; ?>">All Products</a>
            <?php foreach ($categories as $cat): ?>
                <a href="/products.php?category=<?php echo $cat['category']; ?>" 
                   class="filter-btn <?php echo $category == $cat['category'] ? 'active' : ''; ?>">
                    <?php echo ucfirst($cat['category']); ?> (<?php echo $cat['count']; ?>)
                </a>
            <?php endforeach; ?>
            <a href="/products.php?featured=1" class="filter-btn <?php echo $featured ? 'active' : ''; ?>">
                Featured
            </a>
        </div>

        <!-- Products Grid -->
        <div class="products-grid">
            <?php if (empty($products)): ?>
                <div style="grid-column: 1 / -1; text-align: center; padding: 3rem;">
                    <h3 style="color: #666;">No products found</h3>
                    <p style="color: #999;">Try adjusting your search or browse our categories.</p>
                    <a href="/products.php" class="btn">View All Products</a>
                </div>
            <?php else: ?>
                <?php foreach ($products as $product): ?>
                    <div class="product-card fade-in" data-category="<?php echo $product['category']; ?>">
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
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>