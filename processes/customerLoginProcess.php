<?php
session_start();
include "../connection.php";

$email = $_POST["email"];
$password = $_POST["password"];

$rs = Database::search("SELECT * FROM customer WHERE email='$email' AND password='$password'");

if($rs->num_rows == 0) {
    echo "invalid";
    exit;
}

$customer = $rs->fetch_assoc();
$_SESSION['customer_id'] = $customer['id'];
$_SESSION['customer_name'] = $customer['fullname'];
$_SESSION['customer_email'] = $customer['email'];

setcookie("sv_email", $email, time() + (30 * 24 * 60 * 60), "/");
setcookie("sv_password", $password, time() + (30 * 24 * 60 * 60), "/");

echo "success";
?>