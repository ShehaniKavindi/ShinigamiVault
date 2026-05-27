<?php
session_start();
include "../connection.php";

$customer_id = $_SESSION['customer_id'];
$line1    = $_POST['line1'];
$line2    = $_POST['line2'];
$city     = $_POST['city'];
$district = $_POST['district'];
$province = $_POST['province'];
$pcode    = $_POST['pcode'];
$contact1 = $_POST['contact1'];
$contact2 = $_POST['contact2'];

$check = Database::search("SELECT id FROM address WHERE customer_id = '$customer_id'");

if ($check->num_rows > 0) {
    Database::iud("
        UPDATE address SET 
            line1 = '$line1',
            line2 = '$line2',
            city = '$city',
            district_id = '$district',
            postal_code = '$pcode',
            contact1 = '$contact1',
            contact2 = '$contact2'
        WHERE customer_id = '$customer_id'
    ");
} else {
    Database::iud("
        INSERT INTO address (line1, line2, city, district_id, postal_code, contact1, contact2, customer_id)
        VALUES ('$line1', '$line2', '$city', '$district', '$pcode', '$contact1', '$contact2', '$customer_id')
    ");
}

echo "success";
?>