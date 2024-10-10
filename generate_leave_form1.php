<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Leave Form PDF</title>
    <link rel="stylesheet" href="style.css"> <!-- Ensure correct path to your CSS file -->
</head>
<body>
    <h2>Generate Leave Form PDF</h2>
    <form action="generate_leave_form_pdf.php" method="GET">
        <label for="student_id">Enter Student ID:</label>
        <input type="text" id="student_id" name="student_id" required>

        <label for="leave_date">Select Leave Date:</label>
        <input type="date" id="leave_date" name="leave_date" required>

        <button type="submit">Generate PDF</button>
    </form>
</body>
</html>

