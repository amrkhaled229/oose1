<?php
// WE USED THE DECORATOR PATTERN HERE

interface StaffManagerInterface {
    public function addStaff();
    public function displayErrors();
    public function displaySuccessMessage();
    public function closeConnection();
}

class StaffManager implements StaffManagerInterface {
    private $errors = array();
    private $connection;

    public function __construct() {
        $this->connection = mysqli_connect("localhost", "root", "", "smsdb");

        // Check for connection errors
        if (!$this->connection) {
            die("Connection failed: " . mysqli_connect_error());
        }
    }

    public function addStaff() {
        if (isset($_POST['submit'])) {
            // Validate form inputs
            $staffID = $_POST['staffID'];
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $username = $_POST['username'];
            $password = $_POST['password'];
            $phonenum = $_POST['phonenum'];
            $age = $_POST['age'];
            $job = $_POST['job'];
            $salary = $_POST['salary'];
            $address = $_POST['address'];

            // Perform input validation
            if (empty($staffID)) {
                $this->errors[] = "Staff ID is required.";
            }

            // Add validation for other fields

            // If there are no validation errors, proceed with database insertion
            if (empty($this->errors)) {
                // Insert into staff table
                $query = "INSERT INTO staff (staffID, username, password, address, phonenum, fname, lname, age, job, salary)
                          VALUES ('$staffID', '$username', '$password', '$address', '$phonenum', '$fname', '$lname', '$age', '$job', '$salary')";

                if (mysqli_query($this->connection, $query)) {
                    // Insert into user table
                    $userQuery = "INSERT INTO user (username, password, role)
                                  VALUES ('$username', '$password', 'staff')";

                    if (mysqli_query($this->connection, $userQuery)) {
                        mysqli_close($this->connection);
                        header("Location: add_staff.php?success=1");
                        exit();
                    } else {
                        $this->errors[] = "Error inserting data into the user table: " . mysqli_error($this->connection);
                    }
                } else {
                    $this->errors[] = "Error inserting data into the staff table: " . mysqli_error($this->connection);
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
            echo '<p class="msg">Staff added successfully!</p>';
        }
    }

    public function closeConnection() {
        mysqli_close($this->connection);
    }
}

abstract class StaffManagerDecorator implements StaffManagerInterface {
    protected $staffManager;

    public function __construct(StaffManagerInterface $staffManager) {
        $this->staffManager = $staffManager;
    }

    public function addStaff() {
        $this->staffManager->addStaff();
    }

    public function displayErrors() {
        $this->staffManager->displayErrors();
    }

    public function displaySuccessMessage() {
        $this->staffManager->displaySuccessMessage();
    }

    public function closeConnection() {
        $this->staffManager->closeConnection();
    }
}

class ErrorLoggingStaffManagerDecorator extends StaffManagerDecorator {
    public function addStaff() {
        parent::addStaff();
        // Additional error logging functionality
        // Log errors to a file or perform other error handling operations
    }
}

class StaffManagerWithSuccessMessageDecorator extends StaffManagerDecorator {
    public function addStaff() {
        parent::addStaff();
        // Additional success message display functionality
        // Display a success message in a different format or location
    }
}

// Usage Example
$staffManager = new StaffManager();
$staffManager = new ErrorLoggingStaffManagerDecorator($staffManager);
$staffManager = new StaffManagerWithSuccessMessageDecorator($staffManager);

$staffManager->addStaff();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>Add Staff</title>
</head>

<body>
    <h1>Add Staff</h1>
    <?php $staffManager->displayErrors(); ?>
    <?php $staffManager->displaySuccessMessage(); ?>
    <form method="POST">
        <label for="staffID">Staff ID:</label>
        <input type="text" name="staffID" id="staffID" required><br>

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

        <label for="job">Job:</label>
        <input type="text" name="job" id="job" required><br>

        <label for="address">Address:</label>
        <input type="text" name="address" id="address" required><br>

        <label for="salary">Salary:</label>
        <input type="number" name="salary" id="salary" required><br>

        <input type="submit" name="submit" value="Add Staff">
    </form>
    <a href="manage_staff.php" class="button back">Back</a>
</body>

</html>

<?php
$staffManager->closeConnection();
?>
