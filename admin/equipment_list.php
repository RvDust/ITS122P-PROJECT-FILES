<?php

require_once("../config/database.php");

$result = mysqli_query(
    $conn,
    "SELECT * FROM equipment_inventory
     ORDER BY equipment_name ASC"
);

?>

<!DOCTYPE html>
<html>

<head>

    <title>Equipment Inventory</title>

    <link rel="stylesheet" href="../css/admin_style.css">

</head>

<body>

<div class="navbar">

    <div class="logo-section">

        <img src="../images/headerlogo.png">

        <div>

            <h2>BACMS</h2>
            <p>Asset Management</p>

        </div>

    </div>
	
	<div class="nav-links">

        <a href="equipment_list.php" class="active">
            Equipment Inventory
        </a>

        <a href="vehicle_list.php">
            Transport Vehicles
        </a>

    </div>

</div>


<div class="container">

    <h1 class="page-title">

        Equipment Inventory

    </h1>

    <div class="card">

        <a
            class="add-btn"
            href="add_equipment.php">

            + Add Equipment

        </a>

        <table>

            <tr>

                <th>ID</th>
                <th>Name</th>
                <th>Quantity</th>
                <th>Category</th>
                <th>Status</th>
                <th>Condition</th>
                <th>Date Received</th>
                <th>Type</th>
                <th>Location</th>
                <th>Action</th>

            </tr>

            <?php

            while($row = mysqli_fetch_assoc($result)){

            ?>

            <tr>

                <td><?php echo $row['equipment_id']; ?></td>

                <td><?php echo $row['equipment_name']; ?></td>

                <td><?php echo $row['equipment_quantity']; ?></td>

                <td><?php echo $row['equipment_category']; ?></td>

                <td><?php echo $row['equipment_status']; ?></td>

                <td><?php echo $row['equipment_condition']; ?></td>

                <td><?php echo $row['date_received']; ?></td>

                <td><?php echo $row['equipment_type']; ?></td>

                <td><?php echo $row['assigned_location']; ?></td>

                <td>

    <div class="action-buttons">

        <a
            class="edit-btn"
            href="edit_equipment.php?id=<?php echo $row['equipment_id']; ?>">

            Edit

        </a>

        <a
            class="delete-btn"
            href="delete_equipment.php?id=<?php echo $row['equipment_id']; ?>"
            onclick="return confirm('Delete this equipment?')">

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