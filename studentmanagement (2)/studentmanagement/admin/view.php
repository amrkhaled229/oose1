<!DOCTYPE html>
<html>
<head>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            font-family: Arial, sans-serif;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        h2 {
            margin-top: 30px;
            margin-bottom: 10px;
            font-size: 24px;
        }

        .courses-table {
            margin-bottom: 30px;
        }

        .students-table,
        .staff-table,
        .teachers-table {
            margin-bottom: 50px;
        }

        .table-heading {
            background-color: #007bff;
            color: #fff;
        }

        .table-heading th {
            padding: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .table-heading td {
            padding: 12px;
            font-weight: bold;
            color: #fff;
        }

        .table-heading h2 {
            margin-top: 0;
            margin-bottom: 10px;
            font-size: 28px;
            text-transform: uppercase;
            color: #fff;
        }

        .table-row:hover {
            background-color: #f2f2f2;
        }

        .table-row:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
<?php

class Database {
    private $connection;

    public function __construct() {
        include ("../connection.php");

        $this->connection = $connect;

        if (!$this->connection) {
            die("Connection failed: " . mysqli_connect_error());
        }
    }

    public function getCourses() {
        $query = "SELECT * FROM courses";
        $result = mysqli_query($this->connection, $query);
        return $result;
    }

    public function getStudents() {
        $query = "SELECT * FROM student";
        $result = mysqli_query($this->connection, $query);
        return $result;
    }

    public function getStaff() {
        $query = "SELECT * FROM staff";
        $result = mysqli_query($this->connection, $query);
        return $result;
    }

    public function getTeachers() {
        $query = "SELECT * FROM teacher";
        $result = mysqli_query($this->connection, $query);
        return $result;
    }

    public function closeConnection() {
        mysqli_close($this->connection);
    }
}

$database = new Database();

// Retrieve courses
$courses = $database->getCourses();

echo "<div class='courses-table'>";
echo "<div class='table-heading'>";
echo "<h2>Courses</h2>";
echo "</div>";
echo "<table>";
echo "<tr><th>ID</th><th>Description</th><th>Registered Students</th></tr>";

while ($row = mysqli_fetch_assoc($courses)) {
    echo "<tr class='table-row'>";
    echo "<td>".$row['id']."</td>";
    echo "<td>".$row['description']."</td>";
    echo "<td>".$row['registeredStudents']."</td>";
    echo "</tr>";
}

echo "</table>";
echo "</div>";

// Retrieve students
$students = $database->getStudents();

echo "<div class='students-table'>";
echo "<div class='table-heading'>";
echo "<h2>Students</h2>";
echo "</div>";
echo "<table>";
echo "<tr><th>Student ID</th><th>Username</th><th>Password</th><th>Address</th><th>Phone Number</th><th>First Name</th><th>Last Name</th><th>Age</th><th>Courses</th><th>Level Type</th></tr>";

while ($row = mysqli_fetch_assoc($students)) {
    echo "<tr class='table-row'>";
    echo "<td>".$row['studentID']."</td>";
    echo "<td>".$row['username']."</td>";
    echo "<td>".$row['password']."</td>";
    echo "<td>".$row['address']."</td>";
    echo "<td>".$row['phonenum']."</td>";
    echo "<td>".$row['fname']."</td>";
    echo "<td>".$row['lname']."</td>";
    echo "<td>".$row['age']."</td>";
    echo "<td>".$row['courses']."</td>";
    echo "<td>".$row['leveltype']."</td>";
    echo "</tr>";
}

echo "</table>";
echo "</div>";

// Retrieve staff
$staff = $database->getStaff();

echo "<div class='staff-table'>";
echo "<div class='table-heading'>";
echo "<h2>Staff</h2>";
echo "</div>";
echo "<table>";
echo "<tr><th>Staff ID</th><th>Username</th><th>Password</th><th>Address</th><th>Phone Number</th><th>First Name</th><th>Last Name</th><th>Age</th><th>Job</th><th>Salary</th></tr>";

while ($row = mysqli_fetch_assoc($staff)) {
    echo "<tr class='table-row'>";
    echo "<td>".$row['staffID']."</td>";
    echo "<td>".$row['username']."</td>";
    echo "<td>".$row['password']."</td>";
    echo "<td>".$row['address']."</td>";
    echo "<td>".$row['phonenum']."</td>";
    echo "<td>".$row['fname']."</td>";
    echo "<td>".$row['lname']."</td>";
    echo "<td>".$row['age']."</td>";
    echo "<td>".$row['job']."</td>";
    echo "<td>".$row['salary']."</td>";
    echo "</tr>";
}

echo "</table>";
echo "</div>";

// Retrieve teachers
$teachers = $database->getTeachers();

echo "<div class='teachers-table'>";
echo "<div class='table-heading'>";
echo "<h2>Teachers</h2>";
echo "</div>";
echo "<table>";
echo "<tr><th>Teacher ID</th><th>First Name</th><th>Last Name</th><th>Username</th><th>Password</th><th>Phone Number</th><th>Age</th><th>Certificate</th><th>Address</th><th>Salary</th></tr>";

while ($row = mysqli_fetch_assoc($teachers)) {
    echo "<tr class='table-row'>";
    echo "<td>".$row['teacherID']."</td>";
    echo "<td>".$row['fname']."</td>";
    echo "<td>".$row['lname']."</td>";
    echo "<td>".$row['username']."</td>";
    echo "<td>".$row['password']."</td>";
    echo "<td>".$row['phonenum']."</td>";
    echo "<td>".$row['age']."</td>";
    echo "<td>".$row['certificate']."</td>";
    echo "<td>".$row['address']."</td>";
    echo "<td>".$row['salary']."</td>";
    echo "</tr>";
}

echo "</table>";
echo "</div>";

$database->closeConnection();

?>
</body>
</html>
