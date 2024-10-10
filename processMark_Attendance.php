<?php
require_once 'info.php'; // Include info.php to establish the database connection

// Check if the connection variable is defined
if (!isset($conn)) {
    die("Connection failed: Database connection variable is not set.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $class_id = $_POST['class_id'];

    // Retrieve students for the selected class using a prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM students WHERE class_id = ?");
    $stmt->bind_param("i", $class_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Display a form to mark attendance for each student
    echo '<form action="process_Attendance.php" method="post">';
    echo '<input type="hidden" name="class_id" value="' . $class_id . '">';

    while ($row = $result->fetch_assoc()) {
        echo '<label for="attendance_' . $row['student_id'] . '">';
        echo '<input type="checkbox" name="attendance[]" value="' . $row['student_id'] . '"> ' . $row['student_name'];
        echo '</label><br>';
    }

    echo '<label for="attendance_date">Attendance Date:</label>';
    echo '<input type="date" name="attendance_date" required><br>';

    echo '<input type="submit" value="Submit Attendance">';
    echo '</form>';
} else {
    echo 'Invalid request';
}

// Close the prepared statement
$stmt->close();

// Close the connection
mysqli_close($conn);
?>