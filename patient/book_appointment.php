<?php
session_start();
include("../config.php");

if (!isset($_SESSION['patient_id'])) {
    header("Location: ../login.php");
    exit();
}

$patient_id = $_SESSION['patient_id'];
$message = "";

if (isset($_POST['book'])) {

    $doctor_id = $_POST['doctor_id'];
    $appointment_date = $_POST['appointment_date'];
    $appointment_time = $_POST['appointment_time'];
    $symptoms = mysqli_real_escape_string($conn, $_POST['symptoms']);

    $insert = mysqli_query($conn, "INSERT INTO appointments
        (patient_id, doctor_id, appointment_date, appointment_time, symptoms)
        VALUES
        ('$patient_id', '$doctor_id', '$appointment_date', '$appointment_time', '$symptoms')");

    if ($insert) {
        $message = "Appointment booked successfully.";
    } else {
        $message = "Something went wrong.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Book Appointment</title>

    <link rel="stylesheet" href="../css/style.css">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <link rel="preconnect"
          href="https://fonts.googleapis.com">

    <link rel="preconnect"
          href="https://fonts.gstatic.com"
          crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
          rel="stylesheet">


    <style>

        * {
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #f5f5f5;
            font-family: 'Poppins', sans-serif;
        }

        .container {
            width: 700px;
            margin: 60px auto;
            background: #fff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,.15);
        }

        /* ================= BACK BUTTON ================= */

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;

            padding: 10px 18px;

            background: #6b4c8b;
            color: #fff;

            text-decoration: none;

            border-radius: 8px;

            font-size: 14px;
            font-weight: 500;

            margin-bottom: 25px;

            transition: .3s;
        }

        .back-btn:hover {
            background: #563975;
            transform: translateX(-3px);
        }


        /* ================= HEADING ================= */

        h2 {
            text-align: center;
            color: #6f4e8b;
            margin-bottom: 30px;
            font-weight: 600;
        }


        /* ================= LABEL ================= */

        label {
            font-weight: 600;
            display: block;
            margin-top: 18px;
            color: #333;
        }


        /* ================= INPUTS ================= */

        input,
        select,
        textarea {

            width: 100%;

            padding: 12px;

            margin-top: 8px;

            border: 1px solid #ccc;

            border-radius: 8px;

            font-size: 15px;

            outline: none;

            transition: .3s;
        }

        input:focus,
        select:focus,
        textarea:focus {

            border-color: #6b4c8b;

            box-shadow:
                0 0 0 3px rgba(107,76,139,.10);
        }


        /* ================= TEXTAREA ================= */

        textarea {
            height: 120px;
            resize: none;
        }


        /* ================= BOOK BUTTON ================= */

        button {

            margin-top: 25px;

            width: 100%;

            padding: 14px;

            background: #7b5a8d;

            color: #fff;

            border: none;

            border-radius: 8px;

            font-size: 17px;

            font-weight: 600;

            cursor: pointer;

            transition: .3s;
        }

        button:hover {

            background: #654676;

            transform: translateY(-2px);
        }


        /* ================= SUCCESS MESSAGE ================= */

        .success {

            background: #d4edda;

            color: #218838;

            padding: 12px;

            border-radius: 6px;

            margin-bottom: 20px;

            text-align: center;

            font-size: 14px;

        }


        /* ================= RESPONSIVE ================= */

        @media(max-width: 750px) {

            .container {

                width: 90%;

                padding: 25px;

            }

        }

    </style>

</head>


<body>


<div class="container">


    <!-- ================= BACK TO DASHBOARD ================= -->

    <a href="dashboard.php" class="back-btn">

        <i class="fa-solid fa-arrow-left"></i>

        Back to Dashboard

    </a>


    <!-- ================= HEADING ================= -->

    <h2>

        <i class="fa-solid fa-calendar-check"></i>

        Book Appointment

    </h2>


    <!-- ================= MESSAGE ================= -->

    <?php

    if ($message != "") {

        echo "<div class='success'>$message</div>";

    }

    ?>


    <!-- ================= FORM ================= -->

    <form method="POST" onsubmit="return confirmBooking();">


        <!-- DOCTOR -->

        <label>
            Select Doctor
        </label>

        <select name="doctor_id" required>

            <option value="">
                Choose Doctor
            </option>

            <?php

            $doctor = mysqli_query(
                $conn,
                "SELECT * FROM doctors WHERE status='Approved'"
            );

            while ($row = mysqli_fetch_assoc($doctor)) {

            ?>

                <option value="<?php echo $row['doctor_id']; ?>">

                    Dr. <?php echo htmlspecialchars($row['name']); ?>

                    (<?php echo htmlspecialchars($row['specialization']); ?>)

                </option>

            <?php

            }

            ?>

        </select>


        <!-- DATE -->

        <label>
            Appointment Date
        </label>

        <input
            type="date"
            name="appointment_date"
            required>


        <!-- TIME -->

        <label>
            Appointment Time
        </label>

        <input
            type="time"
            name="appointment_time"
            required>


        <!-- SYMPTOMS -->

        <label>
            Symptoms
        </label>

        <textarea
            name="symptoms"
            placeholder="Describe your health problem..."
            required></textarea>


        <!-- BOOK -->

        <button
            type="submit"
            name="book">

            <i class="fa-solid fa-calendar-check"></i>

            Book Appointment

        </button>

    </form>


</div>

<script src="../js/script.js"></script>
</body>

</html>