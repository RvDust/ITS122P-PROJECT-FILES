<?php

require_once("../config/database.php");

if (!isset($_GET['id'])) {
    header("Location: vehicle_list.php");
    exit();
}

$vehicle_id = (int) $_GET['id'];

mysqli_query(
    $conn,
    "DELETE FROM transport_vehicles
    WHERE vehicle_id = '$vehicle_id'"
);

header("Location: vehicle_list.php");
exit();

?>