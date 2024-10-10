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

// Fetch attendance data from the database
$query = "SELECT * FROM attendance";
$result = mysqli_query($conn, $query);

// Check if there is any attendance data
if (mysqli_num_rows($result) > 0) {
    // Start building the HTML table
    $table_html = '<table>
                        <thead>
                            <tr>
                                <th>Attendance ID</th>
                                <th>Student ID</th>
                                <th>Class ID</th>
                                <th>Attendance Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>';

    // Fetch and display each attendance record as a table row
    while ($row = mysqli_fetch_assoc($result)) {
        $table_html .= '<tr>';
        $table_html .= '<td>' . $row['attendance_id'] . '</td>';
        $table_html .= '<td>' . $row['student_id'] . '</td>';
        $table_html .= '<td>' . $row['class_id'] . '</td>';
        $table_html .= '<td>' . $row['attendance_date'] . '</td>';
        $table_html .= '<td>' . $row['status'] . '</td>';
        $table_html .= '</tr>';
    }

    // Close the table body and table
    $table_html .= '</tbody></table>';

    // Output the generated HTML table
    echo $table_html;
} else {
    // If no attendance data found, display a message
    echo 'No attendance data found.';
}

// Close the database connection
mysqli_close($conn);
?>
</body>
</html>