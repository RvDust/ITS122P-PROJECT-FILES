<?php

require_once("../config/database.php");

$result = mysqli_query(
    $conn,
    "SELECT * FROM transport_vehicles
     ORDER BY vehicle_name ASC"
);

?>

<!DOCTYPE html>
<html>

<head>

    <title>Transport Vehicles</title>

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
	
	  <div class="nav-links">

        <a href="equipment_list.php">
            Equipment Inventory
        </a>

        <a href="vehicle_list.php" class="active">
            Transport Vehicles
        </a>

    </div>


</div>

<div class="container">

    <h1 class="page-title">Transport Vehicles</h1>

    <div class="card">

        <a
            class="add-btn"
            href="add_vehicle.php">

            + Add Vehicle

        </a>

        <table>

            <tr>

                <th>ID</th>
                <th>Name</th>
                <th>Quantity</th>
                <th>Type</th>
                <th>Status</th>
                <th>Condition</th>
                <th>Date Acquired</th>
                <th>Location</th>
                <th>Action</th>

            </tr>

            <?php

            while($row = mysqli_fetch_assoc($result)){

            ?>

            <tr>

                <td><?php echo $row['vehicle_id']; ?></td>

                <td><?php echo $row['vehicle_name']; ?></td>

                <td><?php echo $row['vehicle_quantity']; ?></td>

                <td><?php echo $row['vehicle_type']; ?></td>

                <td><?php echo $row['vehicle_status']; ?></td>

                <td><?php echo $row['vehicle_condition']; ?></td>

                <td><?php echo $row['date_acquired']; ?></td>

                <td><?php echo $row['assigned_location']; ?></td>

         <td>

    <div class="action-buttons">

        <a
            class="edit-btn"
            href="edit_vehicle.php?id=<?php echo $row['vehicle_id']; ?>">

            Edit

        </a>

        <a
            class="delete-btn"
            href="delete_vehicle.php?id=<?php echo $row['vehicle_id']; ?>"
            onclick="return confirm('Delete this vehicle?')">

            Delete

        </a>

    </div>

</td>

            </tr>

            <?php

            }

            ?>

        </table>

    </div>

</div>

</body>

</html>