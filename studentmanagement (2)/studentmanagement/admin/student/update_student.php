<?php

class Database {
    private $connection;

    public function __construct() {
        include ("../../connection.php");

        $this->connection = $connect;

        if (!$this->connection) {
            die("Connection failed: " . mysqli_connect_error());
        }
    }

    public function getStudent($studentID) {
        $query = "SELECT * FROM student WHERE studentID = '$studentID'";
        $result = mysqli_query($this->connection, $query);
        return mysqli_fetch_assoc($result);
    }

    public function updateStudent($studentID, $username, $password, $address, $phonenum, $fname, $lname, $age, $courses, $leveltype) {
        $query = "UPDATE student SET username = '$username', password = '$password', address = '$address', phonenum = '$phonenum', fname = '$fname', lname = '$lname', age = '$age', courses = '$courses', leveltype = '$leveltype' WHERE studentID = '$studentID'";

        if (mysqli_query($this->connection, $query)) {
            return true;
        } else {
            return false;
        }
    }

    public function closeConnection() {
        mysqli_close($this->connection);
    }
}

$database = new Database();

if (isset($_POST['submit'])) {
    $studentID = $_POST['studentID'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $address = $_POST['address'];
    $phonenum = $_POST['phonenum'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $age = $_POST['age'];
    $courses = $_POST['courses'];
    $leveltype = $_POST['leveltype'];

    // Check if the student exists before updating
    $existingStudent = $database->getStudent($studentID);
    if (!$existingStudent) {
        $errorMessage = "Student not found!";
    } else {
        // Update the student record in the database
        if ($database->updateStudent($studentID, $username, $password, $address, $phonenum, $fname, $lname, $age, $courses, $leveltype)) {
            $successMessage = "Student updated successfully!";
        } else {
            $errorMessage = "Error updating student in the database.";
        }
    }

    $database->closeConnection();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="../style.css">
   <title>Update Student</title>
</head>
<body>
   <h1>Update Student</h1>
   <?php if (isset($successMessage)) : ?>
      <p class="msg"><?php echo $successMessage; ?></p>
   <?php endif; ?>
   <?php if (isset($errorMessage)) : ?>
      <p class="msg" style="color: red;"><?php echo $errorMessage; ?></p>
   <?php endif; ?>
   <form method="POST">
      <label for="studentID">Student ID:</label>
      <input type="text" name="studentID" id="studentID" required><br>
      <label for="username">Username:</label>
      <input type="text" name="username" id="username" required><br>
      <label for="password">Password:</label>
      <input type="password" name="password" id="password" required><br>
      <label for="address">Address:</label>
      <input type="text" name="address" id="address" required><br>
      <label for="phonenum">Phone Number:</label>
      <input type="text" name="phonenum" id="phonenum" required><br>
      <label for="fname">First Name:</label>
      <input type="text" name="fname" id="fname" required><br>
      <label for="lname">Last Name:</label>
      <input type="text" name="lname" id="lname" required><br>
      <label for="age">Age:</label>
      <input type="text" name="age" id="age" required><br>
      <label for="courses">Courses:</label>
      <input type="text" name="courses" id="courses" required><br>
      <label for="leveltype">Level Type:</label>
      <input type="text" name="leveltype" id="leveltype" required><br>
      <input type="submit" name="submit" value="Update Student">
   </form>
   <a href="manage_student.php" class="button back">Back</a>
</body>
</html>
