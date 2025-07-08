@@ .. @@
                             <div class="product-actions">
-                                <button class="add-to-cart" onclick="addToCart('<?php echo $product['id']; ?>', '<?php echo htmlspecialchars($product['name']); ?>', <?php echo $product['price']; ?>, '<?php echo $product['image']; ?>')">
-                                    Add to Cart
+                                <button class="add-to-cart" onclick="addToCart('<?php echo $product['id']; ?>', '<?php echo htmlspecialchars($product['name']); ?>', <?php echo $product['price']; ?>, '<?php echo $product['image']; ?>')">
+                                    Buy Now
                                </button>
                                <a href="/product.php?id=<?php echo $product['id']; ?>" class="view-product">View Details</a>
                            </div>