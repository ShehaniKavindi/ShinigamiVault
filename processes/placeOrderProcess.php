<?php
session_start();
include "../connection.php";

// NOTE: there's no `orders` / `order_items` table in the schema yet, so this
// endpoint doesn't persist an order record - it just clears the cart (for
// cart checkouts) and confirms. Wire this up to real order storage when
// that table exists.

$mode = isset($_POST['mode']) ? $_POST['mode'] : 'cart';

if ($mode === 'cart') {
    if (!isset($_SESSION['customer_id'])) {
        echo "error";
        exit;
    }

    $customer_id = $_SESSION['customer_id'];
    $result = Database::iud("DELETE FROM cart WHERE customer_id = '$customer_id'");

    echo $result ? "success" : "error";
} else {
    // buy-now items were never added to the cart, nothing to clear
    echo "success";
}