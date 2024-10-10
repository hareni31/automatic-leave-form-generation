<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Forms Report</title>
    <link rel="stylesheet" href="style5.css">
</head>
<body>

<?php
// Include the database connection file
require_once 'info.php';

// Fetch student information from the database
$query = "SELECT * FROM students";
$result = mysqli_query($conn, $query);

// Check if there are any students
if (mysqli_num_rows($result) > 0) {
    // Start building the HTML table
    $table_html = '<table>
                        <thead>
                            <tr>
                                <th>Student ID</th>
                                <th>Student Name</th>
                                <th>Roll Number</th>
                                <th>Class ID</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>';

    // Fetch and display each student as a table row
    while ($row = mysqli_fetch_assoc($result)) {
        $table_html .= '<tr>';
        $table_html .= '<td>' . $row['student_id'] . '</td>';
        $table_html .= '<td>' . $row['student_name'] . '</td>';
        $table_html .= '<td>' . $row['roll_number'] . '</td>';
        $table_html .= '<td>' . $row['class_id'] . '</td>';
        $table_html .= '<td>' . $row['student_email'] . '</td>';
        $table_html .= '</tr>';
    }

    // Close the table body and table
    $table_html .= '</tbody></table>';

    // Output the generated HTML table
    echo $table_html;
} else {
    // If no students found, display a message
    echo 'No students found.';
}

// Close the database connection
mysqli_close($conn);
?>
</body>
</html>