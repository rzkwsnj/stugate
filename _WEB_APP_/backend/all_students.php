<?php
/**
 * This file may not be redistributed in whole or significant part.
 * ---------------- THIS IS NOT FREE SOFTWARE ----------------
 *
 *
 * @file        all_students.php
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

                    <li class="nav-item active">
                        <a href="all_students.php" class="nav-link">
                            <i class="fa fa-group"></i> All Students
                        </a>
                    </li>

                    <li class="nav-item">
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
                            <i class="fa fa-check-square-o"></i> All Students
                        </li>
                    </ol>
                </div>
            </div>
            <!-- /.row -->

            <div class="row">
                <div class="col-lg-12">

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <button type="button" onclick="location.href = 'add_students.php';"
                                    class="btn btn-primary float-right"><i class='fa fa-plus-circle'></i> Add Student
                            </button>
                            <button type="button" onclick="location.href = 'bulk_import_students.php';"
                                    class="btn btn-warning float-left"><i class='fa fa-file-archive'></i> Bulk Import
                                Students
                            </button>
                            <button type="button" data-toggle="modal" data-target="#modalBulkPrint"
                                    class="btn btn-danger float-left"><i class='fa fa-receipt'></i> Bulk Print ID Cards
                            </button>

                        </div>

                        <div class="panel-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>#</th>
                                    <th>Image</th>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>School</th>
                                    <th>Department</th>
                                    <th>Level</th>
                                    <th>Session</th>
                                    <th>Transaction ID</th>
                                    <th>Date Paid</th>
                                    <th>Payment Bank</th>
                                    <th>Passport</th>
                                    <th>Barcode</th>
                                    <th>Status</th>

                                    <th>Action</th>


                                </tr>
                                </thead>
                                <tbody>

                                <?php

                                include("../core/db.php");

                                $sql = "SELECT * FROM students ORDER BY student_id DESC";
                                $result = mysqli_query($con, $sql);
                                $i = 1;
                                while ($row = mysqli_fetch_array($result)) {
                                    echo "<tr>";
                                    echo "<td></td>";
                                    echo "<td>" . $i . "</td>";
                                    echo "<td><img src=\"../uploads/images/student_images/" . $row['student_image'] . "\" width='100' height='100'></td>";
                                    echo "<td><img src=\"https://chart.googleapis.com/chart?chs=100x100&cht=qr&chl=" . $row['student_code'] . "&chld=L|1&choe=UTF-8\" class=\"img-rounded\" width='100' height='100' alt=\"QR Code\"></td>";
                                    echo "<td><button class='btn btn-primary'/> <i class='fa fa-user-tie'></i> " . $row['student_name'] . " ";
                                    echo "<td>" . $row['student_email'] . "</td>";
                                    echo "<td>" . $row['student_phone'] . "</td>";
                                    echo "<td>" . $row['student_address'] . "</td>";
                                    echo "<td>" . schoolNameById($row['school_id']) . "</td>";
                                    echo "<td>" . $row['student_department'] . "</td>";
                                    echo "<td>" . $row['student_level'] . "</td>";

                                    if ($row['student_status'] == 'PAID') {
                                        echo "<td><button class='btn btn-success'/>" . $row['student_session_paid'] . " PAID </button></td>";

                                    } else {
                                        echo "<td><button class='btn btn-danger'/>" . $row['student_session_paid'] . "  NOT PAID </button></td>";

                                    }
                                    echo "<td>" . $row['student_transaction_id'] . "</td>";
                                    echo "<td>" . $row['student_date_paid'] . "</td>";
                                    echo "<td>" . $row['student_payment_bank'] . "</td>";
                                    echo "<td>" . $row['student_passport'] . "</td>";
                                    echo "<td>" . $row['student_barcode'] . "</td>";
                                    echo "<td>" . $row['student_status'] . "</td>";

                                    echo "<td><a class='btn btn-primary'  href=\"view_student.php?id=" . $row['student_id'] . "\" ><i class='fa fa-eye'></i></a>  ";
                                    echo "<a class='btn btn-warning'  href=\"edit_student.php?id=" . $row['student_id'] . "\" ><i class='fa fa-edit'></i></a>  ";
                                    // echo "<a class='btn btn-success'  href=\"email_student.php?id=" . $row['student_id'] . "\" ><i class='fa fa-check-circle'></i> EMAIL</a>  ";
                                    echo "<a class='btn btn-info'  href=\"print_card.php?code=" . $row['student_code'] . "\" ><i class='fa fa-receipt'></i> PRINT ID CARD</a></td>";


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

    <div id="modalBulkPrint" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content" style="font-size: 14px;color:black;">
                <div class="modal-header" style="background:#222d32">
                    <h4 class="modal-title" style="font-weight: bold;color: #F0F0F0">BULK PRINT ID CARD</h4>
                </div>

                <div class="modal-body">
                    <form action="bulk_print_student_cards_simple.php" method="post">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">

                                    <div class="form-group">
                                        <label for="exampleStudentSession">Session</label>
                                        <select class="form-control" name="student_session_paid"
                                                id="exampleStudentSession">

                                            <option value="2021/2022">2021/2022</option>
                                            <option value="2022/2023">2022/2023</option>

                                        </select>


                                    </div>
                                </div>
                            </div>

                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button>
                    <input type="submit" class="btn btn-success" value="SUBMIT"> &nbsp;
                </div>
                </form>
            </div>
        </div>

    </div>
</div>

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
            "autoWidth": true,
            "lengthMenu": [[10, 25, 50, 100, 1000, -1], [10, 25, 50, 100, 1000, "All"]]
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



