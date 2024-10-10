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

// Fetch leave forms data from the database
$query = "SELECT * FROM leave_forms";
$result = mysqli_query($conn, $query);

// Check if there are any leave forms
if (mysqli_num_rows($result) > 0) {
    // Start building the HTML table
    $table_html = '<table>
                        <thead>
                            <tr>
                                <th>Leave ID</th>
                                <th>Student Name</th>
                                <th>Class Name</th>
                                <th>Roll Number</th>
                                <th>Leave Date</th>
                                <th>Reason</th>
                            </tr>
                        </thead>
                        <tbody>';

    // Fetch and display each leave form as a table row
    while ($row = mysqli_fetch_assoc($result)) {
        $table_html .= '<tr>';
        $table_html .= '<td>' . $row['leave_id'] . '</td>';
        $table_html .= '<td>' . $row['student_name'] . '</td>';
        $table_html .= '<td>' . $row['class_name'] . '</td>';
        $table_html .= '<td>' . $row['roll_number'] . '</td>';
        $table_html .= '<td>' . $row['leave_date'] . '</td>';
        $table_html .= '<td>' . $row['reason'] . '</td>';
        $table_html .= '</tr>';
    }

    // Close the table body and table
    $table_html .= '</tbody></table>';

    // Output the generated HTML table
    echo $table_html;
} else {
    // If no leave forms found, display a message
    echo 'No leave forms found.';
}

// Close the database connection
mysqli_close($conn);
?>
</body>
</html>