<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header('location:login_form.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>admin page</title>

   <link rel="stylesheet" href="../style/style3.css">

</head>
<body>
   
<div class="container">

   <div class="content">
      <h3>Register <span>Page</span></h3>
      <h1>Logged in as, <span><?php echo $_SESSION['admin'] ?></span></h1>
      <p></p>
      <a href="manage_teachers.php" class="btn">Manage Teachers</a>
      <a href="student/manage_student.php" class="btn">Manage Students</a>
      <a href="staff/manage_staff.php" class="btn">Manage Staff</a>
      <a href="admin.php" class="btn">Back</a>
   </div>

</div>

</body>
</html>