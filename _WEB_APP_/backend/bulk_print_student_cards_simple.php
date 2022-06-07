<?php
/**
 * This file may not be redistributed in whole or significant part.
 * ---------------- THIS IS NOT FREE SOFTWARE ----------------
 *
 *
 * @file        bulk_print_student_cards_simple.php
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

if (isset($_SESSION['email']) and isset($_SESSION['key']))
    echo " ";
else {
    header("location:../index.php");

}

include("../core/db.php");
include("../core/helpers.php");

$student_session_paid = xss_clean($_POST['student_session_paid']);
$sql = "SELECT * FROM students WHERE student_session_paid='$student_session_paid' ORDER BY student_id DESC";
$result = mysqli_query($con, $sql);
$num_rows = mysqli_num_rows($result);
if ($num_rows < 1) {
    echo "<script>alert('There is no data!')</script>";
    echo "<script>window.open('all_students.php','_self')</script>";
}
?>


<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <title>Bulk Print Student Cards</title>
    <link rel='stylesheet' type='text/css' href='../themes/print/css/style.css'/>
    <link rel='stylesheet' type='text/css' href='../themes/print/css/print.css' media="print"/>
    <script type='text/javascript' src='../themes/print/js/jquery-1.3.2.min.js'></script>
    <script type='text/javascript' src='../themes/print/js/example.js'></script>
    <style>
        @media print {
            body {
                width: 21cm;
                height: 29.7cm;
                /*margin: 30mm 45mm 30mm 45mm; */
                -webkit-print-color-adjust: exact;
            }
        }

        body {
            background: #ffffff;
        }

        #student_cards_bg {
            width: 86mm;
            height: 54mm;
            margin: 10px;
            background-image: url('../uploads/images/student_images/card_placeholder.png');
            background-repeat: no-repeat;
            background-size: 86mm 54mm;
            border: 1px solid #000;
            float: left;
        }

        #separator_10 {
            margin-top: 50px;
        }

        .container {
            font-size: 12px;
            font-family: sans-serif;
        }

        tr.spaceUnder > td {
            padding-bottom: 0.1em;
        }
    </style>
</head>
<body>
<script type="text/javascript">
    window.print();
</script>
<?php

