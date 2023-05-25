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

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../style/style3.css">

</head>
<body>
   
<div class="container">

   <div class="content">
      <h3>Hi, <span>Admin</span></h3>
      <h1>welcome <span><?php echo $_SESSION['admin'] ?></span></h1>
      <p>this is an admin page</p>
      <a href="accounts_form.php" class="btn">Manage Accounts</a>
      <a href="courses/manage_course.php" class="btn">Manage Courses</a>
      <a href="view.php" class="btn">View All</a>
      <a href="../login/logout.php" class="btn">logout</a>
   </div>

</div>

</body>
</html>