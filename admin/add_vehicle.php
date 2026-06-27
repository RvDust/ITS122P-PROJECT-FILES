<?php

require_once("../config/database.php");

if (isset($_POST['add_vehicle'])) {

    $vehicle_name = $_POST['vehicle_name'];
    $vehicle_quantity = $_POST['vehicle_quantity'];
    $vehicle_type = $_POST['vehicle_type'];
    $vehicle_status = $_POST['vehicle_status'];
    $vehicle_condition = $_POST['vehicle_condition'];
    $date_acquired = $_POST['date_acquired'];
    $assigned_location = $_POST['assigned_location'];
    $vehicle_remarks = $_POST['vehicle_remarks'];

    mysqli_query(
        $conn,
        "INSERT INTO transport_vehicles
        (
            vehicle_name,
            vehicle_quantity,
            vehicle_type,
            vehicle_status,
            vehicle_condition,
            date_acquired,
            assigned_location,
            vehicle_remarks
        )
        VALUES
        (
            '$vehicle_name',
            '$vehicle_quantity',
            '$vehicle_type',
            '$vehicle_status',
            '$vehicle_condition',
            '$date_acquired',
            '$assigned_location',
            '$vehicle_remarks'
        )"
    );

    header("Location: vehicle_list.php");
    exit();

}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Add Vehicle</title>

    <link rel="stylesheet" href="../css/admin_style.css">

</head>

<body>

<div class="navbar">

    <div class="logo-section">

        <img src="../images/headerlogo.png" alt="BACMS Logo">

        <div>

            <h2>BACMS</h2>

            <p>Asset Management</p>

        </div>

    </div>

</div>

<div class="container">

    <h1 class="page-title">Add Vehicle</h1>

    <div class="card">

        <form method="POST">

            <p>

                <label>Vehicle Name</label>

                <input
                    type="text"
                    name="vehicle_name"
                    required>

            </p>

            <p>

                <label>Quantity</label>

                <input
                    type="number"
                    name="vehicle_quantity"
                    min="1"
                    required>

            </p>

            <p>

                <label>Vehicle Type</label>

                <select
                    name="vehicle_type"
                    required>

                    <option value="">-- Select Vehicle Type --</option>
                    <option>Community Transport</option>
                    <option>Medical Transport</option>
                    <option>Patrol Vehicle</option>
                    <option>Service Vehicle</option>
                    <option>Utility Vehicle</option>

                </select>

            </p>

            <p>

                <label>Status</label>

                <select
                    name="vehicle_status"
                    required>

                    <option>Available</option>
                    <option>In Use</option>
                    <option>Maintenance</option>

                </select>

            </p>

            <p>

                <label>Condition</label>

                <select
                    name="vehicle_condition"
                    required>

                    <option>Good</option>
                    <option>Fair</option>
                    <option>Damaged</option>

                </select>

            </p>

            <p>

                <label>Date Acquired</label>

                <input
                    type="date"
                    name="date_acquired"
                    required>

            </p>

            <p>

                <label>Assigned Location</label>

                <input
                    type="text"
                    name="assigned_location"
                    required>

            </p>

            <p>

                <label>Remarks</label>

                <textarea
                    name="vehicle_remarks"></textarea>

            </p>

            <button
                type="submit"
                name="add_vehicle"
                class="save-btn">

                Save Vehicle

            </button>

        </form>

    </div>

</div>

</body>

</html>