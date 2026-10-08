<?php
include 'config.php';
include 'includes/header.php';
?>

<link rel="stylesheet" href="css/specialties.css">

<!-- ================= HERO ================= -->

<section class="speciality-hero">

    <div class="speciality-overlay"></div>

    <div class="hero-content">

        <h1>Our Medical Specialties</h1>

        <p>
            Providing expert healthcare across multiple medical specialties
            with experienced doctors and modern treatment facilities.
        </p>

        <div class="breadcrumb">

            <a href="index.php">Home</a>

            <span> / </span>

            <span>Specialties</span>

        </div>

    </div>

</section>

<!-- ================= SPECIALTIES ================= -->

<section class="speciality-section">

    <h2 class="section-title">

        Our Departments

    </h2>

    <div class="speciality-grid">

<?php

$result = mysqli_query($conn,
"SELECT DISTINCT specialization
FROM doctors
ORDER BY specialization ASC");

while($row=mysqli_fetch_assoc($result))
{

$specialization = $row['specialization'];

$icon="fa-user-doctor";

$description="Expert medical consultation and quality healthcare services.";

/* ---------- Icons ---------- */

if($specialization=="Cardiology")
{
    $icon="fa-heart-pulse";
    $description="Advanced diagnosis and treatment for heart diseases.";
}

elseif($specialization=="Neurology")
{
    $icon="fa-brain";
    $description="Comprehensive care for brain and nervous system disorders.";
}

elseif($specialization=="Orthopedics")
{
    $icon="fa-bone";
    $description="Treatment for bones, joints, muscles and sports injuries.";
}

elseif($specialization=="Pediatrics")
{
    $icon="fa-baby";
    $description="Complete healthcare services for infants and children.";
}

elseif($specialization=="Gynecology")
{
    $icon="fa-person-pregnant";
    $description="Women's healthcare, maternity and pregnancy care.";
}

elseif($specialization=="General Medicine")
{
    $icon="fa-stethoscope";
    $description="Diagnosis and treatment for common health conditions.";
}

elseif($specialization=="Ophthalmology")
{
    $icon="fa-eye";
    $description="Advanced eye care and vision correction services.";
}

elseif($specialization=="ENT")
{
    $icon="fa-ear-listen";
    $description="Expert treatment for ear, nose and throat disorders.";
}

elseif($specialization=="Dermatology")
{
    $icon="fa-hand-sparkles";
    $description="Comprehensive skin, hair and nail care treatments.";
}

elseif($specialization=="Emergency")
{
    $icon="fa-truck-medical";
    $description="24×7 emergency medical care with rapid response.";
}

?>

<div class="speciality-card">

    <i class="fa-solid <?php echo $icon; ?>"></i>

    <h3>

        <?php echo $specialization; ?>

    </h3>

    <p>

        <?php echo $description; ?>

    </p>

    <a href="doctors.php?specialization=<?php echo urlencode($specialization); ?>"
       class="view-btn">

       View Doctors

    </a>

</div>

<?php

}

?>

    </div>

</section>
<!-- ================= WHY CHOOSE OUR DEPARTMENTS ================= -->

<section class="why">

    <h2 class="section-title">

        Why Choose Our Departments?

    </h2>

    <div class="card-container">

        <div class="card">

            <i class="fa-solid fa-user-doctor"></i>

            <h3>Expert Specialists</h3>

            <p>

                Our highly qualified doctors provide expert diagnosis,
                treatment, and compassionate healthcare.

            </p>

        </div>

        <div class="card">

            <i class="fa-solid fa-microscope"></i>

            <h3>Advanced Technology</h3>

            <p>

                Modern diagnostic equipment and cutting-edge medical
                technology ensure accurate treatment.

            </p>

        </div>

        <div class="card">

            <i class="fa-solid fa-heart-circle-check"></i>

            <h3>Patient-Centered Care</h3>

            <p>

                Every treatment plan is personalized to provide
                safe, comfortable, and effective healthcare.

            </p>

        </div>

        <div class="card">

            <i class="fa-solid fa-truck-medical"></i>

            <h3>24×7 Emergency</h3>

            <p>

                Emergency medical services are available round the clock
                for immediate patient care.

            </p>

        </div>

    </div>

</section>

<!-- ================= HOSPITAL STATISTICS ================= -->

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

                <h2>10</h2>

                <h3>Departments</h3>

                <p>Comprehensive Healthcare</p>

            </div>

        </div>

    </div>

</section>

<!-- ================= CALL TO ACTION ================= -->

<section class="about-cta">

    <h2>

        Need Expert Medical Care?

    </h2>

    <p>

        Our experienced specialists are here to provide the best
        healthcare for you and your family.

    </p>

    <a href="register.php" class="btn">

        <i class="fa-solid fa-calendar-check"></i>

        Book Appointment

    </a>

</section>
<!-- ================= FOOTER ================= -->

<?php
include 'includes/footer.php';
?>