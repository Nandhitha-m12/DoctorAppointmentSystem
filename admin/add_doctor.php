<?php

session_start();

include("../config.php");

/* ================= ADMIN LOGIN CHECK ================= */

if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}

$message = "";


/* ================= ADD DOCTOR ================= */

if (isset($_POST['add_doctor'])) {

    $doctor_name = mysqli_real_escape_string(
        $conn,
        $_POST['doctor_name']
    );

    $email = mysqli_real_escape_string(
        $conn,
        $_POST['email']
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

    $password = $_POST['password'];


    /* ================= CHECK EMAIL ================= */

    $checkEmail = mysqli_query(
        $conn,
        "SELECT doctor_id
         FROM doctors
         WHERE email='$email'"
    );


    if (mysqli_num_rows($checkEmail) > 0) {

        $message = "
        <div class='error'>
            <i class='fa-solid fa-circle-xmark'></i>
            Email address already exists.
        </div>
        ";

    } else {


        /* ================= PASSWORD ================= */

        $hashedPassword = password_hash(
            $password,
            PASSWORD_DEFAULT
        );


        /* ================= DOCTOR IMAGE ================= */

        $imageName = "";


        if (
            isset($_FILES['doctor_image']) &&
            $_FILES['doctor_image']['error'] == 0
        ) {

            $originalName = $_FILES['doctor_image']['name'];

            $tmpName = $_FILES['doctor_image']['tmp_name'];

            $imageSize = $_FILES['doctor_image']['size'];


            /* File Extension */

            $extension = strtolower(
                pathinfo(
                    $originalName,
                    PATHINFO_EXTENSION
                )
            );


            /* Allowed Images */

            $allowedTypes = array(
                "jpg",
                "jpeg",
                "png",
                "webp"
            );


            if (!in_array($extension, $allowedTypes)) {

                $message = "
                <div class='error'>
                    <i class='fa-solid fa-circle-xmark'></i>
                    Only JPG, JPEG, PNG and WEBP images are allowed.
                </div>
                ";

            }

            elseif ($imageSize > 5 * 1024 * 1024) {

                $message = "
                <div class='error'>
                    <i class='fa-solid fa-circle-xmark'></i>
                    Image size must be less than 5 MB.
                </div>
                ";

            }

            else {


                /* Upload Folder */

                $uploadFolder = "../uploads/doctors/";


                if (!is_dir($uploadFolder)) {

                    mkdir(
                        $uploadFolder,
                        0777,
                        true
                    );
                }


                /* Unique Image Name */

                $imageName =
                    time() . "_" .
                    uniqid() . "." .
                    $extension;


                $uploadPath =
                    $uploadFolder . $imageName;


                if (!move_uploaded_file(
                    $tmpName,
                    $uploadPath
                )) {

                    $message = "
                    <div class='error'>
                        <i class='fa-solid fa-circle-xmark'></i>
                        Failed to upload doctor image.
                    </div>
                    ";

                    $imageName = "";
                }
            }
        }


        /* ================= INSERT DOCTOR ================= */

        if ($message == "") {

            /*
             * New doctors are initially Pending.
             * Admin can approve them from Manage Doctors.
             */

            $status = "Pending";


            $insert = mysqli_query(
                $conn,
                "INSERT INTO doctors
                (
                    name,
                    email,
                    phone,
                    specialization,
                    qualification,
                    experience,
                    password,
                    image,
                    status
                )
                VALUES
                (
                    '$doctor_name',
                    '$email',
                    '$phone',
                    '$specialization',
                    '$qualification',
                    '$experience',
                    '$hashedPassword',
                    '$imageName',
                    '$status'
                )"
            );


            if ($insert) {

                $message = "
                <div class='success'>
                    <i class='fa-solid fa-circle-check'></i>
                    Doctor added successfully.
                </div>
                ";

            } else {

                $message = "
                <div class='error'>
                    <i class='fa-solid fa-circle-xmark'></i>
                    Failed to add doctor.
                    <br>
                    " .
                    htmlspecialchars(
                        mysqli_error($conn)
                    )
                    . "
                </div>
                ";
            }
        }
    }
}

?>


<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>Add Doctor</title>


<!-- Main CSS -->

<link rel="stylesheet"
      href="../css/style.css">


<!-- Poppins -->

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

.page-container {

    width: 100%;

    max-width: 800px;

    margin: 45px auto 60px;

    padding: 0 20px;
}


/* ================= FORM CARD ================= */

.form-box {

    background: white;

    padding: 35px 40px;

    border-radius: 20px;

    box-shadow:
        0 8px 25px
        rgba(0,0,0,0.08);
}


/* ================= TITLE ================= */

.form-box h2 {

    text-align: center;

    color: #2d2340;

    font-size: 30px;

    margin: 0 0 8px;

    font-weight: 600;
}

.form-box h2 i {

    color: #6b4c8b;

    margin-right: 8px;
}


.subtitle {

    text-align: center;

    color: #777;

    font-size: 14px;

    margin-bottom: 30px;
}


/* ================= MESSAGE ================= */

.success {

    background: #d4edda;

    color: #218838;

    padding: 12px 15px;

    border-radius: 8px;

    text-align: center;

    margin-bottom: 20px;

    font-size: 14px;

    font-weight: 500;
}


.error {

    background: #f8d7da;

    color: #b02a37;

    padding: 12px 15px;

    border-radius: 8px;

    text-align: center;

    margin-bottom: 20px;

    font-size: 14px;

    font-weight: 500;
}


/* ================= FORM GROUP ================= */

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


.form-group label::after {

    content: " *";

    color: #b02a37;
}


/* ================= INPUTS ================= */

.form-group input,
.form-group select {

    width: 100%;

    padding: 12px 14px;

    border: 1px solid #d8d2df;

    border-radius: 9px;

    background: white;

    color: #333;

    font-size: 14px;

    outline: none;

    transition: .3s;
}


.form-group input:focus,
.form-group select:focus {

    border-color: #6b4c8b;

    box-shadow:
        0 0 0 3px
        rgba(107,76,139,.10);
}


/* ================= FILE INPUT ================= */

.form-group input[type="file"] {

    padding: 10px;

    background: #faf8fc;

    cursor: pointer;
}


/* ================= BUTTON ================= */

.submit-btn {

    width: 100%;

    padding: 13px;

    margin-top: 10px;

    background: #6b4c8b;

    color: white;

    border: none;

    border-radius: 9px;

    font-size: 15px;

    font-weight: 600;

    cursor: pointer;

    transition: .3s;
}


.submit-btn:hover {

    background: #563975;

    transform: translateY(-2px);
}


.submit-btn i {

    margin-right: 7px;
}


/* ================= BACK BUTTON ================= */

.back-btn {

    display: flex;

    align-items: center;

    justify-content: center;

    gap: 8px;

    width: 100%;

    margin-top: 15px;

    padding: 12px;

    background: #f0e9f7;

    color: #6b4c8b;

    text-decoration: none;

    border-radius: 9px;

    font-size: 14px;

    font-weight: 600;

    transition: .3s;
}


.back-btn:hover {

    background: #e5d9ef;

    transform: translateY(-2px);
}


/* ================= NOTE ================= */

.form-note {

    margin-top: 20px;

    padding: 12px 15px;

    background: #faf8fc;

    border-left: 4px solid #6b4c8b;

    border-radius: 6px;

    color: #666;

    font-size: 12px;

    line-height: 1.6;
}


/* ================= RESPONSIVE ================= */

@media(max-width:600px) {

    .page-container {

        margin-top: 25px;

        padding: 0 15px;
    }


    .form-box {

        padding: 25px 20px;
    }


    .form-box h2 {

        font-size: 25px;
    }

}

</style>

</head>


<body>


<div class="page-container">


<div class="form-box">


<h2>

<i class="fa-solid fa-user-doctor"></i>

Add Doctor

</h2>


<p class="subtitle">

Add a new doctor to Zynovexa Multispeciality Hospital

</p>


<?php

if ($message != "") {

    echo $message;

}

?>


<form
    action="add_doctor.php"
    method="POST"
    enctype="multipart/form-data">


<!-- ================= DOCTOR NAME ================= -->

<div class="form-group">

<label>Doctor Name</label>

<input
    type="text"
    name="doctor_name"
    placeholder="Enter doctor name"
    required>

</div>


<!-- ================= EMAIL ================= -->

<div class="form-group">

<label>Email Address</label>

<input
    type="email"
    name="email"
    placeholder="Enter email address"
    required>

</div>


<!-- ================= PHONE ================= -->

<div class="form-group">

<label>Phone Number</label>

<input
    type="text"
    name="phone"
    placeholder="Enter phone number"
    required>

</div>


<!-- ================= SPECIALIZATION ================= -->

<div class="form-group">

<label>Specialization</label>

<select
    name="specialization"
    required>

<option value="">
    Select Specialization
</option>

<option value="Cardiology">
    Cardiology
</option>

<option value="Neurology">
    Neurology
</option>

<option value="Orthopedics">
    Orthopedics
</option>

<option value="Dermatology">
    Dermatology
</option>

<option value="General Medicine">
    General Medicine
</option>

<option value="Pediatrics">
    Pediatrics
</option>

<option value="Gynecology">
    Gynecology
</option>

<option value="Ophthalmology">
    Ophthalmology
</option>

</select>

</div>


<!-- ================= QUALIFICATION ================= -->

<div class="form-group">

<label>Qualification</label>

<input
    type="text"
    name="qualification"
    placeholder="Example: MBBS, MD"
    required>

</div>


<!-- ================= EXPERIENCE ================= -->

<div class="form-group">

<label>Experience</label>

<input
    type="text"
    name="experience"
    placeholder="Example: 10 Years"
    required>

</div>


<!-- ================= IMAGE ================= -->

<div class="form-group">

<label>Doctor Image</label>

<input
    type="file"
    name="doctor_image"
    accept=".jpg,.jpeg,.png,.webp">

</div>


<!-- ================= PASSWORD ================= -->

<div class="form-group">

<label>Password</label>

<input
    type="password"
    name="password"
    placeholder="Enter doctor password"
    required>

</div>


<!-- ================= SUBMIT ================= -->

<button
    type="submit"
    name="add_doctor"
    class="submit-btn">

<i class="fa-solid fa-user-plus"></i>

Add Doctor

</button>


</form>


<!-- ================= BACK ================= -->

<a
    href="dashboard.php"
    class="back-btn">

<i class="fa-solid fa-arrow-left"></i>

Back to Dashboard

</a>


<div class="form-note">

<i class="fa-solid fa-circle-info"></i>

New doctors are added with
<strong>Pending</strong> status.
The administrator can approve or reject the doctor from
<strong>Manage Doctors</strong>.

</div>


</div>

</div>


</body>

</html>