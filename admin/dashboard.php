<?php

require_once("../config/database.php");

$stats = ['Pending' => 0, 'Approved' => 0, 'Completed' => 0, 'Cancelled' => 0];
$countQuery = mysqli_query($conn, "SELECT status, COUNT(*) AS total FROM service_requests GROUP BY status");
while ($row = mysqli_fetch_assoc($countQuery)) {
    $stats[$row['status']] = $row['total'];
}

$equipRow = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT COALESCE(SUM(equipment_quantity), 0) AS total
    FROM equipment_inventory
    WHERE equipment_status = 'Available'
"));
$availableEquipment = $equipRow['total'];

$vehicleRow = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT COALESCE(SUM(vehicle_quantity), 0) AS total
    FROM transport_vehicles
    WHERE vehicle_status = 'Available'
"));
$availableVehicles = $vehicleRow['total'];

$requests = mysqli_query($conn, "
    SELECT request_id, resident_id, service_type, purpose, needed_date, status, created_at
    FROM service_requests
    ORDER BY FIELD(status, 'Pending', 'Approved', 'Completed', 'Cancelled'), created_at DESC
");

?>

<!DOCTYPE html>
<html>

<head>

    <title>Admin Dashboard</title>

    <link rel="stylesheet" href="../css/admin_style.css">

    <style>
        .stats-grid{
            display:grid;
            grid-template-columns:repeat(auto-fit, minmax(160px, 1fr));
            gap:18px;
            margin-bottom:30px;
        }
        .stat-box{
            background:#185fad;
            color:white;
            border-radius:10px;
            padding:20px;
            text-align:center;
            box-shadow:0 8px 22px rgba(0,0,0,.08);
        }
        .stat-box h3{
            font-size:14px;
            font-weight:bold;
            margin-bottom:8px;
            opacity:.9;
        }
        .stat-box p{
            font-size:30px;
            font-weight:bold;
        }
        .stat-box.equipment, .stat-box.vehicles{
            background:#fff36b;
            color:#185fad;
        }
        .action-msg{
            background:#e8f5e9;
            color:#1e7e34;
            padding:12px 18px;
            border-radius:8px;
            margin-bottom:20px;
            font-weight:bold;
        }
        .status-pill{
            padding:6px 14px;
            border-radius:20px;
            font-size:13px;
            font-weight:bold;
            color:white;
        }
        .status-pill.pending{ background:#f0ad4e; }
        .status-pill.approved{ background:#185fad; }
        .status-pill.completed{ background:#28a745; }
        .status-pill.cancelled{ background:#dc3545; }
        .inline-form{ display:inline-block; }
    </style>

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

        <a href="dashboard.php" class="active">
            Dashboard
        </a>

        <a href="equipment_list.php">
            Equipment Inventory
        </a>

        <a href="vehicle_list.php">
            Transport Vehicles
        </a>

    </div>

</div>


<div class="container">

    <h1 class="page-title">

        Admin Dashboard

    </h1>

    <div class="stats-grid">

        <div class="stat-box">
            <h3>Pending</h3>
            <p><?php echo $stats['Pending']; ?></p>
        </div>

        <div class="stat-box">
            <h3>Approved</h3>
            <p><?php echo $stats['Approved']; ?></p>
        </div>

        <div class="stat-box">
            <h3>Completed</h3>
            <p><?php echo $stats['Completed']; ?></p>
        </div>

        <div class="stat-box">
            <h3>Cancelled</h3>
            <p><?php echo $stats['Cancelled']; ?></p>
        </div>

        <div class="stat-box equipment">
            <h3>Available Equipment</h3>
            <p><?php echo $availableEquipment; ?></p>
        </div>

        <div class="stat-box vehicles">
            <h3>Available Vehicles</h3>
            <p><?php echo $availableVehicles; ?></p>
        </div>

    </div>

    <div class="card">

        <h1 class="page-title" style="font-size:22px; margin-bottom:20px;">Service Requests</h1>

        <?php if (isset($_GET['msg'])): ?>
            <p class="action-msg"><?php echo htmlspecialchars($_GET['msg']); ?></p>
        <?php endif; ?>

        <table>

            <tr>

                <th>ID</th>
                <th>Resident</th>
                <th>Service Type</th>
                <th>Purpose</th>
                <th>Needed Date</th>
                <th>Status</th>
                <th>Requested On</th>
                <th>Action</th>

            </tr>

            <?php while ($req = mysqli_fetch_assoc($requests)): ?>

            <tr>

                <td><?php echo $req['request_id']; ?></td>

                <td>Resident #<?php echo $req['resident_id']; ?></td>

                <td><?php echo htmlspecialchars($req['service_type']); ?></td>

                <td><?php echo htmlspecialchars($req['purpose']); ?></td>

                <td><?php echo $req['needed_date']; ?></td>

                <td>
                    <span class="status-pill <?php echo strtolower($req['status']); ?>">
                        <?php echo $req['status']; ?>
                    </span>
                </td>

                <td><?php echo $req['created_at']; ?></td>

                <td>

                    <div class="action-buttons">

                        <?php if ($req['status'] === 'Pending'): ?>

                            <form method="POST" action="process_request.php" class="inline-form">
                                <input type="hidden" name="request_id" value="<?php echo $req['request_id']; ?>">
                                <input type="hidden" name="action" value="Approved">
                                <button type="submit" class="edit-btn">Approve</button>
                            </form>

                            <form method="POST" action="process_request.php" class="inline-form" onsubmit="return confirm('Cancel this request?')">
                                <input type="hidden" name="request_id" value="<?php echo $req['request_id']; ?>">
                                <input type="hidden" name="action" value="Cancelled">
                                <button type="submit" class="delete-btn">Cancel</button>
                            </form>

                        <?php elseif ($req['status'] === 'Approved'): ?>

                            <form method="POST" action="process_request.php" class="inline-form">
                                <input type="hidden" name="request_id" value="<?php echo $req['request_id']; ?>">
                                <input type="hidden" name="action" value="Completed">
                                <button type="submit" class="edit-btn">Complete</button>
                            </form>

                            <form method="POST" action="process_request.php" class="inline-form" onsubmit="return confirm('Cancel this request?')">
                                <input type="hidden" name="request_id" value="<?php echo $req['request_id']; ?>">
                                <input type="hidden" name="action" value="Cancelled">
                                <button type="submit" class="delete-btn">Cancel</button>
                            </form>

                        <?php else: ?>
                            <span>-</span>
                        <?php endif; ?>

                    </div>

                </td>

            </tr>

            <?php endwhile; ?>

        </table>

    </div>

</div>

</body>

</html>
