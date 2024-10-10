<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}

$role = $_SESSION['role'];

switch ($role) {
    case 'student':
        // Output the student dashboard HTML
        echo '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Student Dashboard</title>
                <link rel="stylesheet" href="style.css"> <!-- Ensure correct path to your CSS file -->
            </head>
            <body>
                <h2>Student Dashboard</h2>
                <div class="welcome">Welcome, ' . $_SESSION['username'] . '!</div>
                <div class="menu">
                    <a class="menu-link" href="filter_absent_students.php">Generate LeaveForm</a>
                    
                    <a class="menu-link" href="logout.php">Logout</a>
                </div>
            </body>
            </html>';
        break;
    default:
        // Redirect to appropriate dashboard or handle invalid access
        header("Location: index.php");
        break;
}
?>
