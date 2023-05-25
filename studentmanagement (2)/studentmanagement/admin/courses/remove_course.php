

<?php
//WE USED SINGLETON DESIGN PATTERN HERE!!

class Database {
    private static $instance;
    private $connection;

    private function __construct() {
        include("../../connection.php");
        $this->connection = $connect;

        if (!$this->connection) {
            die("Connection failed: " . mysqli_connect_error());
        }
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function removeCourse($courseID) {
        $query = "DELETE FROM courses WHERE id = '$courseID'";

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

$database = Database::getInstance();

if (isset($_POST['submit'])) {
    $courseID = $_POST['courseID'];

    // Remove the course from the database
    if ($database->removeCourse($courseID)) {
        $successMessage = "Course removed successfully!";
    } else {
        $errorMessage = "Error removing course from the database.";
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
   <title>Remove Course</title>
</head>
<body>
   <h1>Remove Course</h1>
   <?php if (isset($successMessage)) : ?>
      <p class="msg"><?php echo $successMessage; ?></p>
   <?php endif; ?>
   <?php if (isset($errorMessage)) : ?>
      <p class="msg" style="color: red;"><?php echo $errorMessage; ?></p>
   <?php endif; ?>
   <form method="POST">
      <label for="courseID">Course ID:</label>
      <input type="text" name="courseID" id="courseID" required><br>
      <input type="submit" name="submit" value="Remove Course">
      <a href="manage_course.php" class="button back">Back</a>
   </form>
</body>
</html>
