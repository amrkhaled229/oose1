


<?php
//WE USED THE OBSERVER PATTERN HERE!!
interface Subject {
    public function attach(Observer $observer);
    public function detach(Observer $observer);
    public function notify();
}

class CourseManager implements Subject {
    private $errors = array();
    private $successMessage = "";
    private $connection;
    private $observers = array();

    public function __construct() {
        $this->connection = mysqli_connect("localhost", "root", "", "smsdb");

        // Check for connection errors
        if (!$this->connection) {
            die("Connection failed: " . mysqli_connect_error());
        }
    }

    public function attach(Observer $observer) {
        $this->observers[] = $observer;
    }

    public function detach(Observer $observer) {
        $key = array_search($observer, $this->observers, true);
        if ($key !== false) {
            unset($this->observers[$key]);
        }
    }

    public function notify() {
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
    }

    public function addCourse() {
        if (isset($_POST['submit'])) {
            // Validate form inputs
            $description = $_POST['description'];
            $registeredStudents = $_POST['registeredStudents'];

            // Perform input validation
            if (empty($description)) {
                $this->errors[] = "Description is required.";
            }

            // If there are no validation errors, proceed with database insertion
            if (empty($this->errors)) {
                $query = "INSERT INTO courses (description, registeredStudents)
                          VALUES ('$description', '$registeredStudents')";

                if (mysqli_query($this->connection, $query)) {
                    $this->successMessage = "Course added successfully!";
                    $this->notify(); // Notify observers of the success message
                } else {
                    $this->errors[] = "Error inserting data into the database: " . mysqli_error($this->connection);
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
        if (!empty($this->successMessage)) {
            echo '<div class="msg">';
            echo '<p>' . $this->successMessage . '</p>';
            echo '</div>';
        }
    }

    public function closeConnection() {
        mysqli_close($this->connection);
    }
}

interface Observer {
    public function update(Subject $subject);
}

class SuccessMessageObserver implements Observer {
    public function update(Subject $subject) {
        if ($subject instanceof CourseManager) {
            $subject->displaySuccessMessage();
        }
    }
}

$courseManager = new CourseManager();
$successMessageObserver = new SuccessMessageObserver();
$courseManager->attach($successMessageObserver);
$courseManager->addCourse();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>Add Course</title>
</head>

<body>
    <h1>Add Course</h1>
    <?php $courseManager->displayErrors(); ?>

    <form method="POST">
        <label for="description">Description:</label>
        <input type="text" name="description" id="description" required><br>

        <label for="registeredStudents">Registered Students:</label>
        <input type="text" name="registeredStudents" id="registeredStudents"><br>

        <input type="submit" name="submit" value="Add Course">
    </form>
    <a href="manage_course.php" class="button back">Back</a>
</body>

</html>

<?php
$courseManager->closeConnection();
?>
