<?php
session_start();
require_once 'info.php'; // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Initialize variables
    $username = $password = $role = '';
    $username_err = $password_err = $role_err = '';

    // Validate username
    // Password and role validations are not necessary for this part

    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter username.";
    } else {
        $username = trim($_POST["username"]);
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate role
    if (empty(trim($_POST["role"]))) {
        $role_err = "Please select a role.";
    } else {
        $role = trim($_POST["role"]);
    }

    // Check input errors before database lookup
    if (empty($username_err) && empty($password_err) && empty($role_err)) {
        // Prepare a select statement with role filter
        $sql = "SELECT id, username, password, role FROM users WHERE username = ? AND role = ?";

        if ($stmt = $conn->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("ss", $param_username, $param_role);

            // Set parameters
            $param_username = $username;
            $param_role = $role;

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Store result
                $stmt->store_result();

                // Check if username exists, if yes then verify password
                if ($stmt->num_rows == 1) {
                    // Bind result variables
                    $stmt->bind_result($id, $username, $hashed_password, $role);
                    if ($stmt->fetch()) {
                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;
                            $_SESSION["role"] = $role; // Store role in session

                            // Redirect user to appropriate dashboard based on role
                            switch ($role) {
                                case 'admin':
                                    header("location: admin_dashboard.php");
                                    exit();
                                case 'teacher':
                                    header("location: teacher_dashboard.php");
                                    exit();
                                case 'student':
                                    header("location: student_dashboard.php");
                                    exit();
                                default:
                                    // Redirect to a default page if role is not recognized
                                    header("location: default_dashboard.php");
                                    exit();
                            }
                        } else {
                            // Password is not valid
                            $password_err = "The password you entered is not valid.";
                        }
                    }
                } else {
                    // Username doesn't exist
                    $username_err = "No account found with that username and role.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }

    // Close connection
    $conn->close();
}
?>
