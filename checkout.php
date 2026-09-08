<?php
session_start();
include "connection.php";

$mode = isset($_GET['mode']) ? $_GET['mode'] : 'cart';
$checkout_items = [];
$subtotal = 0;

if ($mode === 'buynow' && isset($_GET['inventory_id'])) {

    $inventory_id = intval($_GET['inventory_id']);
    $qty = isset($_GET['qty']) ? max(1, intval($_GET['qty'])) : 1;

    $item_rs = Database::search("
        SELECT i.id as inventory_id, i.unit_price, i.qty as stock_qty,
            p.title, col.name as collection_name, MIN(pi.path) as path,
            s.value as size_value, c.name as color_name
        FROM inventory i
        JOIN product p ON p.id = i.product_id
        JOIN collection col ON col.id = p.collection_id
        JOIN product_images pi ON pi.product_id = p.id
        JOIN size s ON s.id = i.size_id
        JOIN color c ON c.id = i.color_id
        WHERE i.id = $inventory_id
        GROUP BY i.id, i.unit_price, i.qty, p.title, col.name, s.value, c.name
    ");

    if ($item_rs && $item_rs->num_rows > 0) {
        $row = $item_rs->fetch_assoc();
        $qty = min($qty, $row['stock_qty']);
        $row['qty'] = $qty;
        $checkout_items[] = $row;
        $subtotal += $row['unit_price'] * $qty;
    }

} else {

    $mode = 'cart';

    if (isset($_SESSION['customer_id'])) {
        $cart_rs = Database::search("
            SELECT c.id as cart_id, c.qty, i.id as inventory_id, i.unit_price,
                p.title, col.name as collection_name, MIN(pi.path) as path,
                s.value as size_value, c2.name as color_name
            FROM cart c
            JOIN inventory i ON i.id = c.inventory_id
            JOIN product p ON p.id = i.product_id
            JOIN product_images pi ON pi.product_id = p.id
            JOIN collection col ON col.id = p.collection_id
            JOIN size s ON s.id = i.size_id
            JOIN color c2 ON c2.id = i.color_id
            WHERE c.customer_id = '{$_SESSION['customer_id']}'
            GROUP BY c.id, c.qty, i.id, i.unit_price, p.title, col.name, s.value, c2.name
        ");

        while ($row = $cart_rs->fetch_assoc()) {
            $checkout_items[] = $row;
            $subtotal += $row['unit_price'] * $row['qty'];
        }
    }
}

$shipping = ($subtotal > 0 && $subtotal < 5000) ? 350 : 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout | Shinigami Vault</title>

    <!-- stylesheets -->
    <link rel="stylesheet" href="css/bootstrap.css" />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

    <link rel="icon" href="assets/logo.png" />
</head>

<body>

    <!-- header -->
    <?php include "connection.php"; ?>
    <?php include "header.php"; ?>

    <!-- toast -->
    <div class="toast-msg" id="toast-msg">
        <i id="toast-icon" class="bi bi-x-circle-fill"></i>
        <span id="toast-text" class="toast-text"></span>
    </div>

    <div class="checkout-container">

        <div class="section-heading">
            <p class="section-eyebrow">sealing the order</p>
            <h2 class="section-title">check<span>out</span></h2>
        </div>

        <?php if (empty($checkout_items)) { ?>

            <div class="checkout-empty">
                <?php if ($mode === 'cart' && !isset($_SESSION['customer_id'])) { ?>
                    <p>You need to log in before checking out.</p>
                    <button class="red-btn" onclick="showLogin();">Login</button>
                <?php } else { ?>
                    <p>There's nothing here to check out yet.</p>
                    <button class="red-btn" onclick="gotoSearch();">Shop</button>
                <?php } ?>
            </div>

        <?php } else { ?>

            <div class="checkout-grid">

                <!-- LEFT: items -->
                <div class="checkout-items-panel">
                    <p class="panel-label">items (<?php echo count($checkout_items); ?>)</p>

                    <?php foreach ($checkout_items as $item) { ?>
                        <div class="checkout-item">
                            <div class="checkout-item-img">
                                <img src="<?php echo $item['path']; ?>" alt="">
                            </div>
                            <div class="checkout-item-info">
                                <p class="checkout-item-name">
                                    <?php echo $item['collection_name'] . ' &nbsp;|&nbsp; ' . $item['title']; ?>
                                </p>
                                <p class="checkout-item-variant">
                                    size <?php echo $item['size_value']; ?> &nbsp;&middot;&nbsp; <?php echo $item['color_name']; ?> &nbsp;&middot;&nbsp; qty <?php echo $item['qty']; ?>
                                </p>
                            </div>
                            <p class="checkout-item-price">LKR <?php echo number_format($item['unit_price'] * $item['qty'], 2); ?></p>
                        </div>
                    <?php } ?>
                </div>

                <!-- RIGHT: summary -->
                <div class="checkout-summary-panel">
                    <p class="panel-label">order summary</p>

                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span id="summarySubtotal">LKR <?php echo number_format($subtotal, 2); ?></span>
                    </div>

                    <div class="summary-row" id="discountRow" style="display:none;">
                        <span>Discount<span id="discountTag"></span></span>
                        <span id="summaryDiscount">- LKR 0.00</span>
                    </div>

                    <div class="summary-row">
                        <span>Shipping</span>
                        <span id="summaryShipping"><?php echo $shipping == 0 ? 'Free' : 'LKR ' . number_format($shipping, 2); ?></span>
                    </div>

                    <div class="promo-box">
                        <input type="text" id="promoInput" placeholder="promo code" autocomplete="off">
                        <button type="button" id="promoBtn" onclick="applyPromo();">Apply</button>
                    </div>
                    <p class="promo-msg" id="promoMsg"></p>

                    <div class="summary-total-row">
                        <span>Total</span>
                        <span id="summaryTotal">LKR <?php echo number_format($subtotal + $shipping, 2); ?></span>
                    </div>

                    <button class="primary-btn" id="placeOrderBtn" onclick="placeOrder();">Place Order</button>
                </div>

            </div>

        <?php } ?>

    </div>

    <!-- footer -->
    <?php include "footer.php"; ?>

    <!-- js -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/main.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/bootstrap.bundle.js"></script>

    <script>
        const checkoutMode = <?php echo json_encode($mode); ?>;
        const subtotal = <?php echo json_encode((float)$subtotal); ?>;
        const baseShipping = <?php echo json_encode((float)$shipping); ?>;
        let appliedDiscount = 0;

        function formatLKR(n) {
            return "LKR " + n.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        }

        function recalcTotal() {
            const afterDiscount = Math.max(subtotal - appliedDiscount, 0);
            const shipping = (afterDiscount > 0 && afterDiscount < 5000) ? (baseShipping || 350) : 0;
            const total = afterDiscount + shipping;

            document.getElementById('summaryShipping').textContent = shipping === 0 ? 'Free' : formatLKR(shipping);
            document.getElementById('summaryTotal').textContent = formatLKR(total);
        }

        function applyPromo() {
            const code = document.getElementById('promoInput').value.trim();
            const msg = document.getElementById('promoMsg');

            if (!code) {
                msg.textContent = "Enter a promo code first.";
                msg.className = "promo-msg error";
                return;
            }

            var form = new FormData();
            form.append("code", code);
            form.append("subtotal", subtotal);

            var request = new XMLHttpRequest();
            request.onreadystatechange = function() {
                if (request.readyState == 4 && request.status == 200) {
                    try {
                        const res = JSON.parse(request.responseText);
                        if (res.valid) {
                            appliedDiscount = res.discount;
                            document.getElementById('discountRow').style.display = "flex";
                            document.getElementById('discountTag').textContent = " (" + code.toUpperCase() + ")";
                            document.getElementById('summaryDiscount').textContent = "- " + formatLKR(res.discount);
                            msg.textContent = res.message;
                            msg.className = "promo-msg success";
                        } else {
                            appliedDiscount = 0;
                            document.getElementById('discountRow').style.display = "none";
                            msg.textContent = res.message;
                            msg.className = "promo-msg error";
                        }
                        recalcTotal();
                    } catch (e) {
                        msg.textContent = "Couldn't check that code, try again.";
                        msg.className = "promo-msg error";
                    }
                }
            }
            request.open("POST", "processes/applyPromoProcess.php", true);
            request.send(form);
        }

        function placeOrder() {
            const btn = document.getElementById('placeOrderBtn');
            btn.disabled = true;
            btn.textContent = "Placing order...";

            var form = new FormData();
            form.append("mode", checkoutMode);

            var request = new XMLHttpRequest();
            request.onreadystatechange = function() {
                if (request.readyState == 4 && request.status == 200) {
                    if (request.responseText.trim() === "success") {
                        showToast("Order placed! ✓", "success");
                        setTimeout(() => window.location.href = "home.php", 1500);
                    } else {
                        btn.disabled = false;
                        btn.textContent = "Place Order";
                        showToast("⚠ Something went wrong placing your order!");
                    }
                }
            }
            request.open("POST", "processes/placeOrderProcess.php", true);
            request.send(form);
        }
    </script>

</body>

</html>

<style>

    .checkout-container {
        background: var(--bg);
        min-height: 70vh;
        padding-bottom: 80px;
    }

    .checkout-empty {
        text-align: center;
        padding: 40px 20px 80px;
    }

    .checkout-empty p {
        color: var(--text);
        margin-bottom: 18px;
    }

    .checkout-grid {
        max-width: 1080px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 1.4fr 1fr;
        gap: 50px;
        padding: 10px 40px;
        align-items: start;
    }

    .panel-label {
        font-size: 11px;
        letter-spacing: 0.2em;
        text-transform: uppercase;
        color: #a8a29a;
        margin-bottom: 18px;
        padding-bottom: 12px;
        border-bottom: 1px solid var(--border);
    }

    /* left: items */

    .checkout-item {
        display: flex;
        align-items: center;
        gap: 18px;
        padding: 16px 0;
        border-bottom: 1px solid var(--border);
    }

    .checkout-item-img {
        width: 76px;
        height: 92px;
        flex: 0 0 auto;
        background: var(--surface);
        overflow: hidden;
    }

    .checkout-item-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .checkout-item-info {
        flex: 1;
    }

    .checkout-item-name {
        font-size: 14px;
        color: var(--heading);
        margin-bottom: 6px;
    }

    .checkout-item-variant {
        font-size: 12px;
        color: var(--text);
        opacity: 0.7;
        text-transform: capitalize;
        margin: 0;
    }

    .checkout-item-price {
        font-family: 'Courier New', monospace;
        font-size: 13px;
        color: var(--heading);
        white-space: nowrap;
        margin: 0;
    }

    /* right: summary */

    .checkout-summary-panel {
        background: var(--surface);
        border: 1px solid var(--border);
        padding: 28px 26px;
        position: sticky;
        top: 100px;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        font-size: 13.5px;
        color: var(--text);
        padding: 9px 0;
    }

    .promo-box {
        display: flex;
        gap: 8px;
        margin-top: 14px;
    }

    .promo-box input {
        flex: 1;
        border: 1px solid var(--border);
        background: var(--bg);
        color: var(--text);
        padding: 9px 12px;
        font-size: 13px;
        text-transform: uppercase;
    }

    .promo-box input:focus {
        outline: none;
        border-color: var(--heading);
    }

    .promo-box button {
        border: 1px solid var(--heading);
        background: transparent;
        color: var(--heading);
        padding: 0 18px;
        font-size: 12px;
        letter-spacing: 0.05em;
        cursor: pointer;
        transition: background 0.2s, color 0.2s;
    }

    .promo-box button:hover {
        background: var(--heading);
        color: var(--bg);
    }

    .promo-msg {
        font-size: 11.5px;
        margin: 8px 0 0;
        min-height: 14px;
    }

    .promo-msg.success { color: #2a7a2a; }
    .promo-msg.error { color: var(--red); }

    .summary-total-row {
        display: flex;
        justify-content: space-between;
        font-family: 'header';
        font-size: 20px;
        color: var(--heading);
        padding: 18px 0 22px;
        margin-top: 10px;
        border-top: 1px solid var(--border);
    }

    @media (max-width: 860px) {
        .checkout-grid {
            grid-template-columns: 1fr;
            padding: 10px 20px;
        }
        .checkout-summary-panel {
            position: static;
        }
    }

</style>