<?php
require_once 'info.php'; // Include conn.php to establish the database connection

// Check if the connection variable is defined
if (!isset($conn)) {
    die("Connection failed: Database connection variable is not set.");
}
if(isset($_GET['success']) && $_GET['success'] == 1) {
    echo "<p>Attendance marked successfully!</p>";
}
// Retrieve classes from the database
$query = "SELECT * FROM classes";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mark Attendance</title>
    <link rel="stylesheet" href="styles.css"> <!-- Include your stylesheet here -->
</head>
<body>
    <div class="container">
        <h2>Select a Class to Mark Attendance:</h2>

        <form action="processMark_Attendance.php" method="post">
            <label for="class_id">Select Class:</label>
            <select name="class_id" required>
                <?php
                // Display classes as options
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<option value="' . $row['class_id'] . '">' . $row['class_name'] . '</option>';
                }
                ?>
            </select><br>
            <input type="submit" value="Mark Attendance">
        </form>
<form action="teacher_dashboard.php" method="get"> 
        <button type="submit">Return to Dashboard</button> <!-- Button to return to admin dashboard -->
    </form>
    </div>
</body>
</html>