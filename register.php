<?php
include("config.php");

$message = "";
$message_type = "";

if(isset($_POST['register'])){

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $password = $_POST['password'];

    /* Check whether email already exists */

    $check = mysqli_query($conn,
        "SELECT * FROM patients WHERE email='$email'"
    );

    if(mysqli_num_rows($check) > 0){

        $message = "Email already registered!";
        $message_type = "error";

    }else{

        /* Hash password */

        $hashed_password = password_hash(
            $password,
            PASSWORD_DEFAULT
        );

        /* Insert patient */

        $query = mysqli_query($conn,
            "INSERT INTO patients
            (name,email,phone,dob,gender,address,password)
            VALUES
            ('$name','$email','$phone','$dob','$gender','$address','$hashed_password')"
        );

        if($query){

            $message = "Registration successful! You can now login.";
            $message_type = "success";

        }else{

            $message = "Registration failed. Please try again.";
            $message_type = "error";

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

<title>Patient Registration - Zynovexa Hospital</title>

<link rel="stylesheet"
href="css/style.css">

<link rel="stylesheet"
href="css/register.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
rel="stylesheet">

</head>

<body>

<div class="register-container">

    <!-- ================= LEFT SIDE ================= -->

    <div class="register-left">

        <img
        src="images/logo.png"
        class="hospital-logo"
        alt="Zynovexa Logo">

        <h1>Zynovexa</h1>

        <h3>Multispeciality Hospital</h3>

        <p>

            Your health is our priority.

            Create your patient account and
            access convenient healthcare services
            anytime.

        </p>

        <div class="register-features">

            <div>

                <i class="fa-solid fa-calendar-check"></i>

                <span>Easy Appointment Booking</span>

            </div>

            <div>

                <i class="fa-solid fa-user-doctor"></i>

                <span>Experienced Doctors</span>

            </div>

            <div>

                <i class="fa-solid fa-clock"></i>

                <span>24×7 Healthcare Support</span>

            </div>

        </div>

    </div>


    <!-- ================= RIGHT SIDE ================= -->

    <div class="register-right">

        <div class="register-card">

            <h2>Create Account</h2>

            <p class="subtitle">

                Register as a Patient

            </p>


            <!-- ================= MESSAGE ================= -->

            <?php if($message != ""){ ?>

                <div class="<?php echo $message_type; ?>-box">

                    <?php echo $message; ?>

                </div>

            <?php } ?>


            <!-- ================= FORM ================= -->

            <form method="POST" onsubmit="return validateRegister();">

                <!-- NAME -->

                <label>Full Name</label>

                <div class="input-group">

                    <i class="fa-solid fa-user"></i>

                    <input
                    type="text"
                    name="name"
                    placeholder="Enter your full name"
                    required>

                </div>


                <!-- EMAIL -->

                <label>Email Address</label>

                <div class="input-group">

                    <i class="fa-solid fa-envelope"></i>

                    <input
                    type="email"
                    name="email"
                    placeholder="Enter your email"
                    required>

                </div>


                <!-- PHONE -->

                <label>Phone Number</label>

                <div class="input-group">

                    <i class="fa-solid fa-phone"></i>

                    <input
                    type="tel"
                    name="phone"
                    placeholder="Enter 10 digit phone number"
                    pattern="[0-9]{10}"
                    maxlength="10"
                    required>

                </div>


                <!-- DOB -->

                <label>Date of Birth</label>

                <div class="input-group">

                    <i class="fa-solid fa-calendar"></i>

                    <input
                    type="date"
                    name="dob"
                    required>

                </div>


                <!-- GENDER -->

                <label>Gender</label>

                <div class="input-group">

                    <i class="fa-solid fa-venus-mars"></i>

                    <select name="gender" required>

                        <option value="">
                            Select Gender
                        </option>

                        <option value="Male">
                            Male
                        </option>

                        <option value="Female">
                            Female
                        </option>

                        <option value="Other">
                            Other
                        </option>

                    </select>

                </div>


                <!-- ADDRESS -->

                <label>Address</label>

                <div class="input-group textarea-group">

                    <i class="fa-solid fa-location-dot"></i>

                    <textarea
                    name="address"
                    placeholder="Enter your address"
                    rows="3"
                    required></textarea>

                </div>


                <!-- PASSWORD -->

                <label>Password</label>

                <div class="input-group">

                    <i class="fa-solid fa-lock"></i>

                    <input
                    type="password"
                    name="password"
                    id="password"
                    placeholder="Create a password"
                    minlength="6"
                    required>

                    <span onclick="togglePassword()">

                        <i
                        class="fa-solid fa-eye"
                        id="eye">
                        </i>

                    </span>

                </div>


                <!-- REGISTER BUTTON -->

                <button
                type="submit"
                name="register">

                    <i class="fa-solid fa-user-plus"></i>

                    Create Account

                </button>

            </form>


            <!-- LOGIN LINK -->

            <div class="login-link">

                Already have an account?

                <a href="login.php">

                    Login Here

                </a>

            </div>

        </div>

    </div>

</div>


<!-- ================= PASSWORD SCRIPT ================= -->

<script>

function togglePassword(){

    var password =
    document.getElementById("password");

    var eye =
    document.getElementById("eye");

    if(password.type === "password"){

        password.type = "text";

        eye.classList.remove("fa-eye");

        eye.classList.add("fa-eye-slash");

    }else{

        password.type = "password";

        eye.classList.remove("fa-eye-slash");

        eye.classList.add("fa-eye");

    }

}

</script>
<script src="js/script.js"></script>
</body>

</html>