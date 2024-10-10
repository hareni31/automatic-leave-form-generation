<?php
// Include the database connection file
include('info.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $class_id = $_POST['class_id'];
    $attendance_date = $_POST['attendance_date'];

    // Retrieve absent students for the selected class on the selected date
    $query = "SELECT students.student_id, students.student_name 
              FROM students 
              LEFT JOIN attendance ON students.student_id = attendance.student_id AND attendance.attendance_date = '$attendance_date'
              WHERE students.class_id = '$class_id' 
              AND attendance.student_id IS NULL";

    $result = mysqli_query($connection, $query);

    if ($result) {
        echo "<h2>Absent Students for Class ID: $class_id on $attendance_date</h2>";

        while ($row = mysqli_fetch_assoc($result)) {
            echo "Student ID: {$row['student_id']}, Name: {$row['student_name']}<br>";
        }
    } else {
        echo 'Error in query: ' . mysqli_error($connection);
    }
} else {
    echo 'Invalid request';
}

// Close the connection
mysqli_close($connection);
?>
