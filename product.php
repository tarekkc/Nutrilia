@@ .. @@
                <div class="product-actions">
                    <button class="btn" onclick="showPurchasePopupWithQuantity()" style="padding: 1rem 2rem; font-size: 1.1rem;">
                        Buy Now
                    </button>
                </div>
            </div>
@@ .. @@
<?php endif; ?>

<script>
function showPurchasePopupWithQuantity() {
    const quantity = parseInt(document.getElementById('quantity').value);
    const productId = '<?php echo $product['id']; ?>';
    const productName = '<?php echo addslashes($product['name']); ?>';
    const productPrice = <?php echo $product['price']; ?>;
    const productImage = '<?php echo $product['image']; ?>';
    
    // Show popup and set quantity
    showPurchasePopup(productId, productName, productPrice, productImage);
    
    // Set the quantity in the popup
    setTimeout(() => {
        document.getElementById('popup-quantity').value = quantity;
        updatePopupTotal();
    }, 100);
}
</script>

                        <div class="product-actions">
                            <button class="add-to-cart" onclick="addToCart('<?php echo $relatedProduct['id']; ?>', '<?php echo htmlspecialchars($relatedProduct['name']); ?>', <?php echo $relatedProduct['price']; ?>, '<?php echo $relatedProduct['image']; ?>')">
                                Buy Now
                            </button>
                            <a href="/product.php?id=<?php echo $relatedProduct['id']; ?>" class="view-product">View Details</a>
                        </div>