<?php
/**
 * This file may not be redistributed in whole or significant part.
 * ---------------- THIS IS NOT FREE SOFTWARE ----------------
 *
 *
 * @file        all_schools.php
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
include('../core/helpers.php');
if (isset($_SESSION['email']) and isset($_SESSION['key']))
    echo " ";
else {
    header("location:index.php");

}


?>

<!DOCTYPE html>
<html lang="en" class="no-js">
<HEAD>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="robots" content="noindex, nofollow">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Payment Verification System</title>
    <meta name="description" content="Student Payment Verification"/>
    <meta name="keywords" content="stugate"/>
    <meta name="author" content="rizkiwisnuaji"/>
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
    <link rel="stylesheet" href="../themes/public/assets/dist/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
</HEAD>
<BODY>

<div id='cbn_overlay'><h3>Please Wait. . .</h3></div>

<div class="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#bs-navbar"
                        aria-controls="bs-navbar" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="dashboard.php"><?php echo APP_INITIAL; ?></a>
            </div>
            <!-- Top Menu Items -->
            <nav id="bs-navbar" class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="nav-item">
                        <a href="dashboard.php"><i class="fa fa-home"></i> </a>
                    </li>
                    <?php if (isset($_SESSION['role']) and $_SESSION['role'] == 'superuser') { ?>
                        <li class="nav-item">
                            <a href="all_admins.php" class="nav-link">
                                <i class="fa fa-fw fa-user"></i> All Admins
                            </a>
                        </li>
                    <?php } ?>
                    <li class="nav-item">
                        <a href="all_users.php" class="nav-link">
                            <i class="fa fa-list"></i> All Users
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="all_students.php" class="nav-link">
                            <i class="fa fa-group"></i> All Students
                        </a>
                    </li>

                    <li class="nav-item active">
                        <a href="all_schools.php" class="nav-link">
                            <i class="fa fa-cubes"></i> All Schools
                        </a>
                    </li>
                    <?php if (isset($_SESSION['role']) and $_SESSION['role'] == 'superuser') { ?>
                        <li class="nav-item">
                            <a href="edit_superuser.php" class="nav-link">
                                <i class="fa fa-wrench"></i> Profile
                            </a>
                        </li>
                    <?php } ?>


                    <li class="nav-item">
                        <a href="logout.php" class="nav-link"
                           onclick="return customAlert('', 'warning', 'logout.php');">
                            <i class="fa fa-fw fa-power-off"></i> Logout
                        </a>
                    </li>

                </ul>
            </nav>
        </div>
    </nav>

    <div class="page-wrapper">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <p class="page-header">
                        <?php echo APP_NAME . " ver. " . APP_VERSION; ?>
                    </p>
                    <ol class="breadcrumb">
                        <li>
                            <i class="fa fa-dashboard"></i> <a href="dashboard.php">Dashboard</a>
                        </li>
                        <li class="active">
                            <i class="fa fa-check-square-o"></i> All Schools
                        </li>
                    </ol>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">


                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <?php if (isset($_SESSION['role']) and $_SESSION['role'] == 'superuser') { ?>
                                <button type="button" onclick="location.href = 'add_school.php';"
                                        class="btn btn-primary float-right"><i class='fa fa-plus-circle'></i> Add School
                                </button>
                            <?php } ?>
                        </div>

                        <div class="panel-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>School Logo</th>
                                    <th>School Name</th>
                                    <th>School Email</th>
                                    <th>School Phone</th>
                                    <th>School Address</th>
                                    <th>Currency Symbol</th>
                                    <th>School Status</th>

                                    <th>Action</th>


                                </tr>
                                </thead>
                                <tbody>

                                <?php

                                include("../core/db.php");

                                if (isset($_SESSION['admin_id']) and isset($_SESSION['role']) and $_SESSION['role'] == 'generaluser') {
                                    $schoolAdminId = $_SESSION['admin_id'];
                                    $sql = "SELECT * FROM schools WHERE school_admin_id='$schoolAdminId' ORDER BY school_id DESC";
                                } else {
                                    $sql = "SELECT * FROM schools ORDER BY school_id DESC";
                                }
                                $result = mysqli_query($con, $sql);
                                $i = 1;
                                while ($row = mysqli_fetch_array($result)) {
                                    echo "<tr>";

                                    echo "<td>" . $i . "</td>";
                                    echo "<td><img src=\"../uploads/images/school_images/" . $row['school_logo'] . "\" class=\"img-rounded\" width='100' height='100' alt=\"School Image\"></td>";
                                    echo "<td><button class='btn btn-primary'/> <i class='fa fa-store-alt'></i> " . $row['school_name'] . " ";
                                    echo "<td>" . $row['school_email'] . "</td>";
                                    echo "<td>" . $row['school_contact'] . "</td>";
                                    echo "<td>" . $row['school_address'] . "</td>";
                                    echo "<td>" . $row['currency_symbol'] . "</td>";

                                    if ($row['school_status'] == 'OPEN') {
                                        echo "<td><button class='btn btn-success'/> <i class='fa fa-check-circle'></i> OPEN </button></td>";

                                    } else {
                                        echo "<td><button class='btn btn-danger'/> <i class='fa fa-times-circle'></i> CLOSED </button></td>";

                                    }


                                    echo "<td><a class='btn btn-primary'  href=\"edit_school.php?id=" . $row['school_id'] . "\" ><i class='fa fa-edit'></i></a>  </td>";


                                    $i++;

                                    echo "</tr> ";
                                }

                                echo " </tbody>";
                                echo " </table>";

                                ?>
                        </div>
                    </div>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
    </div>
</div>
<!-- ./wrapper -->

<script src="../<?php echo BOOTSTRAP_COMPONENT_JS; ?>" type="text/javascript"></script>
<script src="../<?php echo GLOBAL_COMPONENTS; ?>fancybox/source/jquery.fancybox.pack.js"
        type="text/javascript"></script>

<!-- DataTables -->
<script src="../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<!--For data export and print-->
<script src="../plugins/buttons/dataTables.buttons.min.js"></script>
<script src="../plugins/buttons/jszip.min.js"></script>
<script src="../plugins/buttons/pdfmake.min.js"></script>
<script src="../plugins/buttons/vfs_fonts.js"></script>
<script src="../plugins/buttons/buttons.html5.min.js"></script>
<script src="../plugins/buttons/buttons.print.min.js"></script>
<!--For data export and print-->
<script>
    $(function () {
        $("#example1").DataTable({
            "responsive": true,
            "autoWidth": false,
        });
    });
</script>


<script>
    $('.confirmation').on('click', function () {
        return confirm('Are you sure?');
    });
</script>

<script type="text/javascript">
    $(window).bind('load', function () {
        $('#cbn_overlay').fadeOut();
    });

    function reload() {
        location.reload();
    }
</script>

<script type="text/javascript">

    function customAlert(formclass, type, link) {

        swal({
                title: "Are you sure ?",
                text: "Are you sure want to continue ?",
                type: type,
                showCancelButton: true,
                confirmButtonColor: 'green',
                confirmButtonText: 'Yes !',
                cancelButtonText: "No !",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function (isConfirm) {
                if (isConfirm) {
                    swal("Done!", "Congratulations !", "success");
                    if (formclass !== '') {
                        $(formclass).submit();
                    }
                    if (link !== '') {
                        window.location = link;
                    }
                } else {
                    swal("Cancelled", "Action was cancelled :)", "error");
                }
            });

        return false;
    }

</script>


<script type="text/javascript">
    $('.navbar-lower').affix({
        offset: {top: 50}
    });
</script>


</BODY>
</HTML>


