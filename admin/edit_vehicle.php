<?php

require_once("../config/database.php");

if (!isset($_GET['id'])) {
    header("Location: vehicle_list.php");
    exit();
}

$vehicle_id = (int) $_GET['id'];

$result = mysqli_query(
    $conn,
    "SELECT * FROM transport_vehicles
     WHERE vehicle_id = '$vehicle_id'"
);

$vehicle = mysqli_fetch_assoc($result);

if (!$vehicle) {
    header("Location: vehicle_list.php");
    exit();
}

if (isset($_POST['update_vehicle'])) {

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
        "UPDATE transport_vehicles
        SET
            vehicle_name = '$vehicle_name',
            vehicle_quantity = '$vehicle_quantity',
            vehicle_type = '$vehicle_type',
            vehicle_status = '$vehicle_status',
            vehicle_condition = '$vehicle_condition',
            date_acquired = '$date_acquired',
            assigned_location = '$assigned_location',
            vehicle_remarks = '$vehicle_remarks'
        WHERE vehicle_id = '$vehicle_id'"
    );

    header("Location: vehicle_list.php");
    exit();
}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Edit Vehicle</title>

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

    <h1 class="page-title">Edit Vehicle</h1>

    <div class="card">

        <form method="POST">

            <p>

                <label>Vehicle Name</label>

                <input
                    type="text"
                    name="vehicle_name"
                    value="<?php echo $vehicle['vehicle_name']; ?>"
                    required>

            </p>

            <p>

                <label>Quantity</label>

                <input
                    type="number"
                    name="vehicle_quantity"
                    min="1"
                    value="<?php echo $vehicle['vehicle_quantity']; ?>"
                    required>

            </p>

            <p>

                 <label>Vehicle Type</label>

    <select
        name="vehicle_type"
        required>

        <option value="Community Transport"
            <?php if ($vehicle['vehicle_type'] == "Community Transport") echo "selected"; ?>>
            Community Transport
        </option>

        <option value="Medical Transport"
            <?php if ($vehicle['vehicle_type'] == "Medical Transport") echo "selected"; ?>>
            Medical Transport
        </option>

        <option value="Patrol Vehicle"
            <?php if ($vehicle['vehicle_type'] == "Patrol Vehicle") echo "selected"; ?>>
            Patrol Vehicle
        </option>

        <option value="Service Vehicle"
            <?php if ($vehicle['vehicle_type'] == "Service Vehicle") echo "selected"; ?>>
            Service Vehicle
        </option>

        <option value="Utility Vehicle"
            <?php if ($vehicle['vehicle_type'] == "Utility Vehicle") echo "selected"; ?>>
            Utility Vehicle
        </option>

    </select>

            </p>

            <p>

                <label>Status</label>

                <select
                    name="vehicle_status">

                    <option value="Available"
                        <?php if ($vehicle['vehicle_status'] == "Available") echo "selected"; ?>>
                        Available
                    </option>

                    <option value="In Use"
                        <?php if ($vehicle['vehicle_status'] == "In Use") echo "selected"; ?>>
                        In Use
                    </option>

                    <option value="Maintenance"
                        <?php if ($vehicle['vehicle_status'] == "Maintenance") echo "selected"; ?>>
                        Maintenance
                    </option>

                </select>

            </p>

            <p>

                <label>Condition</label>

                <select
                    name="vehicle_condition">

                    <option value="Good"
                        <?php if ($vehicle['vehicle_condition'] == "Good") echo "selected"; ?>>
                        Good
                    </option>

                    <option value="Fair"
                        <?php if ($vehicle['vehicle_condition'] == "Fair") echo "selected"; ?>>
                        Fair
                    </option>

                    <option value="Damaged"
                        <?php if ($vehicle['vehicle_condition'] == "Damaged") echo "selected"; ?>>
                        Damaged
                    </option>

                </select>

            </p>

            <p>

                <label>Date Acquired</label>

                <input
                    type="date"
                    name="date_acquired"
                    value="<?php echo $vehicle['date_acquired']; ?>"
                    required>

            </p>

            <p>

                <label>Assigned Location</label>

                <input
                    type="text"
                    name="assigned_location"
                    value="<?php echo $vehicle['assigned_location']; ?>"
                    required>

            </p>

            <p>

                <label>Remarks</label>

                <textarea
                    name="vehicle_remarks"><?php echo $vehicle['vehicle_remarks']; ?></textarea>

            </p>

            <button
                type="submit"
                name="update_vehicle"
                class="save-btn">

                Update Vehicle

            </button>

        </form>

    </div>

</div>

</body>

</html>