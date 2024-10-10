<?php
// Include the database connection file
require_once 'info.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data and escape them
    $student_id = isset($_POST['student_id']) ? mysqli_real_escape_string($conn, $_POST['student_id']) : '';
    $student_name = isset($_POST['student_name']) ? mysqli_real_escape_string($conn, $_POST['student_name']) : '';
    
    $class_name = isset($_POST['class']) ? mysqli_real_escape_string($conn, $_POST['class']) : '';
    $roll_number = isset($_POST['roll_number']) ? mysqli_real_escape_string($conn, $_POST['roll_number']) : '';
    $reason = isset($_POST['reason']) ? mysqli_real_escape_string($conn, $_POST['reason']) : '';
    $teacher_signature = isset($_POST['teacher_signature']) ? mysqli_real_escape_string($conn, $_POST['teacher_signature']) : '';
    $student_signature = isset($_POST['student_signature']) ? mysqli_real_escape_string($conn, $_POST['student_signature']) : '';
    $hod_signature = isset($_POST['hod_signature']) ? mysqli_real_escape_string($conn, $_POST['hod_signature']) : '';

    // Get the current date
    $leave_date = date("Y-m-d");

    // Insert leave form data into the database
    $query = "INSERT INTO leave_forms (student_id, student_name, class_name, roll_number, leave_date, reason, teacher_signature, student_signature, hod_signature) 
              VALUES ('$student_id', '$student_name',  '$class_name', '$roll_number', '$leave_date', '$reason', '$teacher_signature', '$student_signature', '$hod_signature')";
    
    if (mysqli_query($conn, $query)) {
        echo "Leave form submitted successfully.";
    } else {
        // Check if the error is due to foreign key constraint failure
        if (strpos(mysqli_error($conn), 'foreign key constraint') !== false) {
            echo "Error: Invalid class ID.";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
} else {
    echo 'Invalid request';
}

// Close the connection
mysqli_close($conn);
?>
<html><body>
<form action="student_dashboard.php" method="get"> 
        <button type="submit">Return to Dashboard</button> <!-- Button to return to admin dashboard -->
    </form></body></html>
