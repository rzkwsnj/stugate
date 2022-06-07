<?php
/**
 * This file may not be redistributed in whole or significant part.
 * ---------------- THIS IS NOT FREE SOFTWARE ----------------
 *
 *
 * @file        edit_school.php
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
if (isset($_SESSION['email']) and isset($_SESSION['key'])) {
    include("../core/db.php");
    echo " ";
} else {
    header("location:../index.php");

}


if ($_SERVER["REQUEST_METHOD"] == "GET") {

    $getid = xss_clean($_GET['id']);

    if (!empty($getid)) {
        $query = mysqli_query($con, "SELECT * FROM schools WHERE school_id='$getid'");
        $row = mysqli_fetch_assoc($query);
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $school_id = xss_clean($_POST['school_id']);
    $school_name = xss_clean($_POST['school_name']);
    $school_email = xss_clean($_POST['school_email']);
    $school_contact = xss_clean($_POST['school_contact']);
    $school_address = xss_clean($_POST['school_address']);
    $school_status = xss_clean($_POST['school_status']);

    $school_logo = $_POST['school_logo'];
    $currency_symbol = xss_clean($_POST['currency_symbol']);


    $query = mysqli_query($con, "SELECT * FROM schools WHERE school_id='$school_id'");
    $row = mysqli_fetch_assoc($query);

    //get file name
    $filename = basename($_FILES['uploadedfile']['name']);

    if (empty($filename)) {
        $newfilename = $school_logo;
    } else {

        $sms_code = time();
        //generate random file name
        $temp = explode(".", $_FILES["uploadedfile"]["name"]);
        $newfilename = $sms_code . '.' . end($temp);
        move_uploaded_file($_FILES["uploadedfile"]["tmp_name"], "../uploads/images/school_images/" . $newfilename);

    }

    $sql = mysqli_query($con, "Update schools SET school_name='$school_name',school_logo='$newfilename',school_email='$school_email',school_contact='$school_contact',school_address='$school_address',currency_symbol='$currency_symbol',school_status='$school_status' WHERE school_id='$school_id'");

    if ($sql) {
        echo '<script type="text/javascript">';
        echo 'setTimeout(function () { swal("Successfully updated!","Done!","success");';
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
                            <i class="fa fa-check-square-o"></i> Edit School
                        </li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">

                            <h3 class="card-title">Update School information</h3>

                        </div>


                        <form enctype="multipart/form-data" role="form" id="quickForm" method="post"
                              action="edit_school.php">
                            <div class="panel-body">

                                <div class="form-group">

                                    <input type="hidden" name="school_id" class="form-control"
                                           id="exampleInputCustomerName"
                                           value="<?php echo $row['school_id'] ?>">
                                </div>

                                <div class="form-group ">
                                    <label for="exampleInputImage">School Logo</label>


                                    <div>
                                        <?php echo "<img src=\"../uploads/images/school_images/" . $row['school_logo'] . "\" class=\"img-rounded\" width='200' height='200' alt=\"School Image\">" ?>

                                    </div>

                                    <div class="custom-file">


                                        <input type="hidden" class="custom-file-input" id="fileupload"
                                               name="MAX_FILE_SIZE"
                                               value="2000000"/>

                                        <p>Choose a jpg/png file to upload:</p> <input class="btn btn-default"
                                                                                       name="uploadedfile"
                                                                                       type="file" accept="image/*"/>
                                        (Upload 500px x 500px picture)<br/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <input type="hidden" name="school_logo" class="form-control"
                                           id="exampleInputPrice"
                                           value="<?php echo $row['school_logo'] ?>">


                                </div>
                                <div class="form-group">
                                    <label for="exampleInputshopName">School Name</label>
                                    <input type="text" name="school_name" class="form-control" id="exampleInputshopName"
                                           value="<?php echo $row['school_name'] ?>">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">School Email address</label>
                                    <input type="email" name="school_email" class="form-control" id="exampleInputEmail1"
                                           value="<?php echo $row['school_email'] ?>">
                                </div>


                                <div class="form-group">
                                    <label for="exampleInputPhone">School Phone Number</label>
                                    <input type="tel" name="school_contact" class="form-control" id="exampleInputPhone"
                                           value="<?php echo $row['school_contact'] ?>">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputAddress">School Address</label>
                                    <input type="text" name="school_address" class="form-control"
                                           id="exampleInputAddress"
                                           value="<?php echo $row['school_address'] ?>">
                                </div>


                                <div class="form-group">
                                    <label for="exampleInputCurrencySymbol">Currency Symbol</label>
                                    <input type="text" name="currency_symbol" class="form-control"
                                           id="exampleInputCurrencySymbol"
                                           value="<?php echo $row['currency_symbol'] ?>">
                                </div>


                                <div class="form-group">

                                    <div class="form-group">
                                        <label for="exampleSchoolStatus">Status</label>
                                        <select class="form-control" name="school_status" id="exampleSchoolStatus">
                                            <option value="<?php echo $row['school_status'] ?>"><?php echo $row['school_status'] ?></option>
                                            <option value="OPEN">OPEN</option>
                                            <option value="CLOSED">CLOSED</option>

                                        </select>


                                    </div>
                                </div>


                            </div>

                            <div class="panel-footer">
                                <button type="submit" id="update_school" class="btn btn-primary"><i
                                            class="fa fa-check-circle"></i> Update
                                    School Information
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

    $(document).on('click', '#update_school', function (e) {


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
                currency_symbol: {
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

                currency_symbol: {
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

    $(document).on('click', '#update_school', function (e) {
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
