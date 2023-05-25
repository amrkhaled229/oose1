<?php
// ValidationStrategy interface and validation classes
interface ValidationStrategy {
    public function validate($value);
}

class RequiredValidation implements ValidationStrategy {
    public function validate($value) {
        if (empty($value)) {
            return "This field is required.";
        }
        return null;
    }
}

class StudentManager {
    private $errors = array();
    private $connection;
    private $validationStrategies = array();

    public function __construct() {
        $this->connection = mysqli_connect("localhost", "root", "", "smsdb");

        // Check for connection errors
        if (!$this->connection) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Initialize validation strategies
        $this->validationStrategies = array(
            'studentID' => new RequiredValidation(),
            'username' => new RequiredValidation(),
            'password' => new RequiredValidation(),
            'address' => new RequiredValidation(),
            'phonenum' => new RequiredValidation(),
            'fname' => new RequiredValidation(),
            'lname' => new RequiredValidation(),
            'age' => new RequiredValidation(),
            'courses' => new RequiredValidation(),
            'leveltype' => new RequiredValidation()
            // Add more validation strategies for other fields if needed
        );
    }

    public function addStudent() {
        if (isset($_POST['submit'])) {
            // Validate form inputs
            foreach ($this->validationStrategies as $field => $strategy) {
                $errorMessage = $strategy->validate($_POST[$field]);
                if ($errorMessage !== null) {
                    $this->errors[$field] = $errorMessage;
                }
            }

            // If there are no validation errors, proceed with database insertion
            if (empty($this->errors)) {
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

                // Insert student into 'student' table
                $studentQuery = "INSERT INTO student (studentID, username, password, address, phonenum, fname, lname, age, courses, leveltype)
                              VALUES ('$studentID', '$username', '$password', '$address', '$phonenum', '$fname', '$lname', '$age', '$courses', '$leveltype')";

                // Insert student into 'user' table
                $userQuery = "INSERT INTO user (fname, lname, phonenum, username, password, age, usertype)
                          VALUES ('$fname', '$lname', '$phonenum', '$username', '$password', '$age', 'student')";

                if (mysqli_query($this->connection, $studentQuery) && mysqli_query($this->connection, $userQuery)) {
                    // Add default fee value to fees_table
                    $feesQuery = "INSERT INTO fees_table (studentID, fees) VALUES ('$studentID', 5000)";
                    mysqli_query($this->connection, $feesQuery);

                    mysqli_close($this->connection);
                    header("Location: add_student.php?success=1");
                    exit();
                } else {
                    $this->errors['database'] = "Error inserting data into the database: " . mysqli_error($this->connection);
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
            echo '<p class="msg">Student added successfully!</p>';
        }
    }

    public function closeConnection() {
        mysqli_close($this->connection);
    }
}

$studentManager = new StudentManager();
$studentManager->addStudent();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>Add Student</title>
</head>

<body>
    <h1>Add Student</h1>
    <?php $studentManager->displayErrors(); ?>
    <form method="POST">
        <label for="studentID">Student ID:</label>
        <input type="text" name="studentID" id="studentID" required>
        <?php if (isset($studentManager->errors['studentID'])): ?>
            <p class="error-msg"><?php echo $studentManager->errors['studentID']; ?></p>
        <?php endif; ?>

        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required>
        <?php if (isset($studentManager->errors['username'])): ?>
            <p class="error-msg"><?php echo $studentManager->errors['username']; ?></p>
        <?php endif; ?>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
        <?php if (isset($studentManager->errors['password'])): ?>
            <p class="error-msg"><?php echo $studentManager->errors['password']; ?></p>
        <?php endif; ?>

        <label for="address">Address:</label>
        <input type="text" name="address" id="address" required>
        <?php if (isset($studentManager->errors['address'])): ?>
            <p class="error-msg"><?php echo $studentManager->errors['address']; ?></p>
        <?php endif; ?>

        <label for="phonenum">Phone Number:</label>
        <input type="text" name="phonenum" id="phonenum" required>
        <?php if (isset($studentManager->errors['phonenum'])): ?>
            <p class="error-msg"><?php echo $studentManager->errors['phonenum']; ?></p>
        <?php endif; ?>

        <label for="fname">First Name:</label>
        <input type="text" name="fname" id="fname" required>
        <?php if (isset($studentManager->errors['fname'])): ?>
            <p class="error-msg"><?php echo $studentManager->errors['fname']; ?></p>
        <?php endif; ?>

        <label for="lname">Last Name:</label>
        <input type="text" name="lname" id="lname" required>
        <?php if (isset($studentManager->errors['lname'])): ?>
            <p class="error-msg"><?php echo $studentManager->errors['lname']; ?></p>
        <?php endif; ?>

        <label for="age">Age:</label>
        <input type="text" name="age" id="age" required>
        <?php if (isset($studentManager->errors['age'])): ?>
            <p class="error-msg"><?php echo $studentManager->errors['age']; ?></p>
        <?php endif; ?>

        <label for="courses">Courses:</label>
        <input type="text" name="courses" id="courses" required>
        <?php if (isset($studentManager->errors['courses'])): ?>
            <p class="error-msg"><?php echo $studentManager->errors['courses']; ?></p>
        <?php endif; ?>

        <label for="leveltype">Level Type:</label>
        <input type="text" name="leveltype" id="leveltype" required>
        <?php if (isset($studentManager->errors['leveltype'])): ?>
            <p class="error-msg"><?php echo $studentManager->errors['leveltype']; ?></p>
        <?php endif; ?>

        <input type="submit" name="submit" value="Add Student">
    </form>
    <?php $studentManager->displaySuccessMessage(); ?>
</body>

</html>
