<?php
// Start output buffering
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the TCPDF library
require_once('TCPDF-main/tcpdf.php');

// Include database connection
require_once('info.php');

// Function to retrieve leave form data for a specific student and date
function getLeaveFormData($student_id, $leave_date, $conn) {
    // Prepare SQL query to retrieve leave form data for the given student ID and leave date
    $sql = "SELECT * FROM leave_forms WHERE student_id = $student_id AND leave_date = '$leave_date'";
    
    // Execute SQL query
    $result = mysqli_query($conn, $sql);
    
    // Check if query was successful
    if ($result && mysqli_num_rows($result) > 0) {
        // Fetch data
        $data = mysqli_fetch_assoc($result);
    } else {
        $data = array(); // No data found
    }
    
    return $data;
}

// Get student ID and leave date from the URL parameters
$student_id = isset($_GET['student_id']) ? $_GET['student_id'] : null;
$leave_date = isset($_GET['leave_date']) ? $_GET['leave_date'] : null;

// Check if both student ID and leave date are provided
if ($student_id && $leave_date) {
    // Retrieve leave form data for the specified student ID and leave date
    $leaveFormData = getLeaveFormData($student_id, $leave_date, $conn);
    
    // Check if leave form data is found
    if ($leaveFormData) {
        // Create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        
        // Set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Your Name');
        $pdf->SetTitle('Leave Form');
        $pdf->SetSubject('Leave Form Submission');
        $pdf->SetKeywords('Leave, Form, PDF');
        
        // Add a page
        $pdf->AddPage();
        
        // Set some content
        $pdf->SetFont('helvetica', '', 12);
        $pdf->Cell(0, 10, 'Leave Form', 0, 1, 'C');
        $pdf->Ln(5);
    
        // Display leave form fields and data
        $pdf->Cell(50, 10, 'Student Name:', 0, 0, 'L');
        $pdf->Cell(0, 10, $leaveFormData['student_name'], 0, 1, 'L');
        $pdf->Cell(50, 10, 'Class:', 0, 0, 'L');
        $pdf->Cell(0, 10, $leaveFormData['class_name'], 0, 1, 'L');
        $pdf->Cell(50, 10, 'Roll Number:', 0, 0, 'L');
        $pdf->Cell(0, 10, $leaveFormData['roll_number'], 0, 1, 'L');
        $pdf->Cell(50, 10, 'Reason for Leave:', 0, 0, 'L');
        $pdf->Cell(0, 10, $leaveFormData['reason'], 0, 1, 'L');
        $pdf->Cell(50, 10, 'Signatures:', 0, 1, 'L');
        $pdf->Cell(0, 10, 'Teacher: ' . $leaveFormData['teacher_signature'] . '   Student: ' . $leaveFormData['student_signature'] . '         HOD: ' . $leaveFormData['hod_signature'], 0, 1, 'L');
        $pdf->Cell(50, 10, 'Date:', 0, 1, 'L');
        $pdf->Cell(0, 10, $leaveFormData['leave_date'], 0, 1, 'L');
    
        // Generate the file path including student name and leave date
        $fileName = 'leave_form_' . $leaveFormData['student_name'] . '_' . $leaveFormData['leave_date'] . '.pdf';
        $filePath = 'C:/xampp/htdocs/dsb/leaveform/' . $fileName;
    
        // Create the directory if it doesn't exist
        if (!file_exists('C:/xampp/htdocs/dsb/leaveform/')) {
            mkdir('C:/xampp/htdocs/dsb/leaveform/', 0777, true);
        }
        // Output the PDF as a string
        $pdfData = $pdf->Output('', 's');
    
        // Clean the output buffer
        ob_end_clean();
    
        // Save the PDF data to a file
        file_put_contents($filePath, $pdfData);
    
        echo 'PDF generated successfully and saved as: ' . $filePath;
    } else {
        echo 'No leave form found for the provided student ID and leave date.';
    }
} else {
    echo 'Student ID or leave date is not provided.';
}
?>
<html>
<body>
<form action="teacher_dashboard.php" method="get"> 
    <button type="submit">Return to Dashboard</button> <!-- Button to return to admin dashboard -->
</form>
</body>
</html>
