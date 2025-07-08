@@ .. @@
     <div class="cart-overlay" id="cart-overlay" onclick="toggleCart()"></div>

+    <!-- Purchase Popup -->
+    <div class="purchase-popup" id="purchase-popup">
+        <div class="purchase-popup-content">
+            <button class="popup-close" onclick="closePurchasePopup()">×</button>
+            
+            <h2 style="margin-bottom: 1.5rem; color: #2d5a27; text-align: center;">Quick Purchase</h2>
+            
+            <div class="popup-product-info">
+                <img id="popup-product-image" class="popup-product-image" src="" alt="">
+                <div class="popup-product-details">
+                    <h3 id="popup-product-name"></h3>
+                    <div class="popup-product-price" id="popup-product-price"></div>
+                </div>
+            </div>
+            
+            <form id="popup-purchase-form" onsubmit="submitPurchase(event)">
+                <div class="popup-form-group">
+                    <label for="popup-customer-name">Full Name *</label>
+                    <input type="text" id="popup-customer-name" name="customer_name" required>
+                </div>
+                
+                <div class="popup-form-group">
+                    <label for="popup-wilaya">State (Wilaya) *</label>
+                    <select id="popup-wilaya" name="wilaya" required>
+                        <option value="">Select State</option>
+                        <option value="Adrar">Adrar</option>
+                        <option value="Chlef">Chlef</option>
+                        <option value="Laghouat">Laghouat</option>
+                        <option value="Oum El Bouaghi">Oum El Bouaghi</option>
+                        <option value="Batna">Batna</option>
+                        <option value="Béjaïa">Béjaïa</option>
+                        <option value="Biskra">Biskra</option>
+                        <option value="Béchar">Béchar</option>
+                        <option value="Blida">Blida</option>
+                        <option value="Bouira">Bouira</option>
+                        <option value="Tamanrasset">Tamanrasset</option>
+                        <option value="Tébessa">Tébessa</option>
+                        <option value="Tlemcen">Tlemcen</option>
+                        <option value="Tiaret">Tiaret</option>
+                        <option value="Tizi Ouzou">Tizi Ouzou</option>
+                        <option value="Algiers">Algiers</option>
+                        <option value="Djelfa">Djelfa</option>
+                        <option value="Jijel">Jijel</option>
+                        <option value="Sétif">Sétif</option>
+                        <option value="Saïda">Saïda</option>
+                        <option value="Skikda">Skikda</option>
+                        <option value="Sidi Bel Abbès">Sidi Bel Abbès</option>
+                        <option value="Annaba">Annaba</option>
+                        <option value="Guelma">Guelma</option>
+                        <option value="Constantine">Constantine</option>
+                        <option value="Médéa">Médéa</option>
+                        <option value="Mostaganem">Mostaganem</option>
+                        <option value="MSila">MSila</option>
+                        <option value="Mascara">Mascara</option>
+                        <option value="Ouargla">Ouargla</option>
+                        <option value="Oran">Oran</option>
+                        <option value="El Bayadh">El Bayadh</option>
+                        <option value="Illizi">Illizi</option>
+                        <option value="Bordj Bou Arréridj">Bordj Bou Arréridj</option>
+                        <option value="Boumerdès">Boumerdès</option>
+                        <option value="El Tarf">El Tarf</option>
+                        <option value="Tindouf">Tindouf</option>
+                        <option value="Tissemsilt">Tissemsilt</option>
+                        <option value="El Oued">El Oued</option>
+                        <option value="Khenchela">Khenchela</option>
+                        <option value="Souk Ahras">Souk Ahras</option>
+                        <option value="Tipaza">Tipaza</option>
+                        <option value="Mila">Mila</option>
+                        <option value="Aïn Defla">Aïn Defla</option>
+                        <option value="Naâma">Naâma</option>
+                        <option value="Aïn Témouchent">Aïn Témouchent</option>
+                        <option value="Ghardaïa">Ghardaïa</option>
+                        <option value="Relizane">Relizane</option>
+                    </select>
+                </div>
+                
+                <div class="popup-form-group">
+                    <label for="popup-phone">Phone Number *</label>
+                    <input type="tel" id="popup-phone" name="phone" required placeholder="0555 000 000">
+                </div>
+                
+                <div class="popup-form-group">
+                    <label for="popup-quantity">Quantity *</label>
+                    <input type="number" id="popup-quantity" name="quantity" value="1" min="1" max="10" required onchange="updatePopupTotal()">
+                </div>
+                
+                <div class="popup-total">
+                    <div>Total Amount:</div>
+                    <div class="popup-total-amount" id="popup-total-amount">0.00 DA</div>
+                </div>
+                
+                <button type="submit" class="popup-submit-btn">Place Order Now</button>
+            </form>
+            
+            <div style="text-align: center; margin-top: 1rem; font-size: 0.9rem; color: #666;">
+                💳 Payment on Delivery (Cash on Delivery)
+            </div>
+        </div>
+    </div>

     <main class="main-content">