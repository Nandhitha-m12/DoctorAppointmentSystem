<?php
session_start();
include("../config.php");

if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}


/* ================= CHECK PATIENT ID ================= */

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: view_patients.php");
    exit();
}

$patient_id = mysqli_real_escape_string($conn, $_GET['id']);


/* ================= PATIENT DETAILS ================= */

$patientQuery = mysqli_query($conn, "
    SELECT *
    FROM patients
    WHERE patient_id='$patient_id'
");

if (mysqli_num_rows($patientQuery) == 0) {
    header("Location: view_patients.php");
    exit();
}

$patientData = mysqli_fetch_assoc($patientQuery);


/* ================= APPOINTMENT DETAILS ================= */

$result = mysqli_query($conn, "
    SELECT
        appointments.*,
        doctors.name AS doctor_name,
        doctors.specialization AS specialization
    FROM appointments

    INNER JOIN doctors
    ON appointments.doctor_id = doctors.doctor_id

    WHERE appointments.patient_id='$patient_id'

    ORDER BY appointment_date DESC, appointment_time DESC
");

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Patient Appointment History</title>

    <link rel="stylesheet" href="../css/style.css">


    <!-- Google Font -->

    <link rel="preconnect"
          href="https://fonts.googleapis.com">

    <link rel="preconnect"
          href="https://fonts.gstatic.com"
          crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
          rel="stylesheet">


    <!-- Font Awesome -->

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">


    <style>

        * {
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }


        body {
            margin: 0;
            background: #f7f5fa;
        }


        /* ================= CONTAINER ================= */

        .container {

            width: 95%;

            max-width: 1500px;

            margin: 40px auto 60px;
        }


        /* ================= HEADER ================= */

        .page-header {

            background: #ffffff;

            padding: 25px 30px;

            border-radius: 18px;

            box-shadow: 0 8px 25px rgba(0,0,0,.08);

            margin-bottom: 25px;
        }


        .page-header h2 {

            margin: 0;

            color: #2d2340;

            font-size: 28px;

            font-weight: 600;
        }


        .page-header h2 i {

            color: #6b4c8b;

            margin-right: 8px;
        }


        .page-header p {

            margin-top: 8px;

            color: #777;

            font-size: 14px;
        }


        /* ================= PATIENT INFORMATION ================= */

        .patient-card {

            background: #ffffff;

            padding: 25px 30px;

            border-radius: 18px;

            box-shadow: 0 8px 25px rgba(0,0,0,.08);

            margin-bottom: 25px;
        }


        .patient-title {

            display: flex;

            align-items: center;

            gap: 12px;

            margin-bottom: 20px;
        }


        .patient-title i {

            width: 45px;

            height: 45px;

            border-radius: 50%;

            background: #f0e9f7;

            color: #6b4c8b;

            display: flex;

            align-items: center;

            justify-content: center;

            font-size: 20px;
        }


        .patient-title h3 {

            margin: 0;

            color: #2d2340;

            font-size: 20px;
        }


        .patient-details {

            display: grid;

            grid-template-columns: repeat(2, 1fr);

            gap: 15px 30px;
        }


        .detail {

            padding: 12px 15px;

            background: #faf8fc;

            border-radius: 10px;
        }


        .detail strong {

            display: block;

            color: #6b4c8b;

            font-size: 12px;

            margin-bottom: 4px;
        }


        .detail span {

            color: #444;

            font-size: 14px;

            font-weight: 500;
        }


        /* ================= APPOINTMENT SECTION ================= */

        .section-title {

            color: #2d2340;

            font-size: 22px;

            margin: 30px 0 15px;
        }


        .section-title i {

            color: #6b4c8b;

            margin-right: 8px;
        }


        /* ================= TABLE CARD ================= */

        .table-card {

            background: #ffffff;

            padding: 20px;

            border-radius: 18px;

            box-shadow: 0 8px 25px rgba(0,0,0,.08);

            overflow-x: auto;
        }


        /* ================= TABLE ================= */

        table {

            width: 100%;

            border-collapse: collapse;

            min-width: 900px;
        }


        th {

            background: #6b4c8b;

            color: white;

            padding: 14px 12px;

            font-size: 13px;

            font-weight: 600;

            text-align: center;
        }


        th:first-child {

            border-radius: 10px 0 0 0;
        }


        th:last-child {

            border-radius: 0 10px 0 0;
        }


        td {

            padding: 14px 12px;

            text-align: center;

            border-bottom: 1px solid #eee;

            color: #555;

            font-size: 13px;
        }


        tr:hover td {

            background: #faf8fc;
        }


        /* ================= DOCTOR ================= */

        .doctor-name {

            color: #2d2340;

            font-weight: 600;

            display: block;
        }


        .specialization {

            display: block;

            color: #8d63b8;

            font-size: 11px;

            margin-top: 4px;
        }


        /* ================= STATUS ================= */

        .status {

            display: inline-block;

            padding: 6px 13px;

            border-radius: 20px;

            font-size: 11px;

            font-weight: 600;
        }


        .status.pending {

            background: #fff3cd;

            color: #856404;
        }


        .status.approved {

            background: #d4edda;

            color: #218838;
        }


        .status.completed {

            background: #dbeafe;

            color: #2563eb;
        }


        .status.cancelled {

            background: #f8d7da;

            color: #b02a37;
        }


        /* ================= NO APPOINTMENTS ================= */

        .no-appointments {

            text-align: center;

            padding: 50px 20px;

            color: #777;
        }


        .no-appointments i {

            font-size: 45px;

            color: #8d63b8;

            margin-bottom: 15px;
        }


        .no-appointments h3 {

            color: #2d2340;

            margin-bottom: 8px;
        }


        /* ================= BACK BUTTON ================= */

        .back-section {

            text-align: center;

            margin-top: 30px;
        }


        .back {

            display: inline-flex;

            align-items: center;

            gap: 8px;

            background: #6b4c8b;

            color: white;

            padding: 11px 22px;

            border-radius: 8px;

            text-decoration: none;

            font-size: 14px;

            font-weight: 500;

            transition: .3s;
        }


        .back:hover {

            background: #563975;

            transform: translateY(-2px);
        }


        /* ================= RESPONSIVE ================= */

        @media(max-width:700px) {

            .container {

                width: 95%;

                margin-top: 25px;
            }


            .page-header h2 {

                font-size: 23px;
            }


            .patient-details {

                grid-template-columns: 1fr;
            }

        }

    </style>

</head>


<body>


<div class="container">


    <!-- ================= PAGE HEADER ================= -->

    <div class="page-header">

        <h2>

            <i class="fa-solid fa-calendar-check"></i>

            Patient Appointment History

        </h2>

        <p>
            View all appointments booked by this patient.
        </p>

    </div>


    <!-- ================= PATIENT INFORMATION ================= -->

    <div class="patient-card">

        <div class="patient-title">

            <i class="fa-solid fa-user"></i>

            <h3>
                Patient Information
            </h3>

        </div>


        <div class="patient-details">


            <!-- NAME -->

            <div class="detail">

                <strong>
                    Full Name
                </strong>

                <span>

                    <?php
                    echo htmlspecialchars($patientData['name']);
                    ?>

                </span>

            </div>


            <!-- EMAIL -->

            <div class="detail">

                <strong>
                    Email Address
                </strong>

                <span>

                    <?php
                    echo htmlspecialchars($patientData['email']);
                    ?>

                </span>

            </div>


            <!-- PHONE -->

            <div class="detail">

                <strong>
                    Phone Number
                </strong>

                <span>

                    <?php
                    echo htmlspecialchars($patientData['phone']);
                    ?>

                </span>

            </div>


            <!-- DOB -->

            <div class="detail">

                <strong>
                    Date of Birth
                </strong>

                <span>

                    <?php
                    echo htmlspecialchars($patientData['dob']);
                    ?>

                </span>

            </div>


            <!-- GENDER -->

            <div class="detail">

                <strong>
                    Gender
                </strong>

                <span>

                    <?php
                    echo htmlspecialchars($patientData['gender']);
                    ?>

                </span>

            </div>


        </div>

    </div>


    <!-- ================= APPOINTMENTS ================= -->

    <h3 class="section-title">

        <i class="fa-solid fa-calendar-days"></i>

        Appointment History

    </h3>


    <div class="table-card">


        <?php if (mysqli_num_rows($result) > 0) { ?>


        <table>


            <tr>

                <th>
                    Appointment ID
                </th>

                <th>
                    Doctor
                </th>

                <th>
                    Date
                </th>

                <th>
                    Time
                </th>

                <th>
                    Symptoms
                </th>

                <th>
                    Status
                </th>

            </tr>


            <?php while ($row = mysqli_fetch_assoc($result)) { ?>


            <?php

            $status = strtolower($row['status']);

            ?>


            <tr>


                <!-- APPOINTMENT ID -->

                <td>

                    <?php
                    echo htmlspecialchars($row['appointment_id']);
                    ?>

                </td>


                <!-- DOCTOR -->

                <td>

                    <span class="doctor-name">

                        Dr.
                        <?php
                        echo htmlspecialchars($row['doctor_name']);
                        ?>

                    </span>


                    <span class="specialization">

                        <?php
                        echo htmlspecialchars($row['specialization']);
                        ?>

                    </span>

                </td>


                <!-- DATE -->

                <td>

                    <?php
                    echo htmlspecialchars($row['appointment_date']);
                    ?>

                </td>


                <!-- TIME -->

                <td>

                    <?php
                    echo htmlspecialchars($row['appointment_time']);
                    ?>

                </td>


                <!-- SYMPTOMS -->

                <td>

                    <?php
                    echo htmlspecialchars($row['symptoms']);
                    ?>

                </td>


                <!-- STATUS -->

                <td>

                    <span class="status <?php echo htmlspecialchars($status); ?>">

                        <?php
                        echo htmlspecialchars($row['status']);
                        ?>

                    </span>

                </td>


            </tr>


            <?php } ?>


        </table>


        <?php } else { ?>


        <div class="no-appointments">

            <i class="fa-solid fa-calendar-xmark"></i>

            <h3>
                No Appointments Found
            </h3>

            <p>
                This patient has not booked any appointments yet.
            </p>

        </div>


        <?php } ?>


    </div>


    <!-- ================= BACK ================= -->

    <div class="back-section">

        <a
            href="view_patients.php"
            class="back">

            <i class="fa-solid fa-arrow-left"></i>

            Back to Patients

        </a>

    </div>


</div>


</body>

</html>