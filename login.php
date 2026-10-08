<?php
session_start();
include("config.php");

$message = "";

if(isset($_POST['login'])){

    $role = $_POST['role'];
    $username = mysqli_real_escape_string($conn,$_POST['username']);
    $password = $_POST['password'];

    // ================= PATIENT LOGIN =================
    if($role=="Patient"){

        $query = mysqli_query($conn,"SELECT * FROM patients WHERE email='$username'");

        if(mysqli_num_rows($query)>0){

            $row=mysqli_fetch_assoc($query);

            if(password_verify($password,$row['password'])){

                $_SESSION['patient_id']=$row['patient_id'];
                $_SESSION['patient_name']=$row['name'];

                header("Location: patient/dashboard.php");
                exit();

            }else{
                $message="Incorrect Password!";
            }

        }else{
            $message="Patient not found!";
        }
    }

    // ================= DOCTOR LOGIN =================
    elseif($role=="Doctor"){

        $query=mysqli_query($conn,"SELECT * FROM doctors
        WHERE email='$username' AND status='Approved'");

        if(mysqli_num_rows($query)>0){

            $row=mysqli_fetch_assoc($query);

            if(password_verify($password,$row['password'])){

                $_SESSION['doctor_id']=$row['doctor_id'];
                $_SESSION['doctor_name']=$row['name'];

                header("Location: doctor/dashboard.php");
                exit();

            }else{
                $message="Incorrect Password!";
            }

        }else{
            $message="Doctor not approved or account not found!";
        }
    }

    // ================= ADMIN LOGIN =================
    elseif($role=="Admin"){

        $query=mysqli_query($conn,"SELECT * FROM admin
        WHERE username='$username' AND password='$password'");

        if(mysqli_num_rows($query)>0){

            $_SESSION['admin']=$username;

            header("Location: admin/dashboard.php");
            exit();

        }else{

            $message="Invalid Admin Username or Password!";

        }

    }

}
?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Login</title>

<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/login.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">


</head>

<body>

<div class="login-container">

    <!-- Left Side -->

    <div class="login-left">

        <img src="images/logo.png" class="hospital-logo">

        <h1>Zynovexa</h1>

        <h3>Multispeciality Hospital</h3>

        <p>

            Welcome back!

            Login to continue accessing your appointments,
            medical records and healthcare services.

        </p>

    </div>

    <!-- Right Side -->

    <div class="login-right">

        <div class="login-card">

            <h2>Welcome Back</h2>

            <p class="subtitle">

                Login to your account

            </p>

<?php
if($message!=""){
?>

<div class="error-box">

<?php echo $message; ?>

</div>

<?php
}
?>

<form method="POST" onsubmit="return validateLogin();">

<label>

Login As

</label>

<select name="role" required>

<option value="">Select Role</option>

<option>Patient</option>

<option>Doctor</option>

<option>Admin</option>

</select>

<label>

Email / Username

</label>

<div class="input-group">

<i class="fa-solid fa-user"></i>

<input
type="text"
name="username"
placeholder="Enter Email or Username"
required>

</div>

<label>

Password

</label>

<div class="input-group">

<i class="fa-solid fa-lock"></i>

<input
type="password"
id="password"
name="password"
placeholder="Enter Password"
required>

<span onclick="togglePassword()">

<i class="fa-solid fa-eye" id="eye"></i>

</span>

</div>

<button
type="submit"
name="login">

<i class="fa-solid fa-right-to-bracket"></i>

Login

</button>

</form>

<div class="register-link">

New Patient?

<a href="register.php">

Register Here

</a>

</div>

        </div>

    </div>

</div>
</div>
<div class="form-container">

    <a href="index.php" class="back-home">
        <i class="fa-solid fa-arrow-left"></i>
        Back to Home
    </a>
</div>

<script>

function togglePassword(){

var pass=document.getElementById("password");

var eye=document.getElementById("eye");

if(pass.type=="password")
{
pass.type="text";
eye.classList.remove("fa-eye");
eye.classList.add("fa-eye-slash");
}
else
{
pass.type="password";
eye.classList.remove("fa-eye-slash");
eye.classList.add("fa-eye");
}

}

</script>
<script src="js/script.js"></script>
</body>

</html>