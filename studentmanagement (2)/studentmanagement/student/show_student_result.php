<?php
session_start();

if (!isset($_SESSION['student'])) {
    header('location:../login_form.php');
    exit();
}

// Database connection
$connection = mysqli_connect("localhost", "root", "", "smsdb");
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}

// Retrieve username from the session
$username = $_SESSION['student'];

// Retrieve student details from the 'student' table based on the username
$query = "SELECT * FROM student WHERE username = '$username'";
$result = mysqli_query($connection, $query);

if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    $studentID = $row['studentID'];
    $studentName = $row['fname'] . " " . $row['lname'];
    $studentCourses = $row['courses'];
    $studentLevelType = $row['leveltype'];

    // Retrieve student grades from the 'results' table
    $gradesQuery = "SELECT * FROM results WHERE student_id = '$studentID'";
    $gradesResult = mysqli_query($connection, $gradesQuery);

    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Student Results</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <div class="container">
            <h1>Student Results - <?php echo $studentName; ?></h1>
            <p><strong>Student ID:</strong> <?php echo $studentID; ?></p>
            <p><strong>Courses:</strong> <?php echo $studentCourses; ?></p>
            <p><strong>Level Type:</strong> <?php echo $studentLevelType; ?></p>
            <h2>Grades:</h2>
            <table>
                <tr>
                    <th>Subject</th>
                    <th>Marks</th>
                </tr>
                <?php
                while ($gradesRow = mysqli_fetch_assoc($gradesResult)) {
                    $subject = $gradesRow['subject'];
                    $marks = $gradesRow['marks'];
                    ?>
                    <tr>
                        <td><?php echo $subject; ?></td>
                        <td><?php echo $marks; ?></td>
                    </tr>
                    <?php
                }
                ?>
            </table>
            <div class="logout-button">
                <a href="../login/logout.php">Logout</a>
            </div>
        </div>
    </body>
    </html>
    <?php
} else {
    // Student not found in the 'student' table
    echo "Student results not added";
}

mysqli_close($connection);
?>
