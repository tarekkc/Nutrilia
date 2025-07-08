@@ .. @@
document.head.appendChild(style);

+// Purchase popup functionality
+let currentProduct = null;
+
+function showPurchasePopup(productId, name, price, image) {
+    currentProduct = { productId, name, price, image };
+    
+    const popup = document.getElementById('purchase-popup');
+    const productImage = document.getElementById('popup-product-image');
+    const productName = document.getElementById('popup-product-name');
+    const productPrice = document.getElementById('popup-product-price');
+    const quantityInput = document.getElementById('popup-quantity');
+    const totalAmount = document.getElementById('popup-total-amount');
+    
+    // Set product info
+    productImage.src = image;
+    productImage.alt = name;
+    productName.textContent = name;
+    productPrice.textContent = cart.formatPrice(price);
+    
+    // Reset form
+    document.getElementById('popup-purchase-form').reset();
+    quantityInput.value = 1;
+    updatePopupTotal();
+    
+    // Show popup
+    popup.classList.add('active');
+    document.body.style.overflow = 'hidden';
+}
+
+function closePurchasePopup() {
+    const popup = document.getElementById('purchase-popup');
+    popup.classList.remove('active');
+    document.body.style.overflow = 'auto';
+    currentProduct = null;
+}
+
+function updatePopupTotal() {
+    if (!currentProduct) return;
+    
+    const quantity = parseInt(document.getElementById('popup-quantity').value) || 1;
+    const total = currentProduct.price * quantity;
+    document.getElementById('popup-total-amount').textContent = cart.formatPrice(total);
+}
+
+function submitPurchase(event) {
+    event.preventDefault();
+    
+    if (!currentProduct) return;
+    
+    const form = event.target;
+    const formData = new FormData(form);
+    
+    const customerName = formData.get('customer_name').trim();
+    const wilaya = formData.get('wilaya');
+    const phone = formData.get('phone').trim();
+    const quantity = parseInt(formData.get('quantity')) || 1;
+    
+    // Validation
+    if (!customerName || !wilaya || !phone) {
+        alert('Please fill in all required fields');
+        return;
+    }
+    
+    if (quantity < 1) {
+        alert('Quantity must be at least 1');
+        return;
+    }
+    
+    // Prepare order data
+    const orderData = {
+        customer_name: customerName,
+        wilaya: wilaya,
+        phone: phone,
+        cart_data: JSON.stringify([{
+            productId: currentProduct.productId,
+            name: currentProduct.name,
+            price: currentProduct.price,
+            image: currentProduct.image,
+            quantity: quantity
+        }])
+    };
+    
+    // Submit order
+    const submitBtn = form.querySelector('button[type="submit"]');
+    const originalText = submitBtn.textContent;
+    submitBtn.textContent = 'Processing...';
+    submitBtn.disabled = true;
+    
+    // Create form and submit
+    const hiddenForm = document.createElement('form');
+    hiddenForm.method = 'POST';
+    hiddenForm.action = '/checkout.php';
+    
+    Object.keys(orderData).forEach(key => {
+        const input = document.createElement('input');
+        input.type = 'hidden';
+        input.name = key;
+        input.value = orderData[key];
+        hiddenForm.appendChild(input);
+    });
+    
+    document.body.appendChild(hiddenForm);
+    hiddenForm.submit();
+}
+
+// Update add to cart function to show popup instead
+function addToCart(productId, name, price, image) {
+    showPurchasePopup(productId, name, price, image);
+}