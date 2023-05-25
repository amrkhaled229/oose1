<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Fees</title>
    <style>
        /* CSS styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }

        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-top: 0;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        input[type="text"] {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            background-color: #4caf50;
            color: #ffffff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .fees {
            margin-top: 20px;
            font-weight: bold;
            text-align: center;
        }

        .error {
            margin-top: 20px;
            color: red;
            text-align: center;
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
 
 .msg{
    text-align: center;
 }
    </style>
</head>
<body>
    <div class="container">
        <h1>Check Fees</h1>
        <form method="post" action="">
            <label for="student_id">Student ID:</label>
            <input type="text" id="student_id" name="student_id" required>
            <p></p>
            <input type="submit" value="Check">
        </form>
        <?php
        // Check if the student ID is submitted
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $studentID = $_POST['student_id'];

            // Connect to the database (Update connection details as per your configuration)
            $connection = mysqli_connect("localhost", "root", "", "smsdb");

            // Check if the connection was successful
            if (mysqli_connect_errno()) {
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
                exit();
            }

            // Prepare and execute the SQL query to retrieve fees for the student
            $query = "SELECT fees FROM fees_table WHERE studentID = '$studentID'";
            $result = mysqli_query($connection, $query);

            if (mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_assoc($result);
                $fees = $row['fees'];
                echo "<div class='fees'>Fees: $fees</div>";
            } else {
                echo "<div class='error msg
                '>Student not found</div>";
            }

            mysqli_close($connection);
        }
        ?>
    </div>
    <a href="student.php" class="button back">Back</a>
</body>
</html>
