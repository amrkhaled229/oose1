<?php
session_start();

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $studentIDs = $_POST['student_id'];
    $statuses = $_POST['status'];
    $date = date('Y-m-d');

    // Connect to the database (Update connection details as per your configuration)
    $connection = mysqli_connect("localhost", "root", "", "smsdb");

    // Check if the connection was successful
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        exit();
    }

    // Prepare and execute the SQL query to insert attendance records
   // Prepare and execute the SQL query to insert attendance records
$stmt = mysqli_prepare($connection, "INSERT INTO attendance (student_id, student_name, status, date) VALUES (?, ?, ?, ?)");

if (!$stmt) {
    echo "Error preparing statement: " . mysqli_error($connection);
    exit();
}

mysqli_stmt_bind_param($stmt, 'ssss', $studentID, $studentName, $status, $date);

foreach ($studentIDs as $key => $studentID) {
    // Check if student ID exists in the student table
    $query = "SELECT * FROM student WHERE studentID = '$studentID'";
    $result = mysqli_query($connection, $query);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $studentName = $row['fname'] . ' ' . $row['lname'];
        $status = $statuses[$key];
        mysqli_stmt_execute($stmt);
    } else {
        $error .= "Invalid Student ID: $studentID<br>";
    }
}


    mysqli_stmt_close($stmt);
    mysqli_close($connection);

    if (empty($error)) {
        echo "<script>alert('Attendance taken successfully!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Take Attendance</title>
    <style>
        /* CSS styles */
        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        input[type="text"],
        select {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
        }

        .error {
            color: red;
            margin-bottom: 10px;
        }
        .button {
    display: inline-block;
    padding: 10px 20px;
    margin: 10px;
    font-size: 16px;
    font-weight: bold;
    text-align: center;
    text-decoration: none;
    text-transform: uppercase;
    border: none;
    border-radius: 4px;
    color: #fff;
    background-color: #007bff;
    cursor: pointer;
    position: relative;
 }

 .button:hover {
    background-color: #0056b3;
 }
 .button.back {
    background-color: #555;
 }

 .button.back:hover {
    background-color: #333;
 }
    </style>
</head>
<body>
    <div class="container">
        <h1>Take Attendance</h1>
        <form method="post" action="">
            <table>
                <tr>
                    <th>Student ID</th>
                    <th>Status</th>
                </tr>
                <tr>
                    <td><input type="text" name="student_id[]" required></td>
                    <td>
                        <select name="status[]" required>
                            <option value="Present">Present</option>
                            <option value="Absent">Absent</option>
                        </select>
                    </td>
                </tr>
                <!-- Add more rows for additional students if needed -->
            </table>
            <input type="submit" value="Submit Attendance">
            <div class="error"><?php echo $error; ?></div>
        </form>
        <a href="teacher.php" class="button back">Back</a>
    </div>
</body>
</html>
