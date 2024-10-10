<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}

$role = $_SESSION['role'];

switch ($role) {
    case 'teacher':
        echo " ";
        break;
    default:
        // Redirect to appropriate dashboard or handle invalid access
        header("Location: index.php");
        break;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard</title>
    <link rel="stylesheet" href="style.css"> <!-- Ensure correct path to your CSS file -->
</head>
<body>
    <h2>Teacher Dashboard</h2>
    <div class="welcome">Welcome, <?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ''; ?>!</div>
    <div class="menu">
        <a class="menu-link" href="mark_attendance.php">Mark Attendance</a>
        <a class="menu-link" href="filter_absent_students1.php">Filter Absent Students</a>
        <a class="menu-link" href="generate_leave_form1.php">Generate Leave Form PDF</a>
        <a class="menu-link" href="logout.php">Logout</a>
    </div>
</body>
</html>
