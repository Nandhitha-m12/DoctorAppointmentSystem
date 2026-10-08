<?php
include 'config.php';
include 'includes/header.php';

$specialization = "";

if(isset($_GET['specialization']))
{
    $specialization = mysqli_real_escape_string($conn,$_GET['specialization']);
}
?>

<link rel="stylesheet" href="css/doctors.css">

<!-- ================= HERO ================= -->

<section class="doctor-hero">

    <div class="doctor-overlay"></div>

    <div class="hero-content">

        <h1>Meet Our Expert Doctors</h1>

        <p>

            Our experienced specialists are committed to providing
            exceptional healthcare with compassion and advanced
            medical expertise.

        </p>

        <div class="breadcrumb">

            <a href="index.php">Home</a>

            <span> / </span>

            <span>Doctors</span>

        </div>

    </div>

</section>

<!-- ================= SEARCH ================= -->

<section class="doctor-search">

<div class="search-box">

<form method="GET" action="doctors.php">

<input
type="text"
name="search"
placeholder="Search Doctor by Name..."
value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">

<select name="specialization">

<option value="">All Departments</option>

<?php

$result=mysqli_query($conn,
"SELECT DISTINCT specialization
FROM doctors
ORDER BY specialization");

while($row=mysqli_fetch_assoc($result))
{

?>

<option

value="<?php echo $row['specialization']; ?>"

<?php

if(isset($_GET['specialization']) &&
$_GET['specialization']==$row['specialization'])

echo "selected";

?>

>

<?php echo $row['specialization']; ?>

</option>

<?php

}

?>

</select>

<button type="submit">

<i class="fa-solid fa-magnifying-glass"></i>

Search

</button>

</form>

</div>

</section>

<!-- ================= DOCTORS ================= -->

<section class="doctor-section">

<h2 class="section-title">

<?php

if($specialization!="")
{
    echo $specialization." Specialists";
}
else
{
    echo "Our Medical Experts";
}

?>

</h2>

<div class="doctor-grid">
<?php

$where = array();

if(isset($_GET['search']) && $_GET['search'] != "")
{
    $search = mysqli_real_escape_string($conn,$_GET['search']);
    $where[] = "name LIKE '%$search%'";
}

if(isset($_GET['specialization']) && $_GET['specialization'] != "")
{
    $spec = mysqli_real_escape_string($conn,$_GET['specialization']);
    $where[] = "specialization='$spec'";
}

$sql = "SELECT * FROM doctors";

if(count($where) > 0)
{
    $sql .= " WHERE ".implode(" AND ",$where);
}

$sql .= " ORDER BY name ASC";

$doctor = mysqli_query($conn,$sql);

if(mysqli_num_rows($doctor)>0)
{

while($row=mysqli_fetch_assoc($doctor))
{

?>

<div class="doctor-card">

    <div class="doctor-image">

<?php

if(!empty($row['image']))
{

?>

<img src="uploads/doctors/<?php echo $row['image']; ?>" alt="Doctor">

<?php

}
else
{

?>

<img src="images/default-doctor.png" alt="Doctor">

<?php

}

?>

    </div>

    <div class="doctor-info">

        <h3>

            Dr. <?php echo $row['name']; ?>

        </h3>

        <span class="speciality">

            <?php echo $row['specialization']; ?>

        </span>

        <p>

            <i class="fa-solid fa-graduation-cap"></i>

            <?php echo $row['qualification']; ?>

        </p>

        <p>

            <i class="fa-solid fa-briefcase-medical"></i>

            <?php echo $row['experience']; ?>

            Years Experience

        </p>

        <p>

            <i class="fa-solid fa-envelope"></i>

            <?php echo $row['email']; ?>

        </p>
<div class="doctor-buttons">

    <a href="register.php" class="book-btn">
        <i class="fa-solid fa-calendar-check"></i>
        Book Appointment
    </a>

</div>


    </div>

</div>

<?php

}

}
else
{

?>

<div class="no-doctor">

<i class="fa-solid fa-user-doctor"></i>

<h2>No Doctors Found</h2>

<p>

No doctors are available for the selected department or search.

</p>

<a href="doctors.php" class="book-btn">

View All Doctors

</a>

</div>

<?php

}

?>

</div>

</section>

