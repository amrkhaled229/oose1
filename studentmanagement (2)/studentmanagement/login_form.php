<?php
session_start();

if (isset($_SESSION['admin'])) {
    header('location: admin/admin.php');
    exit();
} elseif (isset($_SESSION['teacher'])) {
    header('location: teacher/teacher.php');
    exit();
} elseif (isset($_SESSION['student'])) {
    header('location: student/student.php');
    exit();
}

class LoginForm
{
    private $connection;

    public function __construct()
    {
        include("header.php");
        include("connection.php");
        $this->connection = mysqli_connect("localhost", "root", "", "smsDB");

        // Check if the connection was successful
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
            exit();
        }
    }

    public function handleLoginForm()
    {
        if (isset($_POST['login'])) {
            $username = $_POST['uname'];
            $password = $_POST['pass'];

            $error = array();

            if (empty($username)) {
                $error['admin'] = "Please enter a username";
            } elseif (empty($password)) {
                $error['admin'] = "Please enter a password";
            }

            if (count($error) == 0) {
                $username = mysqli_real_escape_string($this->connection, $username);
                $password = mysqli_real_escape_string($this->connection, $password);

                $query = "SELECT * FROM user WHERE username = '$username' AND password ='$password'";

                $result = mysqli_query($this->connection, $query);

                // Check for query execution errors
                if ($result === false) {
                    echo "Error executing the query: " . mysqli_error($this->connection);
                    exit();
                }

                if (mysqli_num_rows($result) == 1) {
                    $row = mysqli_fetch_assoc($result);

                    if ($row['usertype'] == 'admin') {
                        $_SESSION['admin'] = $username;
                        header("Location: admin/admin.php");
                        exit();
                    } elseif ($row['usertype'] == 'student') {
                        $_SESSION['student'] = $username;
                        header("Location: student/student.php");
                        exit();
                    } elseif ($row['usertype'] == 'teacher') {
                        $_SESSION['teacher'] = $username;
                        header("Location: teacher/teacher.php");
                        exit();
                    }
                } else {
                    echo "<script>alert('Invalid Username or Password')</script>";
                }
            }
        }
    }

    public function renderLoginForm()
    {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" type="text/css" href="../style/style.css">
            <title>Login</title>
        </head>
        <body>
        <div class="container">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <form method="post" class="my-2">
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" name="uname" class="form-control"
                                       autocomplete="off" placeholder="Username">
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="pass" class="form-control"
                                       placeholder="Password">
                            </div>
                            <input type="submit" name="login" class="btn btn-success"
                                   value="Login">
                        </form>
                    </div>
                    <div class="col-md-3"></div>
                </div>
            </div>
        </div>
        </body>
        </html>
        <?php
    }

    public function __destruct()
    {
        mysqli_close($this->connection);
    }
}

$loginForm = new LoginForm();
$loginForm->handleLoginForm();
$loginForm->renderLoginForm();
?>
