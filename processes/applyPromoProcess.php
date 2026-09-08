<?php
session_start();
include "../connection.php";

$code = isset($_POST['code']) ? strtoupper(trim($_POST['code'])) : '';
$subtotal = isset($_POST['subtotal']) ? floatval($_POST['subtotal']) : 0;

// demo promo codes - swap this for a real promocode table when ready
$promos = [
    'VAULT10'    => ['type' => 'percent', 'value' => 10, 'min' => 0,    'message' => "10% off applied!"],
    'FIRST500'   => ['type' => 'flat',    'value' => 500, 'min' => 2000, 'message' => "LKR 500 off applied!"],
];

header('Content-Type: application/json');

if (!isset($promos[$code])) {
    echo json_encode(['valid' => false, 'message' => 'Invalid promo code.']);
    exit;
}

$promo = $promos[$code];

if ($subtotal < $promo['min']) {
    echo json_encode(['valid' => false, 'message' => "This code needs a subtotal of at least LKR " . number_format($promo['min'], 2) . "."]);
    exit;
}

$discount = $promo['type'] === 'percent'
    ? round($subtotal * ($promo['value'] / 100), 2)
    : $promo['value'];

$discount = min($discount, $subtotal);

echo json_encode(['valid' => true, 'discount' => $discount, 'message' => $promo['message']]);