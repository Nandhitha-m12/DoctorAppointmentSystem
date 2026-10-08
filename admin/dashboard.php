<?php

session_start();

include("../config.php");


/* ================= ADMIN LOGIN CHECK ================= */

if (!isset($_SESSION['admin'])) {

    header("Location: ../login.php");

    exit();

}


/* ================= DASHBOARD COUNTS ================= */

/* Doctors */

$totalDoctors = mysqli_num_rows(
    mysqli_query(
        $conn,
        "SELECT * FROM doctors"
    )
);


/* Patients */

$totalPatients = mysqli_num_rows(
    mysqli_query(
        $conn,
        "SELECT * FROM patients"
    )
);


/* Total Appointments */

$totalAppointments = mysqli_num_rows(
    mysqli_query(
        $conn,
        "SELECT * FROM appointments"
    )
);


/* Pending */

$pendingAppointments = mysqli_num_rows(
    mysqli_query(
        $conn,
        "SELECT * FROM appointments
         WHERE status='Pending'"
    )
);


/* Approved */

$approvedAppointments = mysqli_num_rows(
    mysqli_query(
        $conn,
        "SELECT * FROM appointments
         WHERE status='Approved'"
    )
);


/* Completed */

$completedAppointments = mysqli_num_rows(
    mysqli_query(
        $conn,
        "SELECT * FROM appointments
         WHERE status='Completed'"
    )
);


/* Cancelled */

$cancelledAppointments = mysqli_num_rows(
    mysqli_query(
        $conn,
        "SELECT * FROM appointments
         WHERE status='Cancelled'"
    )
);

?>


<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">


<title>Admin Dashboard</title>


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

    margin: 0;

    padding: 0;

    box-sizing: border-box;

    font-family: 'Poppins', sans-serif;

}


body {

    background: #f7f5fa;

}


/* ================= SIDEBAR ================= */

.sidebar {

    width: 250px;

    height: 100vh;

    background: #6b4c8b;

    position: fixed;

    left: 0;

    top: 0;

}


.sidebar h2 {

    text-align: center;

    color: white;

    padding: 25px 10px;

    font-size: 25px;

    border-bottom:
        1px solid
        rgba(255,255,255,.2);

}


.sidebar ul {

    list-style: none;

}


.sidebar ul li {

    border-bottom:
        1px solid
        rgba(255,255,255,.12);

}


.sidebar ul li a {

    display: flex;

    align-items: center;

    gap: 12px;

    padding: 15px 20px;

    text-decoration: none;

    color: white;

    font-size: 14px;

    transition: .3s;

}


.sidebar ul li a:hover {

    background: #563975;

    padding-left: 28px;

}


.sidebar ul li a i {

    width: 20px;

    text-align: center;

}


/* ================= MAIN ================= */

.main {

    margin-left: 250px;

    width: calc(100% - 250px);

    padding: 35px;

}


/* ================= HEADER ================= */

.header {

    background: white;

    padding: 25px 30px;

    border-radius: 18px;

    box-shadow:
        0 8px 25px
        rgba(0,0,0,.08);

    margin-bottom: 30px;

}


.header h1 {

    color: #2d2340;

    margin-bottom: 8px;

    font-size: 28px;

}


.header h1 i {

    color: #6b4c8b;

    margin-right: 8px;

}


.header p {

    color: #777;

    font-size: 14px;

}


/* ================= SECTION TITLE ================= */

.section-title {

    color: #2d2340;

    font-size: 22px;

    margin-bottom: 20px;

}


/* ================= CARDS ================= */

.cards {

    display: grid;

    grid-template-columns:
        repeat(4, 1fr);

    gap: 20px;

    margin-bottom: 35px;

}


.card {

    background: white;

    padding: 25px 20px;

    border-radius: 16px;

    box-shadow:
        0 8px 25px
        rgba(0,0,0,.08);

    text-align: center;

    text-decoration: none;

    color: #333;

    transition: .3s;

}


.card:hover {

    transform:
        translateY(-6px);

    box-shadow:
        0 15px 30px
        rgba(107,76,139,.16);

}


.card i {

    font-size: 38px;

    color: #6b4c8b;

    margin-bottom: 15px;

}


.card h3 {

    margin-bottom: 8px;

    color: #2d2340;

    font-size: 16px;

}


.card p {

    font-size: 28px;

    font-weight: 700;

    color: #6b4c8b;

}


/* ================= STATUS CARDS ================= */

.status-card {

    border-top:
        4px solid #6b4c8b;

}


.status-card.pending {

    border-top-color: #d6a400;

}


.status-card.approved {

    border-top-color: #28a745;

}


.status-card.completed {

    border-top-color: #2878d8;

}


.status-card.cancelled {

    border-top-color: #dc3545;

}


.status-card.pending i {

    color: #d6a400;

}


.status-card.approved i {

    color: #28a745;

}


.status-card.completed i {

    color: #2878d8;

}


.status-card.cancelled i {

    color: #dc3545;

}


/* ================= MANAGEMENT ================= */

.management {

    display: grid;

    grid-template-columns:
        repeat(3, 1fr);

    gap: 20px;

}


.management-card {

    background: white;

    padding: 22px;

    border-radius: 15px;

    box-shadow:
        0 8px 25px
        rgba(0,0,0,.08);

    text-decoration: none;

    color: #333;

    transition: .3s;

}


.management-card:hover {

    transform:
        translateY(-5px);

}


.management-card i {

    color: #6b4c8b;

    font-size: 28px;

    margin-bottom: 12px;

}


.management-card h3 {

    color: #2d2340;

    margin-bottom: 5px;

}


.management-card p {

    color: #777;

    font-size: 13px;

}


