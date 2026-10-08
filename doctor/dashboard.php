<?php

session_start();

include("../config.php");


/* ================= LOGIN CHECK ================= */

if (!isset($_SESSION['doctor_id'])) {

    header("Location: ../login.php");

    exit();

}


$doctor_id = $_SESSION['doctor_id'];

$doctor_name = $_SESSION['doctor_name'];


/* ================= APPOINTMENT COUNTS ================= */

// Total
$total_query = mysqli_query($conn, "
    SELECT * FROM appointments
    WHERE doctor_id='$doctor_id'
");

$total = mysqli_num_rows($total_query);


// Pending
$pending_query = mysqli_query($conn, "
    SELECT * FROM appointments
    WHERE doctor_id='$doctor_id'
    AND status='Pending'
");

$pending = mysqli_num_rows($pending_query);


// Approved
$approved_query = mysqli_query($conn, "
    SELECT * FROM appointments
    WHERE doctor_id='$doctor_id'
    AND status='Approved'
");

$approved = mysqli_num_rows($approved_query);


// Completed
$completed_query = mysqli_query($conn, "
    SELECT * FROM appointments
    WHERE doctor_id='$doctor_id'
    AND status='Completed'
");

$completed = mysqli_num_rows($completed_query);


// Cancelled
$cancelled_query = mysqli_query($conn, "
    SELECT * FROM appointments
    WHERE doctor_id='$doctor_id'
    AND status='Cancelled'
");

$cancelled = mysqli_num_rows($cancelled_query);

?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>Doctor Dashboard</title>


<!-- Main CSS -->

<link rel="stylesheet"
      href="../css/style.css">


<!-- Font Awesome -->

<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">


<!-- Poppins -->

<link rel="preconnect"
      href="https://fonts.googleapis.com">

<link rel="preconnect"
      href="https://fonts.gstatic.com"
      crossorigin>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
      rel="stylesheet">


<style>

/* ================= GENERAL ================= */

* {

    box-sizing: border-box;

    font-family: 'Poppins', sans-serif;

}


body {

    margin: 0;

    background: #f7f5fa;

    font-family: 'Poppins', sans-serif;

}


/* ================= CONTAINER ================= */

.doctor-dashboard {

    width: 92%;

    max-width: 1400px;

    margin: 40px auto 60px;

}


/* ================= WELCOME ================= */

.dashboard-welcome {

    background: linear-gradient(
        135deg,
        #6b4c8b,
        #8d63b8
    );

    padding: 45px 50px;

    border-radius: 20px;

    color: white;

    margin-bottom: 45px;

    box-shadow:
        0 12px 30px
        rgba(107,76,139,.20);

}


.welcome-label {

    display: inline-block;

    background: rgba(255,255,255,.18);

    padding: 7px 16px;

    border-radius: 20px;

    font-size: 14px;

    margin-bottom: 12px;

}


.dashboard-welcome h1 {

    font-size: 36px;

    margin: 0 0 10px;

    font-weight: 600;

}


.dashboard-welcome p {

    font-size: 16px;

    line-height: 1.7;

    max-width: 700px;

    margin: 0;

}


/* ================= SECTION TITLE ================= */

.section-title {

    text-align: center;

    color: #2d2340;

    font-size: 30px;

    margin-bottom: 30px;

}


.section-title::after {

    content: "";

    display: block;

    width: 60px;

    height: 4px;

    background: #6b4c8b;

    border-radius: 5px;

    margin: 12px auto 0;

}


/* ================= STAT CARDS ================= */

.stats-container {

    display: grid;

    grid-template-columns:
        repeat(5, 1fr);

    gap: 20px;

    margin-bottom: 50px;

}


.stat-card {

    background: white;

    border-radius: 18px;

    padding: 25px 15px;

    text-align: center;

    text-decoration: none;

    color: #2d2340;

    box-shadow:
        0 8px 25px
        rgba(0,0,0,.08);

    transition: .3s;

}


.stat-card:hover {

    transform: translateY(-7px);

    box-shadow:
        0 15px 35px
        rgba(107,76,139,.18);

}


.stat-icon {

    width: 65px;

    height: 65px;

    margin: 0 auto 15px;

    border-radius: 50%;

    background: #f0e9f7;

    color: #6b4c8b;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 25px;

}


.stat-card h3 {

    font-size: 15px;

    margin: 8px 0;

    color: #555;

}


.stat-number {

    font-size: 30px;

    font-weight: 700;

    color: #6b4c8b;

}


/* ================= QUICK ACTIONS ================= */

.action-container {

    display: grid;

    grid-template-columns:
        repeat(3, 1fr);

    gap: 25px;

    margin-bottom: 50px;

}


.action-card {

    background: white;

    border-radius: 18px;

    padding: 30px 22px;

    text-align: center;

    box-shadow:
        0 8px 25px
        rgba(0,0,0,.08);

    transition: .3s;

}


.action-card:hover {

    transform: translateY(-7px);

    box-shadow:
        0 15px 35px
        rgba(107,76,139,.18);

}


.action-icon {

    width: 70px;

    height: 70px;

    margin: 0 auto 20px;

    border-radius: 50%;

    background: #f0e9f7;

    color: #6b4c8b;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 28px;

}


.action-card h3 {

    color: #2d2340;

    margin-bottom: 10px;

}


.action-card p {

    color: #777;

    font-size: 14px;

    line-height: 1.6;

    min-height: 45px;

}


/* ================= BUTTON ================= */

.dashboard-btn {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    gap: 8px;

    margin-top: 15px;

    padding: 11px 22px;

    background: #6b4c8b;

    color: white;

    text-decoration: none;

    border-radius: 25px;

    font-size: 14px;

    font-weight: 600;

    transition: .3s;

}


.dashboard-btn:hover {

    background: #563975;

    transform: translateY(-2px);

}


.logout-btn {

    background: #8b4c6b;

}


.logout-btn:hover {

    background: #713b56;

}


/* ================= RESPONSIVE ================= */

@media(max-width: 1100px) {

    .stats-container {

        grid-template-columns:
            repeat(3, 1fr);

    }

}


@media(max-width: 800px) {

    .action-container {

        grid-template-columns:
            repeat(2, 1fr);

    }

}


@media(max-width: 650px) {

    .doctor-dashboard {

        width: 94%;

        margin-top: 25px;

    }


    .dashboard-welcome {

        padding: 30px 25px;

    }


    .dashboard-welcome h1 {

        font-size: 27px;

    }


    .stats-container {

        grid-template-columns: 1fr 1fr;

    }


    .action-container {

        grid-template-columns: 1fr;

    }

}


@media(max-width: 450px) {

    .stats-container {

        grid-template-columns: 1fr;

    }

}

</style>

</head>


<body>


<div class="doctor-dashboard">


<!-- ================= WELCOME ================= -->

<div class="dashboard-welcome">

    <span class="welcome-label">

        Doctor Dashboard

    </span>


    <h1>

        Welcome, Dr.
        <?php
        echo htmlspecialchars($doctor_name);
        ?>
        👋

    </h1>


    <p>

        Manage your appointments, view patient information
        and provide quality healthcare services from one place.

    </p>

</div>



<!-- ================= STATISTICS ================= -->

<h2 class="section-title">

    Appointment Overview

</h2>


<div class="stats-container">


<!-- TOTAL -->

<a href="appointments.php"
   class="stat-card">

    <div class="stat-icon">

        <i class="fa-solid fa-calendar-check"></i>

    </div>

    <h3>
        Total Appointments
    </h3>

    <div class="stat-number">

        <?php echo $total; ?>

    </div>

</a>



<!-- PENDING -->

<a href="appointments.php?status=Pending"
   class="stat-card">

    <div class="stat-icon">

        <i class="fa-solid fa-clock"></i>

    </div>

    <h3>
        Pending
    </h3>

    <div class="stat-number">

        <?php echo $pending; ?>

    </div>

</a>



<!-- APPROVED -->

<a href="appointments.php?status=Approved"
   class="stat-card">

    <div class="stat-icon">

        <i class="fa-solid fa-user-check"></i>

    </div>

    <h3>
        Approved
    </h3>

    <div class="stat-number">

        <?php echo $approved; ?>

    </div>

</a>



<!-- COMPLETED -->

<a href="appointments.php?status=Completed"
   class="stat-card">

    <div class="stat-icon">

        <i class="fa-solid fa-circle-check"></i>

    </div>

    <h3>
        Completed
    </h3>

    <div class="stat-number">

        <?php echo $completed; ?>

    </div>

</a>



<!-- CANCELLED -->

<a href="appointments.php?status=Cancelled"
   class="stat-card">

    <div class="stat-icon">

        <i class="fa-solid fa-ban"></i>

    </div>

    <h3>
        Cancelled
    </h3>

    <div class="stat-number">

        <?php echo $cancelled; ?>

    </div>

</a>


</div>



<!-- ================= QUICK ACTIONS ================= -->

<h2 class="section-title">

    Quick Actions

</h2>


<div class="action-container">


<!-- MY APPOINTMENTS -->

<div class="action-card">

    <div class="action-icon">

        <i class="fa-solid fa-calendar-days"></i>

    </div>


    <h3>

        My Appointments

    </h3>


    <p>

        View and manage appointments
        booked by your patients.

    </p>


    <a href="appointments.php"
       class="dashboard-btn">

        View Appointments

        <i class="fa-solid fa-arrow-right"></i>

    </a>

</div>



<!-- MY PROFILE -->

<div class="action-card">

    <div class="action-icon">

        <i class="fa-solid fa-user-doctor"></i>

    </div>


    <h3>

        My Profile

    </h3>


    <p>

        View and update your professional
        information.

    </p>


    <a href="profile.php"
       class="dashboard-btn">

        View Profile

        <i class="fa-solid fa-arrow-right"></i>

    </a>

</div>



<!-- LOGOUT -->

<div class="action-card">

    <div class="action-icon">

        <i class="fa-solid fa-right-from-bracket"></i>

    </div>


    <h3>

        Logout

    </h3>


    <p>

        Sign out securely from your
        doctor account.

    </p>


    <a href="../logout.php"
       class="dashboard-btn logout-btn">

        Logout

        <i class="fa-solid fa-arrow-right"></i>

    </a>

</div>


</div>


</div>


</body>

</html>