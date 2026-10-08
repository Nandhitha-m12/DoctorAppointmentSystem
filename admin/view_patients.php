<?php
session_start();
include("../config.php");

if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}

/* ================= DELETE PATIENT ================= */

if (isset($_GET['delete'])) {

    $patient_id = mysqli_real_escape_string($conn, $_GET['delete']);

    mysqli_query($conn,
        "DELETE FROM patients WHERE patient_id='$patient_id'"
    );

    header("Location: view_patients.php");
    exit();
}


/* ================= SEARCH ================= */

$search = "";

if (isset($_GET['search'])) {

    $search = mysqli_real_escape_string($conn, $_GET['search']);

    $result = mysqli_query($conn, "
        SELECT *
        FROM patients
        WHERE name LIKE '%$search%'
        OR email LIKE '%$search%'
        OR phone LIKE '%$search%'
        ORDER BY patient_id DESC
    ");

} else {

    $result = mysqli_query($conn, "
        SELECT *
        FROM patients
        ORDER BY patient_id DESC
    ");
}


/* ================= TOTAL PATIENTS ================= */

$totalQuery = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total FROM patients"
);

$totalRow = mysqli_fetch_assoc($totalQuery);

$total = $totalRow['total'];

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Manage Patients</title>

    <link rel="stylesheet" href="../css/style.css">

    <!-- Google Font -->

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

        * {
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            margin: 0;
            background: #f7f5fa;
        }


        /* ================= CONTAINER ================= */

        .container {
            width: 95%;
            max-width: 1500px;
            margin: 40px auto 60px;
        }


        /* ================= HEADER ================= */

        .page-header {
            background: #ffffff;
            padding: 25px 30px;
            border-radius: 18px;

            box-shadow: 0 8px 25px rgba(0,0,0,.08);

            margin-bottom: 25px;
        }

        .page-header h2 {
            margin: 0;

            color: #2d2340;

            font-size: 28px;

            font-weight: 600;
        }

        .page-header h2 i {
            color: #6b4c8b;
            margin-right: 8px;
        }

        .page-header p {
            margin-top: 8px;

            color: #777;

            font-size: 14px;
        }


        /* ================= TOTAL ================= */

        .total-box {

            display: flex;

            align-items: center;

            gap: 15px;

            background: #f0e9f7;

            color: #6b4c8b;

            padding: 15px 20px;

            border-radius: 12px;

            margin-bottom: 25px;

            font-weight: 600;
        }

        .total-box i {
            font-size: 25px;
        }


        /* ================= SEARCH ================= */

        .search-box {

            background: #ffffff;

            padding: 20px;

            border-radius: 15px;

            box-shadow: 0 8px 25px rgba(0,0,0,.06);

            margin-bottom: 25px;
        }

        .search-box form {

            display: flex;

            gap: 10px;

            justify-content: center;
        }

        .search-box input {

            width: 400px;

            padding: 12px 15px;

            border: 1px solid #ddd;

            border-radius: 8px;

            font-size: 14px;

            outline: none;
        }

        .search-box input:focus {

            border-color: #6b4c8b;

        }

        .search-btn {

            padding: 12px 22px;

            background: #6b4c8b;

            color: white;

            border: none;

            border-radius: 8px;

            cursor: pointer;

            font-size: 14px;

            font-weight: 500;
        }

        .search-btn:hover {

            background: #563975;

        }


        /* ================= TABLE CARD ================= */

        .table-card {

            background: white;

            padding: 20px;

            border-radius: 18px;

            box-shadow: 0 8px 25px rgba(0,0,0,.08);

            overflow-x: auto;
        }


        /* ================= TABLE ================= */

        table {

            width: 100%;

            border-collapse: collapse;

            min-width: 950px;
        }

        th {

            background: #6b4c8b;

            color: white;

            padding: 14px 12px;

            font-size: 13px;

            font-weight: 600;

            text-align: center;
        }

        th:first-child {

            border-radius: 10px 0 0 0;
        }

        th:last-child {

            border-radius: 0 10px 0 0;
        }

        td {

            padding: 14px 12px;

            text-align: center;

            border-bottom: 1px solid #eee;

            color: #555;

            font-size: 13px;
        }

        tr:hover td {

            background: #faf8fc;
        }


        /* ================= PATIENT NAME ================= */

        .patient-name {

            color: #2d2340;

            font-weight: 600;
        }


        /* ================= BUTTONS ================= */

        .btn {

            display: inline-flex;

            align-items: center;

            justify-content: center;

            gap: 6px;

            padding: 7px 13px;

            border-radius: 7px;

            color: white;

            text-decoration: none;

            font-size: 12px;

            font-weight: 500;

            transition: .3s;
        }

        .history {

            background: #28a745;
        }

        .history:hover {

            background: #218838;

            transform: translateY(-2px);
        }

        .delete {

            background: #dc3545;
        }

        .delete:hover {

            background: #b02a37;

            transform: translateY(-2px);
        }


        /* ================= NO PATIENTS ================= */

        .no-patients {

            text-align: center;

            padding: 50px 20px;

            color: #777;
        }

        .no-patients i {

            font-size: 45px;

            color: #8d63b8;

            margin-bottom: 15px;
        }

        .no-patients h3 {

            color: #2d2340;

            margin-bottom: 8px;
        }


        /* ================= BACK BUTTON ================= */

        .back-section {

            text-align: center;

            margin-top: 30px;
        }

        .back {

            display: inline-flex;

            align-items: center;

            gap: 8px;

            background: #6b4c8b;

            color: white;

            padding: 11px 22px;

            border-radius: 8px;

            text-decoration: none;

            font-size: 14px;

            font-weight: 500;

            transition: .3s;
        }

        .back:hover {

            background: #563975;

            transform: translateY(-2px);
        }


        /* ================= RESPONSIVE ================= */

        @media(max-width: 700px) {

            .container {

                width: 95%;

                margin-top: 25px;
            }

            .page-header h2 {

                font-size: 23px;
            }

            .search-box form {

                flex-direction: column;
            }

            .search-box input {

                width: 100%;
            }

            .search-btn {

                width: 100%;
            }

        }

    </style>

</head>


<body>


<div class="container">


    <!-- ================= HEADER ================= -->

    <div class="page-header">

        <h2>

            <i class="fa-solid fa-users"></i>

            Manage Patients

        </h2>

        <p>
            View, search and manage registered patients.
        </p>

    </div>


    <!-- ================= TOTAL ================= -->

    <div class="total-box">

        <i class="fa-solid fa-user-group"></i>

        Total Patients:
        <?php echo $total; ?>

    </div>


    <!-- ================= SEARCH ================= -->

    <div class="search-box">

        <form method="GET">

            <input
                type="text"
                name="search"
                value="<?php echo htmlspecialchars($search); ?>"
                placeholder="Search by Name, Email or Phone">

            <button
                type="submit"
                class="search-btn">

                <i class="fa-solid fa-magnifying-glass"></i>

                Search

            </button>

        </form>

    </div>


    <!-- ================= TABLE ================= -->

    <div class="table-card">

        <?php if (mysqli_num_rows($result) > 0) { ?>


        <table>

            <tr>

                <th>ID</th>

                <th>Name</th>

                <th>Email</th>

                <th>Phone</th>

                <th>Date of Birth</th>

                <th>Gender</th>

                <th>Appointments</th>

                <th>Delete</th>

            </tr>


            <?php while ($row = mysqli_fetch_assoc($result)) { ?>


            <tr>

                <!-- ID -->

                <td>

                    <?php
                    echo htmlspecialchars($row['patient_id']);
                    ?>

                </td>


                <!-- NAME -->

                <td>

                    <span class="patient-name">

                        <?php
                        echo htmlspecialchars($row['name']);
                        ?>

                    </span>

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


                <!-- DOB -->

                <td>

                    <?php
                    echo htmlspecialchars($row['dob']);
                    ?>

                </td>


                <!-- GENDER -->

                <td>

                    <?php
                    echo htmlspecialchars($row['gender']);
                    ?>

                </td>


                <!-- APPOINTMENTS -->

                <td>

                    <a
                        href="patient_appointments.php?id=<?php echo $row['patient_id']; ?>"
                        class="btn history">

                        <i class="fa-solid fa-calendar-check"></i>

                        View

                    </a>

                </td>


                <!-- DELETE -->

                <td>

                    <a
                        href="view_patients.php?delete=<?php echo $row['patient_id']; ?>"
                        class="btn delete"

                        onclick="return confirmDelete();"

                        <i class="fa-solid fa-trash"></i>

                        Delete

                    </a>

                </td>

            </tr>


            <?php } ?>


        </table>


        <?php } else { ?>


        <div class="no-patients">

            <i class="fa-solid fa-user-slash"></i>

            <h3>No Patients Found</h3>

            <p>
                There are no patients matching your search.
            </p>

        </div>


        <?php } ?>

    </div>


    <!-- ================= BACK ================= -->

    <div class="back-section">

        <a
            href="dashboard.php"
            class="back">

            <i class="fa-solid fa-arrow-left"></i>

            Back to Dashboard

        </a>

    </div>


</div>

<script src="../js/script.js"></script>
</body>

</html>