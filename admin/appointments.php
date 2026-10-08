<?php

session_start();

include("../config.php");


/* ================= ADMIN LOGIN CHECK ================= */

if (!isset($_SESSION['admin'])) {

    header("Location: ../login.php");

    exit();

}


/* ================= UPDATE STATUS ================= */

if (isset($_POST['update_status'])) {

    $appointment_id = mysqli_real_escape_string(
        $conn,
        $_POST['appointment_id']
    );

    $status = mysqli_real_escape_string(
        $conn,
        $_POST['status']
    );


    mysqli_query(
        $conn,
        "UPDATE appointments
         SET status='$status'
         WHERE appointment_id='$appointment_id'"
    );


    /* Keep current filter */

    if (
        isset($_POST['current_status']) &&
        $_POST['current_status'] != ""
    ) {

        header(
            "Location: appointments.php?status="
            . urlencode($_POST['current_status'])
        );

    } else {

        header("Location: appointments.php");

    }

    exit();

}


/* ================= DELETE APPOINTMENT ================= */

if (isset($_GET['delete'])) {

    $id = mysqli_real_escape_string(
        $conn,
        $_GET['delete']
    );


    mysqli_query(
        $conn,
        "DELETE FROM appointments
         WHERE appointment_id='$id'"
    );


    if (
        isset($_GET['status']) &&
        $_GET['status'] != ""
    ) {

        header(
            "Location: appointments.php?status="
            . urlencode($_GET['status'])
        );

    } else {

        header("Location: appointments.php");

    }

    exit();

}


/* ================= STATUS FILTER ================= */

$statusFilter = "";


if (
    isset($_GET['status']) &&
    $_GET['status'] != ""
) {

    $statusFilter = mysqli_real_escape_string(
        $conn,
        $_GET['status']
    );

}


/* ================= FETCH APPOINTMENTS ================= */

if ($statusFilter == "") {

    $sql = "

        SELECT
            appointments.*,

            patients.name AS patient_name,

            doctors.name AS doctor_name,

            doctors.specialization

        FROM appointments

        INNER JOIN patients
        ON appointments.patient_id =
           patients.patient_id

        INNER JOIN doctors
        ON appointments.doctor_id =
           doctors.doctor_id

        ORDER BY
            appointment_date DESC,
            appointment_time DESC

    ";

} else {

    $sql = "

        SELECT
            appointments.*,

            patients.name AS patient_name,

            doctors.name AS doctor_name,

            doctors.specialization

        FROM appointments

        INNER JOIN patients
        ON appointments.patient_id =
           patients.patient_id

        INNER JOIN doctors
        ON appointments.doctor_id =
           doctors.doctor_id

        WHERE appointments.status='$statusFilter'

        ORDER BY
            appointment_date DESC,
            appointment_time DESC

    ";

}


$result = mysqli_query($conn, $sql);

?>


<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">


<title>Manage Appointments</title>


<!-- Main CSS -->

<link rel="stylesheet"
      href="../css/style.css">


<!-- Poppins Font -->

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

    width: 94%;

    max-width: 1500px;

    margin: 35px auto 60px;

}


/* ================= HEADER ================= */

.header {

    display: flex;

    align-items: center;

    justify-content: space-between;

    margin-bottom: 25px;

}


.header h2 {

    margin: 0;

    color: #2d2340;

    font-size: 28px;

}


.header h2 i {

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

    text-decoration: none;

    padding: 10px 18px;

    border-radius: 8px;

    font-size: 14px;

    font-weight: 500;

    transition: .3s;

}


.back-btn:hover {

    background: #563975;

    transform: translateX(-3px);

}


/* ================= FILTER ================= */

.filter-box {

    background: white;

    padding: 18px 20px;

    border-radius: 15px;

    box-shadow:
        0 8px 25px
        rgba(0,0,0,.07);

    margin-bottom: 20px;

}


.filter-box label {

    color: #2d2340;

    font-weight: 600;

    margin-right: 10px;

}


.filter-box select {

    padding: 9px 14px;

    border: 1px solid #ddd;

    border-radius: 7px;

    outline: none;

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

    padding: 14px 10px;

    font-size: 13px;

    font-weight: 600;

    text-align: center;

}


th:first-child {

    border-radius: 9px 0 0 0;

}


th:last-child {

    border-radius: 0 9px 0 0;

}


td {

    padding: 13px 10px;

    text-align: center;

    border-bottom: 1px solid #eee;

    color: #555;

    font-size: 13px;

}


tr:hover td {

    background: #faf8fc;

}


/* ================= PATIENT / DOCTOR ================= */

.patient-name,

.doctor-name {

    color: #2d2340;

    font-weight: 600;

}


