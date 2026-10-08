<?php
session_start();
include("../config.php");

if (!isset($_SESSION['doctor_id'])) {
    header("Location: ../login.php");
    exit();
}

if (isset($_POST['update'])) {

    $appointment_id = $_POST['appointment_id'];
    $status = $_POST['status'];

    mysqli_query($conn, "UPDATE appointments
    SET status='$status'
    WHERE appointment_id='$appointment_id'");
}

header("Location: appointments.php");
exit();
?>