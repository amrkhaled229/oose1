<?php
session_start();

if (!isset($_SESSION['teacher'])) {
    header('location:../login_form.php');
    exit();
}

// Assuming you have a database connection established
include ("../connection.php");

// Initialize variables
$error = "";
$success = "";

if (isset($_POST['edit_results'])) {
    $student_id = $_POST['student_id'];

    // Validate if the student ID exists in the student table
    $query = "SELECT * FROM student WHERE studentID = '$student_id'";
    $result = mysqli_query($connect, $query);

    if (mysqli_num_rows($result) == 0) {
        $error = "Student with ID $student_id does not exist.";
    } else {
        // Perform edit operation on the student results
        $marks = $_POST['marks'];

        // Update the grades in the results table
        $updateQuery = "UPDATE results SET marks = '$marks' WHERE student_id = '$student_id'";
        $updateResult = mysqli_query($connect, $updateQuery);

        if ($updateResult) {
            $success = "Results for student with ID $student_id have been successfully edited.";
        } else {
            $error = "Error editing the student results: " . mysqli_error($connect);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Student Results</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 20px;
    }
    
    h1 {
      text-align: center;
    }
    
    .form-container {
      margin-top: 50px;
      display: flex;
      flex-direction: column;
      align-items: center;
    }
    
    .form-container label {
      margin-bottom: 10px;
    }
    
    .form-container input[type="text"] {
      padding: 8px;
      margin-bottom: 10px;
    }
    
    .form-container input[type="submit"] {
      padding: 8px 16px;
      background-color: #4CAF50;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    .error-message {
      margin-top: 10px;
      color: red;
    }

    .success-message {
      margin-top: 10px;
      color: green;
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
  <h1>Edit Student Results</h1>

  <div class="form-container">
    <h2>Enter Student ID to Edit Results</h2>
    <?php if (!empty($error)) { ?>
      <p class="error-message"><?php echo $error; ?></p>
    <?php } ?>
    <?php if (!empty($success)) { ?>
      <p class="success-message"><?php echo $success; ?></p>
    <?php } ?>
    <form method="post">
      <label for="student_id">Student ID:</label>
      <input type="text" name="student_id" id="student_id">
      <label for="marks">Marks:</label>
      <input type="text" name="marks" id="marks">
      <input type="submit" name="edit_results" value="Edit Results">
    </form>
    <a href="teacher.php" class="button back">Back</a>
  </div>
</body>
</html>
