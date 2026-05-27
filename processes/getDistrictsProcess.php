<?php
include "../connection.php";

$province_id = intval($_GET['province_id']);
$rs = Database::search("SELECT id, name FROM district WHERE province_id = '$province_id' ORDER BY name");

$districts = [];
while ($row = $rs->fetch_assoc()) {
    $districts[] = $row;
}

echo json_encode($districts);
?>