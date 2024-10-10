<?php
// Include the database connection file
require_once 'info.php';

// Retrieve classes from the database
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

    <form action="processFilter_Absent.php" method="post">
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
