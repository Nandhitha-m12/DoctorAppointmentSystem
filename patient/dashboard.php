<?php
session_start();

if(!isset($_SESSION['patient_id'])){
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Patient Dashboard</title>

    <!-- Patient Dashboard CSS -->
    <link rel="stylesheet" href="dashboard.css">

    <!-- Font Awesome -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<link rel="preconnect" href="https://fonts.googleapis.com">

<link rel="preconnect"
      href="https://fonts.gstatic.com"
      crossorigin>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
      rel="stylesheet">
</head>

<body>
    <!-- ================= WELCOME SECTION ================= -->

<section class="dashboard-welcome">

    <div class="welcome-text">

        <span class="welcome-label">
            Patient Dashboard
        </span>

        <h1>
            Welcome, <?php echo htmlspecialchars($_SESSION['patient_name']); ?> 👋
        </h1>

        <p>
            Manage your appointments, profile and healthcare
            services easily from one place.
        </p>

    </div>

</section>


<!-- ================= QUICK ACTIONS ================= -->

<section class="dashboard-section">

    <h2 class="section-title">
        Quick Actions
    </h2>

    <div class="card-container">

        <!-- BOOK APPOINTMENT -->

        <div class="dashboard-card">

            <div class="card-icon">
                <i class="fa-solid fa-calendar-check"></i>
            </div>

            <h3>
                Book Appointment
            </h3>

            <p>
                Schedule an appointment with our specialists.
            </p>

            <a href="book_appointment.php" class="dashboard-btn">

                Book Now

                <i class="fa-solid fa-arrow-right"></i>

            </a>

        </div>


        <!-- MY APPOINTMENTS -->

        <div class="dashboard-card">

            <div class="card-icon">
                <i class="fa-solid fa-file-medical"></i>
            </div>

            <h3>
                My Appointments
            </h3>

            <p>
                View and manage your booked appointments.
            </p>

            <a href="my_appointments.php" class="dashboard-btn">

                View

                <i class="fa-solid fa-arrow-right"></i>

            </a>

        </div>


        <!-- MY PROFILE -->

        <div class="dashboard-card">

            <div class="card-icon">
                <i class="fa-solid fa-user"></i>
            </div>

            <h3>
                My Profile
            </h3>

            <p>
                View and update your personal information.
            </p>

            <a href="profile.php" class="dashboard-btn">

                Profile

                <i class="fa-solid fa-arrow-right"></i>

            </a>

        </div>


        <!-- LOGOUT -->

        <div class="dashboard-card">

            <div class="card-icon">
                <i class="fa-solid fa-right-from-bracket"></i>
            </div>

            <h3>
                Logout
            </h3>

            <p>
                Sign out securely from your account.
            </p>

            <a href="../logout.php"
               class="dashboard-btn logout-btn">

                Logout

                <i class="fa-solid fa-arrow-right"></i>

            </a>

        </div>

    </div>

</section>


<!-- ================= PATIENT INFORMATION ================= -->

<section class="dashboard-section">

    <h2 class="section-title">
        Patient Information
    </h2>

    <div class="patient-info-card">

        <div class="patient-info-icon">

            <i class="fa-solid fa-user"></i>

        </div>

        <div class="patient-info-content">

            <h3>
                <?php
                echo htmlspecialchars($_SESSION['patient_name']);
                ?>
            </h3>

            <p>
                Welcome to
                <strong>Zynovexa Multispeciality Hospital</strong>.
            </p>

            <p>
                From your dashboard, you can book appointments,
                view your appointment history and manage your
                personal information.
            </p>

        </div>

    </div>

</section>
</body>
</html>