<?php
session_start();

if (!isset($_SESSION['teacher'])) {
    header('location:../login_form.php');
    exit();
}

// Assuming you have a database connection established
include ("../connection.php");

$error = "";
$studentData = array();

if (isset($_POST['search_student'])) {
    $student_id = $_POST['student_id'];

    // Check if the student ID exists in the student table
    $query = "SELECT * FROM student WHERE studentID = '$student_id'";
    $result = mysqli_query($connect, $query);

    if (mysqli_num_rows($result) > 0) {
        // Student found, fetch the data
        $row = mysqli_fetch_assoc($result);
        $studentData = $row;
    } else {
        // Student not found
        $error = "No student found with the provided ID.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Search Student</title>
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
    
    .student-data-container {
      margin-top: 50px;
      border: 1px solid #ccc;
      padding: 20px;
      border-radius: 4px;
    }

    .student-data {
      display: flex;
      flex-direction: column;
      margin-bottom: 10px;
    }

    .student-data label {
      font-weight: bold;
    }

    .student-data span {
      margin-left: 10px;
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
  <h1>Search Student</h1>

  <div class="form-container">
    <h2>Enter Student ID</h2>
    <?php if (!empty($error)) { ?>
      <p class="error-message"><?php echo $error; ?></p>
    <?php } ?>
    <form method="post">
      <label for="student_id">Student ID:</label>
      <input type="text" name="student_id" id="student_id">
      <input type="submit" name="search_student" value="Search">
    </form>
  </div>

  <?php if (isset($studentData) && !empty($studentData)) { ?>
    <div class="student-data-container">
      <h2>Student Data</h2>
      <div class="student-data">
        <?php foreach ($studentData as $field => $value) { ?>
          <label><?php echo $field; ?>:</label>
          <span><?php echo $value; ?></span>
          <br>
        <?php } ?>
      </div>
    </div>
  <?php } ?>
  <a href="teacher.php" class="button back">Back</a>
</body>
</html>
