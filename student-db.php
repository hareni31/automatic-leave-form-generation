<?php
// Include the database connection file and ensure session is started
require_once 'info.php';
session_start();

// Check if the user is logged in, if not redirect to login page
if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

// Retrieve filled leave forms for the logged-in student from the database
$student_id = $_SESSION['student_id'];
$query = "SELECT * FROM leave_forms WHERE student_id = $student_id";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to your CSS file -->
</head>
<body>
    <h2>My Leave Forms</h2>
    <ul>
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<li>Date: {$row['attendance_date']} - Reason: {$row['reason']}</li>";
        }
        ?>
    </ul>
    <a href="fill_leave_form.php">Fill New Leave Form</a> <!-- Link to fill leave form page -->
    <br>
    <a href="logout.php">Logout</a> <!-- Link to logout -->
</body>
</html>
