<?php

require_once("../config/database.php");

if (!isset($_GET['id'])) {
    header("Location: equipment_list.php");
    exit();
}

$equipment_id = (int) $_GET['id'];

mysqli_query(
    $conn,
    "DELETE FROM equipment_inventory
    WHERE equipment_id = '$equipment_id'"
);

header("Location: equipment_list.php");
exit();

?>