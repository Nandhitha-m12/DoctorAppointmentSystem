```php
<?php
session_start();
include("../config.php");

if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: view_doctors.php");
    exit();
}

$doctor_id = mysqli_real_escape_string($conn, $_GET['id']);
$message = "";

/* ================= UPDATE DOCTOR ================= */

if (isset($_POST['update_doctor'])) {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $specialization = mysqli_real_escape_string($conn, $_POST['specialization']);
    $qualification = mysqli_real_escape_string($conn, $_POST['qualification']);
    $experience = mysqli_real_escape_string($conn, $_POST['experience']);

    $update = mysqli_query($conn, "
        UPDATE doctors SET
            name='$name',
            email='$email',
            phone='$phone',
            specialization='$specialization',
            qualification='$qualification',
            experience='$experience'
        WHERE doctor_id='$doctor_id'
    ");

    if ($update) {
        $message = "Doctor details updated successfully.";
    } else {
        $message = "Failed to update doctor details.";
    }
}


/* ================= FETCH DOCTOR ================= */

$result = mysqli_query($conn, "
    SELECT * FROM doctors
    WHERE doctor_id='$doctor_id'
");

$doctor = mysqli_fetch_assoc($result);

if (!$doctor) {
    header("Location: view_doctors.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>Edit Doctor</title>

<link rel="stylesheet" href="../css/style.css">


<style>

body {
    background: #f5f5f5;
    font-family: Arial, sans-serif;
}

.container {
    width: 100%;
    display: flex;
    justify-content: center;
    margin: 40px auto;
}

.form-box {
    width: 550px;
    background: white;
    padding: 35px;
    border-radius: 12px;
    box-shadow: 0 5px 15px rgba(0,0,0,.12);
}

.form-box h2 {
    text-align: center;
    color: #6f4e8b;
    margin-bottom: 25px;
}

.form-group {
    margin-bottom: 18px;
}

.form-group label {
    display: block;
    font-weight: bold;
    margin-bottom: 7px;
    color: #444;
}

.form-group input,
.form-group select {
    width: 100%;
    padding: 11px;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 15px;
    box-sizing: border-box;
}

.form-group input:focus,
.form-group select:focus {
    border-color: #6f4e8b;
    outline: none;
}

.success {
    background: #d4edda;
    color: #155724;
    padding: 10px;
    text-align: center;
    border-radius: 6px;
    margin-bottom: 20px;
}

.error {
    background: #f8d7da;
    color: #721c24;
    padding: 10px;
    text-align: center;
    border-radius: 6px;
    margin-bottom: 20px;
}

.update-btn {
    width: 100%;
    padding: 12px;
    background: #6f4e8b;
    color: white;
    border: none;
    border-radius: 6px;
    font-size: 16px;
    cursor: pointer;
    margin-top: 10px;
}

.update-btn:hover {
    background: #563d7c;
}

.back-btn {
    display: block;
    text-align: center;
    margin-top: 20px;
    padding: 11px;
    background: #6f4e8b;
    color: white;
    text-decoration: none;
    border-radius: 6px;
}

.back-btn:hover {
    background: #563d7c;
}

</style>

</head>


<body>


<div class="container">

<div class="form-box">

<h2>Edit Doctor</h2>


<?php

if ($message != "") {

    echo "<div class='success'>$message</div>";

}

?>


<form method="POST">


<!-- Doctor Name -->

<div class="form-group">

<label>Doctor Name</label>

<input
    type="text"
    name="name"
    value="<?php echo htmlspecialchars($doctor['name']); ?>"
    required>

</div>


<!-- Email -->

<div class="form-group">

<label>Email Address</label>

<input
    type="email"
    name="email"
    value="<?php echo htmlspecialchars($doctor['email']); ?>"
    required>

</div>


<!-- Phone -->

<div class="form-group">

<label>Phone Number</label>

<input
    type="text"
    name="phone"
    value="<?php echo htmlspecialchars($doctor['phone']); ?>"
    required>

</div>


<!-- Specialization -->

<div class="form-group">

<label>Specialization</label>

<select name="specialization" required>

<option value="">Select Specialization</option>

<option value="Cardiology"
<?php
if ($doctor['specialization'] == "Cardiology")
    echo "selected";
?>>
Cardiology
</option>

<option value="Neurology"
<?php
if ($doctor['specialization'] == "Neurology")
    echo "selected";
?>>
Neurology
</option>

<option value="Orthopedic"
<?php
if ($doctor['specialization'] == "Orthopedic")
    echo "selected";
?>>
Orthopedic
</option>

<option value="Dermatology"
<?php
if ($doctor['specialization'] == "Dermatology")
    echo "selected";
?>>
Dermatology
</option>

<option value="General Medicine"
<?php
if ($doctor['specialization'] == "General Medicine")
    echo "selected";
?>>
General Medicine
</option>

</select>

</div>


<!-- Qualification -->

<div class="form-group">

<label>Qualification</label>

<input
    type="text"
    name="qualification"
    value="<?php echo htmlspecialchars($doctor['qualification']); ?>"
    placeholder="Example: MBBS, MD">

</div>


<!-- Experience -->

<div class="form-group">

<label>Experience</label>

<input
    type="text"
    name="experience"
    value="<?php echo htmlspecialchars($doctor['experience']); ?>"
    placeholder="Example: 10 Years">

</div>


<!-- Update -->

<button
    type="submit"
    name="update_doctor"
    class="update-btn">

    Update Doctor

</button>


</form>


<a href="view_doctors.php" class="back-btn">

    ← Back to Manage Doctors

</a>


</div>

</div>


</body>

</html>
```