/* ================= RESPONSIVE ================= */

@media(max-width:1100px) {

    .cards {

        grid-template-columns:
            repeat(2, 1fr);

    }


    .management {

        grid-template-columns:
            repeat(2, 1fr);

    }

}


@media(max-width:700px) {

    .sidebar {

        width: 200px;

    }


    .main {

        margin-left: 200px;

        width:
            calc(100% - 200px);

        padding: 20px;

    }


    .cards {

        grid-template-columns: 1fr;

    }


    .management {

        grid-template-columns: 1fr;

    }

}

</style>

</head>


<body>


<!-- ================= SIDEBAR ================= -->

<div class="sidebar">


<h2>

    Zynovexa

</h2>


<ul>


<li>

<a href="dashboard.php">

<i class="fa-solid fa-house"></i>

Dashboard

</a>

</li>


<li>

<a href="add_doctor.php">

<i class="fa-solid fa-user-doctor"></i>

Add Doctor

</a>

</li>


<li>

<a href="view_doctors.php">

<i class="fa-solid fa-user-group"></i>

Manage Doctors

</a>

</li>


<li>

<a href="view_patients.php">

<i class="fa-solid fa-users"></i>

Manage Patients

</a>

</li>


<li>

<a href="appointments.php">

<i class="fa-solid fa-calendar-check"></i>

Appointments

</a>

</li>


<li>

<a href="reports.php">

<i class="fa-solid fa-chart-column"></i>

Reports

</a>

</li>


<li>

<a href="../logout.php">

<i class="fa-solid fa-right-from-bracket"></i>

Logout

</a>

</li>


</ul>

</div>



<!-- ================= MAIN ================= -->

<div class="main">


<!-- HEADER -->

<div class="header">

<h1>

<i class="fa-solid fa-gauge-high"></i>

Welcome Admin

</h1>


<p>

Zynovexa Multispeciality Hospital

</p>

</div>



<!-- ================= MAIN COUNTS ================= -->

<h2 class="section-title">

Overview

</h2>


<div class="cards">


<!-- DOCTORS -->

<a href="view_doctors.php"
   class="card">

<i class="fa-solid fa-user-doctor"></i>

<h3>

Total Doctors

</h3>

<p>

<?php

echo $totalDoctors;

?>

</p>

</a>



<!-- PATIENTS -->

<a href="view_patients.php"
   class="card">

<i class="fa-solid fa-users"></i>

<h3>

Total Patients

</h3>

<p>

<?php

echo $totalPatients;

?>

</p>

</a>



<!-- TOTAL APPOINTMENTS -->

<a href="appointments.php"
   class="card">

<i class="fa-solid fa-calendar-check"></i>

<h3>

Total Appointments

</h3>

<p>

<?php

echo $totalAppointments;

?>

</p>

</a>



<!-- REPORTS -->

<a href="reports.php"
   class="card">

<i class="fa-solid fa-chart-column"></i>

<h3>

Reports

</h3>

<p>

<?php

echo $totalAppointments;

?>

</p>

</a>


</div>



<!-- ================= APPOINTMENT STATUS ================= -->

<h2 class="section-title">

Appointment Status

</h2>


<div class="cards">


<!-- PENDING -->

<a href="appointments.php?status=Pending"
   class="card status-card pending">

<i class="fa-solid fa-clock"></i>

<h3>

Pending

</h3>

<p>

<?php

echo $pendingAppointments;

?>

</p>

</a>



<!-- APPROVED -->

<a href="appointments.php?status=Approved"
   class="card status-card approved">

<i class="fa-solid fa-circle-check"></i>

<h3>

Approved

</h3>

<p>

<?php

echo $approvedAppointments;

?>

</p>

</a>



<!-- COMPLETED -->

<a href="appointments.php?status=Completed"
   class="card status-card completed">

<i class="fa-solid fa-calendar-check"></i>

<h3>

Completed

</h3>

<p>

<?php

echo $completedAppointments;

?>

</p>

</a>



<!-- CANCELLED -->

<a href="appointments.php?status=Cancelled"
   class="card status-card cancelled">

<i class="fa-solid fa-ban"></i>

<h3>

Cancelled

</h3>

<p>

<?php

echo $cancelledAppointments;

?>

</p>

</a>


</div>



<!-- ================= MANAGEMENT ================= -->

<h2 class="section-title">

Quick Management

</h2>


<div class="management">


<a href="add_doctor.php"
   class="management-card">

<i class="fa-solid fa-user-plus"></i>

<h3>

Add Doctor

</h3>

<p>

Register a new doctor in the system.

</p>

</a>



<a href="view_doctors.php"
   class="management-card">

<i class="fa-solid fa-user-doctor"></i>

<h3>

Manage Doctors

</h3>

<p>

View and manage registered doctors.

</p>

</a>



<a href="view_patients.php"
   class="management-card">

<i class="fa-solid fa-users"></i>

<h3>

Manage Patients

</h3>

<p>

View and manage registered patients.

</p>

</a>



<a href="appointments.php"
   class="management-card">

<i class="fa-solid fa-calendar-days"></i>

<h3>

Manage Appointments

</h3>

<p>

View and manage all appointments.

</p>

</a>



<a href="reports.php"
   class="management-card">

<i class="fa-solid fa-chart-column"></i>

<h3>

Reports

</h3>

<p>

View appointment reports and statistics.

</p>

</a>



<a href="../logout.php"
   class="management-card">

<i class="fa-solid fa-right-from-bracket"></i>

<h3>

Logout

</h3>

<p>

Sign out securely from the admin account.

</p>

</a>


</div>


</div>


</body>

</html>