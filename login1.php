<?php
session_start();
require_once 'info.php'; // Include the database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and execute SQL query to retrieve user information
    $sql = "SELECT id, username, role, password FROM user WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a user with the given username exists
    if ($result->num_rows == 1) {
        // Fetch user data from the result
        $user = $result->fetch_assoc();

        // Compare the passwords directly (plaintext comparison)
        if ($password === $user['password']) {
            // Store user data in session variables
            $_SESSION['id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Redirect the user to the appropriate dashboard based on their role
            switch ($user['role']) {
                case 'admin':
                    header("Location: admin_dashboard.php");
                    exit();
                case 'student':
                    header("Location: student_dashboard.php");
                    exit();
                case 'teacher':
                    header("Location: teacher_dashboard.php");
                    exit();
                default:
                    // Handle invalid role
                    echo "Invalid role. Please contact support.";
                    exit();
            }
        } else {
            // Password verification failed
            echo "Invalid password. Please try again.";
        }
    } else {
        // User not found or multiple users found
        echo "User not found. Please register or check your credentials.";
    }

    // Close prepared statement and database connection
    $stmt->close();
    $conn->close();
}
?>
