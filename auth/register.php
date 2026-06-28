<?php
session_start();
include("../config/database.php");

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $osca_id = strtoupper(trim(mysqli_real_escape_string($conn, $_POST['osca_pwd_id'])));
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $classification = mysqli_real_escape_string($conn, $_POST['classification']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact_number']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $check = mysqli_query($conn, "SELECT * FROM users WHERE osca_pwd_id='$osca_id'");
    
    if (mysqli_num_rows($check) > 0) {
        $message = "This ID is already registered.";
    } else {
        $insert = "INSERT INTO users (osca_pwd_id, full_name, profile_classification, contact_number, address, password_hash) 
                   VALUES ('$osca_id', '$full_name', '$classification', '$contact', '$address', '$password')";
        
        if (mysqli_query($conn, $insert)) {
            $_SESSION['reg_success'] = "Registration successful! Please login below.";
            header("Location: login.php");
            exit();
        } else {
            $message = "Database Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>BACMS - Register</title>
    <link rel="icon" type="image/png" href="../images/headerlogo.png">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background: #f4f8fc; display: flex; flex-direction: column; align-items: center; min-height: 100vh; color: #333; }
        
        .wrapper { display: flex; justify-content: center; align-items: center; flex: 1; width: 100%; padding: 40px 20px; }
        .card { background: white; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,.08); width: 100%; max-width: 500px; overflow: hidden; }
        .card-header { background: #185fad; padding: 25px; display: flex; justify-content: center; align-items: center; }
        .logo { height: 55px; object-fit: contain; }
        .card-body { padding: 35px; }
        
        h2 { color: #185fad; margin-bottom: 25px; font-size: 24px; text-align: center; }
        .msg { color: #d9534f; margin-bottom: 20px; font-weight: 500; font-size: 14px; text-align: center; }
        
        .form-group { margin-bottom: 18px; text-align: left; }
        label { display: block; margin-bottom: 8px; font-weight: 500; font-size: 14px; color: #444; }
        input, select, textarea { width: 100%; padding: 12px 15px; border: 1px solid #d9d9d9; border-radius: 6px; outline: none; font-size: 15px; transition: .3s; background: #fff; }
        input:focus, select:focus, textarea:focus { border: 1px solid #185fad; box-shadow: 0 0 0 3px rgba(24,95,173,0.1); }
        textarea { resize: vertical; min-height: 80px; }
        
        .btn-register { background: #185fad; color: white; border: none; padding: 15px; border-radius: 6px; cursor: pointer; width: 100%; font-size: 16px; font-weight: 600; margin-top: 10px; transition: .3s; }
        .btn-register:hover { background: #144d8c; }
        .login-link { text-align: center; margin-top: 20px; font-size: 14px; color: #666; }
        .login-link a { color: #185fad; text-decoration: none; font-weight: 600; }
        .login-link a:hover { text-decoration: underline; }
    </style>
</head>
<body>

    <div class="wrapper">
        <div class="card">
            <div class="card-header">
                <img src="../images/headerlogo.png" class="logo" alt="BACMS Logo">
            </div>
            
            <div class="card-body">
                <h2>Resident & Caregiver Registration</h2>
                <div class="msg"><?php echo $message; ?></div>
                
                <form method="POST" action="register.php">
                    <div class="form-group">
                        <label>Government OSCA / PWD ID Number</label>
                        <input type="text" name="osca_pwd_id" placeholder="e.g. 1111" required>
                    </div>

                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" name="full_name" placeholder="e.g. Juan Dela Cruz" required>
                    </div>

                    <div class="form-group">
                        <label>User Profile Classification</label>
                        <select name="classification" required>
                            <option value="Resident">Resident</option>
                            <option value="Authorized Caregiver">Authorized Caregiver</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Primary Contact Number</label>
                        <input type="text" name="contact_number" placeholder="e.g. 09171234567" required>
                    </div>

                    <div class="form-group">
                        <label>Full Residential Address (Barangay Pinagkaisahan)</label>
                        <textarea name="address" placeholder="Unit, House Number, and Street" required></textarea>
                    </div>

                    <div class="form-group">
                        <label>Create Secure Account Password</label>
                        <input type="password" name="password" placeholder="Min. 8 characters" minlength="8" required>
                    </div>

                    <button type="submit" class="btn-register">Register Account</button>
                </form>
                
                <div class="login-link">
                    Already have an active account? <a href="login.php">Login here</a>
                </div>
            </div>
        </div>
    </div>

</body>
</html>