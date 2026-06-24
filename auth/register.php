<?php
session_start();
include("../config/database.php");

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $osca_id = mysqli_real_escape_string($conn, $_POST['osca_pwd_id']);
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $check = mysqli_query($conn, "SELECT * FROM users WHERE osca_pwd_id='$osca_id'");
    
    if (mysqli_num_rows($check) > 0) {
        $message = "This ID is already registered.";
    } else {
        $insert = "INSERT INTO users (osca_pwd_id, full_name, password_hash) VALUES ('$osca_id', '$full_name', '$password')";
        if (mysqli_query($conn, $insert)) {
            $message = "<span style='color:#185fad;'>Registration successful! <a href='login.php'>Login here</a></span>";
        } else {
            $message = "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>BACMS - Register</title>
    <link rel="icon" type="image/png" href="../images/headerlogo.png">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; font-weight: 400; }
        body { background: #f4f8fc; display: flex; justify-content: center; align-items: center; height: 100vh; color: #333; }
        .card { background: white; padding: 45px; border-radius: 20px; box-shadow: 0 0 15px rgba(0,0,0,.12); width: 100%; max-width: 450px; text-align: center; }
        .logo { height: 85px; margin-bottom: 25px; object-fit: contain; }
        h2 { color: #185fad; margin-bottom: 25px; font-size: 28px; }
        input { width: 100%; padding: 15px; margin-bottom: 20px; border: 1px solid #d9d9d9; border-radius: 10px; outline: none; font-size: 16px; transition: .3s; }
        input:focus { border: 1px solid #185fad; background: #f5f5f5; }
        .btn { border: none; padding: 18px; border-radius: 10px; cursor: pointer; width: 100%; font-size: 18px; font-weight: 500; margin-bottom: 20px; transition: .3s; }
        .btn-register { background: #fcfd83; color: #185fad; }
        .btn-register:hover { background: #e7e86a; }
        .msg { color: #d9534f; margin-bottom: 20px; font-weight: 500; }
        a { color: #185fad; text-decoration: none; transition: .3s; }
        a:hover { color: #144d8c; text-decoration: underline; }
    </style>
</head>
<body>
    <div class="card">
        <img src="../images/headerlogo.png" class="logo" alt="BACMS Logo">
        <h2>Resident Registration</h2>
        <div class="msg"><?php echo $message; ?></div>
        
        <form method="POST" action="register.php">
            <input type="text" name="osca_pwd_id" placeholder="OSCA / PWD ID Number" required>
            <input type="text" name="full_name" placeholder="Full Name" required>
            <input type="password" name="password" placeholder="Create Password" required>
            <button type="submit" class="btn btn-register">Register Account</button>
        </form>
        
        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>
</body>
</html>