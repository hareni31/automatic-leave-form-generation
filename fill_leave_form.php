<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

// Include database connection
require_once 'db.php';

// Retrieve the student's roll number
$roll_number = $_SESSION['roll_number'];

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = $_POST['date'];
    $reason = $_POST['reason'];

    // Insert leave form into database
    $insert_query = "INSERT INTO leave_forms (student_roll_number, date, reason) VALUES ('$roll_number', '$date', '$reason')";
    $insert_result = mysqli_query($connection, $insert_query);

    if ($insert_result) {
        echo "<p>Leave form submitted successfully!</p>";
    } else {
        echo "<p>Error submitting leave form.</p>";
    }
}

// Close database connection
mysqli_close($connection);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fill Leave Form</title>
</head>
<body>
    <h2>Fill Leave Form</h2>
    <form method="POST">
        <label for="date">Date:</label>
        <input type="date" id="date" name="date" required><br>
        <label for="reason">Reason:</label>
        <textarea id="reason" name="reason" required></textarea><br>
        <button type="submit">Submit</button>
    </form>
</body>
</html>
