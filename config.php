<?php

$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "doctorappointmentsystem"
);

if(!$conn){
    die("Database Connection Failed: " . mysqli_connect_error());
}

?>