<?php
// report_handler.php

// Check if the request method is GET and if the 'report_type' parameter is set
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['report_type'])) {
    $report_type = $_GET['report_type'];

    // Redirect to the corresponding report page based on the selected report type
    switch ($report_type) {
        case 'attendance':
            header("Location: attendance_report.php");
            break;
        case 'classwise_attendance':
            header("Location: classwise_attendance_report.php");
            break;
        case 'leave_forms':
            header("Location: leave_forms_report.php");
            break;
        case 'student_info':
            header("Location: student_info_report.php");
            break;
        case 'teacher_info':
            header("Location: teacher_info_report.php");
            break;
        case 'user_activity':
            header("Location: user_activity_report.php");
            break;
        default:
            // If an invalid report type is provided, display an error message
            header("Location: report_handler.php?report_type=error");
            exit; // Stop script execution
    }
}
?>
