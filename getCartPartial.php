<?php
session_start();
include "connection.php";

if (isset($_SESSION['customer_id'])) {
    $cart_rs = Database::search("
        SELECT c.id, c.qty, p.title, MIN(pi.path) as path, i.unit_price,
            col.name as collection_name, s.value as size_value, col2.name as color_name
        FROM cart c
        JOIN inventory i ON i.id = c.inventory_id
        JOIN product p ON p.id = i.product_id
        JOIN product_images pi ON pi.product_id = p.id
        JOIN collection col ON col.id = p.collection_id
        JOIN size s ON s.id = i.size_id
        JOIN color col2 ON col2.id = i.color_id
        WHERE c.customer_id = '{$_SESSION['customer_id']}'
        GROUP BY c.id, c.qty, p.title, i.unit_price, col.name, s.value, col2.name
    ");

    $cart_num = $cart_rs->num_rows;
    $cart_total = 0;

    if ($cart_num == 0) { ?>

        <div class="cart-header">
            <h2 class="cart-title">The Vault</h2>
            <button class="cart-close" onclick="closeCart()">✕</button>
        </div>

        <div class="cart-items">
            <div class="p-5">
                <p class="text-secondary mb-4 text-center">No items added to the bag yet!</p>
                <button class="red-btn" onclick="gotoSearch();">Shop</button>
            </div>
        </div>

        <div class="cart-footer">
            <div class="cart-total-row">
                <span class="cart-total-label">Total :</span>
                <span class="cart-total-amount">00.00 LKR</span>
            </div>
            <button class="primary-btn" disabled>Checkout</button>
        </div>

    <?php } else { ?>

        <div class="cart-header">
            <h2 class="cart-title">The Vault</h2>
            <button class="cart-close" onclick="closeCart()">✕</button>
        </div>

        <div class="cart-items">
            <?php for ($i = 0; $i < $cart_num; $i++) {
                $cart_data = $cart_rs->fetch_assoc();
                $cart_total += $cart_data['unit_price'] * $cart_data['qty'];
            ?>
            <div class="cart-item">
                <img src="<?php echo $cart_data['path']; ?>" alt="Product" class="cart-item-img">
                <div class="cart-item-info">
                    <p class="cart-item-name"><?php echo $cart_data['collection_name']; ?> | <?php echo $cart_data['title']; ?></p>
                    <p class="cart-item-price">LKR. <?php echo $cart_data['unit_price']; ?>.00</p>
                    <p class="cart-item-variant">x <?php echo $cart_data['qty']; ?> | <?php echo $cart_data['color_name']; ?></p>
                </div>
                <button class="cart-item-remove" title="Remove" onclick="removeFromCart(<?php echo $cart_data['id']; ?>);">✕</button>
            </div>
            <?php } ?>
        </div>

        <div class="cart-footer">
            <div class="cart-total-row">
                <span class="cart-total-label">Total :</span>
                <span class="cart-total-amount"><?php echo $cart_total; ?>.00 LKR</span>
            </div>
            <button class="primary-btn" onclick="checkout();">Checkout</button>
        </div>

    <?php }
} else { ?>

    <div class="cart-header">
        <h2 class="cart-title">The Vault</h2>
        <button class="cart-close" onclick="closeCart()">✕</button>
    </div>

    <div class="cart-items">
        <div class="p-5">
            <p class="text-secondary mb-4 text-center">Login first!</p>
            <button class="red-btn" onclick="showLogin();">Login</button>
        </div>
    </div>

    <div class="cart-footer">
        <div class="cart-total-row">
            <span class="cart-total-label">Total :</span>
            <span class="cart-total-amount">00.00 LKR</span>
        </div>
        <button class="primary-btn" disabled>Checkout</button>
    </div>

<?php } ?>