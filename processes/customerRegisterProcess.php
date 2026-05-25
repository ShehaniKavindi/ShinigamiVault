<?php
session_start();
include "../connection.php";

$name = $_POST["name"];
$email = $_POST["email"];
$password = $_POST["password"];
$joined = date("Y-m-d H:i:s");

$check = Database::search("SELECT * FROM customer WHERE email='$email'");
if($check->num_rows > 0) {
    echo "exists";
    exit;
}

Database::iud("INSERT INTO customer (fullname, email, password, joined_date) 
               VALUES ('$name', '$email', '$password', '$joined')");

$rs = Database::search("SELECT * FROM customer WHERE email='$email'");
$customer = $rs->fetch_assoc();

$_SESSION['customer_id'] = $customer['id'];
$_SESSION['customer_name'] = $customer['fullname'];
$_SESSION['customer_email'] = $customer['email'];

echo "success";
?>