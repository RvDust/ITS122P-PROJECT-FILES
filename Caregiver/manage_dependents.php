<?php
session_start();
include("../config/database.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['link_dependent'])) {
    $dependent_osca = mysqli_real_escape_string($conn, $_POST['dependent_osca']);
    
    $query = "SELECT user_id, caregiver_id FROM users WHERE osca_pwd_id = '$dependent_osca'";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) == 1) {
        $dep = mysqli_fetch_assoc($result);
        if ($dep['user_id'] == $user_id) {
            $message = "<span style='color:#d9534f;'>You cannot add yourself as a dependent.</span>";
        } elseif ($dep['caregiver_id'] !== null) {
            $message = "<span style='color:#d9534f;'>This resident is already linked to a caregiver.</span>";
        } else {
            $dep_id = $dep['user_id'];
            $update = "UPDATE users SET caregiver_id = '$user_id' WHERE user_id = '$dep_id'";
            if (mysqli_query($conn, $update)) {
                $message = "<span style='color:#28a745;'>Dependent linked successfully!</span>";
            } else {
                $message = "<span style='color:#d9534f;'>Error linking dependent.</span>";
            }
        }
    } else {
        $message = "<span style='color:#d9534f;'>No resident found with that ID.</span>";
    }
}

$dependents = mysqli_query($conn, "SELECT user_id, osca_pwd_id, full_name FROM users WHERE caregiver_id = '$user_id'");
?>
<!DOCTYPE html>
<html>
<head>
    <title>BACMS - Caregiver Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background: #f4f8fc; min-height: 100vh; padding-bottom: 60px; color: #333; }
        
        /* Navbar layout */
        .navbar { background: #185fad; padding: 15px 40px; display: flex; justify-content: space-between; align-items: center; color: white; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .navbar-brand { display: flex; align-items: center; }
        .nav-logo { height: 45px; margin-right: 15px; object-fit: contain; }
        .brand-text h1 { font-size: 22px; font-weight: 500; letter-spacing: 0.5px; line-height: 1.2; }
        .brand-text p { font-size: 13px; font-weight: 300; opacity: 0.9; }
        .navbar-links a { color: white; text-decoration: none; margin-left: 25px; font-size: 15px; font-weight: 400; transition: 0.2s; }
        .navbar-links a:hover { opacity: 0.8; text-decoration: underline; }
        
        .container { max-width: 1200px; margin: 40px auto; padding: 0 20px; }
        .page-title { text-align: center; color: #185fad; font-size: 28px; font-weight: 500; margin-bottom: 40px; }
        
        /* Wide Card layout */
        .wide-card { background: white; padding: 40px; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); border: 1px solid #eef2f7; margin-bottom: 30px; text-align: left; }
        .card-title { color: #185fad; font-size: 20px; font-weight: 500; margin-bottom: 25px; }
        
        .form-group { display: flex; flex-direction: column; width: 100%; max-width: 400px; margin-bottom: 20px; }
        .form-group label { color: #185fad; font-size: 14px; margin-bottom: 8px; font-weight: 400; }
        
        input[type="text"] { width: 100%; padding: 14px; border: 1px solid #d9d9d9; border-radius: 10px; outline: none; font-size: 15px; background: white; transition: 0.2s; }
        input[type="text"]:focus { border: 1px solid #185fad; }
        
        .btn-yellow { background: #fcfd83; color: #185fad; border: none; padding: 12px 30px; border-radius: 10px; font-size: 15px; font-weight: 500; cursor: pointer; display: block; margin: 25px auto 0 auto; transition: 0.2s; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        .btn-yellow:hover { background: #e7e86a; }
        
        /* Table Layout */
        .table-container { width: 100%; border-collapse: collapse; margin-top: 15px; background: white; border-radius: 10px; overflow: hidden; border: 1px solid #eef2f7; }
        .table-container th { background: #185fad; color: white; padding: 15px 20px; font-size: 14px; font-weight: 500; text-align: left; }
        .table-container td { padding: 16px 20px; font-size: 14px; border-bottom: 1px solid #eef2f7; color: #444; }
        .table-container tr:last-child td { border-bottom: none; }
        
        .btn-blue { background: #185fad; color: white; border: none; padding: 8px 20px; border-radius: 6px; font-size: 13px; font-weight: 500; cursor: pointer; text-decoration: none; transition: 0.2s; display: inline-block; }
        .btn-blue:hover { background: #144d8c; }
        
        .msg-box { margin-bottom: 20px; font-size: 14px; font-weight: 500; }
    </style>
</head>
<body>

    <!-- Top Navbar with Upper Left Logo -->
    <div class="navbar">
        <div class="navbar-brand">
            <img src="images/headerlogo.png" class="nav-logo" alt="BACMS Logo">
            <div class="brand-text">
                <h1>BACMS</h1>
                <p>Caregiver Portal</p>
            </div>
        </div>
        <div class="navbar-links">
            <a href="dashboard.php">Dashboard</a>
            <a href="manage_dependents.php" style="text-decoration: underline; font-weight: 500;">Manage Dependents</a>
        </div>
    </div>

    <div class="container">
        <h2 class="page-title">My Dependents</h2>
        
        <div class="wide-card">
            <h3 class="card-title">Submit New Dependent</h3>
            <div class="msg-box"><?php echo $message; ?></div>
            
            <form method="POST">
                <div class="form-group">
                    <label for="dependent_osca">OSCA / PWD ID Number</label>
                    <input type="text" id="dependent_osca" name="dependent_osca" placeholder="Enter ID Number" required>
                </div>
                <button type="submit" name="link_dependent" class="btn-yellow">Submit Request</button>
            </form>
        </div>

        <div class="wide-card">
            <h3 class="card-title">Dependents List</h3>
            
            <table class="table-container">
                <thead>
                    <tr>
                        <th style="width: 30%;">ID / OSCA Number</th>
                        <th style="width: 50%;">Full Name</th>
                        <th style="width: 20%; text-align: center;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($dependents) > 0): ?>
                        <?php while($row = mysqli_fetch_assoc($dependents)): ?>
                            <tr>
                                <td><strong><?php echo $row['osca_pwd_id']; ?></strong></td>
                                <td><?php echo $row['full_name']; ?></td>
                                <td style="text-align: center;">
                                    <a href="switch_profile.php?switch_to=<?php echo $row['user_id']; ?>" class="btn-blue">Switch</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" style="text-align: center; color: #999; padding: 30px 0;">No dependents linked yet.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>