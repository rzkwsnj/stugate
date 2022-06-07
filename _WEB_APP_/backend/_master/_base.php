<?php
/**
 * This file may not be redistributed in whole or significant part.
 * ---------------- THIS IS NOT FREE SOFTWARE ----------------
 *
 *
 * @file        _base.php
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
?>

<!DOCTYPE html>
<html lang="en" class="no-js">
<HEAD>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="robots" content="noindex, nofollow">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo APP_NAME; ?></title>
    <meta name="description" content="<?php echo APP_NAME; ?>"/>
    <meta name="keywords" content="<?php echo APP_INITIAL; ?>"/>
    <meta name="author" content="rzkwsnj"/>
    <link rel="shortcut icon" href="../<?php echo PUBLIC_DIR; ?>ico/favicon.ico">
    <link rel="stylesheet" href="../<?php echo BOOTSTRAP_COMPONENT_CSS; ?>" type="text/css"/>
    <link rel="stylesheet" href="../<?php echo BACKEND_ASSETS_CSS; ?>style.css" type="text/css"/>
    <link rel="stylesheet" href="../<?php echo BACKEND_ASSETS_CSS; ?>plugins/morris.css" type="text/css"/>
    <link rel="stylesheet" href="../<?php echo PUBLIC_ASSETS; ?>font-awesome/css/font-awesome.min.css" type="text/css"/>
    <link rel="stylesheet"
          href="../<?php echo GLOBAL_COMPONENTS; ?>bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css"
          type="text/css"/>
    <link rel="stylesheet" href="../<?php echo GLOBAL_COMPONENTS; ?>gritter/css/jquery.gritter.css" type="text/css"/>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="../<?php echo JQUERY_COMPONENT; ?>" type="text/javascript"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.js"></script>
    <script src="../<?php echo GLOBAL_COMPONENTS; ?>sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="../<?php echo GLOBAL_COMPONENTS; ?>sweetalert/dist/sweetalert.css" type="text/css"/>
    <!-- DataTables -->
    <!--For data export and print button css-->
    <link rel="stylesheet" href="../../themes/public/assets/dist/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
</HEAD>
<BODY>

<div id='cbn_overlay'><h3>Please Wait. . .</h3></div>
