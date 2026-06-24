<?php
session_start();
include("../config/database.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$residentID = $_SESSION['user_id'];
$message = "";

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $delete = "DELETE FROM service_requests
               WHERE request_id='$id'
               AND resident_id='$residentID'";

    mysqli_query($conn, $delete);

    header("Location: my_request.php#history");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $service = $_POST['service_type'];
    $purpose = $_POST['purpose'];
    $date = $_POST['needed_date'];

    $insert = "INSERT INTO service_requests
              (resident_id, service_type, purpose, needed_date, status)
              VALUES
              ('$residentID', '$service', '$purpose', '$date', 'Pending')";

    if (mysqli_query($conn, $insert)) {
        $message = "Request submitted successfully!";
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}

$sql = "SELECT *
        FROM service_requests
        WHERE resident_id='$residentID'
        ORDER BY request_id DESC";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Requests</title>

    <link rel="icon" type="image/png" href="../images/headerlogo.png">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500&display=swap" rel="stylesheet">

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:'Inter', sans-serif;
            font-weight:400;
        }

        body{
            background:#f4f8fc;
            color:#333;
        }

        .header{
            background:#185fad;
            color:white;
            padding:18px 45px;
            display:flex;
            justify-content:space-between;
            align-items:center;
        }

        .header-logo{
            height:75px;
            width:auto;
            object-fit:contain;
            display:block;
        }

        .nav a{
            color:white;
            text-decoration:none;
            margin-left:30px;
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
            margin-bottom:30px;
        }

        h2{
            color:#185fad;
            font-size:24px;
            margin-bottom:20px;
        }

        .card{
            background:white;
            padding:30px;
            border-radius:20px;
            box-shadow:0 0 15px rgba(0,0,0,.12);
            margin-bottom:30px;
        }

        .form-row{
            display:flex;
            gap:20px;
        }

        .form-group{
            flex:1;
        }

        label{
            display:block;
            margin-bottom:10px;
            color:#185fad;
        }

        select,
        textarea,
        input{
            width:100%;
            padding:12px;
            border:1px solid #d9d9d9;
            border-radius:10px;
            background:white;
            color:#333;
            font-size:15px;
            outline:none;
            transition:.3s;
        }

        select:hover,
        textarea:hover,
        input:hover{
            background:#f5f5f5;
        }

        select:focus,
        textarea:focus,
        input:focus{
            background:#f5f5f5;
            border:1px solid #185fad;
        }

        textarea{
            height:120px;
            resize:none;
        }

        .center{
            text-align:center;
            margin-top:30px;
        }

        button{
            background:#fcfd83;
            color:#185fad;
            border:none;
            padding:12px 30px;
            border-radius:10px;
            cursor:pointer;
            font-size:15px;
            transition:.3s;
        }

        button:hover{
            background:#e7e86a;
        }

        .message{
            background:#fcfd83;
            color:#185fad;
            padding:15px;
            border-radius:10px;
            text-align:center;
            margin-bottom:30px;
        }

        table{
            width:100%;
            border-collapse:collapse;
        }

        th{
            background:#185fad;
            color:white;
            padding:12px;
            font-size:14px;
        }

        td{
            border:1px solid #e5e5e5;
            padding:12px;
            text-align:center;
            font-size:14px;
        }

        .status{
            background:#fcfd83;
            color:#185fad;
            padding:7px 15px;
            border-radius:8px;
            display:inline-block;
        }

        .delete-btn{
            background:#d9534f;
            color:white;
            text-decoration:none;
            padding:7px 14px;
            border-radius:8px;
            transition:.3s;
            display:inline-block;
        }

        .delete-btn:hover{
            background:#b52b27;
        }

        .modal{
            display:none;
            position:fixed;
            top:0;
            left:0;
            width:100%;
            height:100%;
            background:rgba(0,0,0,0.45);
            justify-content:center;
            align-items:center;
            z-index:9999;
        }

        .modal.show{
            display:flex;
        }

        .modal-box{
            background:white;
            width:350px;
            padding:35px;
            border-radius:20px;
            text-align:center;
            box-shadow:0 10px 30px rgba(0,0,0,.20);
        }

        .modal-box h3{
            color:#185fad;
            margin-bottom:15px;
            font-size:22px;
        }

        .modal-box p{
            color:#555;
            margin-bottom:30px;
        }

        .modal-buttons{
            display:flex;
            justify-content:center;
            gap:15px;
        }

        .yes-btn{
            background:#185fad;
            color:white;
            text-decoration:none;
            padding:12px 30px;
            border-radius:10px;
            transition:.3s;
        }

        .yes-btn:hover{
            background:#144d8c;
        }

        .no-btn{
            background:white;
            color:#185fad;
            border:1px solid #ddd;
            padding:12px 30px;
            border-radius:10px;
            cursor:pointer;
            transition:.3s;
        }

        .no-btn:hover{
            background:#f5f5f5;
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
                gap:15px;
            }

            .header-logo{
                height:60px;
            }

            .nav a{
                margin:10px;
            }

            .form-row{
                flex-direction:column;
            }

            .card{
                overflow-x:auto;
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

    <h1>My Requests</h1>

    <?php if($message != "") { ?>
        <div class="message">
            <?php echo $message; ?>
        </div>
    <?php } ?>

    <div class="card">
        <h2>Submit New Request</h2>

        <form action="my_request.php" method="POST">

            <div class="form-row">

                <div class="form-group">
                    <label>Service Type</label>

                    <select name="service_type" required>
                        <option value="">Select Service</option>
                        <option value="Wheelchair">Wheelchair</option>
                        <option value="Cane">Cane</option>
                        <option value="Walker">Walker</option>
                        <option value="Oxygen Tank">Oxygen Tank</option>
                        <option value="Transportation">Transportation</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Purpose</label>

                    <textarea
                        name="purpose"
                        placeholder="Enter purpose of request..."
                        required></textarea>
                </div>

                <div class="form-group">
                    <label>Needed Date</label>

                    <input
    type="date"
    id="needed_date"
    name="needed_date"
    max="<?php echo date('Y'); ?>-12-31"
    required>
                </div>

            </div>

            <div class="center">
                <button type="submit">
                    Submit Request
                </button>
            </div>

        </form>
    </div>

    <div class="card" id="history">
        <h2>Request History</h2>

        <table>
            <tr>
                <th>ID</th>
                <th>Service</th>
                <th>Purpose</th>
                <th>Needed Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>

            <?php if(mysqli_num_rows($result) > 0){ ?>

                <?php while($row = mysqli_fetch_assoc($result)){ ?>

                    <tr>
                        <td><?php echo $row['request_id']; ?></td>
                        <td><?php echo $row['service_type']; ?></td>
                        <td><?php echo $row['purpose']; ?></td>
                        <td><?php echo $row['needed_date']; ?></td>
                        <td>
                            <span class="status">
                                <?php echo $row['status']; ?>
                            </span>
                        </td>
                        <td>
                            <a
                                class="delete-btn"
                                href="#"
                                onclick="openDeleteModal(<?php echo $row['request_id']; ?>); return false;">
                                Delete
                            </a>
                        </td>
                    </tr>

                <?php } ?>

            <?php } else { ?>

                <tr>
                    <td colspan="6">
                        No requests found.
                    </td>
                </tr>

            <?php } ?>

        </table>
    </div>

</div>

<div class="footer">
    © 2025 BACMS. All Rights Reserved.
</div>

<div id="deleteModal" class="modal">
    <div class="modal-box">
        <h3>Delete Request</h3>

        <p>Do you want to delete this request?</p>

        <div class="modal-buttons">
            <a id="confirmDelete" class="yes-btn">
                Yes
            </a>

            <button
                type="button"
                class="no-btn"
                onclick="closeDeleteModal()">
                No
            </button>
        </div>
    </div>
</div>

<script>
function openDeleteModal(id)
{
    document.getElementById("deleteModal").classList.add("show");
    document.getElementById("confirmDelete").href =
        "my_request.php?delete=" + id + "#history";
}

function closeDeleteModal()
{
    document.getElementById("deleteModal").classList.remove("show");
}

const dateInput = document.getElementById('needed_date');

if (dateInput) {
    dateInput.addEventListener('change', function () {

        const selectedDate = new Date(this.value);
        const currentYear = new Date().getFullYear();

        if (selectedDate.getFullYear() > currentYear) {
            alert('You cannot select a year beyond ' + currentYear + '.');
            this.value = '';
        }
    });
}
</script>

</body>
</html>
