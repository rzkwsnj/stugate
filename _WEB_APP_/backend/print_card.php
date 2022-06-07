<?php
/**
 * This file may not be redistributed in whole or significant part.
 * ---------------- THIS IS NOT FREE SOFTWARE ----------------
 *
 *
 * @file        print_card.php
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

error_reporting(0);
global $con;
session_start();

if (isset($_SESSION['email'])  AND isset($_SESSION['key']) )
    echo " ";
else {
    header("location:../index.php");

}

require '../plugins/fpdf184/fpdf.php';
include("../core/db.php");
include("../core/helpers.php");

$student_code = xss_clean($_GET['code']);
$query = mysqli_query($con, "SELECT * FROM students WHERE student_code='$student_code' LIMIT 1");
$num_rows = mysqli_num_rows($query);
if ($num_rows < 1 ) {
	echo "<script>alert('Something went wrong!')</script>";
	echo "<script>window.open('all_students.php','_self')</script>";
} else {
	$row = mysqli_fetch_assoc($query);
}

try {
    $pdf = new FPDF('P','mm','A4');
    $pdf->AddPage();

    $pdf->Image('../uploads/images/student_images/card_placeholder.png', 10, 10, 86, 54,'', '');
    $pdf->SetXY(28.5, 32.5);
    $pdf->SetFont('Times','',9);
    $pdf->Cell(9.5,8,$row['student_name'],0,4,'L');
    $pdf->SetXY(36.5, 37);
    $pdf->Cell(9.5,8,$row['student_code'],0,4,'L');
    $pdf->SetXY(26, 41.5);
    $pdf->Cell(9.5,8,$row['student_department'],0,4,'L');
    $pdf->SetXY(18.5, 45.5);
    $pdf->Cell(9.5,8,$row['student_level'],0,4,'L');
    $pdf->SetXY(31.5, 50);
    $pdf->Cell(9.5,8,$row['student_session_paid'] . ' Academic Session',0,4,'L');
    $pdf->Image('../uploads/images/student_images/'.$row["student_image"], 72.5, 17, 22, 22,'', '');
    $pdf->Image('https://chart.googleapis.com/chart?chs=100x100&cht=qr&chl='.$row["student_code"].'&chld=L|1&choe=UTF-8',74,42,18,18,'PNG');
    $pdf->SetXY(19.5, 54);
    $pdf->Cell(9.5,8,$row['student_phone'],0,4,'L');

    $pdf->Output();
} catch (Exception $exception) {
    $msg = "Something went wrong!";
    echo "<script>alert('".$msg."')</script>";
    echo "<script>window.open('all_students.php','_self')</script>";
}