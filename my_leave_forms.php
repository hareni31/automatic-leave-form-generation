<?php
session_start();
require_once 'info.php'; // Make sure to add a semicolon here

// Check if user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

// Include database connection
require_once 'db.php';

// Retrieve the student's roll number
$roll_number = $_SESSION['roll_number']; // Assuming 'roll_number' is set correctly in the session

// Retrieve leave forms for the logged-in student
$query = "SELECT * FROM leave_forms WHERE student_roll_number = '$roll_number'";
$result = mysqli_query($connection, $query);

// Check if there are leave forms
if (mysqli_num_rows($result) > 0) {
    // Display leave forms
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<p>Date: {$row['date']} - Reason: {$row['reason']}</p>";
    }
} else {
    echo "<p>No leave forms found.</p>";
}

// Close database connection
mysqli_close($connection);
?>
