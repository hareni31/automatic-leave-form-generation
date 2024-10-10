<?php
// Include database connection
require_once 'info.php';

// Check if form is submitted for adding a new student
if(isset($_POST['submit_student'])) {
    $student_name = $_POST['student_name'];
    $roll_number = $_POST['roll_number'];
    $class_id = $_POST['class_id'];
    $student_email = $_POST['student_email']; // New field for student email

    // Insert new student into the database
    $sql = "INSERT INTO students (student_name, roll_number, class_id, student_email) VALUES (?, ?, ?, ?)";
    
    // Prepare an SQL statement
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bind_param("ssis", $student_name, $roll_number, $class_id, $student_email);

    // Execute the statement
    if ($stmt->execute()) {
        // Refresh the page to display the updated list of students
        header("Location: manage_students.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Fetch existing students
$sql = "SELECT * FROM students";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Students</title>
    <link rel="stylesheet" href="style.css"> <!-- Ensure correct path to your CSS file -->
</head>
<body>
    <h2>Manage Students</h2>
    <h3>Add New Student</h3>
    <form method="POST" action="">
        <label for="student_name">Student Name:</label>
        <input type="text" name="student_name" required><br><br>
        <label for="roll_number">Roll Number:</label>
        <input type="text" name="roll_number" required><br><br>
        <label for="class_id">Class:</label>
        <select name="class_id" required>
            <!-- Fetch and display existing classes as options -->
            <?php
            $sql = "SELECT * FROM classes";
            $class_result = $conn->query($sql);
            if ($class_result->num_rows > 0) {
                while ($class_row = $class_result->fetch_assoc()) {
                    echo "<option value='" . $class_row['class_id'] . "'>" . $class_row['class_name'] . "</option>";
                }
            } else {
                echo "<option value=''>No classes found</option>";
            }
            ?>
        </select><br><br>
        <label for="student_email">Email:</label> <!-- New field for student email -->
        <input type="email" name="student_email" required><br><br> <!-- New input field for student email -->
        <button type="submit" name="submit_student">Add Student</button>
    </form>
    <h3>Existing Students</h3>
    <ul>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<li>" . $row['student_name'] . " - Roll Number: " . $row['roll_number'] . "</li>";
            }
        } else {
            echo "<li>No students found</li>";
        }
        ?>
    </ul>
    <form action="admin_dashboard.php" method="get"> <!-- Form to submit to admin dashboard -->
        <button type="submit">Return to Dashboard</button> <!-- Button to return to admin dashboard -->
    </form>
</body>
</html>
