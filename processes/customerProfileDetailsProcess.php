<?php

session_start();
include "../connection.php";

$customer_id = $_SESSION['customer_id'];
$fullname = trim($_POST['fullname']);

// validation
if (empty($fullname)) {
    echo "Name cannot be empty";
    exit;
}
if (strlen($fullname) < 3) {
    echo "Name must be at least 3 characters";
    exit;
}
if (strlen($fullname) > 100) {
    echo "Name is too long";
    exit;
}
if (!preg_match("/^[a-zA-Z\s]+$/", $fullname)) {
    echo "Name can only contain letters and spaces";
    exit;
}


Database::iud("
    UPDATE `customer` SET fullname = '$fullname' WHERE id = '$customer_id'
");

echo "success";

?>