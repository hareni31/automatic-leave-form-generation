<?php
// Include the database connection file
require_once 'info.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['student_id'])) {
    // Retrieve student_id from the POST array
    $student_id = $_POST['student_id'];

    // Retrieve student details from the database
    $query = "SELECT students.*, classes.class_name 
              FROM students 
              LEFT JOIN classes ON students.class_id = classes.class_id
              WHERE students.student_id = '$student_id'";

    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        // Fetch student details
        $row = mysqli_fetch_assoc($result);
        $student_name = $row['student_name'];
        $class_name = $row['class_name'];
        $roll_number = $row['roll_number'];

        // Display the leave form for the selected student
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>Leave Form</title>
        </head>
        <body>
            <h2>Leave Form</h2>
            <form action="process_leave_form.php" method="post">
                <input type="hidden" name="student_id" value="<?php echo $student_id; ?>">
                <label for="student_name">Student Name:</label>
                <input type="text" name="student_name" value="<?php echo $student_name; ?>" readonly><br>
                <label for="class">Class:</label>
                <input type="text" name="class" value="<?php echo $class_name; ?>" readonly><br>
                <label for="roll_number">Roll Number:</label>
                <input type="text" name="roll_number" value="<?php echo $roll_number; ?>" readonly><br>
                <label for="reason">Reason for Leave:</label>
                <textarea name="reason" required></textarea><br><br>
                <!-- Add signature fields for teacher, student, and HOD -->
                <label for="teacher_signature">Teacher Signature:</label>
                <input type="text" name="teacher_signature" required><br>
                <label for="student_signature">Student Signature:</label>
                <input type="text" name="student_signature" required><br>
                <label for="hod_signature">HOD Signature:</label>
                <input type="text" name="hod_signature" required><br><br>
                <input type="submit" value="Submit Leave Form">
            </form>
        </body>
        </html>
        <?php
    } else {
        echo 'Student not found.';
    }
} else {
    echo 'Invalid request';
}
?>
