<?php
/**
 * This file may not be redistributed in whole or significant part.
 * ---------------- THIS IS NOT FREE SOFTWARE ----------------
 *
 *
 * @file        helpers.php
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

const APP_INITIAL = 'STUGATE';
const APP_NAME = 'Student Payment Validation System';
const APP_VERSION = '1.0.0';

/*
 *---------------------------------------------------------------
 * ALL ASSETS AND COMPONENTS DIR
 *---------------------------------------------------------------
 */
define('BASE_DIR', 'http' . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 's' : '') . '://' . $_SERVER['HTTP_HOST'] . str_replace('//', '/', dirname($_SERVER['SCRIPT_NAME']) . '/'));

const PUBLIC_DIR = 'themes/public/';

const PUBLIC_ASSETS = 'themes/public/assets/';

const FRONTEND_ASSETS_CSS = 'themes/public/assets/css/frontend/';

const FRONTEND_ASSETS_JS = 'themes/public/assets/js/frontend/';

const FRONTEND_ASSETS_IMG = 'themes/public/assets/img/frontend/';

const BACKEND_ASSETS_CSS = 'themes/public/assets/css/backend/';

const BACKEND_ASSETS_JS = 'themes/public/assets/js/backend/';

const BACKEND_ASSETS_IMG = 'themes/public/assets/img/backend/';

const GLOBAL_ASSETS_CSS = 'themes/public/assets/css/global/';

const GLOBAL_ASSETS_JS = 'themes/public/assets/js/global/';

const GLOBAL_ASSETS_IMG = 'themes/public/assets/img/global/';

const GLOBAL_COMPONENTS = 'themes/public/components/';

const BOOTSTRAP_COMPONENT_CSS = 'themes/public/components/bootstrap/dist/css/bootstrap.min.css';

const BOOTSTRAP_COMPONENT_JS = 'themes/public/components/bootstrap/dist/js/bootstrap.min.js';

const JQUERY_COMPONENT = 'themes/public/components/jquery/dist/jquery.min.js';

const KNOCKOUT_COMPONENT = 'themes/public/components/knockout/dist/knockout.js';

const FULLCALENDAR_CSS = 'themes/public/components/fullcalendar/dist/fullcalendar.css';

const FULLCALENDAR_PRINT_CSS = 'themes/public/components/fullcalendar/dist/fullcalendar.print.css';

const FULLCALENDAR_JS = 'themes/public/components/fullcalendar/dist/fullcalendar.min.js';

const FULLCALENDAR_MOMENT_JS = 'themes/public/components/moment/min/moment.min.js';

const SWAL_CSS = 'themes/public/components/sweetalert2/sweetalert2.min.css';

const SWAL_JS = 'themes/public/components/sweetalert2/sweetalert2.min.js';

const JQUERY_VALIDATE_JS = 'themes/public/components/jquery-validation/jquery.validate.min.js';

const JQUERY_VALIDATE_ADDITIONAL_JS = 'themes/public/components/jquery-validation/additional-methods.min.js';

