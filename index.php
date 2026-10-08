<?php
include 'config.php';
include 'includes/header.php';
?>

<!-- ================= HERO SECTION ================= -->
<section class="hero">

    <div class="hero-overlay"></div>

    <div class="hero-container">

        <div class="hero-content">

            <p class="welcome-text">
                Welcome to
            </p>

            <h1>
                Zynovexa <br>
                Multispeciality Hospital
            </h1>

            <h3>
                Healing Beyond Care, Trusted by Every Family.
            </h3>

            <p>
                Providing world-class healthcare with experienced doctors,
                advanced medical technology, and compassionate patient care
                available 24×7.
            </p>

            <div class="hero-buttons">

                <a href="register.php" class="btn">
                    <i class="fa-solid fa-calendar-check"></i>
                    Book Appointment
                </a>

                <a href="doctors.php" class="btn btn-outline">
                    <i class="fa-solid fa-user-doctor"></i>
                    Find Doctors
                </a>

            </div>

            <div class="hero-features">

                <div>
                    <i class="fa-solid fa-truck-medical"></i>
                    <span>24×7 Emergency</span>
                </div>

                <div>
                    <i class="fa-solid fa-award"></i>
                    <span>Quality Care</span>
                </div>

                <div>
                    <i class="fa-solid fa-user-doctor"></i>
                    <span>15+ Specialists</span>
                </div>

            </div>

        </div>

    </div>

</section>


<!-- ================= COUNTER SECTION ================= -->

<section class="stats-section">

    <div class="stats-wrapper">

        <div class="stats-card">
            <div class="icon purple">
                <i class="fa-solid fa-user-doctor"></i>
            </div>

            <div class="stats-content">
                <h2>15+</h2>
                <h3>Doctors</h3>
                <p>Experienced Specialists</p>
            </div>
        </div>

        <div class="stats-card">
            <div class="icon green">
                <i class="fa-solid fa-users"></i>
            </div>

            <div class="stats-content">
                <h2>10K+</h2>
                <h3>Patients</h3>
                <p>Happy & Healthy</p>
            </div>
        </div>

        <div class="stats-card">
            <div class="icon blue">
                <i class="fa-solid fa-calendar-check"></i>
            </div>

            <div class="stats-content">
                <h2>25K+</h2>
                <h3>Appointments</h3>
                <p>Successfully Completed</p>
            </div>
        </div>

        <div class="stats-card">
            <div class="icon pink">
                <i class="fa-solid fa-hospital"></i>
            </div>

            <div class="stats-content">
                <h2>10+</h2>
                <h3>Departments</h3>
                <p>Wide Range of Services</p>
            </div>
        </div>

    </div>

</section>

<!-- ================= ABOUT ================= -->

<section class="about-home">

    <div class="about-image">

        <img src="images/hospital-bg.png" alt="Hospital">

    </div>

    <div class="about-content">

        <h2>About Zynovexa Hospital</h2>

        <p>

            Zynovexa Multispeciality Hospital is committed to delivering
            exceptional healthcare with modern infrastructure,
            experienced doctors and advanced medical technology.

            We provide high-quality treatment across multiple
            specialities while ensuring compassionate patient care.

        </p>

        <a href="about.php" class="btn">

            Read More

        </a>

    </div>

</section>


<!-- ================= SPECIALITIES ================= -->

<section class="specialities">

<h2 class="section-title">

Our Medical Specialities

</h2>

<div class="card-container">

<?php

$result=mysqli_query($conn,"
SELECT DISTINCT specialization
FROM doctors
LIMIT 6
");

while($row=mysqli_fetch_assoc($result))
{

?>

<div class="card">

<i class="fa-solid fa-stethoscope"></i>

<h3>

<?php echo $row['specialization']; ?>

</h3>

<p>

Expert medical consultation and treatment.

</p>

</div>

<?php

}

?>

</div>

</section>


<!-- ================= DOCTORS ================= -->

<section class="doctors">

<h2 class="section-title">

Our Medical Experts

</h2>

<div class="card-container">

<?php

$doctor=mysqli_query($conn,"
SELECT *
FROM doctors
LIMIT 6
");

while($row=mysqli_fetch_assoc($doctor))
{

?>

<div class="doctor-card">

<?php

if($row['image']!="")
{

?>

<img src="uploads/doctors/<?php echo $row['image']; ?>">

<?php

}

else

{

?>

<img src="images/default-doctor.png">

<?php

}

?>

<h3>

Dr. <?php echo $row['name']; ?>

</h3>

<p>

<?php echo $row['specialization']; ?>

</p>

<p>

<?php echo $row['qualification']; ?>

</p>

<p>

<?php echo $row['experience']; ?> Years Experience

</p>

</div>

<?php

}

?>

</div>

</section>


<!-- ================= WHY CHOOSE US ================= -->

<section class="why">

<h2 class="section-title">

Why Choose Zynovexa?

</h2>

<div class="card-container">

<div class="card">

<i class="fa-solid fa-user-doctor"></i>

<h3>Experienced Doctors</h3>

<p>

Highly qualified specialists with years of experience.

</p>

</div>

<div class="card">

<i class="fa-solid fa-calendar-check"></i>

<h3>Easy Appointment</h3>

<p>

Book appointments online anytime.

</p>

</div>

<div class="card">

<i class="fa-solid fa-hospital"></i>

<h3>Modern Facilities</h3>

<p>

Advanced medical equipment and technology.

</p>

</div>

<div class="card">

<i class="fa-solid fa-truck-medical"></i>

<h3>24×7 Emergency</h3>

<p>

Emergency services available around the clock.

</p>

</div>

</div>

</section>


<?php
include 'includes/footer.php';
?>