<?php
require_once 'info.php'; // Include info.php to establish the database connection

// Check if the connection variable is defined
if (!isset($conn)) {
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
        $stmt_present = $conn->prepare("INSERT INTO attendance (student_id, class_id, attendance_date, status) VALUES (?, ?, ?, 'Present')");
        $stmt_absent = $conn->prepare("INSERT INTO attendance (student_id, class_id, attendance_date, status) VALUES (?, ?, ?, 'Absent')");

        // Loop through each student's attendance status
        foreach ($_POST['attendance'] as $student_id) {
            // Bind parameters and execute the statement for present students
            $stmt_present->bind_param("iis", $student_id, $class_id, $attendance_date);
            $stmt_present->execute();

            // Bind parameters and execute the statement for absent students
            $stmt_absent->bind_param("iis", $student_id, $class_id, $attendance_date);
            $stmt_absent->execute();
        }

        // Close statements
        $stmt_present->close();
        $stmt_absent->close();

        // Redirect back to mark_Attendance.php with a success message
        header("Location: mark_Attendance.php?success=1");
        exit();
    } else {
        // If no attendance data is present, redirect with an error message
        header("Location: mark_Attendance.php?error=1");
        exit();
    }
} else {
    // If the form was not submitted via POST, redirect back to mark_Attendance.php
    header("Location: mark_Attendance.php");
    exit();
}
?>
