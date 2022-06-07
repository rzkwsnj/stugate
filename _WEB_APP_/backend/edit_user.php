<?php
/**
 * This file may not be redistributed in whole or significant part.
 * ---------------- THIS IS NOT FREE SOFTWARE ----------------
 *
 *
 * @file        edit_user.php
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
if (isset($_SESSION['email']) and isset($_SESSION['key'])) {
    echo " ";
    include("../core/db.php");

} else {
    header("location:../index.php");

}


if ($_SERVER["REQUEST_METHOD"] == "GET") {

    $get_id = xss_clean($_GET['id']);
    $query = mysqli_query($con, "SELECT * FROM users WHERE id='$get_id'");
    $row = mysqli_fetch_assoc($query);


}


if ($_SERVER["REQUEST_METHOD"] == "POST") {


    $id = xss_clean($_POST['id']);
    $name = xss_clean($_POST['name']);
    $email = xss_clean($_POST['email']);
    $phone = xss_clean($_POST['phone']);
    $type = xss_clean($_POST['type']);
    $password = xss_clean($_POST['password']);


    $query = mysqli_query($con, "SELECT * FROM users WHERE id='$id'");
    $row = mysqli_fetch_assoc($query);

    $pass = valueEncryptDecrypt('encrypt', $password);
    $sql = mysqli_query($con, "Update users SET name='$name',email='$email',cell='$phone',user_type='$type',password='$pass' WHERE id='$id'");

    if ($sql) {
        echo '<script type="text/javascript">';
        echo 'setTimeout(function () { swal("Successfully Updated!","Done!","success");';
        echo '}, 500);</script>';

        echo '<script type="text/javascript">';
        echo "setTimeout(function () { window.open('all_users.php','_self')";
        echo '}, 1500);</script>';

    } else {// display the error message
        echo '<script type="text/javascript">';
        echo 'setTimeout(function () { swal("ERROR!","Something Wrong!","error");';
        echo '}, 500);</script>';


    }


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
                    <li class="nav-item active">
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
                            <i class="fa fa-check-square-o"></i> <a href="all_users.php">All Users</a>
                        </li>
                        <li class="active">
                            <i class="fa fa-check-square-o"></i> Edit User
                        </li>
                    </ol>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">

                            <h3 class="card-title">User information</h3>

                        </div>


                        <form role="form" id="quickForm" method="post" action="edit_user.php">
                            <div class="panel-body">

                                <div class="form-group">

                                    <input type="hidden" name="id" class="form-control" id="exampleInputAdminName"
                                           value="<?php echo $row['id'] ?>">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputUserName">Name</label>
                                    <input type="text" name="name" class="form-control" id="exampleInputUserName"
                                           value="<?php echo $row['name'] ?>">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Email address <small>[Not Editable]</small> </label>
                                    <input type="email" name="email" class="form-control" id="exampleInputEmail1"
                                           readonly
                                           value="<?php echo $row['email'] ?>">
                                </div>


                                <div class="form-group">
                                    <label for="exampleInputPhone">Phone Number <small>[Not Editable]</small> </label>
                                    <input type="tel" name="phone" class="form-control" id="exampleInputPhone"
                                           readonly
                                           value="<?php echo $row['cell'] ?>">
                                </div>

                                <div class="form-group">

                                    <div class="form-group">
                                        <label for="exampleType">Role</label>
                                        <select class="form-control" name="type" id="exampleType">
                                            <option value="<?php echo strtolower($row['user_type']) ?>"><?php echo strtoupper($row['user_type']) ?></option>
                                            <option value="examiner">Examiner</option>
                                            <option value="invigilator">Invigilator</option>

                                        </select>


                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputPassword">Password</label>
                                    <input type="password" name="password" class="form-control"
                                           id="exampleInputPassword" minlength="4"
                                           value="<?php echo valueEncryptDecrypt('decrypt', $row['password']); ?>">
                                </div>


                            </div>
                            <div class="panel-footer">
                                <button type="submit" id="update_user" class="btn btn-primary"><i
                                            class="fa fa-check-circle"></i> Update User
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

    $(document).on('click', '#update_user', function (e) {


        $('#quickForm').validate({
            rules: {

                name: {
                    required: true
                },
                email: {
                    required: true,
                    email: true,
                },
                phone: {
                    required: true
                },
                password: {
                    required: true
                },


            },
            messages: {
                name: {
                    required: "Please enter name"
                },
                email: {
                    required: "Please enter a email address",
                    email: "Please enter a valid email address"
                },
                phone: {
                    required: "Please enter phone number"
                },
                password: {
                    required: "Please enter password"
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

    $(document).on('click', '#update_user', function (e) {
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
