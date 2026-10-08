<?php

session_start();

include("../config.php");


/* ================= LOGIN CHECK ================= */

if (!isset($_SESSION['doctor_id'])) {

    header("Location: ../login.php");

    exit();

}


$doctor_id = $_SESSION['doctor_id'];


/* ================= UPDATE STATUS ================= */

if (isset($_POST['update_status'])) {

    $appointment_id = mysqli_real_escape_string(
        $conn,
        $_POST['appointment_id']
    );

    $new_status = mysqli_real_escape_string(
        $conn,
        $_POST['status']
    );


    $update = mysqli_query($conn, "
        UPDATE appointments

        SET status='$new_status'

        WHERE appointment_id='$appointment_id'

        AND doctor_id='$doctor_id'
    ");


    if ($update) {

        header("Location: appointments.php");

        exit();

    } else {

        $error = "Unable to update appointment status.";

    }

}


/* ================= STATUS FILTER ================= */

$status = "";


if (isset($_GET['status']) && $_GET['status'] != "") {

    $status = mysqli_real_escape_string(
        $conn,
        $_GET['status']
    );

}


/* ================= FETCH APPOINTMENTS ================= */

if ($status == "") {

    $query = mysqli_query($conn, "

        SELECT
            appointments.*,
            patients.name AS patient_name,
            patients.phone AS patient_phone,
            patients.gender AS patient_gender,
            patients.dob AS patient_dob

        FROM appointments

        INNER JOIN patients
        ON appointments.patient_id = patients.patient_id

        WHERE appointments.doctor_id='$doctor_id'

        ORDER BY appointment_date ASC,
                 appointment_time ASC

    ");

} else {

    $query = mysqli_query($conn, "

        SELECT
            appointments.*,
            patients.name AS patient_name,
            patients.phone AS patient_phone,
            patients.gender AS patient_gender,
            patients.dob AS patient_dob

        FROM appointments

        INNER JOIN patients
        ON appointments.patient_id = patients.patient_id

        WHERE appointments.doctor_id='$doctor_id'

        AND appointments.status='$status'

        ORDER BY appointment_date ASC,
                 appointment_time ASC

    ");

}

?>


<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>My Appointments</title>


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

}


/* ================= CONTAINER ================= */

.container {

    width: 92%;

    max-width: 1450px;

    margin: 40px auto 60px;

}


/* ================= HEADER ================= */

.header {

    display: flex;

    align-items: center;

    justify-content: space-between;

    margin-bottom: 25px;

}


.page-title {

    color: #2d2340;

    margin: 0;

    font-size: 30px;

    font-weight: 600;

}


.page-title i {

    color: #6b4c8b;

    margin-right: 8px;

}


/* ================= BACK BUTTON ================= */

.back-btn {

    display: inline-flex;

    align-items: center;

    gap: 8px;

    background: #6b4c8b;

    color: white;

    padding: 10px 18px;

    border-radius: 8px;

    text-decoration: none;

    font-size: 14px;

    font-weight: 500;

    transition: .3s;

}


.back-btn:hover {

    background: #563975;

    transform: translateX(-3px);

}


/* ================= FILTER INFO ================= */

.filter-box {

    background: white;

    padding: 18px 22px;

    border-radius: 12px;

    margin-bottom: 20px;

    box-shadow:
        0 5px 18px
        rgba(0,0,0,.06);

    color: #666;

}


.filter-box strong {

    color: #6b4c8b;

}


/* ================= TABLE CARD ================= */

.table-card {

    background: white;

    padding: 20px;

    border-radius: 18px;

    box-shadow:
        0 8px 25px
        rgba(0,0,0,.08);

    overflow-x: auto;

}


/* ================= TABLE ================= */

table {

    width: 100%;

    border-collapse: collapse;

    min-width: 1100px;

}


th {

    background: #6b4c8b;

    color: white;

    padding: 15px 12px;

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

    padding: 15px 12px;

    text-align: center;

    border-bottom: 1px solid #eee;

    color: #555;

    font-size: 13px;

}


tr:hover td {

    background: #faf8fc;

}


/* ================= PATIENT ================= */

.patient-name {

    color: #2d2340;

    font-weight: 600;

}


.patient-phone {

    display: block;

    color: #8d63b8;

    font-size: 12px;

    margin-top: 4px;

}


/* ================= DATE & TIME ================= */

.appointment-date {

    color: #2d2340;

    font-weight: 500;

}


.appointment-time {

    color: #777;

    font-size: 12px;

}


/* ================= SYMPTOMS ================= */

.symptoms {

    max-width: 220px;

    line-height: 1.5;

}


/* ================= STATUS ================= */

.status {

    display: inline-block;

    padding: 6px 14px;

    border-radius: 20px;

    font-size: 11px;

    font-weight: 600;

}


/* Pending */

.status.pending {

    background: #fff3cd;

    color: #856404;

}


/* Approved */

.status.approved {

    background: #d4edda;

    color: #218838;

}


/* Completed */

.status.completed {

    background: #dbeafe;

    color: #2563eb;

}


/* Cancelled */

.status.cancelled {

    background: #f8d7da;

    color: #b02a37;

}


/* ================= ACTION FORM ================= */

.status-form {

    display: flex;

    align-items: center;

    justify-content: center;

    gap: 6px;

}


.status-form select {

    padding: 7px 8px;

    border: 1px solid #ddd;

    border-radius: 7px;

    background: white;

    font-size: 12px;

}


.update-btn {

    border: none;

    background: #6b4c8b;

    color: white;

    padding: 7px 12px;

    border-radius: 7px;

    cursor: pointer;

    font-size: 12px;

    transition: .3s;

}


.update-btn:hover {

    background: #563975;

}


/* ================= ERROR ================= */

.error-message {

    background: #f8d7da;

    color: #b02a37;

    padding: 12px 15px;

    border-radius: 8px;

    margin-bottom: 20px;

    text-align: center;

}


/* ================= NO DATA ================= */

.no-data {

    background: white;

    padding: 60px 20px;

    border-radius: 18px;

    text-align: center;

    box-shadow:
        0 8px 25px
        rgba(0,0,0,.08);

}


.no-data i {

    font-size: 50px;

    color: #8d63b8;

    margin-bottom: 15px;

}


.no-data h3 {

    color: #2d2340;

    margin-bottom: 8px;

}


.no-data p {

    color: #777;

    font-size: 14px;

}


/* ================= RESPONSIVE ================= */

@media(max-width:700px) {

    .container {

        width: 95%;

        margin-top: 25px;

    }


    .header {

        flex-direction: column;

        align-items: flex-start;

        gap: 15px;

    }


    .page-title {

        font-size: 25px;

    }


    .back-btn {

        font-size: 13px;

    }

}

</style>

</head>


<body>


<div class="container">


<!-- ================= HEADER ================= -->

<div class="header">


<h2 class="page-title">

    <i class="fa-solid fa-calendar-check"></i>

    <?php

    if ($status == "") {

        echo "All Appointments";

    } else {

        echo htmlspecialchars($status) . " Appointments";

    }

    ?>

</h2>


<a href="dashboard.php"
   class="back-btn">

    <i class="fa-solid fa-arrow-left"></i>

    Back to Dashboard

</a>


</div>



<!-- ================= FILTER MESSAGE ================= -->

<div class="filter-box">

    <i class="fa-solid fa-filter"></i>

    Showing:

    <strong>

        <?php

        if ($status == "") {

            echo "All Appointments";

        } else {

            echo htmlspecialchars($status);

        }

        ?>

    </strong>

</div>



<?php

if (isset($error)) {

?>

<div class="error-message">

    <?php echo $error; ?>

</div>

<?php

}

?>



<!-- ================= APPOINTMENTS ================= -->

<?php

if (mysqli_num_rows($query) > 0) {

?>


<div class="table-card">


<table>


<tr>

    <th>Appointment ID</th>

    <th>Patient</th>

    <th>Date</th>

    <th>Time</th>

    <th>Symptoms</th>

    <th>Status</th>

    <th>Update Status</th>

</tr>



<?php

while ($row = mysqli_fetch_assoc($query)) {

    $status_class =
        strtolower($row['status']);

?>


<tr>


<!-- APPOINTMENT ID -->

<td>

    <strong>

        #<?php
        echo htmlspecialchars(
            $row['appointment_id']
        );
        ?>

    </strong>

</td>



<!-- PATIENT -->

<td>

    <span class="patient-name">

        <?php

        echo htmlspecialchars(
            $row['patient_name']
        );

        ?>

    </span>


    <span class="patient-phone">

        <i class="fa-solid fa-phone"></i>

        <?php

        echo htmlspecialchars(
            $row['patient_phone']
        );

        ?>

    </span>

</td>



<!-- DATE -->

<td>

    <span class="appointment-date">

        <?php

        echo htmlspecialchars(
            $row['appointment_date']
        );

        ?>

    </span>

</td>



<!-- TIME -->

<td>

    <span class="appointment-time">

        <i class="fa-regular fa-clock"></i>

        <?php

        echo htmlspecialchars(
            $row['appointment_time']
        );

        ?>

    </span>

</td>



<!-- SYMPTOMS -->

<td>

    <div class="symptoms">

        <?php

        echo htmlspecialchars(
            $row['symptoms']
        );

        ?>

    </div>

</td>



<!-- STATUS -->

<td>

    <span class="status <?php echo $status_class; ?>">

        <?php

        echo htmlspecialchars(
            $row['status']
        );

        ?>

    </span>

</td>



<!-- UPDATE STATUS -->

<td>

<form method="POST"
      class="status-form">


<input
    type="hidden"
    name="appointment_id"
    value="<?php
        echo $row['appointment_id'];
    ?>">


<select name="status">

    <option value="Pending"
        <?php

        if ($row['status'] == "Pending")
            echo "selected";

        ?>>

        Pending

    </option>


    <option value="Approved"
        <?php

        if ($row['status'] == "Approved")
            echo "selected";

        ?>>

        Approved

    </option>


    <option value="Completed"
        <?php

        if ($row['status'] == "Completed")
            echo "selected";

        ?>>

        Completed

    </option>


    <option value="Cancelled"
        <?php

        if ($row['status'] == "Cancelled")
            echo "selected";

        ?>>

        Cancelled

    </option>

</select>


<button
    type="submit"
    name="update_status"
    class="update-btn">

    <i class="fa-solid fa-pen"></i>

    Update

</button>


</form>

</td>


</tr>


<?php

}

?>


</table>


</div>


<?php

} else {

?>


<!-- ================= NO APPOINTMENTS ================= -->

<div class="no-data">

    <i class="fa-solid fa-calendar-xmark"></i>

    <h3>

        No Appointments Found

    </h3>

    <p>

        There are no appointments
        in this category.

    </p>

</div>


<?php

}

?>


</div>


</body>

</html>