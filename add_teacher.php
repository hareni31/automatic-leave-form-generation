<?php
session_start();
require_once 'info.php'; // Include database connection

// Check if the user is logged in as an admin, otherwise redirect to login page

// Define variables and initialize with empty values
$teacher_name = $teacher_dept = $teacher_email = $teacher_course = "";
$teacher_name_err = $teacher_dept_err = $teacher_email_err = $teacher_course_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate teacher name
    if (empty(trim($_POST["teacher_name"]))) {
        $teacher_name_err = "Please enter teacher's name.";
    } else {
        $teacher_name = trim($_POST["teacher_name"]);
    }

    // Validate department
    if (empty(trim($_POST["teacher_dept"]))) {
        $teacher_dept_err = "Please enter teacher's department.";
    } else {
        $teacher_dept = trim($_POST["teacher_dept"]);
    }

    // Validate email
    if (empty(trim($_POST["teacher_email"]))) {
        $teacher_email_err = "Please enter teacher's email.";
    } else {
        $teacher_email = trim($_POST["teacher_email"]);
    }

    // Validate course
    if (empty(trim($_POST["teacher_course"]))) {
        $teacher_course_err = "Please enter the course.";
    } else {
        $teacher_course = trim($_POST["teacher_course"]);
    }

    // Check input errors before inserting into database
    if (empty($teacher_name_err) && empty($teacher_dept_err) && empty($teacher_email_err) && empty($teacher_course_err)) {

        // Prepare an insert statement
        $sql = "INSERT INTO teachers (teacher_name, teacher_dept, teacher_email, teacher_course) VALUES (?, ?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("ssss", $param_teacher_name, $param_teacher_dept, $param_teacher_email, $param_teacher_course);

            // Set parameters
            $param_teacher_name = $teacher_name;
            $param_teacher_dept = $teacher_dept;
            $param_teacher_email = $teacher_email;
            $param_teacher_course = $teacher_course;

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Redirect to manage_teachers.php
                header("location: manage_teachers.php");
                exit();
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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Teacher</title>
    <link rel="stylesheet" href="style.css"> <!-- Ensure correct path to your CSS file -->
</head>
<body>
    <h2>Add Teacher</h2>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-group <?php echo (!empty($teacher_name_err)) ? 'has-error' : ''; ?>">
            <label>Name</label>
            <input type="text" name="teacher_name" class="form-control" value="<?php echo $teacher_name; ?>">
            <span class="help-block"><?php echo $teacher_name_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($teacher_dept_err)) ? 'has-error' : ''; ?>">
            <label>Department</label>
            <input type="text" name="teacher_dept" class="form-control" value="<?php echo $teacher_dept; ?>">
            <span class="help-block"><?php echo $teacher_dept_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($teacher_email_err)) ? 'has-error' : ''; ?>">
            <label>Email</label>
            <input type="email" name="teacher_email" class="form-control" value="<?php echo $teacher_email; ?>">
            <span class="help-block"><?php echo $teacher_email_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($teacher_course_err)) ? 'has-error' : ''; ?>">
            <label>Course</label>
            <input type="text" name="teacher_course" class="form-control" value="<?php echo $teacher_course; ?>">
            <span class="help-block"><?php echo $teacher_course_err; ?></span>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Submit">
            <a class="btn btn-link" href="manage_teachers.php">Cancel</a>
        </div>
    </form>
</body>
</html>