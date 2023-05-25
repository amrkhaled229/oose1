<?php
session_start();

if (!isset($_SESSION['student'])) {
    header('location:../login_form.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Welcome to the School Portal</h1>
        <div class="button-container">
            <a href="check_fees.php" class="button">Check Fees</a>
            <a href="show_student_result.php" class="button">Show Student Result</a>
            <a href="check_attendance.php" class="button">Check Attendance</a>
        </div>
        <div class="logout-button">
            <a href="../login/logout.php">Logout</a>
        </div>
    </div>
</body>
</html>

