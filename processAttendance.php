<?php
require_once 'info.php'; // Include info.php to establish the database connection

// Check if the connection variable is defined
if (!isset($connection)) {
    die("Connection failed: Database connection variable is not set.");
}

// Check if the form was submitted via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve class ID and attendance date from the form
    $class_id = $_POST['class_id'];
    $attendance_date = $_POST['attendance_date'];

    // Check if attendance data is present in the request
    if (isset($_POST['attendance']) && is_array($_POST['attendance'])) {
        // Prepare and execute statements to insert attendance data into the database
        $stmt = $connection->prepare("INSERT INTO attendance (student_id, class_id, attendance_date, status) VALUES (?, ?, ?, 'Present')");

        // Loop through each student's attendance status
        foreach ($_POST['attendance'] as $student_id) {
            // Bind parameters and execute the statement
            $stmt->bind_param("iis", $student_id, $class_id, $attendance_date);
            $stmt->execute();
        }

        // Close statement
        $stmt->close();

        // Redirect back to mark_attendance.php with a success message
        header("Location: mark_attendance.php?success=1");
        exit();
    } else {
        // If no attendance data is present, redirect with an error message
        header("Location: mark_attendance.php?error=1");
        exit();
    }
} else {
    // If the form was not submitted via POST, redirect back to mark_attendance.php
    header("Location: mark_attendance.php");
    exit();
}
?>
