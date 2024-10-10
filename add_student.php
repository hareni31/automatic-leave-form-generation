<?php
// Include database connection
require_once 'info.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $studentName = $_POST['student_name'];
    $rollNumber = $_POST['roll_number'];
    $classId = $_POST['class_id'];

    // Insert new student into the database
    $sql = "INSERT INTO students (student_name, roll_number, class_id) VALUES ('$studentName', '$rollNumber', $classId)";
    if ($conn->query($sql) === TRUE) {
        echo "New student added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to your CSS file -->
</head>
<body>
    <div class="container">
        <h2>Add Student</h2>
        <form method="POST" action="">
            <label for="student_name">Student Name:</label>
            <input type="text" name="student_name" required>
            <label for="roll_number">Roll Number:</label>
            <input type="text" name="roll_number" required>
            <label for="class_id">Class:</label>
            <select name="class_id" required>
                <?php
                // Fetch classes from the database
                $sql = "SELECT * FROM classes";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['class_id'] . "'>" . $row['class_name'] . "</option>";
                    }
                } else {
                    echo "<option value=''>No classes found</option>";
                }
                ?>
            </select>
            <button type="submit">Add Student</button>
        </form>
    </div>
</body>
</html>
