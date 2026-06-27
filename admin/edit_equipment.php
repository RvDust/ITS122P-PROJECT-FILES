<?php

require_once("../config/database.php");

if (!isset($_GET['id'])) {
    header("Location: equipment_list.php");
    exit();
}

$equipment_id = (int) $_GET['id'];

$result = mysqli_query(
    $conn,
    "SELECT * FROM equipment_inventory
     WHERE equipment_id = '$equipment_id'"
);

$equipment = mysqli_fetch_assoc($result);

if (!$equipment) {
    header("Location: equipment_list.php");
    exit();
}

if (isset($_POST['update_equipment'])) {

    $equipment_name = $_POST['equipment_name'];
    $equipment_quantity = $_POST['equipment_quantity'];
    $equipment_category = $_POST['equipment_category'];
    $equipment_status = $_POST['equipment_status'];
    $equipment_condition = $_POST['equipment_condition'];
    $date_received = $_POST['date_received'];
    $equipment_type = $_POST['equipment_type'];
    $assigned_location = $_POST['assigned_location'];
    $equipment_remarks = $_POST['equipment_remarks'];

    mysqli_query(
        $conn,
        "UPDATE equipment_inventory
        SET
            equipment_name='$equipment_name',
            equipment_quantity='$equipment_quantity',
            equipment_category='$equipment_category',
            equipment_status='$equipment_status',
            equipment_condition='$equipment_condition',
            date_received='$date_received',
            equipment_type='$equipment_type',
            assigned_location='$assigned_location',
            equipment_remarks='$equipment_remarks'
        WHERE equipment_id='$equipment_id'"
    );

    header("Location: equipment_list.php");
    exit();
}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Edit Equipment</title>

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

    <h1 class="page-title">Edit Equipment</h1>

    <div class="card">

        <form method="POST">

            <p>

                <label>Equipment Name</label>

                <input
                    type="text"
                    name="equipment_name"
                    value="<?php echo $equipment['equipment_name']; ?>"
                    required>

            </p>

            <p>

                <label>Quantity</label>

                <input
                    type="number"
                    name="equipment_quantity"
                    min="1"
                    value="<?php echo $equipment['equipment_quantity']; ?>"
                    required>

            </p>

            <p>

                <label>Category</label>

                <select name="equipment_category" required>

                    <option value="Mobility Aid" <?php if($equipment['equipment_category']=="Mobility Aid") echo "selected"; ?>>
                        Mobility Aid
                    </option>

                    <option value="Medical Equipment" <?php if($equipment['equipment_category']=="Medical Equipment") echo "selected"; ?>>
                        Medical Equipment
                    </option>

                    <option value="Emergency Equipment" <?php if($equipment['equipment_category']=="Emergency Equipment") echo "selected"; ?>>
                        Emergency Equipment
                    </option>

                </select>

            </p>

            <p>

                <label>Status</label>

                <select name="equipment_status">

                    <option value="Available" <?php if($equipment['equipment_status']=="Available") echo "selected"; ?>>
                        Available
                    </option>

                    <option value="Borrowed" <?php if($equipment['equipment_status']=="Borrowed") echo "selected"; ?>>
                        Borrowed
                    </option>

                    <option value="Maintenance" <?php if($equipment['equipment_status']=="Maintenance") echo "selected"; ?>>
                        Maintenance
                    </option>

                </select>

            </p>

            <p>

                <label>Condition</label>

                <select name="equipment_condition">

                    <option value="Good" <?php if($equipment['equipment_condition']=="Good") echo "selected"; ?>>
                        Good
                    </option>

                    <option value="Fair" <?php if($equipment['equipment_condition']=="Fair") echo "selected"; ?>>
                        Fair
                    </option>

                    <option value="Damaged" <?php if($equipment['equipment_condition']=="Damaged") echo "selected"; ?>>
                        Damaged
                    </option>

                </select>

            </p>

            <p>

                <label>Date Received</label>

                <input
                    type="date"
                    name="date_received"
                    value="<?php echo $equipment['date_received']; ?>"
                    required>

            </p>

            <p>

                <label>Type</label>

                <select name="equipment_type">

                    <option value="Manual" <?php if($equipment['equipment_type']=="Manual") echo "selected"; ?>>
                        Manual
                    </option>

                    <option value="Electric" <?php if($equipment['equipment_type']=="Electric") echo "selected"; ?>>
                        Electric
                    </option>

                </select>

            </p>

            <p>

                <label>Assigned Location</label>

                <input
                    type="text"
                    name="assigned_location"
                    value="<?php echo $equipment['assigned_location']; ?>"
                    required>

            </p>

            <p>

                <label>Remarks</label>

                <textarea name="equipment_remarks"><?php echo $equipment['equipment_remarks']; ?></textarea>

            </p>

            <button
                type="submit"
                name="update_equipment"
                class="save-btn">

                Update Equipment

            </button>

        </form>

    </div>

</div>

</body>

</html>