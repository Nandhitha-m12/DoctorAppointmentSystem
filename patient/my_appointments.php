<?php

session_start();

include("../config.php");


/* ================= LOGIN CHECK ================= */

if (!isset($_SESSION['patient_id'])) {

    header("Location: ../login.php");

    exit();

}


$patient_id = $_SESSION['patient_id'];


/* ================= CANCEL APPOINTMENT ================= */

if (isset($_GET['cancel'])) {

    $appointment_id = intval($_GET['cancel']);

    $cancel = mysqli_query($conn, "
        UPDATE appointments
        SET status='Cancelled'
        WHERE appointment_id='$appointment_id'
        AND patient_id='$patient_id'
        AND status IN ('Pending','Approved')
    ");

    if ($cancel) {

        header("Location: my_appointments.php");

        exit();

    }

}


/* ================= FETCH APPOINTMENTS ================= */

$query = mysqli_query($conn, "

    SELECT appointments.*,
           doctors.name AS doctor_name,
           doctors.specialization

    FROM appointments

    INNER JOIN doctors
        ON appointments.doctor_id = doctors.doctor_id

    WHERE appointments.patient_id='$patient_id'

    ORDER BY appointment_date DESC,
             appointment_time DESC

");

?>

<!DOCTYPE html>

<html lang="en">

<head>


<meta charset="UTF-8">


<meta name="viewport"
      content="width=device-width, initial-scale=1.0">


<title>My Appointments</title>


<!-- Main CSS -->

<link rel="stylesheet" href="../css/style.css">


<!-- Font Awesome -->

<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">


<!-- Poppins Font -->

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

    background: #f7f5fa;

    margin: 0;

    font-family: 'Poppins', sans-serif;

}


/* ================= CONTAINER ================= */

.container {

    width: 92%;

    max-width: 1400px;

    margin: 40px auto 60px;

}


/* ================= TOP SECTION ================= */

.top-section {

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

.back {

    display: inline-flex;

    align-items: center;

    gap: 8px;

    background: #6b4c8b;

    color: white;

    padding: 10px 18px;

    text-decoration: none;

    border-radius: 8px;

    font-size: 14px;

    font-weight: 500;

    transition: .3s;

}


.back:hover {

    background: #563975;

    transform: translateX(-3px);

}


/* ================= TABLE CARD ================= */

.table-card {

    background: white;

    padding: 20px;

    border-radius: 18px;

    box-shadow: 0 8px 25px rgba(0,0,0,.08);

    overflow-x: auto;

}


/* ================= TABLE ================= */

table {

    width: 100%;

    border-collapse: collapse;

    min-width: 950px;

}


th {

    background: #6b4c8b;

    color: white;

    padding: 15px;

    font-size: 14px;

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

    padding: 15px;

    text-align: center;

    border-bottom: 1px solid #eee;

    color: #555;

    font-size: 14px;

}


tr:hover td {

    background: #faf8fc;

}


/* ================= DOCTOR ================= */

.doctor-name {

    color: #2d2340;

    font-weight: 600;

}


.specialization {

    display: block;

    color: #8d63b8;

    font-size: 12px;

    margin-top: 4px;

}


/* ================= STATUS ================= */

.status {

    display: inline-block;

    padding: 6px 14px;

    border-radius: 20px;

    font-size: 12px;

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


/* ================= CANCEL BUTTON ================= */

.cancel-btn {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    gap: 6px;

    padding: 7px 14px;

    background: #dc3545;

    color: white;

    text-decoration: none;

    border-radius: 20px;

    font-size: 12px;

    font-weight: 600;

    transition: .3s;

}


.cancel-btn:hover {

    background: #b02a37;

    transform: translateY(-2px);

}


.no-action {

    color: #aaa;

    font-weight: 600;

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


.no-appointments p {

    font-size: 14px;

}


/* ================= RESPONSIVE ================= */

@media(max-width: 700px) {


    .container {

        width: 95%;

        margin-top: 25px;

    }


    .top-section {

        flex-direction: column;

        align-items: flex-start;

        gap: 15px;

    }


    .page-title {

        font-size: 25px;

    }


    .back {

        font-size: 13px;

    }

}


</style>


</head>


<body>


<div class="container">


<!-- ================= TOP SECTION ================= -->

<div class="top-section">


    <h2 class="page-title">

        <i class="fa-solid fa-calendar-check"></i>

        My Appointments

    </h2>


    <a href="dashboard.php" class="back">

        <i class="fa-solid fa-arrow-left"></i>

        Back to Dashboard

    </a>


</div>



<!-- ================= TABLE ================= -->

<div class="table-card">


<?php

if (mysqli_num_rows($query) > 0) {

?>


<table>


<tr>


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


    <th>
        Action
    </th>


</tr>



<?php


while ($row = mysqli_fetch_assoc($query)) {


    $status = strtolower($row['status']);


?>


<tr>


<!-- ================= DOCTOR ================= -->

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



<!-- ================= DATE ================= -->

<td>

    <?php

    echo htmlspecialchars($row['appointment_date']);

    ?>

</td>



<!-- ================= TIME ================= -->

<td>

    <?php

    echo htmlspecialchars($row['appointment_time']);

    ?>

</td>



<!-- ================= SYMPTOMS ================= -->

<td>

    <?php

    echo htmlspecialchars($row['symptoms']);

    ?>

</td>



<!-- ================= STATUS ================= -->

<td>


    <span class="status <?php echo $status; ?>">

        <?php

        echo htmlspecialchars($row['status']);

        ?>

    </span>


</td>



<!-- ================= ACTION ================= -->

<td>


<?php

if (
    $row['status'] == 'Pending' ||
    $row['status'] == 'Approved'
) {

?>


    <a
        href="my_appointments.php?cancel=<?php echo $row['appointment_id']; ?>"
        class="cancel-btn"
        onclick="return confirm('Are you sure you want to cancel this appointment?');"
    >

        <i class="fa-solid fa-xmark"></i>

        Cancel

    </a>


<?php

} else {

?>


    <span class="no-action">

        -

    </span>


<?php

}

?>


</td>


</tr>


<?php

}

?>


</table>


<?php

} else {

?>


<!-- ================= NO APPOINTMENTS ================= -->

<div class="no-appointments">


    <i class="fa-solid fa-calendar-xmark"></i>


    <h3>

        No Appointments Found

    </h3>


    <p>

        You have not booked any appointments yet.

    </p>


</div>


<?php

}

?>


</div>


</div>


</body>

</html>