<?php
session_start();
include "../connection.php";

$cart_id = intval($_POST['cart_id']);
$customer_id = $_SESSION['customer_id'];

$result = Database::iud("
    DELETE FROM cart WHERE id = '$cart_id' AND customer_id = '$customer_id'
");

echo $result ? "success" : "error";