<?php
require_once '../config/database.php';

$stats = ['Pending' => 0, 'Approved' => 0, 'Completed' => 0, 'Cancelled' => 0];
$countQuery = mysqli_query($conn, "SELECT status, COUNT(*) AS total FROM service_requests GROUP BY status");
while ($row = mysqli_fetch_assoc($countQuery)) {
    $stats[$row['status']] = $row['total'];
}

$requests = mysqli_query($conn, "
    SELECT sr.request_id, sr.resident_id, sr.service_type, sr.purpose, sr.needed_date, sr.status, sr.created_at,
           r.full_name AS resident_name
    FROM service_requests sr
    LEFT JOIN residents r ON sr.resident_id = r.resident_id
    ORDER BY FIELD(sr.status, 'Pending', 'Approved', 'Completed', 'Cancelled'), sr.created_at DESC
");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard - BACMS</title>
    <link rel="stylesheet" href="../css/admin_style.css">
</head>
<body>

<h1>Admin Dashboard</h1>

<div class="stats-container">
    <div class="stat-card pending">
        <h3>Pending</h3>
        <p><?php echo $stats['Pending']; ?></p>
    </div>
    <div class="stat-card approved">
        <h3>Approved</h3>
        <p><?php echo $stats['Approved']; ?></p>
    </div>
    <div class="stat-card completed">
        <h3>Completed</h3>
        <p><?php echo $stats['Completed']; ?></p>
    </div>
    <div class="stat-card cancelled">
        <h3>Cancelled</h3>
        <p><?php echo $stats['Cancelled']; ?></p>
    </div>
</div>

<h2>Service Requests</h2>

<?php if (isset($_GET['msg'])): ?>
    <p class="action-msg"><?php echo htmlspecialchars($_GET['msg']); ?></p>
<?php endif; ?>

<table class="requests-table">
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
        <td><?php echo htmlspecialchars($req['resident_name'] ?? 'Resident #' . $req['resident_id']); ?></td>
        <td><?php echo htmlspecialchars($req['service_type']); ?></td>
        <td><?php echo htmlspecialchars($req['purpose']); ?></td>
        <td><?php echo $req['needed_date']; ?></td>
        <td><span class="status-badge status-<?php echo strtolower($req['status']); ?>"><?php echo $req['status']; ?></span></td>
        <td><?php echo $req['created_at']; ?></td>
        <td>
            <?php if ($req['status'] === 'Pending'): ?>
                <form method="POST" action="process_request.php" class="inline-form">
                    <input type="hidden" name="request_id" value="<?php echo $req['request_id']; ?>">
                    <input type="hidden" name="action" value="Approved">
                    <button type="submit" class="btn-approve">Approve</button>
                </form>
                <form method="POST" action="process_request.php" class="inline-form">
                    <input type="hidden" name="request_id" value="<?php echo $req['request_id']; ?>">
                    <input type="hidden" name="action" value="Cancelled">
                    <button type="submit" class="btn-cancel">Cancel</button>
                </form>
            <?php elseif ($req['status'] === 'Approved'): ?>
                <form method="POST" action="process_request.php" class="inline-form">
                    <input type="hidden" name="request_id" value="<?php echo $req['request_id']; ?>">
                    <input type="hidden" name="action" value="Completed">
                    <button type="submit" class="btn-complete">Complete</button>
                </form>
                <form method="POST" action="process_request.php" class="inline-form">
                    <input type="hidden" name="request_id" value="<?php echo $req['request_id']; ?>">
                    <input type="hidden" name="action" value="Cancelled">
                    <button type="submit" class="btn-cancel">Cancel</button>
                </form>
            <?php else: ?>
                <span>-</span>
            <?php endif; ?>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

</body>
</html>
