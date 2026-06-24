<?php
session_start();
include("../config/database.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$residentID = $_SESSION['user_id'];

$total = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) AS count
FROM service_requests
WHERE resident_id='$residentID'"));

$pending = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) AS count
FROM service_requests
WHERE resident_id='$residentID'
AND status='Pending'"));

$approved = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) AS count
FROM service_requests
WHERE resident_id='$residentID'
AND status='Approved'"));

$completed = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) AS count
FROM service_requests
WHERE resident_id='$residentID'
AND status='Completed'"));

$cancelled = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) AS count
FROM service_requests
WHERE resident_id='$residentID'
AND status='Cancelled'"));
?>

<!DOCTYPE html>
<html>
<head>
    <title>Resident Dashboard</title>

    <link rel="icon"
          type="image/png"
          href="../images/headerlogo.png">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500&display=swap"
          rel="stylesheet">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Inter',sans-serif;
    font-weight:400;
}

body{
    background:#f4f8fc;
}

.header{
    background:#185fad;
    padding:18px 45px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.header-logo{
    height:85px;
    width:auto;
    object-fit:contain;
    display:block;
}

.nav{
    display:flex;
    gap:35px;
    align-items:center;
}

.nav a{
    color:white;
    text-decoration:none;
    transition:.3s;
}

.nav a:hover{
    color:#e7e86a;
}

.container{
    width:65%;
    max-width:1100px;
    margin:40px auto;
}

h1{
    text-align:center;
    color:#185fad;
    font-size:32px;
    margin-bottom:10px;
}

.subtitle{
    text-align:center;
    color:#555;
    margin-bottom:35px;
}

.stats{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(170px,1fr));
    gap:20px;
    margin-bottom:35px;
}

.stat-card{
    background:white;
    padding:25px;
    border-radius:20px;
    box-shadow:0 0 15px rgba(0,0,0,.12);
    text-align:center;
}

.stat-card h3{
    color:#185fad;
    margin-bottom:15px;
}

.stat-card p{
    color:#185fad;
    font-size:32px;
}

.main-card{
    background:white;
    padding:35px;
    border-radius:20px;
    box-shadow:0 0 15px rgba(0,0,0,.12);
    text-align:center;
}

.main-card h2{
    color:#185fad;
    margin-bottom:15px;
}

.main-card p{
    color:#555;
    margin-bottom:30px;
}

.btn{
    background:#fcfd83;
    color:#185fad;
    text-decoration:none;
    padding:14px 35px;
    border-radius:10px;
    display:inline-block;
    transition:.3s;
}

.btn:hover{
    background:#e7e86a;
}

.footer{
    background:#185fad;
    color:white;
    text-align:center;
    padding:20px;
    margin-top:50px;
}

@media(max-width:900px){

    .container{
        width:90%;
    }

    .header{
        flex-direction:column;
        gap:20px;
        padding:20px;
    }

    .header-logo{
        height:60px;
    }

    .nav{
        gap:20px;
    }

    .stats{
        grid-template-columns:1fr;
    }
}
</style>
</head>

<body>

<div class="header">
    <img src="../images/headerlogo.png" class="header-logo" alt="BACMS Logo">

    <div class="nav">
        <a href="dashboard.php">Dashboard</a>
        <a href="my_request.php">My Requests</a>
        <a href="../auth/logout.php" style="color: #fcfd83;">Logout</a>
    </div>
</div>

<div class="container">

    <h1>Resident Dashboard</h1>

    <p class="subtitle">
        Track your assistive care service requests.
    </p>

    <div class="stats">

        <div class="stat-card">
            <h3>Total Requests</h3>
            <p><?php echo $total['count']; ?></p>
        </div>

        <div class="stat-card">
            <h3>Pending</h3>
            <p><?php echo $pending['count']; ?></p>
        </div>

        <div class="stat-card">
            <h3>Approved</h3>
            <p><?php echo $approved['count']; ?></p>
        </div>

        <div class="stat-card">
            <h3>Completed</h3>
            <p><?php echo $completed['count']; ?></p>
        </div>

        <div class="stat-card">
            <h3>Cancelled</h3>
            <p><?php echo $cancelled['count']; ?></p>
        </div>

    </div>

    <div class="main-card">

        <h2>Need equipment or transportation?</h2>

        <p>
            Create a request and monitor its status from your request history.
        </p>

        <a
            class="btn"
            href="my_request.php">
            Go to My Requests
        </a>

    </div>

</div>

<div class="footer">
    © 2025 BACMS. All Rights Reserved.
</div>

</body>
</html>
