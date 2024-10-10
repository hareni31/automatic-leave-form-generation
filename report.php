<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Report</title>
    <link rel="stylesheet" href="style4.css"> <!-- Link to external CSS file -->
</head>
<body>
    <div class="container">
        <h2>Select Report:</h2>
        <div class="report-options">
            <div class="report-option">
                <a href="report_handler.php?report_type=attendance">Attendance Report</a>
            </div>
            
            <div class="report-option">
                <a href="report_handler.php?report_type=leave_forms">Leave Forms Report</a>
            </div>
            <div class="report-option">
                <a href="report_handler.php?report_type=student_info">Student Information Report</a>
            </div>
            <div class="report-option">
                <a href="report_handler.php?report_type=teacher_info">Teacher Information Report</a>
            </div>
            
        </div>
<form action="admin_dashboard.php" method="get"> <!-- Form to submit to admin dashboard -->
        <button type="submit">Return to Dashboard</button> <!-- Button to return to admin dashboard -->
    </form>
    </div>

</body>
</html>
