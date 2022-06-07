<?php
/**
 * This file may not be redistributed in whole or significant part.
 * ---------------- THIS IS NOT FREE SOFTWARE ----------------
 *
 *
 * @file        add_school.php
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
if (isset($_SESSION['role']) AND $_SESSION['role'] == 'superuser') { 

    if (isset($_SESSION['email'])  AND isset($_SESSION['key']) ) {
        echo " ";
    } else {
        header("location:../index.php");

    }



    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        include("../core/db.php");

        $school_name = xss_clean($_POST['school_name']);
        $school_email = xss_clean($_POST['school_email']);
        $school_phone = xss_clean($_POST['school_phone']);
        $school_address = xss_clean($_POST['school_address']);
        $school_currency = xss_clean($_POST['school_currency']);
        $school_status = xss_clean($_POST['school_status']);
        $admin_id = xss_clean($_POST['admin_id']);

         //get file name
        $filename = basename($_FILES['uploadedfile']['name']);


        $result = mysqli_query($con, "SELECT * FROM schools WHERE school_name='$school_name' OR school_email='$school_email' OR school_contact='$school_phone' AND school_admin_id='$admin_id'");
        $num_rows = mysqli_num_rows($result);


        if ($num_rows > 0) {
            echo '<script type="text/javascript">';
            echo 'setTimeout(function () { swal("ERROR!","School already exists!","error");';
            echo '}, 500);</script>';
        } else {

            if (empty($filename)) {
                $newfilename = 'image_placeholder.png';
            } else {

                $sms_code = time();
                //generate random file name
                $temp = explode(".", $_FILES["uploadedfile"]["name"]);
                $newfilename = $sms_code . '.' . end($temp);
                move_uploaded_file($_FILES["uploadedfile"]["tmp_name"], "../uploads/images/school_images/" . $newfilename);
            }

            if (mysqli_query($con, "INSERT INTO schools (`school_name`,`school_logo`,`school_email`,`school_contact`,`school_address`,`currency_symbol`,`school_status`,`school_admin_id`) VALUE ('$school_name','$newfilename','$school_email','$school_phone','$school_address','$school_currency','$school_status','$admin_id')")) {
                echo '<script type="text/javascript">';
                echo 'setTimeout(function () { swal("School Successfully Added!","Done!","success");';
                echo '}, 500);</script>';

                echo '<script type="text/javascript">';
                echo "setTimeout(function () { window.open('all_schools.php','_self')";
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
                        <li>
                            <i class="fa fa-check-square-o"></i> <a href="all_schools.php">All Schools</a>
                        </li>
                        <li class="active">
                            <i class="fa fa-check-square-o"></i> Add School
                        </li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">

                    <div class="panel panel-default">
                        <div class="panel-heading">

                            <h3 class="card-title">Add school information</h3>

                        </div>


                        <form enctype="multipart/form-data" role="form" id="quickForm" method="post" action="add_school.php">
                            <div class="panel-body">

                                <div class="form-group ">
                                    <label for="exampleInputImage">School Logo</label>


                                    <div class="custom-file">
                                        <input type="hidden" class="custom-file-input" id="fileupload"
                                               name="MAX_FILE_SIZE"
                                               value="2000000"/>

                                        Choose a jpg/png file to upload:<br> <input class="btn btn-default"
                                                                                    name="uploadedfile"
                                                                                    type="file" accept="image/*"/>
                                        (Upload 500px x 500px picture)<br/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputCustomerName">School Name</label>
                                    <input type="text" name="school_name" class="form-control" id="exampleInputshopName"
                                           placeholder="Enter school Name">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">School Email Address</label>
                                    <input type="email" name="school_email" class="form-control" id="exampleInputEmail1"
                                           placeholder="Enter email address">
                                </div>


                                <div class="form-group">
                                    <label for="exampleInputPhone">School Phone Number</label>
                                    <input type="tel" name="school_phone" class="form-control" id="exampleInputPhone"
                                           placeholder="Enter phone number">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputAddress">School Address</label>
                                    <input type="text" name="school_address" class="form-control" id="exampleInputAddress"
                                           placeholder="Enter school address">
                                </div>


                                <div class="form-group">
                                    <label for="exampleInputAddress">Currency Symbol</label>
                                    <input type="text" name="school_currency" class="form-control"
                                           id="exampleInputAddress" maxlength="3"
                                           placeholder="Enter school currency symbol">
                                </div>


                                <div class="form-group">

                                    <div class="form-group">
                                        <label for="exampleSchoolStatus">Status</label>
                                        <select class="form-control" name="school_status" id="exampleSchoolStatus">

                                            <option value="OPEN">OPEN</option>
                                            <option value="CLOSED">CLOSED</option>

                                        </select>


                                    </div>
                                </div>



                                <div class="form-group">

                                    <div class="form-group">
                                        <label for="exampleInputAdmin">Select Admin</label>
                                        <select class="form-control" name="admin_id">

                                            <?php
                                            include('../core/db.php');

                                            $result = mysqli_query($con, "SELECT * FROM admins WHERE admin_status='1'");
                                            while ($row = mysqli_fetch_array($result)) {
                                                echo "<option value='" . $row['admin_id'] . "'>" . $row['admin_name'] . "</option>";

                                            }
                                            echo "</select>";

                                            ?>
                                    </div>
                                </div>



                            </div>
                            <div class="panel-footer">
                                <button type="reset" class="btn btn-dark"><i class="fa fa-times-circle"></i> Reset
                                </button>
                                <button type="submit" id="add_school" class="btn btn-primary"><i
                                            class="fa fa-check-circle"></i> Add School
                                </button>
                            </div>
                        </form>


                    </div>
                    <!-- /.card -->
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

    $(document).on('click', '#add_school', function (e) {


        $('#quickForm').validate({
            rules: {

                school_name: {
                    required: true
                },
                school_email: {
                    required: true,
                    email: true,
                },
                school_phone: {
                    required: true
                },
                school_address: {
                    required: true
                },
                school_currency: {
                    required: true
                },


            },
            messages: {
                school_name: {
                    required: "Please enter school name"
                },
                email: {
                    required: "Please enter a email address",
                    email: "Please enter a valid email address"
                },
                school_phone: {
                    required: "Please enter school phone number"
                },
                school_address: {
                    required: "Please enter school address"
                },
                school_currency: {
                    required: "Please enter school currency symbol"
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

    $(document).on('click', '#add_school', function (e) {
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
