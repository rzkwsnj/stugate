<?php
/**
 * This file may not be redistributed in whole or significant part.
 * ---------------- THIS IS NOT FREE SOFTWARE ----------------
 *
 *
 * @file        view_student.php
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

?>

<!DOCTYPE html>
<head>
    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'/>
    <title>STUDENT DETAILS</title>
    <link rel='stylesheet' type='text/css' href='../themes/print/css/style.css'/>
    <link rel='stylesheet' type='text/css' href='../themes/print/css/print.css' media="print"/>
    <script type='text/javascript' src='../themes/print/js/jquery-1.3.2.min.js'></script>
    <script type='text/javascript' src='../themes/print/js/example.js'></script>
    <style type="text/css">
        @media print {
            #printbtn {
                display: none;
            }
        }

        .button {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
        }

        #biodata {
            width: 350px;
            height: 150px;
            float: left;
        }
    </style>
    <script>
        function printpage() {
            window.print()
        }
    </script>
</head>
<body>
<div id="page-wrap">

    <?php
    include('../core/db.php');
    include("../core/helpers.php");
    $getid = xss_clean($_GET['id']);
    global $con;
    $my_result = mysqli_query($con, "SELECT * FROM students WHERE student_id='$getid'");
    $data = mysqli_fetch_array($my_result);

    ?>

    <textarea id="header"><?php echo strtoupper(strtoupper($data['student_session_paid'])); ?></textarea>

    <div id="identity">

        <p id="biodata">
            <?php echo '<b>Student Name:</b> ' . $data['student_name']; ?><br>
            <?php echo '<b>Department:</b> ' . $data['student_department']; ?><br>
            <?php echo '<b>Level:</b> ' . $data['student_level']; ?><br>
            <?php echo '<b>Email:</b> ' . $data['student_email']; ?><br>
            <?php echo '<b>Phone:</b> ' . $data['student_phone']; ?><br>
            <?php echo '<b>Address:</b> ' . $data['student_address']; ?><br>
            <?php echo ' ' ?><br>


        </p>

        <div id="logo">

            <?php
            echo "<th style='text-align:center;'><img src=\"../uploads/images/student_images/" . $data['student_image'] . "\" class=\"img-rounded\" width='122' height='122' alt=\"Student Image\"></th>";
            ?>

        </div>

    </div>

    <div style="clear:both"></div>

    <div id="customer">


        <table id="meta2">

            <tr>
                <td class="meta-head">QR CODE</td>

                <td>
                    <div class="due">
                        <?php
                        echo "<img src=\"https://chart.googleapis.com/chart?chs=100x100&cht=qr&chl=" . $data['student_code'] . "&chld=L|1&choe=UTF-8\" class=\"img-rounded\" width='180' height='180' alt=\"QR Code\">";
                        ?>
                    </div>
                </td>


        </table>

        <table id="meta">
            <tr>
                <td class="meta-head">Registration Number #</td>
                <td><p><?php echo strtoupper(strtoupper($data['student_code'])) ?></p></td>
            </tr>
            <tr>
                <td class="meta-head">Status</td>
                <td><p><?php echo strtoupper(strtoupper($data['student_status'])) ?></p></td>
            </tr>
            <tr>
                <td class="meta-head">Transaction ID #</td>
                <td><p><?php echo strtoupper(strtoupper($data['student_transaction_id'])) ?></p></td>
            </tr>
            <tr>
                <td class="meta-head">Session Paid For</td>
                <td><p><?php echo strtoupper(strtoupper($data['student_session_paid'])) . " Academic Session" ?></p>
                </td>
            </tr>
            <tr>
                <td class="meta-head">Bank of Payment</td>
                <td><p><?php echo strtoupper(strtoupper($data['student_payment_bank'])) ?></p></td>
            </tr>
            <tr>
                <td class="meta-head">Payment Date</td>
                <td><p><?php echo strtoupper(strtoupper($data['student_date_paid'])) ?></p></td>
            </tr>

        </table>
    </div>
    <br>
    <br>
    <div id="terms">
        <h5><?php echo strtoupper(strtoupper(schoolNameById($data['school_id']))) ?></h5>
    </div>
    <div align='center'>
        <input class="button" id="printbtn" type="button" value="PRINT" onclick="window.print();">
    </div>
    <br>
    <br>
    <br>
</div>
</body>
</html>