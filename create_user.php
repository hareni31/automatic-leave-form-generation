<?php
// Include database connection
require_once 'info.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Prepare SQL query to insert user information
    $sql = "INSERT INTO user (username, password, role) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $username, $password, $role); // Store password as plaintext
    $stmt->execute();

    echo "User created successfully";
    $stmt->close();
}

$conn->close();
?>
<form action="admin_dashboard.php" method="get"> <!-- Form to submit to admin dashboard -->
        <button type="submit">Return to Dashboard</button> <!-- Button to return to admin dashboard -->
    </form>