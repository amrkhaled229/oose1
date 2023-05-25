<?php
session_start();

if (!isset($_SESSION['teacher'])) {
    header('location:../login_form.php');
    exit();
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
  </style>
</head>
<body>
  <h1>Teacher Control Panel</h1>
  
  <div class="button-container">
    <a class="button" href="take_attendance.php">Take Student Attendance</a>
    <a class="button" href="add_results.php">Add Student Result</a>
    <a class="button" href="edit_result.php">Edit Student Results</a>
    <a class="button" href="view_student_data.php">View Student Results</a>
  </div>

  <div class="logout-button">
    <a href="../login/logout.php">Logout</a>
  </div>
</body>
</html>
