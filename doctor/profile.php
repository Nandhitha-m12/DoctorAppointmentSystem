<?php

session_start();

include("../config.php");


/* ================= LOGIN CHECK ================= */

if (!isset($_SESSION['doctor_id'])) {

    header("Location: ../login.php");

    exit();

}


$doctor_id = $_SESSION['doctor_id'];

$message = "";


/* ================= UPDATE PROFILE ================= */

if (isset($_POST['update'])) {

    $name = mysqli_real_escape_string(
        $conn,
        $_POST['name']
    );

    $phone = mysqli_real_escape_string(
        $conn,
        $_POST['phone']
    );

    $specialization = mysqli_real_escape_string(
        $conn,
        $_POST['specialization']
    );

    $qualification = mysqli_real_escape_string(
        $conn,
        $_POST['qualification']
    );

    $experience = mysqli_real_escape_string(
        $conn,
        $_POST['experience']
    );


    $update = mysqli_query($conn, "

        UPDATE doctors SET

        name='$name',

        phone='$phone',

        specialization='$specialization',

        qualification='$qualification',

        experience='$experience'

        WHERE doctor_id='$doctor_id'

    ");


    if ($update) {

        $message = "Profile Updated Successfully.";

    } else {

        $message = "Failed to Update Profile.";

    }

}


/* ================= FETCH DOCTOR DETAILS ================= */

$result = mysqli_query(
    $conn,
    "SELECT * FROM doctors
     WHERE doctor_id='$doctor_id'"
);


$doctor = mysqli_fetch_assoc($result);

?>


<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">


<title>Doctor Profile</title>


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

.profile-container {

    width: 92%;

    max-width: 700px;

    margin: 40px auto 60px;

}


/* ================= TOP ================= */

.profile-header {

    display: flex;

    align-items: center;

    justify-content: space-between;

    margin-bottom: 25px;

}


.profile-title {

    margin: 0;

    color: #2d2340;

    font-size: 30px;

    font-weight: 600;

}


.profile-title i {

    color: #6b4c8b;

    margin-right: 8px;

}


/* ================= FORM CARD ================= */

.profile-card {

    background: #fff;

    padding: 35px;

    border-radius: 18px;

    box-shadow:
        0 8px 25px
        rgba(0,0,0,.08);

}


/* ================= PROFILE ICON ================= */

.profile-icon {

    width: 80px;

    height: 80px;

    margin: 0 auto 20px;

    border-radius: 50%;

    background: #f0e9f7;

    color: #6b4c8b;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 32px;

}


/* ================= LABEL ================= */

.form-group {

    margin-bottom: 18px;

}


.form-group label {

    display: block;

    color: #2d2340;

    font-size: 14px;

    font-weight: 600;

    margin-bottom: 7px;

}


/* ================= INPUT ================= */

.form-group input,

.form-group select {

    width: 100%;

    padding: 12px 14px;

    border: 1px solid #ddd;

    border-radius: 8px;

    font-size: 14px;

    outline: none;

    background: #fff;

    transition: .3s;

}


.form-group input:focus,

.form-group select:focus {

    border-color: #6b4c8b;

    box-shadow:
        0 0 0 3px
        rgba(107,76,139,.10);

}


/* ================= READONLY ================= */

.form-group input[readonly] {

    background: #f5f5f5;

    color: #777;

    cursor: not-allowed;

}


/* ================= BUTTON ================= */

.update-btn {

    width: 100%;

    padding: 13px;

    margin-top: 10px;

    border: none;

    border-radius: 8px;

    background: #6b4c8b;

    color: white;

    font-size: 15px;

    font-weight: 600;

    cursor: pointer;

    transition: .3s;

}


.update-btn:hover {

    background: #563975;

    transform: translateY(-2px);

}


/* ================= MESSAGE ================= */

.success-message {

    background: #d4edda;

    color: #218838;

    padding: 12px;

    border-radius: 8px;

    text-align: center;

    margin-bottom: 20px;

    font-size: 14px;

    font-weight: 500;

}


.error-message {

    background: #f8d7da;

    color: #b02a37;

    padding: 12px;

    border-radius: 8px;

    text-align: center;

    margin-bottom: 20px;

}


/* ================= BACK BUTTON ================= */

.back-btn {

    display: flex;

    align-items: center;

    justify-content: center;

    gap: 8px;

    margin-top: 20px;

    padding: 12px;

    background: #eee8f3;

    color: #6b4c8b;

    text-decoration: none;

    border-radius: 8px;

    font-size: 14px;

    font-weight: 600;

    transition: .3s;

}


.back-btn:hover {

    background: #e2d8eb;

}


/* ================= RESPONSIVE ================= */

@media(max-width:600px) {

    .profile-container {

        width: 94%;

        margin-top: 25px;

    }


    .profile-card {

        padding: 25px 20px;

    }


    .profile-title {

        font-size: 25px;

    }

}

</style>

</head>


<body>


<div class="profile-container">


<!-- ================= HEADER ================= -->

<div class="profile-header">

    <h2 class="profile-title">

        <i class="fa-solid fa-user-doctor"></i>

        My Profile

    </h2>

</div>



<!-- ================= PROFILE CARD ================= -->

<div class="profile-card">


<div class="profile-icon">

    <i class="fa-solid fa-user-doctor"></i>

</div>



<?php

if ($message != "") {

    if (strpos(
        $message,
        "Successfully"
    ) !== false) {

?>

<div class="success-message">

    <i class="fa-solid fa-circle-check"></i>

    <?php echo $message; ?>

</div>

<?php

    } else {

?>

<div class="error-message">

    <i class="fa-solid fa-circle-exclamation"></i>

    <?php echo $message; ?>

</div>

<?php

    }

}

?>



<form method="POST">


<!-- NAME -->

<div class="form-group">

    <label>

        Doctor Name

    </label>

    <input
        type="text"
        name="name"
        value="<?php
            echo htmlspecialchars(
                $doctor['name']
            );
        ?>"
        required>

</div>



<!-- EMAIL -->

<div class="form-group">

    <label>

        Email Address

    </label>

    <input
        type="email"
        value="<?php
            echo htmlspecialchars(
                $doctor['email']
            );
        ?>"
        readonly>

</div>



<!-- PHONE -->

<div class="form-group">

    <label>

        Phone Number

    </label>

    <input
        type="text"
        name="phone"
        value="<?php
            echo htmlspecialchars(
                $doctor['phone']
            );
        ?>"
        required>

</div>



<!-- SPECIALIZATION -->

<div class="form-group">

    <label>

        Specialization

    </label>

    <select
        name="specialization"
        required>


        <option value="Cardiology"
            <?php
            if (
                $doctor['specialization']
                == "Cardiology"
            )
                echo "selected";
            ?>>

            Cardiology

        </option>


        <option value="Neurology"
            <?php
            if (
                $doctor['specialization']
                == "Neurology"
            )
                echo "selected";
            ?>>

            Neurology

        </option>


        <option value="Orthopedics"
            <?php
            if (
                $doctor['specialization']
                == "Orthopedics"
            )
                echo "selected";
            ?>>

            Orthopedics

        </option>


        <option value="Pediatrics"
            <?php
            if (
                $doctor['specialization']
                == "Pediatrics"
            )
                echo "selected";
            ?>>

            Pediatrics

        </option>


        <option value="Dermatology"
            <?php
            if (
                $doctor['specialization']
                == "Dermatology"
            )
                echo "selected";
            ?>>

            Dermatology

        </option>


        <option value="Gynecology"
            <?php
            if (
                $doctor['specialization']
                == "Gynecology"
            )
                echo "selected";
            ?>>

            Gynecology

        </option>


        <option value="Ophthalmology"
            <?php
            if (
                $doctor['specialization']
                == "Ophthalmology"
            )
                echo "selected";
            ?>>

            Ophthalmology

        </option>


        <option value="General Medicine"
            <?php
            if (
                $doctor['specialization']
                == "General Medicine"
            )
                echo "selected";
            ?>>

            General Medicine

        </option>


    </select>

</div>



<!-- QUALIFICATION -->

<div class="form-group">

    <label>

        Qualification

    </label>

    <input
        type="text"
        name="qualification"
        value="<?php
            echo htmlspecialchars(
                $doctor['qualification']
            );
        ?>"
        required>

</div>



<!-- EXPERIENCE -->

<div class="form-group">

    <label>

        Experience (Years)

    </label>

    <input
        type="number"
        name="experience"
        min="0"
        value="<?php
            echo htmlspecialchars(
                $doctor['experience']
            );
        ?>"
        required>

</div>



<!-- UPDATE -->

<button
    type="submit"
    name="update"
    class="update-btn">

    <i class="fa-solid fa-floppy-disk"></i>

    Update Profile

</button>


</form>



<!-- BACK -->

<a href="dashboard.php"
   class="back-btn">

    <i class="fa-solid fa-arrow-left"></i>

    Back to Dashboard

</a>


</div>

</div>


</body>

</html>