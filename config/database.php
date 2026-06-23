<?php

$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "bacms"
);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>