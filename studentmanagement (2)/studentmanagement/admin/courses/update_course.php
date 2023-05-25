

<?php
//WE USED FACTORY PATTERN HERE!!

class Database {
    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function getCourse($courseID) {
        $query = "SELECT * FROM courses WHERE id = '$courseID'";
        $result = mysqli_query($this->connection, $query);
        return mysqli_fetch_assoc($result);
    }

    public function updateCourse($courseID, $description, $registeredStudents) {
        $query = "UPDATE courses SET description = '$description', registeredStudents = '$registeredStudents' WHERE id = '$courseID'";

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

class DatabaseFactory {
    public static function createDatabase() {
        include("../../connection.php");

        $connection = $connect;

        if (!$connection) {
            die("Connection failed: " . mysqli_connect_error());
        }

        return new Database($connection);
    }
}

$database = DatabaseFactory::createDatabase();

if (isset($_POST['submit'])) {
    $courseID = $_POST['courseID'];
    $description = $_POST['description'];
    $registeredStudents = $_POST['registeredStudents'];

    // Check if the course exists before updating
    $existingCourse = $database->getCourse($courseID);
    if (!$existingCourse) {
        $errorMessage = "Course not found!";
    } else {
        // Update the course record in the database
        if ($database->updateCourse($courseID, $description, $registeredStudents)) {
            $successMessage = "Course updated successfully!";
        } else {
            $errorMessage = "Error updating course in the database.";
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
   <title>Update Course</title>
</head>
<body>
   <h1>Update Course</h1>
   <?php if (isset($successMessage)) : ?>
      <p class="msg"><?php echo $successMessage; ?></p>
   <?php endif; ?>
   <?php if (isset($errorMessage)) : ?>
      <p class="msg" style="color: red;"><?php echo $errorMessage; ?></p>
   <?php endif; ?>
   <form method="POST">
      <label for="courseID">Course ID:</label>
      <input type="text" name="courseID" id="courseID" required><br>
      <label for="description">Description:</label>
      <input type="text" name="description" id="description" required><br>
      <label for="registeredStudents">Registered Students:</label>
      <input type="text" name="registeredStudents" id="registeredStudents"><br>
      <input type="submit" name="submit" value="Update Course">
   </form>
   <a href="manage_course.php" class="button back">Back</a>
</body>
</html>
