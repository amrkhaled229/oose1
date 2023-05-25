<?php

class Database {
    private $connection;

    public function __construct() {
        include ("../connection.php");

        $this->connection = $connect;

        if (!$this->connection) {
            die("Connection failed: " . mysqli_connect_error());
        }
    }

    public function getTeacher($teacherID) {
        $query = "SELECT * FROM teacher WHERE teacherID = '$teacherID'";
        $result = mysqli_query($this->connection, $query);
        return mysqli_fetch_assoc($result);
    }

    public function updateTeacher($teacherID, $fname, $lname, $username, $password, $phonenum, $age, $certificate, $address, $salary) {
        $query = "UPDATE teacher SET fname = '$fname', lname = '$lname', username = '$username', password = '$password', phonenum = '$phonenum', age = '$age', certificate = '$certificate', address = '$address', salary = '$salary' WHERE teacherID = '$teacherID'";

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

    // Check if the teacher exists before updating
    $existingTeacher = $database->getTeacher($teacherID);
    if (!$existingTeacher) {
        $errorMessage = "Teacher not found!";
    } else {
        // Update the teacher record in the database
        if ($database->updateTeacher($teacherID, $fname, $lname, $username, $password, $phonenum, $age, $certificate, $address, $salary)) {
            $successMessage = "Teacher updated successfully!";
        } else {
            $errorMessage = "Error updating teacher in the database.";
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
   <link rel="stylesheet" href="style.css">
   <title>Update Teacher</title>
</head>
<body>
   <h1>Update Teacher</h1>
   <?php if (isset($successMessage)) : ?>
      <p class="msg"><?php echo $successMessage; ?></p>
   <?php endif; ?>
   <?php if (isset($errorMessage)) : ?>
      <p class="msg" style="color: red;"><?php echo $errorMessage; ?></p>
   <?php endif; ?>
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
      <input type="text" name="age" id="age" required><br>
      <label for="certificate">Certificate:</label>
      <input type="text" name="certificate" id="certificate" required><br>
      <label for="address">Address:</label>
      <input type="text" name="address" id="address" required><br>
      <label for="salary">Salary:</label>
      <input type="text" name="salary" id="salary" required><br>
      <input type="submit" name="submit" value="Update Teacher">
   </form>
   <a href="manage_teachers.php" class="button back">Back</a>
</body>
</html>
