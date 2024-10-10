<?php
// Include database connection
require_once 'info.php';

// Check if form is submitted to add a new class
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_class'])) {
    $className = $_POST['class_name'];

    // Prepare and bind the SQL statement
    $sql = "INSERT INTO classes (class_name) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $className);

    // Execute the statement
    if ($stmt->execute()) {
        $add_class_message = "New class added successfully";
    } else {
        $add_class_error = "Error adding new class: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Fetch existing classes from the database
$sql = "SELECT class_id, class_name FROM classes";
$result = $conn->query($sql);

$classes = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $classes[] = $row;
    }
}

// Close the database connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Classes</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to your CSS file -->
</head>
<body>
    <div class="container">
        <h2>Manage Classes</h2>
        <!-- Form to add a new class -->
        <form method="POST" action="">
            <label for="class_name">New Class Name:</label>
            <input type="text" name="class_name" required>
            <button type="submit" name="add_class">Add Class</button>
            <?php
            if (isset($add_class_message)) {
                echo "<p class='success-message'>$add_class_message</p>";
            }
            if (isset($add_class_error)) {
                echo "<p class='error-message'>$add_class_error</p>";
            }
            ?>
        </form>

        <!-- List of existing classes -->
        <h3>Existing Classes:</h3>
        <ul>
            <?php
            foreach ($classes as $class) {
                echo "<li>{$class['class_name']}</li>";
            }
            ?>
        </ul>
    </div>
</body>
</html>
