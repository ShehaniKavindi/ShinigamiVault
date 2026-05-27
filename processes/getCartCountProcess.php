<?php
session_start();
include "../connection.php";

if(isset($_SESSION['customer_id'])) {
    $rs = Database::search("SELECT COUNT(*) as cnt FROM cart WHERE customer_id = '{$_SESSION['customer_id']}'");
    $row = $rs->fetch_assoc();
    echo $row['cnt'];
} else {
    echo 0;
}