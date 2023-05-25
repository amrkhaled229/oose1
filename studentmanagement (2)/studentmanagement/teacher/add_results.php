<?php
session_start();

if (!isset($_SESSION['teacher'])) {
    header('location:../login_form.php');
    exit();
}

// Assuming you have a database connection established
include ("../connection.php");

// Fetch students from the student table
$query = "SELECT * FROM student";
$result = mysqli_query($connect, $query);

// Initialize the success message
$success = "";

// Handle form submission to add results
if (isset($_POST['add_result'])) {
    $student_id = $_POST['student_id'];
    $marks = $_POST['marks'];

    // Perform validation: check if the student ID exists in the student table
    $checkQuery = "SELECT * FROM student WHERE studentID = '$student_id'";
    $checkResult = mysqli_query($connect, $checkQuery);

    if (mysqli_num_rows($checkResult) == 1) {
        // Student ID exists, add the result to the database
        $insertQuery = "INSERT INTO results (student_id, marks) VALUES ('$student_id', '$marks')";
        $insertResult = mysqli_query($connect, $insertQuery);

        if ($insertResult) {
            // Result added successfully
            $success = "Result added successfully.";
        } else {
            // Error occurred while adding the result
            $error = "Error adding the result: " . mysqli_error($connect);
        }
    } else {
        // Student ID doesn't exist
        $error = "Invalid Student ID. Please enter a valid Student ID.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Teacher Control Panel</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 20px;
    }
    
    h1 {
      text-align: center;
    }
    
    .button-container {
      display: flex;
      justify-content: center;
      margin-top: 50px;
    }
    
    .button {
      display: inline-block;
      padding: 10px 20px;
      margin: 0 10px;
      background-color: #4CAF50;
      color: white;
      text-decoration: none;
      border-radius: 4px;
      transition: background-color 0.3s;
    }
    
    .button:hover {
      background-color: #45a049;
    }
    
    .logout-button {
      display: flex;
      justify-content: center;
      margin-top: 20px;
    }
    
    .logout-button a {
      display: inline-block;
      padding: 10px 20px;
      background-color: #f44336;
      color: white;
      text-decoration: none;
      border-radius: 4px;
      transition: background-color 0.3s;
    }
    
    .logout-button a:hover {
      background-color: #d32f2f;
    }
    
    .add-result-form {
      margin-top: 50px;
      display: flex;
      flex-direction: column;
      align-items: center;
    }
    
    .add-result-form label {
      margin-bottom: 10px;
    }
    
    .add-result-form input[type="submit"] {
      margin-top: 10px;
      padding: 8px 16px;
      background-color: #4CAF50;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    .success-message {
      margin-top: 10px;
      color: green;
    }

    .error-message {
      margin-top: 10px;
      color: red;
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

  <div class="add-result-form">
    <h2>Add Student Result</h2>
    <?php if (isset($error)) { ?>
      <p class="error-message"><?php echo $error; ?></p>
    <?php } ?>
    <?php if ($success) { ?>
      <p class="success-message"><?php echo $success; ?></p>
    <?php } ?>
    <form method="post">
      <label for="student_id">Student ID:</label>
      <input type="text" name="student_id" id="student_id">
      <label for="marks">Marks:</label>
      <input type="text" name="marks" id="marks">
      <input type="submit" name="add_result" value="Add Result">
    </form>
    <a href="teacher.php" class="button back">Back</a>
  </div>
</body>
</html>