.specialization {

    display: block;

    color: #8d63b8;

    font-size: 11px;

    margin-top: 3px;

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


/* ================= ACTION FORM ================= */

.action-form {

    display: flex;

    align-items: center;

    justify-content: center;

    gap: 6px;

}


.action-form select {

    padding: 6px;

    border: 1px solid #ccc;

    border-radius: 6px;

    font-size: 12px;

}


/* ================= UPDATE BUTTON ================= */

.update-btn {

    border: none;

    background: #6b4c8b;

    color: white;

    padding: 7px 12px;

    border-radius: 6px;

    cursor: pointer;

    font-size: 12px;

    transition: .3s;

}


.update-btn:hover {

    background: #563975;

}


/* ================= DELETE BUTTON ================= */

.delete-btn {

    display: inline-block;

    background: #dc3545;

    color: white;

    padding: 7px 12px;

    border-radius: 6px;

    text-decoration: none;

    font-size: 12px;

    transition: .3s;

}


.delete-btn:hover {

    background: #b02a37;

}


/* ================= NO DATA ================= */

.no-data {

    text-align: center;

    padding: 60px 20px;

    color: #777;

}


.no-data i {

    font-size: 45px;

    color: #8d63b8;

    margin-bottom: 15px;

}


.no-data h3 {

    color: #2d2340;

    margin-bottom: 8px;

}


/* ================= BOTTOM ================= */

.bottom-button {

    text-align: center;

    margin-top: 25px;

}


.report-btn {

    display: inline-flex;

    align-items: center;

    gap: 8px;

    background: #6b4c8b;

    color: white;

    text-decoration: none;

    padding: 11px 20px;

    border-radius: 8px;

    font-size: 14px;

}


.report-btn:hover {

    background: #563975;

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


    .header h2 {

        font-size: 24px;

    }

}

</style>

</head>


<body>


<div class="container">


<!-- ================= HEADER ================= -->

<div class="header">


<h2>

<i class="fa-solid fa-calendar-check"></i>


<?php

if ($statusFilter == "") {

    echo "Manage Appointments";

} else {

    echo htmlspecialchars(
        $statusFilter
    ) . " Appointments";

}

?>

</h2>


<a href="dashboard.php"
   class="back-btn">

<i class="fa-solid fa-arrow-left"></i>

Dashboard

</a>


</div>



<!-- ================= FILTER ================= -->

<div class="filter-box">


<label>

<i class="fa-solid fa-filter"></i>

Filter by Status:

</label>


<select
onchange="filterStatus(this.value)">


<option value="">

All Appointments

</option>


<option value="Pending"
<?php
if ($statusFilter == "Pending")
    echo "selected";
?>>

Pending

</option>


<option value="Approved"
<?php
if ($statusFilter == "Approved")
    echo "selected";
?>>

Approved

</option>


<option value="Completed"
<?php
if ($statusFilter == "Completed")
    echo "selected";
?>>

Completed

</option>


<option value="Cancelled"
<?php
if ($statusFilter == "Cancelled")
    echo "selected";
?>>

Cancelled

</option>


</select>


</div>



<!-- ================= TABLE ================= -->

<div class="table-card">


<?php

if (mysqli_num_rows($result) > 0) {

?>


<table>


<tr>

<th>ID</th>

<th>Patient</th>

<th>Doctor</th>

<th>Date</th>

<th>Time</th>

<th>Symptoms</th>

<th>Status</th>

<th>Update Status</th>

<th>Delete</th>

</tr>


<?php

while (
    $row = mysqli_fetch_assoc($result)
) {

    $statusClass =
        strtolower($row['status']);

?>


<tr>


<!-- ID -->

<td>

<?php

echo htmlspecialchars(
    $row['appointment_id']
);

?>

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

</td>



<!-- DOCTOR -->

<td>

<span class="doctor-name">

Dr.
<?php

echo htmlspecialchars(
    $row['doctor_name']
);

?>

</span>


<span class="specialization">

<?php

echo htmlspecialchars(
    $row['specialization']
);

?>

</span>

</td>



<!-- DATE -->

<td>

<?php

echo htmlspecialchars(
    $row['appointment_date']
);

?>

</td>



<!-- TIME -->

<td>

<?php

echo htmlspecialchars(
    $row['appointment_time']
);

?>

</td>



<!-- SYMPTOMS -->

<td>

<?php

echo htmlspecialchars(
    $row['symptoms']
);

?>

</td>



<!-- STATUS -->

<td>

<span class="status <?php
echo $statusClass;
?>">

<?php

echo htmlspecialchars(
    $row['status']
);

?>

</span>

</td>



<!-- UPDATE -->

<td>


<form
method="POST"
class="action-form">


<input
type="hidden"
name="appointment_id"
value="<?php
echo $row['appointment_id'];
?>">


<input
type="hidden"
name="current_status"
value="<?php
echo htmlspecialchars(
    $statusFilter
);
?>">


<select name="status">


<option value="Pending"
<?php
if (
    $row['status']
    == "Pending"
)
    echo "selected";
?>>

Pending

</option>


<option value="Approved"
<?php
if (
    $row['status']
    == "Approved"
)
    echo "selected";
?>>

Approved

</option>


<option value="Completed"
<?php
if (
    $row['status']
    == "Completed"
)
    echo "selected";
?>>

Completed

</option>


<option value="Cancelled"
<?php
if (
    $row['status']
    == "Cancelled"
)
    echo "selected";
?>>

Cancelled

</option>


</select>


<button
type="submit"
name="update_status"
class="update-btn">

Update

</button>


</form>


</td>



<!-- DELETE -->

<td>


<a
href="appointments.php?delete=<?php
echo $row['appointment_id'];

if ($statusFilter != "") {

    echo "&status=" .
         urlencode($statusFilter);

}
?>"

class="delete-btn"

onclick="return confirmDelete();"


<i class="fa-solid fa-trash"></i>

Delete


</a>


</td>


</tr>


<?php

}

?>


</table>


<?php

} else {

?>


<div class="no-data">


<i class="fa-solid fa-calendar-xmark"></i>


<h3>

No Appointments Found

</h3>


<p>

There are no appointments in this category.

</p>


</div>


<?php

}

?>


</div>



<!-- ================= BOTTOM ================= -->

<div class="bottom-button">


<a href="reports.php"
   class="report-btn">

<i class="fa-solid fa-chart-column"></i>

View Reports

</a>


</div>


</div>



<script>

/* ================= STATUS FILTER ================= */

function filterStatus(status) {

    if (status === "") {

        window.location.href =
            "appointments.php";

    } else {

        window.location.href =
            "appointments.php?status="
            + encodeURIComponent(status);

    }

}

</script>

<script src="../js/script.js"></script>
</body>

</html>