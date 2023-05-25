<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <style>
      body {
         background-color: #f2f2f2;
         font-family: Arial, sans-serif;
         text-align: center;
         margin: 0;
         padding: 20px;
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

      .big-photo {
         margin-bottom: 20px;
      }
   </style>
   <title>Student Management</title>
</head>
<body>
   <h1>Student Management</h1>
   <img src="../../img/edit.png" alt="Big Photo" class="big-photo">
   <div>
      <a href="add_student.php" class="button">Add Student</a>
      <a href="remove_student.php" class="button">Remove Student</a>
      <a href="update_student.php" class="button">Update Student</a>
      <a href="../accounts_form.php" class="button back">Back</a>
   </div>
</body>
</html>
