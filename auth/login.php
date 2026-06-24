<?php
session_start();
include("../config/database.php");

if(isset($_SESSION['user_id'])) {
    header("Location: ../resident/dashboard.php");
    exit();
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $osca_id = mysqli_real_escape_string($conn, $_POST['osca_pwd_id']);
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE osca_pwd_id='$osca_id'";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        
        if (password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['full_name'] = $user['full_name'];
            
            header("Location: ../resident/dashboard.php");
            exit();
        } else {
            $message = "Invalid password.";
        }
    } else {
        $message = "No account found with that ID.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>BACMS - Login</title>
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
        .btn-login { background: #185fad; color: white; }
        .btn-login:hover { background: #144d8c; }
        .msg { color: #d9534f; margin-bottom: 20px; font-weight: 500; }
        a { color: #185fad; text-decoration: none; transition: .3s; }
        a:hover { color: #144d8c; text-decoration: underline; }
    </style>
</head>
<body>
    <div class="card">
        <img src="../images/headerlogo.png" class="logo" alt="BACMS Logo">
        <h2>System Login</h2>
        <div class="msg"><?php echo $message; ?></div>
        
        <form method="POST" action="login.php">
            <input type="text" name="osca_pwd_id" placeholder="OSCA / PWD ID Number" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" class="btn btn-login">Sign In</button>
        </form>
        
        <p>Don't have an account? <a href="register.php">Register here</a></p>
    </div>
</body>
</html>