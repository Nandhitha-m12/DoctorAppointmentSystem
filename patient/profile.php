<?php

session_start();

include("../config.php");


/* ================= LOGIN CHECK ================= */

if (!isset($_SESSION['patient_id'])) {

    header("Location: ../login.php");

    exit();

}


$patient_id = $_SESSION['patient_id'];

$message = "";


/* ================= UPDATE PROFILE ================= */

if (isset($_POST['update'])) {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);


    $update = mysqli_query($conn, "

        UPDATE patients

        SET
            name='$name',
            phone='$phone',
            dob='$dob',
            gender='$gender',
            address='$address'

        WHERE patient_id='$patient_id'

    ");


    if ($update) {

        $message = "Profile updated successfully.";

        $_SESSION['patient_name'] = $name;

    } else {

        $message = "Unable to update profile.";

    }

}


/* ================= GET PATIENT DETAILS ================= */

$query = mysqli_query($conn, "

    SELECT *
    FROM patients
    WHERE patient_id='$patient_id'

");


$patient = mysqli_fetch_assoc($query);

?>


<!DOCTYPE html>

<html lang="en">

<head>


<meta charset="UTF-8">


<meta name="viewport"
      content="width=device-width, initial-scale=1.0">


<title>My Profile</title>


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

    font-family: 'Poppins', sans-serif;

}


/* ================= PROFILE CONTAINER ================= */

.profile-container {

    width: 90%;

    max-width: 800px;

    margin: 40px auto 60px;

}


/* ================= TOP ================= */

.profile-top {

    display: flex;

    align-items: center;

    justify-content: space-between;

    margin-bottom: 25px;

}


.profile-title {

    color: #2d2340;

    font-size: 30px;

    font-weight: 600;

    margin: 0;

}


.profile-title i {

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

    text-decoration: none;

    border-radius: 8px;

    font-size: 14px;

    font-weight: 500;

    transition: .3s;

}


.back-btn:hover {

    background: #563975;

    transform: translateX(-3px);

}


/* ================= PROFILE CARD ================= */

.form-box {

    background: white;

    padding: 35px 40px;

    border-radius: 18px;

    box-shadow: 0 8px 25px rgba(0,0,0,.08);

}


.form-box h2 {

    text-align: center;

    color: #6b4c8b;

    font-size: 26px;

    font-weight: 600;

    margin-bottom: 25px;

}


/* ================= SUCCESS MESSAGE ================= */

.success {

    background: #d4edda;

    color: #218838;

    padding: 12px;

    border-radius: 8px;

    text-align: center;

    font-size: 14px;

    margin-bottom: 20px;

}


/* ================= LABEL ================= */

.form-box label {

    display: block;

    color: #2d2340;

    font-size: 14px;

    font-weight: 600;

    margin-top: 18px;

}


/* ================= INPUT ================= */

.form-box input,

.form-box select,

.form-box textarea {

    width: 100%;

    padding: 12px 14px;

    margin-top: 8px;

    border: 1px solid #d6d1dc;

    border-radius: 8px;

    font-size: 14px;

    outline: none;

    background: #fff;

    transition: .3s;

}


.form-box input:focus,

.form-box select:focus,

.form-box textarea:focus {

    border-color: #6b4c8b;

    box-shadow: 0 0 0 3px rgba(107,76,139,.10);

}


/* ================= EMAIL ================= */

.form-box input[readonly] {

    background: #f2eff5;

    color: #777;

    cursor: not-allowed;

}


/* ================= TEXTAREA ================= */

.form-box textarea {

    resize: vertical;

    min-height: 100px;

}


/* ================= UPDATE BUTTON ================= */

.form-box button {

    width: 100%;

    margin-top: 25px;

    padding: 13px;

    background: #6b4c8b;

    color: white;

    border: none;

    border-radius: 8px;

    font-size: 16px;

    font-weight: 600;

    cursor: pointer;

    transition: .3s;

}


.form-box button:hover {

    background: #563975;

    transform: translateY(-2px);

}


/* ================= RESPONSIVE ================= */

@media(max-width: 700px) {

    .profile-container {

        width: 94%;

        margin-top: 25px;

    }


    .profile-top {

        flex-direction: column;

        align-items: flex-start;

        gap: 15px;

    }


    .profile-title {

        font-size: 25px;

    }


    .form-box {

        padding: 25px 20px;

    }

}

</style>


</head>


<body>


<div class="profile-container">


    <!-- ================= TOP SECTION ================= -->

    <div class="profile-top">


        <h1 class="profile-title">

            <i class="fa-solid fa-user"></i>

            My Profile

        </h1>


        <a href="dashboard.php"
           class="back-btn">

            <i class="fa-solid fa-arrow-left"></i>

            Back to Dashboard

        </a>


    </div>


    <!-- ================= PROFILE FORM ================= -->

    <div class="form-box">


        <h2>

            Personal Information

        </h2>


        <?php

        if ($message != "") {

            echo "<p class='success'>" .
                 htmlspecialchars($message) .
                 "</p>";

        }

        ?>


        <form method="POST">


            <!-- FULL NAME -->

            <label>
                Full Name
            </label>


            <input
                type="text"
                name="name"
                value="<?php echo htmlspecialchars($patient['name']); ?>"
                required>


            <!-- EMAIL -->

            <label>
                Email Address
            </label>


            <input
                type="email"
                value="<?php echo htmlspecialchars($patient['email']); ?>"
                readonly>


            <!-- PHONE -->

            <label>
                Phone Number
            </label>


            <input
                type="text"
                name="phone"
                value="<?php echo htmlspecialchars($patient['phone']); ?>"
                required>


            <!-- DOB -->

            <label>
                Date of Birth
            </label>


            <input
                type="date"
                name="dob"
                value="<?php echo htmlspecialchars($patient['dob']); ?>"
                required>


            <!-- GENDER -->

            <label>
                Gender
            </label>


            <select name="gender" required>

                <option value="Male"
                    <?php
                    if ($patient['gender'] == "Male")
                        echo "selected";
                    ?>>
                    Male
                </option>


                <option value="Female"
                    <?php
                    if ($patient['gender'] == "Female")
                        echo "selected";
                    ?>>
                    Female
                </option>


                <option value="Other"
                    <?php
                    if ($patient['gender'] == "Other")
                        echo "selected";
                    ?>>
                    Other
                </option>

            </select>


            <!-- ADDRESS -->

            <label>
                Address
            </label>


            <textarea
                name="address"
                rows="4"
                required><?php echo htmlspecialchars($patient['address']); ?></textarea>


            <!-- UPDATE -->

            <button
                type="submit"
                name="update">

                <i class="fa-solid fa-floppy-disk"></i>

                Update Profile

            </button>


        </form>


    </div>


</div>


</body>

</html>