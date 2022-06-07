<?php
/**
 * This file may not be redistributed in whole or significant part.
 * ---------------- THIS IS NOT FREE SOFTWARE ----------------
 *
 *
 * @file        add_admin.php
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
if (isset($_SESSION['role']) and $_SESSION['role'] == 'superuser') {

    if (isset($_SESSION['email']) and isset($_SESSION['key'])) {
        echo " ";
    } else {
        header("location:../index.php");

    }


    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        include('../core/db.php');

        $admin_name = xss_clean($_POST['admin_name']);
        $admin_email = xss_clean($_POST['admin_email']);
        $admin_phone = xss_clean($_POST['admin_phone']);
        $admin_address = xss_clean($_POST['admin_address']);
        $admin_password = xss_clean($_POST['admin_password']);

        $result = mysqli_query($con, "SELECT * FROM admins where admin_email='$admin_email' OR admin_cell='$admin_phone'");
        $num_rows = mysqli_num_rows($result);


        if ($num_rows > 0) {
            echo '<script type="text/javascript">';
            echo 'setTimeout(function () { swal("ERROR!","Admin email already exists!","error");';
            echo '}, 500);</script>';
        } else {
            $pass = valueEncryptDecrypt('encrypt', $admin_password);
            if (mysqli_query($con, "INSERT INTO admins (`admin_name`,`admin_email`,`admin_cell`,`admin_address`,`admin_password`) VALUE ('$admin_name','$admin_email','$admin_phone','$admin_address','$pass')")) {
                echo '<script type="text/javascript">';
                echo 'setTimeout(function () { swal("Admin Successfully Added!","Done!","success");';
                echo '}, 500);</script>';

                echo '<script type="text/javascript">';
                echo "setTimeout(function () { window.open('all_admins.php','_self')";
                echo '}, 1500);</script>';
            } else {// display the error message
                echo '<script type="text/javascript">';
                echo 'setTimeout(function () { swal("ERROR!","Something Wrong!","error");';
                echo '}, 500);</script>';
            }


        }
    }
} else {
    echo '<script type="text/javascript">';
    echo 'setTimeout(function () { swal.fire("ERROR!","Unauthorized!","error");';
    echo '}, 500);</script>';
    echo '<script type="text/javascript">';
    echo "setTimeout(function () { window.open('dashboard.php','_self')";
    echo '}, 1500);</script>';
}
?>

<?php include_once '_master/_base.php'; ?>

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
                        <li class="nav-item active">
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
                        <li>
                            <i class="fa fa-check-square-o"></i> <a href="all_admins.php">All Admins</a>
                        </li>
                        <li class="active">
                            <i class="fa fa-check-square-o"></i> Add Admin
                        </li>
                    </ol>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">

                            <h3 class="card-title">Add Admin information</h3>

                        </div>


                        <form role="form" id="quickForm" method="post" action="add_admin.php">
                            <div class="panel-body">

                                <div class="form-group">
                                    <label for="exampleInputAdminName">Admin Name</label>
                                    <input type="text" name="admin_name" class="form-control" id="exampleInputAdminName"
                                           placeholder="Enter Admin Name">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Email Address</label>
                                    <input type="email" name="admin_email" class="form-control" id="exampleInputEmail1"
                                           placeholder="Enter email">
                                </div>


                                <div class="form-group">
                                    <label for="exampleInputPhone">Phone Number</label>
                                    <input type="tel" name="admin_phone" class="form-control" id="exampleInputPhone"
                                           placeholder="Enter phone number">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputAddress">Admin Address</label>
                                    <input type="text" name="admin_address" class="form-control"
                                           id="exampleInputAddress"
                                           placeholder="Enter Admin address">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputAddress">Admin Password</label>
                                    <input type="password" name="admin_password" class="form-control"
                                           id="exampleInputAddress"
                                           placeholder="Enter Password">
                                </div>

                            </div>
                            <div class="panel-footer">
                                <button type="reset" class="btn btn-dark"><i class="fa fa-times-circle"></i> Reset
                                </button>
                                <button type="submit" id="add_admin" class="btn btn-primary"><i
                                            class="fa fa-check-circle"></i> Add Admin
                                </button>
                            </div>
                        </form>


                    </div>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
    </div>

    <!-- /.control-sidebar -->
</div>


<!-- ./wrapper -->

<script src="../<?php echo BOOTSTRAP_COMPONENT_JS; ?>" type="text/javascript"></script>
<script src="../<?php echo GLOBAL_COMPONENTS; ?>fancybox/source/jquery.fancybox.pack.js"
        type="text/javascript"></script>
<!-- jquery-validation -->
<script src="../<?php echo JQUERY_VALIDATE_JS; ?>"></script>
<script src="../<?php echo JQUERY_VALIDATE_ADDITIONAL_JS; ?>"></script>
<script type="text/javascript">

    $(document).on('click', '#add_admin', function (e) {


        $('#quickForm').validate({
            rules: {

                admin_name: {
                    required: true
                },
                admin_email: {
                    required: true,
                    email: true,
                },
                admin_phone: {
                    required: true
                },
                admin_address: {
                    required: true
                },

                admin_password: {
                    required: true
                },


            },
            messages: {
                admin_name: {
                    required: "Please enter admin name"
                },
                email: {
                    required: "Please enter a email address",
                    email: "Please enter a valid email address"
                },
                admin_phone: {
                    required: "Please enter admin phone number"
                },
                admin_address: {
                    required: "Please enter admin address"
                },

                admin_password: {
                    required: "Please enter admin password"
                },

            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });

    });


</script>

<script type="text/javascript">

    $(document).on('click', '#add_admin', function (e) {
        e.preventDefault();
        swal({
                title: 'Want to add ?',
                text: 'Are you sure?',
                icon: 'warning',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes!',
                cancelButtonText: 'No'
            },
            function (isConfirm) {
                if (isConfirm) {
                    $('#quickForm').submit();
                }
            });

    });
</script>

<?php include_once '_master/_footer.php'; ?>



