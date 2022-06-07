<?php
/**
 * This file may not be redistributed in whole or significant part.
 * ---------------- THIS IS NOT FREE SOFTWARE ----------------
 *
 *
 * @file        email_student.php
 * @package     Student Payment Validation System
 * @author      rzkwsnj <drg.rizkiwisnuaji@gmail.com>
 * @copyright   2022 rzkwsnj. All Rights Reserved.
 * @license     https://opensource.org/licenses/MIT
 * @version     Release: @1.0.0@
 * @framework   http://php.net
 *
 *
 * ---------------- THIS IS NOT FREE SOFTWARE ----------------
 * This file may not be redistributed in whole or significant part.
 **/

# ===================================
#  STUGATE PROJECTS
# ===================================

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

//Load Composer's autoloader
require '../vendor/autoload.php';
require '../plugins/fpdf184/fpdf.php';
include('../core/db.php');
include("../core/helpers.php");
$getid = xss_clean($_GET['id']);
global $con;
$my_result = mysqli_query($con, "SELECT * FROM students WHERE student_id='$getid'");
$num_rows = mysqli_num_rows($my_result);

if ($num_rows > 0) {
    $data = mysqli_fetch_array($my_result);

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host = 'smtp.mailtrap.io';                     //Set the SMTP server to send through
        $mail->SMTPAuth = true;                                   //Enable SMTP authentication
        $mail->Username = 'xxxxxxxxxx';                     //SMTP username
        $mail->Password = 'xxxxxxxxxx';                               //SMTP password
        // $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port = 2525;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('backend@example.com', 'STUGATE');
        $mail->addAddress($data["student_email"], $data["student_name"]);     //Add a recipient
        // $mail->addAddress('ellen@example.com');               //Name is optional
        // $mail->addReplyTo('info@example.com', 'Information');
        // $mail->addCC('cc@example.com');
        // $mail->addBCC('bcc@example.com');

        //Attachments
        $pdf = new FPDF('L', 'mm', array(86, 54));
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Image('../uploads/images/school_images/' . schoolLogoById($data['school_id']), 0, 0, 30, 35);
        $pdf->Image('https://chart.googleapis.com/chart?chs=100x100&cht=qr&chl=' . $data["student_code"] . '&chld=L|1&choe=UTF-8', 20, 0, 30, 30, 'PNG');
        //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
        $mail->addStringAttachment($pdf->Output("S", str_replace(" ", "_", $data['student_name']) . '.pdf'), str_replace(" ", "_", $data['student_name']) . '.pdf');

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Here is your student card';
        $mail->Body = 'Hi ' . $data['student_name'] . ', This is your <b>student card!</b>';
        $mail->AltBody = 'Hi ' . $data['student_name'] . ', This is your student card!';

        $mail->send();
        echo "<script>alert('Message has been sent!')</script>";
        echo "<script>window.open('all_students.php','_self')</script>";
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    echo "<script>alert('Something went wrong!')</script>";
    echo "<script>window.open('all_students.php','_self')</script>";
}