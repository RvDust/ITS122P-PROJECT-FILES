<?php

require_once("../config/database.php");

if (isset($_POST['add_equipment'])) {

    $equipment_name = $_POST['equipment_name'];
    $equipment_quantity = $_POST['equipment_quantity'];
    $equipment_category = $_POST['equipment_category'];
    $equipment_status = $_POST['equipment_status'];
    $equipment_condition = $_POST['equipment_condition'];
    $date_received = $_POST['date_received'];
    $equipment_type = $_POST['equipment_type'];
    $assigned_location = $_POST['assigned_location'];
    $equipment_remarks = $_POST['equipment_remarks'];

    $check = mysqli_query(
        $conn,
        "SELECT * FROM equipment_inventory
        WHERE
            equipment_name = '$equipment_name'
            AND equipment_category = '$equipment_category'
            AND equipment_status = '$equipment_status'
            AND equipment_condition = '$equipment_condition'
            AND equipment_type = '$equipment_type'
            AND date_received = '$date_received'
            AND assigned_location = '$assigned_location'"
    );

    if (mysqli_num_rows($check) > 0) {

        $row = mysqli_fetch_assoc($check);

        $new_quantity = $row['equipment_quantity'] + $equipment_quantity;

        mysqli_query(
            $conn,
            "UPDATE equipment_inventory
            SET
                equipment_quantity = '$new_quantity',
                equipment_remarks = '$equipment_remarks'
            WHERE equipment_id = '".$row['equipment_id']."'"
        );

    } else {

        mysqli_query(
            $conn,
            "INSERT INTO equipment_inventory
            (
                equipment_name,
                equipment_quantity,
                equipment_category,
                equipment_status,
                equipment_condition,
                date_received,
                equipment_type,
                assigned_location,
                equipment_remarks
            )
            VALUES
            (
                '$equipment_name',
                '$equipment_quantity',
                '$equipment_category',
                '$equipment_status',
                '$equipment_condition',
                '$date_received',
                '$equipment_type',
                '$assigned_location',
                '$equipment_remarks'
            )"
        );

    }

    header("Location: equipment_list.php");
    exit();

}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Add Equipment</title>

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

    <h1 class="page-title">Add Equipment</h1>

    <div class="card">

        <form method="POST">

            <p>

                <label>Equipment Name</label>

                <input
                    type="text"
                    name="equipment_name"
                    required>

            </p>

            <p>

                <label>Quantity</label>

                <input
                    type="number"
                    name="equipment_quantity"
                    min="1"
                    required>

            </p>

            <p>

                <label>Category</label>

                <select
                    name="equipment_category"
                    required>

                    <option value="">-- Select Category --</option>
                    <option>Mobility Aid</option>
                    <option>Medical Equipment</option>
                    <option>Emergency Equipment</option>

                </select>

            </p>

            <p>

                <label>Status</label>

                <select
                    name="equipment_status"
                    required>

                    <option>Available</option>
                    <option>Borrowed</option>
                    <option>Maintenance</option>

                </select>

            </p>

            <p>

                <label>Condition</label>

                <select
                    name="equipment_condition"
                    required>

                    <option>Good</option>
                    <option>Fair</option>
                    <option>Damaged</option>

                </select>

            </p>

            <p>

                <label>Date Received</label>

                <input
                    type="date"
                    name="date_received"
                    required>

            </p>

            <p>

                <label>Type</label>

                <select
                    name="equipment_type"
                    required>

                    <option>Manual</option>
                    <option>Electric</option>

                </select>

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
                    name="equipment_remarks"></textarea>

            </p>

            <button
                type="submit"
                name="add_equipment"
                class="save-btn">

                Save Equipment

            </button>

        </form>

    </div>

</div>

</body>

</html>