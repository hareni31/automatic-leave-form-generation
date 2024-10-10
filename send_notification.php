<?php
// Include the database connection file
require_once 'info.php';

// Include PHPMailer autoloader
require 'C:/xampp/htdocs/dsb/PHPMailer-master/src/PHPMailer.php';
require 'C:/xampp/htdocs/dsb/PHPMailer-master/src/SMTP.php';
require 'C:/xampp/htdocs/dsb/PHPMailer-master/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $attendance_date = $_POST['attendance_date'];
    $absent_students = $_POST['absent_students'];

    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'harenivaradharaj432@gmail.com';
        $mail->Password   = 'staz nogd pqrl zyuu';
        $mail->SMTPSecure = 'tls'; // Change to TLS
        $mail->Port       = 587;   // Change to 587

    // Send notification emails to absent students
    foreach ($absent_students as $student_id) {
        // Retrieve student details
        $query = "SELECT student_name, student_email FROM students WHERE student_id = '$student_id'";
        $result = mysqli_query($conn, $query);
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $student_name = $row['student_name'];
            $to = $row['student_email'];

            // Compose the email
            $subject = 'Absent Notification';
            $message = "Dear $student_name,\n\n";
            $message .= "You were absent on $attendance_date. Please fill out the leave form.\n\n";
            
            // Set up sender and recipient
            $mail->setFrom('harenivaradharaj432@gmail.com', 'admin');
            $mail->addAddress($to, $student_name);

            // Set email subject and body
            $mail->Subject = $subject;
            $mail->Body = $message;

            // Send the email
            if ($mail->send()) {
                echo "Notification sent to $student_name ($to) successfully.<br>";
            } else {
                echo "Failed to send notification to $student_name ($to). Error: " . $mail->ErrorInfo . "<br>";
            }
        } else {
            echo "Failed to retrieve details for student with ID: $student_id<br>";
        }
    }
} else {
    echo "Invalid request";
}

// Close the connection
mysqli_close($conn);
?>
<html><body>
<form action="teacher_dashboard.php" method="get"> 
        <button type="submit">Return to Dashboard</button> <!-- Button to return to admin dashboard -->
    </form></body></html>