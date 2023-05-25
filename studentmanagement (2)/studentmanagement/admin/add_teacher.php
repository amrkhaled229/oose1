<?php

class TeacherManager {
    private $errors = array();
    private $connection;

    public function __construct() {
        $this->connection = mysqli_connect("localhost", "root", "", "smsdb");

        // Check for connection errors
        if (!$this->connection) {
            die("Connection failed: " . mysqli_connect_error());
        }
    }

    public function addTeacher() {
        if (isset($_POST['submit'])) {
            // Validate form inputs
            $teacherID = $_POST['teacherID'];
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $username = $_POST['username'];
            $password = $_POST['password'];
            $phonenum = $_POST['phonenum'];
            $age = $_POST['age'];
            $certificate = $_POST['certificate'];
            $address = $_POST['address'];
            $salary = $_POST['salary'];

            // Perform input validation
            if (empty($teacherID)) {
                $this->errors[] = "Teacher ID is required.";
            }

            // Add validation for other fields

            // If there are no validation errors, proceed with database insertion
            if (empty($this->errors)) {
                // Insert into teacher table
                $query = "INSERT INTO teacher (teacherID, fname, lname, username, password, phonenum, age, certificate, address, salary)
                          VALUES ('$teacherID', '$fname', '$lname', '$username', '$password', '$phonenum', '$age', '$certificate', '$address', '$salary')";

                if (mysqli_query($this->connection, $query)) {
                    // Insert into user table
                    $userQuery = "INSERT INTO user (username, password, role)
                                  VALUES ('$username', '$password', 'teacher')";

                    if (mysqli_query($this->connection, $userQuery)) {
                        mysqli_close($this->connection);
                        header("Location: add_teacher.php?success=1");
                        exit();
                    } else {
                        $this->errors[] = "Error inserting data into the user table: " . mysqli_error($this->connection);
                    }
                } else {
                    $this->errors[] = "Error inserting data into the teacher table: " . mysqli_error($this->connection);
                }
            }
        }
    }

    public function displayErrors() {
        if (!empty($this->errors)) {
            echo '<div class="error-msg">';
            foreach ($this->errors as $error) {
                echo '<p>' . $error . '</p>';
            }
            echo '</div>';
        }
    }

    public function displaySuccessMessage() {
        if (isset($_GET['success']) && $_GET['success'] == 1) {
            echo '<p class="msg">Teacher added successfully!</p>';
        }
    }

    public function closeConnection() {
        mysqli_close($this->connection);
    }
}

$teacherManager = new TeacherManager();
$teacherManager->addTeacher();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Add Teacher</title>
</head>

<body>
    <h1>Add Teacher</h1>
    <?php $teacherManager->displayErrors(); ?>
    <form method="POST">
        <label for="teacherID">Teacher ID:</label>
        <input type="text" name="teacherID" id="teacherID" required><br>

        <label for="fname">First Name:</label>
        <input type="text" name="fname" id="fname" required><br>

        <label for="lname">Last Name:</label>
        <input type="text" name="lname" id="lname" required><br>

        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br>

        <label for="phonenum">Phone Number:</label>
        <input type="text" name="phonenum" id="phonenum" required><br>

        <label for="age">Age:</label>
        <input type="number" name="age" id="age" required><br>

        <label for="certificate">Certificate:</label>
        <input type="text" name="certificate" id="certificate" required><br>

        <label for="address">Address:</label>
        <input type="text" name="address" id="address" required><br>

        <label for="salary">Salary:</label>
        <input type="number" name="salary" id="salary" required><br>

        <input type="submit" name="submit" value="Add Teacher">
        <?php $teacherManager->displaySuccessMessage(); ?>
    </form>
</body>

</html>
