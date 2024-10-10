<?php
// Include the database connection file
require_once 'info.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $class_id = $_POST['class_id'];
    $attendance_date = $_POST['attendance_date'];

    // Retrieve absent students for the selected class on the selected date
    $query = "SELECT students.student_id, students.student_name, students.student_email
              FROM students 
              LEFT JOIN attendance ON students.student_id = attendance.student_id AND attendance.attendance_date = ?
              WHERE students.class_id = ? 
              AND attendance.student_id IS NULL";

    // Prepare the query
    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        die('Error in preparing query: ' . $conn->error);
    }

    // Bind parameters and execute the statement
    $stmt->bind_param("si", $attendance_date, $class_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<h2>Absent Students for Class ID: $class_id on $attendance_date</h2>";

        // Display absent students and form to send notification
        echo '<form action="send_notification.php" method="post">';
        echo '<input type="hidden" name="attendance_date" value="' . $attendance_date . '">';
        while ($row = $result->fetch_assoc()) {
            echo "<input type='hidden' name='absent_students[]' value='{$row['student_id']}'>";
            echo "Student ID: " . $row["student_id"] . " - Name: " . $row["student_name"] . "<br>";
        }
        echo '<input type="submit" value="Send Notification">';
        echo '</form>';
    } else {
        echo 'No absent students found.';
    }

    // Close the statement
    $stmt->close();
} else {
    // Display class selection form
    $query = "SELECT * FROM classes";
    $result = mysqli_query($conn, $query);
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Filter Absent Students</title>
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <link rel="stylesheet" href="style2.css">
    </head>
    <body>
        <h2>Select a Class to Filter Absent Students:</h2>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="class_id">Select Class:</label>
            <select name="class_id" required>
                <?php
                // Display classes as options
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<option value="' . $row['class_id'] . '">' . $row['class_name'] . '</option>';
                }
                ?>
            </select><br>
            <label for="attendance_date">Select Date:</label>
            <input type="text" id="attendance_date" name="attendance_date" required><br>
            <script>
                $(function() {
                    $("#attendance_date").datepicker({ dateFormat: 'yy-mm-dd' });
                });
            </script>
            <input type="submit" value="Filter Absent Students">
        </form>

        <?php
        // Close the connection
        mysqli_close($conn);
        ?>
    </body>
    </html>
    <?php
}
?>
