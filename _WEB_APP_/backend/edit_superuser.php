<?php
/**
 * This file may not be redistributed in whole or significant part.
 * ---------------- THIS IS NOT FREE SOFTWARE ----------------
 *
 *
 * @file        edit_superuser.php
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
include("../core/helpers.php");
if (isset($_SESSION['role']) and $_SESSION['role'] == 'superuser') {

    if (isset($_SESSION['email']) and isset($_SESSION['key'])) {
        echo " ";
        include("../core/db.php");
    } else {
        header("location:../index.php");

    }


    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $getid = $_SESSION['email'];


        if (!empty($getid)) {

            $query = mysqli_query($con, "SELECT * FROM superusers WHERE superuser_email='$getid'");
            $row = mysqli_fetch_assoc($query);

        }
    }


    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $superuser_id = xss_clean($_POST['superuser_id']);
        $superuser_name = xss_clean($_POST['superuser_name']);
        $superuser_email = xss_clean($_POST['superuser_email']);
        $superuser_phone = xss_clean($_POST['superuser_phone']);
        $superuser_password = xss_clean($_POST['superuser_password']);


        $query = mysqli_query($con, "SELECT * FROM superusers WHERE superuser_id='$superuser_id'");
        $row = mysqli_fetch_assoc($query);
        $pass = valueEncryptDecrypt('encrypt', $superuser_password);

        $sql = mysqli_query($con, "Update superusers SET superuser_name='$superuser_name',superuser_email='$superuser_email',superuser_cell='$superuser_phone',superuser_password='$pass' WHERE superuser_id='$superuser_id'");

        if ($sql) {
            echo '<script type="text/javascript">';
            echo 'setTimeout(function () { swal("Successfully updated!","Done!","success");';
            echo '}, 500);</script>';

            echo '<script type="text/javascript">';
            echo "setTimeout(function () { window.open('dashboard.php','_self')";
            echo '}, 1500);</script>';

        } else {// display the error message
            echo '<script type="text/javascript">';
            echo 'setTimeout(function () { swal("ERROR!","Something Wrong!","error");';
            echo '}, 500);</script>';


        }


    }

} else {
    echo '<script type="text/javascript">';
    echo 'setTimeout(function () { swal("ERROR!","Unauthorized!","error");';
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

                    <li class="nav-item">
                        <a href="all_schools.php" class="nav-link">
                            <i class="fa fa-cubes"></i> All Schools
                        </a>
                    </li>
                    <?php if (isset($_SESSION['role']) and $_SESSION['role'] == 'superuser') { ?>
                        <li class="nav-item active">
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
                            <i class="fa fa-check-square-o"></i> Edit Profile
                        </li>
                    </ol>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">

                    <div class="panel panel-default">
                        <div class="panel-heading">

                            <h3 class="card-title">Update profile information</h3>

                        </div>


                        <form role="form" id="quickForm" method="post" action="edit_superuser.php">
                            <div class="panel-body">

                                <div class="form-group">

                                    <input type="hidden" name="superuser_id" class="form-control" id="exampleInputName"
                                           value="<?php echo $row['superuser_id'] ?>">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputadminName">Admin Name</label>
                                    <input type="text" name="superuser_name" class="form-control" id="exampleInputName"
                                           value="<?php echo $row['superuser_name'] ?>">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Email Address </label>
                                    <input type="email" name="superuser_email" class="form-control"
                                           id="exampleInputEmail1"
                                           value="<?php echo $row['superuser_email'] ?>">
                                </div>


                                <div class="form-group">
                                    <label for="exampleInputPhone">Phone Number </label>
                                    <input type="tel" name="superuser_phone" class="form-control" id="exampleInputPhone"
                                           value="<?php echo $row['superuser_cell'] ?>">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputAddress">Admin Password</label>
                                    <input type="password" name="superuser_password" class="form-control"
                                           id="exampleInputAddress" minlength="4"
                                           value="<?php echo valueEncryptDecrypt('decrypt', $row['superuser_password']); ?>">
                                </div>


                            </div>
                            <div class="panel-footer">
                                <button type="submit" id="update_superuser" class="btn btn-primary"><i
                                            class="fa fa-check-circle"></i> Update Profile
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
</div>
<!-- ./wrapper -->

<script src="../<?php echo BOOTSTRAP_COMPONENT_JS; ?>" type="text/javascript"></script>
<script src="../<?php echo GLOBAL_COMPONENTS; ?>fancybox/source/jquery.fancybox.pack.js"
        type="text/javascript"></script>
<!-- jquery-validation -->
<script src="../<?php echo JQUERY_VALIDATE_JS; ?>"></script>
<script src="../<?php echo JQUERY_VALIDATE_ADDITIONAL_JS; ?>"></script>

<script type="text/javascript">

    $(document).on('click', '#update_superuser', function (e) {


        $('#quickForm').validate({
            rules: {

                superuser_name: {
                    required: true
                },
                superuser_email: {
                    required: true,
                    email: true,
                },
                superuser_phone: {
                    required: true
                },
                superuser_password: {
                    required: true
                },


            },
            messages: {
                superuser_name: {
                    required: "Please enter name"
                },
                email: {
                    required: "Please enter a email address",
                    email: "Please enter a valid email address"
                },
                superuser_phone: {
                    required: "Please enter phone number"
                },
                superuser_password: {
                    required: "Please enter password"
                },

            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                $(element).closest('.form-group').append(error);
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

    $(document).on('click', '#update_superuser', function (e) {
        e.preventDefault();
        swal({
                title: 'Want to update ?',
                text: 'Are you sure?',
                icon: 'warning',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Update it!',
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
