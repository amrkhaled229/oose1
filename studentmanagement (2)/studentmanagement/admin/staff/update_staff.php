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

    public function getStaff($staffID) {
        $query = "SELECT * FROM staff WHERE staffID = '$staffID'";
        $result = mysqli_query($this->connection, $query);
        return mysqli_fetch_assoc($result);
    }

    public function updateStaff($staffID, $username, $password, $address, $phonenum, $fname, $lname, $age, $position, $salary) {
        $query = "UPDATE staff SET username = '$username', password = '$password', address = '$address', phonenum = '$phonenum', fname = '$fname', lname = '$lname', age = '$age', position = '$position', salary = '$salary' WHERE staffID = '$staffID'";

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
    $staffID = $_POST['staffID'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $address = $_POST['address'];
    $phonenum = $_POST['phonenum'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $age = $_POST['age'];
    $position = $_POST['position'];
    $salary = $_POST['salary'];

    // Check if the staff exists before updating
    $existingStaff = $database->getStaff($staffID);
    if (!$existingStaff) {
        $errorMessage = "Staff not found!";
    } else {
        // Update the staff record in the database
        if ($database->updateStaff($staffID, $username, $password, $address, $phonenum, $fname, $lname, $age, $position, $salary)) {
            $successMessage = "Staff updated successfully!";
        } else {
            $errorMessage = "Error updating staff in the database.";
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
   <title>Update Staff</title>
</head>
<body>
   <h1>Update Staff</h1>
   <?php if (isset($successMessage)) : ?>
      <p class="msg"><?php echo $successMessage; ?></p>
   <?php endif; ?>
   <?php if (isset($errorMessage)) : ?>
      <p class="msg" style="color: red;"><?php echo $errorMessage; ?></p>
   <?php endif; ?>
   <form method="POST">
      <label for="staffID">Staff ID:</label>
      <input type="text" name="staffID" id="staffID" required><br>
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
      <label for="position">Position:</label>
      <input type="text" name="position" id="position" required><br>
      <label for="salary">Salary:</label>
      <input type="text" name="salary" id="salary" required><br>
      <input type="submit" name="submit" value="Update Staff">
   </form>
   <a href="manage_staff.php" class="button back">Back</a>
</body>
</html>
