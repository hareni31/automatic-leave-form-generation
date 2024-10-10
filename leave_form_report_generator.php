<?php
// Include TCPDF library
require_once('tcpdf/tcpdf.php');

// Include the database connection file
require_once('info.php');

// Create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Leave Form Report');
$pdf->SetSubject('Leave Form Report');
$pdf->SetKeywords('Leave, Form, Report');

// Set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// Set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// Set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// Set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// Set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// Set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// Set font
$pdf->SetFont('helvetica', '', 12);

// Add a page
$pdf->AddPage();

// Retrieve leave form data from the database
$query = "SELECT * FROM leave_forms";
$result = mysqli_query($conn, $query);

// Check if there is data to display
if (mysqli_num_rows($result) > 0) {
    // Add header row
    $pdf->Cell(40, 10, 'Student Name', 1, 0, 'C');
    $pdf->Cell(40, 10, 'Class', 1, 0, 'C');
    $pdf->Cell(40, 10, 'Roll Number', 1, 0, 'C');
    $pdf->Cell(80, 10, 'Reason for Leave', 1, 1, 'C');

    // Loop through the data and add rows to the PDF
    while ($row = mysqli_fetch_assoc($result)) {
        $pdf->Cell(40, 10, $row['student_name'], 1, 0, 'C');
        $pdf->Cell(40, 10, $row['class'], 1, 0, 'C');
        $pdf->Cell(40, 10, $row['roll_number'], 1, 0, 'C');
        $pdf->Cell(80, 10, $row['reason'], 1, 1, 'C');
    }
} else {
    // If no data found, display a message
    $pdf->Cell(0, 10, 'No leave form data available.', 0, 1, 'C');
}

// Output PDF to the browser
$pdf->Output('leave_form_report.pdf', 'D'); // D means force download

// Close PDF document
$pdf->close();

// Close the database connection
mysqli_close($conn);
?>
