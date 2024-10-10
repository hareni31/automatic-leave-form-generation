<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}

$role = $_SESSION['role'];

switch ($role) {
    case 'admin':
        echo "";
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
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css"> <!-- Ensure correct path to your CSS file -->
</head>
<body>
    <h2>Admin Dashboard</h2>
    <div class="welcome">Welcome, <?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ''; ?>!</div>
    <div class="menu">
        <a class="menu-link" href="manage_teachers.php">Manage Teachers</a>
        <a class="menu-link" href="manage_classes.php">Manage Classes</a>
        <a class="menu-link" href="manage_students.php">Manage Students</a>
        <a class="menu-link" href="create_user_form.php">Create User</a>
        <a class="menu-link" href="report.php">Report</a>
    </div>
</body>
</html>
