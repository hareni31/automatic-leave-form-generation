<?php
// Include database connection
require_once 'info.php';

// Check if form is submitted for adding a new teacher
if(isset($_POST['submit_teacher'])) {
    $teacher_name = $_POST['teacher_name'];
    $teacher_dept = $_POST['teacher_dept']; // New field for teacher department
    $teacher_email = $_POST['teacher_email']; // New field for teacher email
    $teacher_course = $_POST['teacher_course']; // New field for teacher course

    // Insert new teacher into the database
    $sql = "INSERT INTO teachers (teacher_name, teacher_dept, teacher_email, teacher_course) VALUES (?, ?, ?, ?)";
    
    // Prepare an SQL statement
    $stmt = $conn->prepare($sql);
    
    // Bind parameters
    $stmt->bind_param("ssss", $teacher_name, $teacher_dept, $teacher_email, $teacher_course);
    
    // Execute the statement
    if ($stmt->execute()) {
        echo "New teacher added successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Fetch existing teachers
$sql = "SELECT * FROM teachers";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Teachers</title>
    <link rel="stylesheet" href="style.css"> <!-- Ensure correct path to your CSS file -->
</head>
<body>
    <h2>Manage Teachers</h2>
    <h3>Add New Teacher</h3>
    <form method="POST" action="">
        <label for="teacher_name">Teacher Name:</label>
        <input type="text" name="teacher_name" required><br><br>
        <label for="teacher_dept">Department:</label> <!-- New field for teacher department -->
        <input type="text" name="teacher_dept" required><br><br>
        <label for="teacher_email">Email:</label> <!-- New field for teacher email -->
        <input type="email" name="teacher_email" required><br><br>
        <label for="teacher_course">Course:</label> <!-- New field for teacher course -->
        <input type="text" name="teacher_course" required><br><br>
        <button type="submit" name="submit_teacher">Add Teacher</button>
    </form>
    <h3>Existing Teachers</h3>
    <ul>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<li>" . $row['teacher_name'] . " - Department: " . $row['teacher_dept'] . " - Email: " . $row['teacher_email'] . " - Course: " . $row['teacher_course'] . "</li>";
            }
        } else {
            echo "<li>No teachers found</li>";
        }
        ?>
    </ul>
    <form action="admin_dashboard.php" method="get"> <!-- Form to submit to admin dashboard -->
        <button type="submit">Return to Admin Dashboard</button> <!-- Button to return to admin dashboard -->
    </form>
</body>
</html>
