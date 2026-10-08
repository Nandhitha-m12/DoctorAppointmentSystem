<?php
session_start();
include("../config.php");

if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}


/* ================= UPDATE DOCTOR STATUS ================= */

if (isset($_POST['update_status'])) {

    $doctor_id = mysqli_real_escape_string($conn, $_POST['doctor_id']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    mysqli_query($conn, "
        UPDATE doctors
        SET status='$status'
        WHERE doctor_id='$doctor_id'
    ");

    header("Location: view_doctors.php");
    exit();
}


/* ================= DELETE DOCTOR ================= */

if (isset($_GET['delete'])) {

    $doctor_id = mysqli_real_escape_string($conn, $_GET['delete']);

    mysqli_query($conn, "
        DELETE FROM doctors
        WHERE doctor_id='$doctor_id'
    ");

    header("Location: view_doctors.php");
    exit();
}


/* ================= SEARCH DOCTORS ================= */

$search = "";

if (isset($_GET['search'])) {

    $search = mysqli_real_escape_string(
        $conn,
        $_GET['search']
    );

    $result = mysqli_query($conn, "
        SELECT *
        FROM doctors
        WHERE name LIKE '%$search%'
        OR specialization LIKE '%$search%'
        ORDER BY doctor_id DESC
    ");

} else {

    $result = mysqli_query($conn, "
        SELECT *
        FROM doctors
        ORDER BY doctor_id DESC
    ");
}


/* ================= TOTAL DOCTORS ================= */

$total = mysqli_num_rows(
    mysqli_query($conn, "SELECT * FROM doctors")
);

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>Manage Doctors</title>

<link rel="stylesheet" href="../css/style.css">

<style>

* {
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}

body {
    background: #f5f5f5;
    margin: 0;
}

.container {
    width: 95%;
    max-width: 1500px;
    margin: 40px auto;
}


/* ================= TITLE ================= */

h2 {
    text-align: center;
    color: #6f4e8b;
    margin-bottom: 15px;
}

.total {
    text-align: center;
    font-size: 18px;
    margin-bottom: 20px;
    font-weight: bold;
    color: #444;
}


/* ================= SEARCH ================= */

.search-box {
    text-align: center;
    margin-bottom: 25px;
}

.search-box input {
    padding: 10px;
    width: 300px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 14px;
}

.search-box button {
    padding: 10px 18px;
    background: #6f4e8b;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.search-box button:hover {
    background: #563d7c;
}


/* ================= TABLE ================= */

.table-container {
    overflow-x: auto;
}

table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    box-shadow: 0 5px 15px rgba(0,0,0,.1);
}

table th {
    background: #6f4e8b;
    color: white;
    padding: 12px;
    white-space: nowrap;
}

table td {
    padding: 10px;
    text-align: center;
    border-bottom: 1px solid #ddd;
    white-space: nowrap;
}

table tr:hover {
    background: #faf7fd;
}


/* ================= DOCTOR IMAGE ================= */

table img {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    object-fit: cover;
}


/* ================= BUTTON ================= */

.btn {
    display: inline-block;
    padding: 7px 12px;
    border-radius: 5px;
    color: white;
    text-decoration: none;
    border: none;
    cursor: pointer;
}


/* ================= EDIT ================= */

.edit {
    background: #ff9800;
}

.edit:hover {
    background: #e68900;
}


/* ================= DELETE ================= */

.delete {
    background: #dc3545;
}

.delete:hover {
    background: #b02a37;
}


/* ================= SAVE ================= */

.save {
    background: #28a745;
    padding: 6px 12px;
    border: none;
    border-radius: 5px;
    color: white;
    cursor: pointer;
}

.save:hover {
    background: #218838;
}


/* ================= STATUS ================= */

.status-form {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
}

.status-form select {
    padding: 6px;
    border-radius: 5px;
    border: 1px solid #ccc;
}


/* ================= BACK ================= */

.back {
    display: inline-block;
    margin-top: 25px;
    padding: 12px 25px;
    background: #6f4e8b;
    color: white;
    text-decoration: none;
    border-radius: 5px;
}

.back:hover {
    background: #563d7c;
}


/* ================= NO DATA ================= */

.no-data {
    text-align: center;
    padding: 30px;
    background: white;
    color: #666;
}


/* ================= RESPONSIVE ================= */

@media(max-width:700px) {

    .container {
        width: 95%;
        margin-top: 25px;
    }

    .search-box input {
        width: 70%;
    }

    table {
        min-width: 1100px;
    }

}

</style>

</head>

<body>


<div class="container">


<h2>
    Manage Doctors
</h2>


<div class="total">

    Total Doctors :
    <?php echo $total; ?>

</div>


<!-- ================= SEARCH ================= -->

<div class="search-box">

    <form method="GET">

        <input
            type="text"
            name="search"
            value="<?php echo htmlspecialchars($search); ?>"
            placeholder="Search by Name or Specialization">

        <button type="submit">
            Search
        </button>

    </form>

</div>


<!-- ================= TABLE ================= -->

<div class="table-container">

<table>

<tr>

    <th>ID</th>

    <th>Image</th>

    <th>Name</th>

    <th>Email</th>

    <th>Phone</th>

    <th>Specialization</th>

    <th>Qualification</th>

    <th>Experience</th>

    <th>Status</th>

    <th>Edit</th>

    <th>Delete</th>

</tr>


<?php

if (mysqli_num_rows($result) > 0) {

    while ($row = mysqli_fetch_assoc($result)) {

?>


<tr>


<!-- ID -->

<td>

    <?php echo $row['doctor_id']; ?>

</td>


<!-- IMAGE -->

<td>

<?php

if (
    empty($row['image']) ||
    !file_exists("../uploads/doctors/" . $row['image'])
) {

?>

    <img src="../images/default-doctor.png"
         alt="Doctor">

<?php

} else {

?>

    <img
        src="../uploads/doctors/<?php echo htmlspecialchars($row['image']); ?>"
        alt="Doctor">

<?php

}

?>

</td>


<!-- NAME -->

<td>

    Dr.
    <?php
    echo htmlspecialchars($row['name']);
    ?>

</td>


<!-- EMAIL -->

<td>

    <?php
    echo htmlspecialchars($row['email']);
    ?>

</td>


<!-- PHONE -->

<td>

    <?php
    echo htmlspecialchars($row['phone']);
    ?>

</td>


<!-- SPECIALIZATION -->

<td>

    <?php
    echo htmlspecialchars($row['specialization']);
    ?>

</td>


<!-- QUALIFICATION -->

<td>

    <?php
    echo htmlspecialchars($row['qualification']);
    ?>

</td>


<!-- EXPERIENCE -->

<td>

    <?php
    echo htmlspecialchars($row['experience']);
    ?>
    Years

</td>


<!-- STATUS -->

<td>

<form method="POST"
      class="status-form">

    <input
        type="hidden"
        name="doctor_id"
        value="<?php echo $row['doctor_id']; ?>">

    <select name="status">

        <option value="Pending"
            <?php
            if ($row['status'] == "Pending")
                echo "selected";
            ?>>
            Pending
        </option>

        <option value="Approved"
            <?php
            if ($row['status'] == "Approved")
                echo "selected";
            ?>>
            Approved
        </option>

    </select>

    <button
        type="submit"
        name="update_status"
        class="save">

        Save

    </button>

</form>

</td>


<!-- EDIT -->

<td>

<a
    class="btn edit"
    href="edit_doctor.php?id=<?php echo $row['doctor_id']; ?>">

    Edit

</a>

</td>


<!-- DELETE -->

<td>

<a
    class="btn delete"
    href="view_doctors.php?delete=<?php echo $row['doctor_id']; ?>"
    onclick="return confirmDelete();"
    Delete

</a>

</td>


</tr>


<?php

    }

} else {

?>


<tr>

<td colspan="11"
    class="no-data">

    No doctors found.

</td>

</tr>


<?php

}

?>

</table>

</div>


<!-- ================= BACK ================= -->

<center>

<a
    class="back"
    href="dashboard.php">

    ← Back to Dashboard

</a>

</center>


</div>
<script src="../js/script.js"></script>
</body>

</html>