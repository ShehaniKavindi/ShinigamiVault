<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include "../connection.php";



if(!isset($_SESSION['customer_id'])) {
    echo "login";
    exit;
}

$customer_id = $_SESSION['customer_id'];
$inventory_id = $_POST['inventory_id'];
$qty = $_POST['qty'];

// check if already in cart
$check = Database::search("SELECT * FROM cart WHERE customer_id='$customer_id' AND inventory_id='$inventory_id'");

if($check->num_rows > 0) {
    // update qty
    $existing = $check->fetch_assoc();
    $new_qty = $existing['qty'] + $qty;
    $result = Database::iud("UPDATE cart SET qty='$new_qty' WHERE id='{$existing['id']}'");
} else {
    // insert new
    $result = Database::iud("INSERT INTO cart (customer_id, inventory_id, qty) VALUES ('$customer_id', '$inventory_id', '$qty')");
}

if($result) {
    echo "success";
} else {
    echo "error";
}
?>