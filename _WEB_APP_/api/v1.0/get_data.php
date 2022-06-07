<?php
/**
 * This file may not be redistributed in whole or significant part.
 * ---------------- THIS IS NOT FREE SOFTWARE ----------------
 *
 *
 * @file        get_data.php
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

const _STUGATE_ = true;

error_reporting(0);
global $con;

date_default_timezone_set('Asia/Jakarta');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    require_once '../../core/db.php';
    include '../../core/helpers.php';

    $response = array();

    $code = xss_clean($_GET['code']);

    $query = "SELECT * FROM students WHERE student_code='$code' LIMIT 1";

    $result = mysqli_query($con, $query);
    $num_rows = mysqli_num_rows($result);

    if ($num_rows > 0) {

        while ($row = mysqli_fetch_array($result)) {

            $student_name = $row['student_name'];
            $student_code = $row['student_code'];
            $student_department = $row['student_department'];
            $student_level = $row['student_level'];
            $student_status = $row['student_status'];
            $student_session_paid = $row['student_session_paid'];
            $student_image = $row['student_image'];

        }

        $response["value"] = "success";
        $response["message"] = "SUCCESS !";
        $response["student_name"] = $student_name;
        $response["student_code"] = $student_code;
        $response["student_department"] = $student_department;
        $response["student_level"] = $student_level;
        $response["student_status"] = $student_status;
        $response["student_session_paid"] = $student_session_paid;
        $response["student_image"] = $student_image;

        echo json_encode($response);

    } else {
        $response["value"] = "failure";
        $response["message"] = "Invalid request! Try again!";
        echo json_encode($response);
    }


} else {
    $response["value"] = "failure";
    $response["message"] = "Oops! Try again!";
    echo json_encode($response);
}

//close db connection
mysqli_close($con);