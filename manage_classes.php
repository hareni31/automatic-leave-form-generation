<?php

// Include database connection
require_once 'info.php';

// Check if form is submitted for adding a new class
if(isset($_POST['submit_class'])) {
    $class_name = $_POST['class_name'];

    // Prepare an SQL statement
    $stmt = $conn->prepare("INSERT INTO classes (class_name) VALUES (?)");
    
    // Bind parameters
    $stmt->bind_param("s", $class_name);
    
    // Execute the statement
    if ($stmt->execute()) {
        // Refresh the page to display the updated list of classes
        header("Location: manage_classes.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Fetch existing classes
$sql = "SELECT * FROM classes";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Classes</title>
    <link rel="stylesheet" href="style.css"> <!-- Ensure correct path to your CSS file -->
</head>
<body>
    <h2>Manage Classes</h2>
    <h3>Add New Class</h3>
    <form method="POST" action="">
        <label for="class_name">Class Name:</label>
        <input type="text" name="class_name" required>
        <button type="submit" name="submit_class">Add Class</button>
    </form>
    <h3>Existing Classes</h3>
    <ul>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<li>" . $row['class_name'] . "</li>";
            }
        } else {
            echo "<li>No classes found</li>";
        }
        ?>
    </ul>
    <form action="admin_dashboard.php" method="get"> <!-- Form to submit to admin dashboard -->
        <button type="submit">Return to Dashboard</button> <!-- Button to return to admin dashboard -->
    </form>
</body>
</html>
