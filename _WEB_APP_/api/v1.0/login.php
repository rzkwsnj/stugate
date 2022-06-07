<?php
/**
 * This file may not be redistributed in whole or significant part.
 * ---------------- THIS IS NOT FREE SOFTWARE ----------------
 *
 *
 * @file        login.php
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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    require_once '../../core/db.php';
    include '../../core/helpers.php';

    $response = array();

    $email = xss_clean($_POST['email']);
    $password = valueEncryptDecrypt('encrypt', $_POST['password']);

    $query = "SELECT * FROM users WHERE email='$email' AND password='$password' AND user_status='1' LIMIT 1";

    $result = mysqli_query($con, $query);
    $num_rows = mysqli_num_rows($result);

    if ($num_rows > 0) {

        while ($row = mysqli_fetch_array($result)) {

            $id = $row['id'];
            $name = $row['name'];
            $cell = $row['cell'];
            $email = $row['email'];
            $password = $row['password'];
            $user_status = $row['user_status'];
            $user_type = $row['user_type'];

        }

        $response["value"] = "success";
        $response["message"] = "Welcome !";
        $response["id"] = $id;
        $response["name"] = $name;
        $response["cell"] = $cell;
        $response["email"] = $email;
        $response["password"] = $password;
        $response["user_status"] = $user_status;
        $response["user_type"] = $user_type;

        echo json_encode($response);

    } else {
        $response["value"] = "failure";
        $response["message"] = "Invalid credentials! Try again!";
        echo json_encode($response);
    }


} else {
    $response["value"] = "failure";
    $response["message"] = "Oops! Try again!";
    echo json_encode($response);
}

//close db connection
mysqli_close($con);