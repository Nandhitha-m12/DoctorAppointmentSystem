<?php
session_start();
include("../config.php");

if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}

/* ================= APPOINTMENT COUNTS ================= */

$total = mysqli_num_rows(mysqli_query(
    $conn,
    "SELECT * FROM appointments"
));

$pending = mysqli_num_rows(mysqli_query(
    $conn,
    "SELECT * FROM appointments WHERE status='Pending'"
));

$approved = mysqli_num_rows(mysqli_query(
    $conn,
    "SELECT * FROM appointments WHERE status='Approved'"
));

$completed = mysqli_num_rows(mysqli_query(
    $conn,
    "SELECT * FROM appointments WHERE status='Completed'"
));

$cancelled = mysqli_num_rows(mysqli_query(
    $conn,
    "SELECT * FROM appointments WHERE status='Cancelled'"
));

?>
<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>Appointment Reports</title>

<link rel="stylesheet" href="../css/style.css">

<style>

*{
    box-sizing:border-box;
    margin:0;
    padding:0;
    font-family:Arial,sans-serif;
}

body{
    background:#f5f5f5;
}

/* ================= CONTAINER ================= */

.container{
    width:90%;
    max-width:1200px;
    margin:40px auto;
}

/* ================= HEADER ================= */

.header{
    background:white;
    padding:25px;
    border-radius:12px;
    box-shadow:0 5px 15px rgba(0,0,0,.1);
    margin-bottom:30px;
}

.header h1{
    color:#6f4e8b;
    margin-bottom:8px;
}

.header p{
    color:#666;
}

/* ================= REPORT CARDS ================= */

.report-cards{

    display:grid;

    grid-template-columns:
    repeat(auto-fit,minmax(210px,1fr));

    gap:20px;

}

/* ================= CARD ================= */

.report-card{

    background:white;

    padding:25px;

    border-radius:12px;

    box-shadow:0 5px 15px rgba(0,0,0,.1);

    text-align:center;

    text-decoration:none;

    color:#333;

    transition:.3s;

}

.report-card:hover{

    transform:translateY(-7px);

    box-shadow:
    0 10px 25px rgba(0,0,0,.15);

}

/* ================= ICON ================= */

.report-icon{

    width:65px;

    height:65px;

    margin:0 auto 15px;

    border-radius:50%;

    background:#f0e9f7;

    color:#6f4e8b;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:28px;

}

/* ================= TEXT ================= */

.report-card h3{

    color:#6f4e8b;

    margin-bottom:10px;

}

.report-card .count{

    font-size:35px;

    font-weight:bold;

    color:#333;

}

/* ================= BACK BUTTON ================= */

.back-section{

    text-align:center;

    margin-top:35px;

}

.back-btn{

    display:inline-block;

    background:#6f4e8b;

    color:white;

    text-decoration:none;

    padding:12px 25px;

    border-radius:7px;

    transition:.3s;

}

.back-btn:hover{

    background:#563d7c;

}

/* ================= RESPONSIVE ================= */

@media(max-width:600px){

    .container{

        width:95%;

        margin:25px auto;

    }

    .header h1{

        font-size:25px;

    }

}

</style>

</head>

<body>

<div class="container">

    <!-- ================= HEADER ================= -->

    <div class="header">

        <h1>Appointment Reports</h1>

        <p>
            View appointment statistics and manage appointment records.
        </p>

    </div>


    <!-- ================= REPORT CARDS ================= -->

    <div class="report-cards">


        <!-- TOTAL -->

        <a href="appointments.php"
           class="report-card">

            <div class="report-icon">
                📋
            </div>

            <h3>
                Total Appointments
            </h3>

            <div class="count">
                <?php echo $total; ?>
            </div>

        </a>


        <!-- PENDING -->

        <a href="appointments.php?status=Pending"
           class="report-card">

            <div class="report-icon">
                ⏳
            </div>

            <h3>
                Pending
            </h3>

            <div class="count">
                <?php echo $pending; ?>
            </div>

        </a>


        <!-- APPROVED -->

        <a href="appointments.php?status=Approved"
           class="report-card">

            <div class="report-icon">
                ✓
            </div>

            <h3>
                Approved
            </h3>

            <div class="count">
                <?php echo $approved; ?>
            </div>

        </a>


        <!-- COMPLETED -->

        <a href="appointments.php?status=Completed"
           class="report-card">

            <div class="report-icon">
                ✓
            </div>

            <h3>
                Completed
            </h3>

            <div class="count">
                <?php echo $completed; ?>
            </div>

        </a>


        <!-- CANCELLED -->

        <a href="appointments.php?status=Cancelled"
           class="report-card">

            <div class="report-icon">
                ✕
            </div>

            <h3>
                Cancelled
            </h3>

            <div class="count">
                <?php echo $cancelled; ?>
            </div>

        </a>


    </div>


    <!-- ================= BACK ================= -->

    <div class="back-section">

        <a href="dashboard.php"
           class="back-btn">

            ← Back to Dashboard

        </a>

    </div>

</div>

</body>

</html>