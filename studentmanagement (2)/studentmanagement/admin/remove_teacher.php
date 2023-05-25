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

    public function removeTeacher($teacherID) {
        $query = "DELETE FROM teacher WHERE teacherID = '$teacherID'";

        $result = mysqli_query($this->connection, $query);

        if (mysqli_affected_rows($this->connection) > 0) {
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

    // Remove the teacher from the database
    if ($database->removeTeacher($teacherID)) {
        $successMessage = "Teacher removed successfully!";
    } else {
        $errorMessage = "Error removing teacher from the database.";
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
   <title>Remove Teacher</title>
</head>
<body>
   <h1>Remove Teacher</h1>
   <?php if (isset($successMessage)) : ?>
      <p class="msg"><?php echo $successMessage; ?></p>
   <?php endif; ?>
   <?php if (isset($errorMessage)) : ?>
      <p class="msg" style="color: red;"><?php echo $errorMessage; ?></p>
   <?php endif; ?>
   <form method="POST">
      <label for="teacherID">Teacher ID:</label>
      <input type="text" name="teacherID" id="teacherID" required><br>
      <input type="submit" name="submit" value="Remove Teacher"><p></p>
      <a href="manage_teachers.php" class="button back">Back</a>
   </form>
</body>
</html>