$i = 1;
while ($row = mysqli_fetch_array($result)) {
    if ($i % 10 === 0) {
        echo '<div id="separator_10">';
    }
    echo '<div id="student_cards_bg">';
    // echo '<table style="width:100%">';
    // echo '<tr class="spaceUnder">';
    // echo '<th style="border: none;" rowspan="2">';
    // echo '<img src="../uploads/images/school_images/'.schoolLogoById($row['school_id']).'" width="30" height="35" style="margin: 0;">';
    // echo '</th>';
    // echo '<td style="border: none; background-color: white; color: green; font-size: 8pt; text-align:center;"><b>'.strtoupper(schoolNameById($row['school_id'])).'</b></td>';
    // echo '</tr>';
    // echo '<tr>';
    // echo '<td style="border: none; background-color: lightgreen; font-size: 6pt; text-align:center;"><b>EXAMINATION PERMIT CARD</b></td>';
    // echo '</tr>';
    // echo '</table>';
    // echo '<table>';
    // echo '<tr class="spaceUnder">';
    // echo '<td style="font-size:7pt; border: none;"><b>Student Name:</b></td>';
    // echo '<td style="border: none;"><p style="font-size:6.5pt;">'.$row['student_name'].'</p></td>';
    // echo '<th style="border: none;" rowspan="2"></th>';
    // echo '<th style="border-color: white;" rowspan="4">';
    // echo '<img src="../uploads/images/student_images/'.$row['student_image'].'" width="50" height="50">';
    // echo '</th>';
    // echo '</tr>';
    // echo '<tr class="spaceUnder">';
    // echo '<td style="font-size:7pt; border: none;"><b>Registration Number:</b></td>';
    // echo '<td style="border: none;"><p style="font-size:6.5pt;">'.$row['student_code'].'</p></td>';
    // echo '</tr>';
    // echo '<tr class="spaceUnder">';
    // echo '<td style="font-size:7pt; border: none;"><b>Department:</b></td>';
    // echo '<td style="border: none;"><p style="font-size:6.5pt;">'.$row['student_departmentstudent_department'].'</p></td>';
    // echo '</tr>';
    // echo '<tr class="spaceUnder">';
    // echo '<td style="font-size:7pt; border: none;"><b>Level:</b></td>';
    // echo '<td style="border: none;"><p style="font-size:6.5pt;">'.$row['student_level'].'</p></td>';
    // echo '</tr>';
    // echo '<tr class="spaceUnder">';
    // echo '<td style="font-size:7pt; border: none;"><b>Session Paid For:</b></td>';
    // echo '<td style="border: none;"><p style="font-size:6.5pt;">'.$row['student_session_paid'].' Academic Session</p></td>';
    // echo '<th style="border: none;" rowspan="2"></th>';
    // echo '<th style="border: none;" rowspan="4">';
    // echo '<img src="https://chart.googleapis.com/chart?chs=100x100&cht=qr&chl='.$row['student_code'].'&chld=L|1&choe=UTF-8" width="59" height="59">';
    // echo '</th>';
    // echo '</tr>';
    // echo '<tr class="spaceUnder">';
    // echo '<td style="font-size:7pt; border: none;"><b>Date of Payment:</b></td>';
    // echo '<td style="border: none;"><p style="font-size:6.5pt;">'.$row['student_date_paid'].'</p></td>';
    // echo '</tr>';
    // echo '<tr class="spaceUnder">';
    // echo '<td style="font-size:7pt; border: none;"><b>Bank of Payment:</b></td>';
    // echo '<td style="border: none;"><p style="font-size:6.5pt;">'.$row['student_payment_bank'].'</p></td>';
    // echo '</tr>';
    // echo '<tr class="spaceUnder">';
    // echo '<td style="font-size:7pt; border: none;"><b>Phone</b></td>';
    // echo '<td style="border: none;"><p style="font-size:6.5pt;">'.$row['student_phone'].'</p></td>';
    // echo '</tr>';
    // echo '</table>';
    // echo '<table style="width:100%;">';
    // echo '<tr>';
    // echo '<td style="border: none; background-color: green; color:  white; font-size: 6.5pt; text-align:center;"><b>Forgery of this card is tantamount to Expulsion from the University</b></td>';
    // echo '</tr>';
    // echo '</table>';
    echo '<table style="width:100%;">';
    echo '</tr>';
    echo '<tr>';
    echo '<td style="border: none;">';
    echo '<p style="font-size:9pt; padding: 67px 0 0 70px;">' . $row['student_name'] . '</p>';
    echo '<p style="font-size:9pt; padding: 3px 0 0 100px;">' . $row['student_code'] . '</p>';
    echo '<p style="font-size:9pt; padding: 1px 0 0 60px;">' . $row['student_department'] . '</p>';
    echo '<p style="font-size:9pt; padding: 1px 0 0 30px;">' . $row['student_level'] . '</p>';
    echo '<p style="font-size:9pt; padding: 1px 0 0 80px;">' . $row['student_session_paid'] . '  Academic Session</p>';
    echo '<p style="font-size:9pt; padding: 3px 0 0 35px;">' . $row['student_phone'] . '</p>';
    echo '</td>';
    echo '<td style="border: none;"><img style="padding: 0 0 0 0;" src="../uploads/images/student_images/' . $row['student_image'] . '" width="55" height="55"><br /><img style="padding: 50px 0 0 0;" src="https://chart.googleapis.com/chart?chs=100x100&cht=qr&chl=' . $row['student_code'] . '&chld=L|1&choe=UTF-8" width="59" height="59"></td><br />';
    echo '</tr>';
    echo '</table>';
    echo '</div>';

    $i++;
}

?>
</body>
</html>
