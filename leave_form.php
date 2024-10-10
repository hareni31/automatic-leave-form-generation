<?php
// Include the database connection file and ensure session is started
require_once 'info.php';


// Fetch student details from the database
$student_id = $_SESSION['student_id'];
$query = "SELECT student_name, class, roll_number FROM students WHERE student_id = $student_id";
$result = mysqli_query($conn, $query);

// Initialize variables to store student details
$student_name = $class = $roll_number = '';

// Check if student details are fetched successfully
if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    $student_name = $row['student_name'];
    $class = $row['class'];
    $roll_number = $row['roll_number'];
} else {
    // Redirect to dashboard if student details are not found
    header("Location: dashboard.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reason = $_POST['reason'];

    // Insert leave form data into the database
    $query = "INSERT INTO leave_forms (student_id, student_name, class, roll_number, reason) 
              VALUES ($student_id, '$student_name', '$class', '$roll_number', '$reason')";
    if (mysqli_query($conn, $query)) {
        echo "Leave form submitted successfully.";
        // Redirect to dashboard after submission
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Fill Leave Form</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to your CSS file -->
</head>
<body>
    <h2>Fill Leave Form</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo $student_name; ?>" readonly><br><br>
        
        <label for="class">Class:</label>
        <input type="text" id="class" name="class" value="<?php echo $class; ?>" readonly><br><br>
        
        <label for="roll_number">Roll Number:</label>
        <input type="text" id="roll_number" name="roll_number" value="<?php echo $roll_number; ?>" readonly><br><br>
        
        <label for="absent_date">Absent Date:</label>
        <input type="text" id="absent_date" name="absent_date" value="<?php echo date('Y-m-d'); ?>" readonly><br><br>
        
        <label for="reason">Reason for Leave:</label>
        <textarea name="reason" id="reason" required></textarea><br><br>
        
        <input type="submit" value="Submit Leave Form">
    </form>
</body>
</html>