function valueEncryptDecrypt($action, $value)
{

    $output = false;
    $encrypt_method = "AES-256-CBC";
    $secret_key = 'key_one';
    $secret_iv = 'key_two';
    // hash
    $key = hash('sha256', $secret_key);
    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
    if ($action == 'encrypt') {
        $output = openssl_encrypt($value, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    } else if ($action == 'decrypt') {
        $output = openssl_decrypt(base64_decode($value), $encrypt_method, $key, 0, $iv);
    }
    return $output;
}

function getFileName($_path, $_filename)
{
    $filename = preg_replace('/[^a-zA-Z0-9\s\-\.\_]/', ' ', $_filename);
    $filename = preg_replace('/(\s\s)+/', ' ', $filename);
    $filename = trim($filename);
    $filename = preg_replace('/\s+/', '-', $filename);
    $filename = preg_replace('/\-+/', '-', $filename);

    if (strlen($filename) == 0) $filename = "file";
    else if ($filename[0] == ".") $filename = "file" . $filename;
    while (file_exists($_path . $filename)) {
        $pos = strrpos($filename, ".");
        if ($pos !== false) {
            $ext = substr($filename, $pos);
            $filename = substr($filename, 0, $pos);
        } else {
            $ext = "";
        }
        $pos = strrpos($filename, "-");
        if ($pos !== false) {
            $suffix = substr($filename, $pos + 1);
            if (is_numeric($suffix)) {
                $suffix++;
                $filename = substr($filename, 0, $pos) . "-" . $suffix . $ext;
            } else {
                $filename = $filename . "-1" . $ext;
            }
        } else {
            $filename = $filename . "-1" . $ext;
        }
    }
    return $filename;
}

function valueSafe($value)
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function generateStudentCode($length = 10)
{
    return bin2hex(openssl_random_pseudo_bytes($length));

}

function generateUserCode($length = 10)
{
    return bin2hex(openssl_random_pseudo_bytes($length));

}

function schoolNameById($school_id)
{

    global $con;
    $sql = mysqli_query($con, "SELECT * FROM schools WHERE school_id='$school_id'");
    $school_data = mysqli_fetch_assoc($sql);
    $school_name = $school_data['school_name'];
    return strtoupper($school_name);
}

function schoolLogoById($school_id)
{

    global $con;
    $sql = mysqli_query($con, "SELECT * FROM schools WHERE school_id='$school_id'");
    $school_data = mysqli_fetch_assoc($sql);
    $school_logo = $school_data['school_logo'];
    return $school_logo;
}

function time_elapsed_string($datetime, $full = false)
{

    //set default time zone
    date_default_timezone_set("Asia/Jakarta");

    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

function getAmountInWord($number)
{
    $decimal = round($number - ($no = floor($number)), 2) * 100;
    $hundred = null;
    $digits_length = strlen($no);
    $i = 0;
    $str = array();
    $words = array(0 => '', 1 => 'one', 2 => 'two',
        3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
        7 => 'seven', 8 => 'eight', 9 => 'nine',
        10 => 'ten', 11 => 'eleven', 12 => 'twelve',
        13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
        16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
        19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
        40 => 'forty', 50 => 'fifty', 60 => 'sixty',
        70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
    $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
    while ($i < $digits_length) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += $divider == 10 ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str [] = ($number < 21) ? $words[$number] . ' ' . $digits[$counter] . $plural . ' ' . $hundred : $words[floor($number / 10) * 10] . ' ' . $words[$number % 10] . ' ' . $digits[$counter] . $plural . ' ' . $hundred;
        } else $str[] = null;
    }
    $Rupees = implode('', array_reverse($str));
    $paise = ($decimal > 0) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
    return ($Rupees ? $Rupees . 'Taka ' : '') . $paise;
}

function xss_clean($data)
{
    $data = trim($data);
    // Fix &entity\n;
    $data = str_replace(array('&amp;', '&lt;', '&gt;'), array('&amp;amp;', '&amp;lt;', '&amp;gt;'), $data);
    $data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
    $data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
    $data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');

    // Remove any attribute starting with "on" or xmlns
    $data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);

    // Remove javascript: and vbscript: protocols
    $data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
    $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
    $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);

    // Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
    $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
    $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
    $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);

    // Remove namespaced elements (we do not need them)
    $data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);

    do {
        // Remove really unwanted tags
        $old_data = $data;
        $data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
    } while ($old_data !== $data);

    // we are done...
    return $data;
}

function get_last_inserted_id($table)
{
    global $con;
    $sql = mysqli_query($con, "SELECT MAX(id) as id FROM $table");
    $row = mysqli_fetch_array($sql);
    if (!empty($row)) {
        return $row[0]['id'];
    } else {
        return 0;
    }
}
