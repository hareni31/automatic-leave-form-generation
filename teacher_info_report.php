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

// Fetch teacher information from the database
$query = "SELECT * FROM teachers";
$result = mysqli_query($conn, $query);

// Check if there are any teachers
if (mysqli_num_rows($result) > 0) {
    // Start building the HTML table
    $table_html = '<table>
                        <thead>
                            <tr>
                                <th>Teacher ID</th>
                                <th>Teacher Name</th>
                                <th>Department</th>
                                <th>Email</th>
                                <th>Course</th>
                            </tr>
                        </thead>
                        <tbody>';

    // Fetch and display each teacher as a table row
    while ($row = mysqli_fetch_assoc($result)) {
        $table_html .= '<tr>';
        $table_html .= '<td>' . $row['teacher_id'] . '</td>';
        $table_html .= '<td>' . $row['teacher_name'] . '</td>';
        $table_html .= '<td>' . $row['teacher_dept'] . '</td>';
        $table_html .= '<td>' . $row['teacher_email'] . '</td>';
        $table_html .= '<td>' . $row['teacher_course'] . '</td>';
        $table_html .= '</tr>';
    }

    // Close the table body and table
    $table_html .= '</tbody></table>';

    // Output the generated HTML table
    echo $table_html;
} else {
    // If no teachers found, display a message
    echo 'No teachers found.';
}

// Close the database connection
mysqli_close($conn);
?>
</body>
</html>