<?php
/**
 * This file may not be redistributed in whole or significant part.
 * ---------------- THIS IS NOT FREE SOFTWARE ----------------
 *
 *
 * @file        add_students.php
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
    echo " ";
} else {
    header("location:../index.php");

}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    include("../core/db.php");

    $student_name = xss_clean($_POST['student_name']);
    $student_code = generateStudentCode(10);
    $student_email = xss_clean($_POST['student_email']);
    $student_phone = xss_clean($_POST['student_phone']);
    $student_address = xss_clean($_POST['student_address']);
    $student_department = xss_clean($_POST['student_department']);
    $student_level = xss_clean($_POST['student_level']);
    $student_session_paid = xss_clean($_POST['student_session_paid']);
    $student_transaction_id = xss_clean($_POST['student_transaction_id']);
    $student_date_paid = xss_clean($_POST['student_date_paid']);
    $student_passport = xss_clean($_POST['student_passport']);
    $student_barcode = generateStudentCode(10);
    $student_status = xss_clean($_POST['student_status']);
    $student_payment_bank = xss_clean($_POST['student_payment_bank']);
    $school_id = xss_clean($_POST['school_id']);
    $admin_id = xss_clean($_POST['admin_id']);

    //get file name
    $filename = basename($_FILES['uploadedfile']['name']);


    $result = mysqli_query($con, "SELECT * FROM students WHERE student_name='$student_name' OR student_email='$student_email' OR student_phone='$student_phone' AND admin_id='$admin_id'");
    $num_rows = mysqli_num_rows($result);


    if ($num_rows > 0) {
        echo '<script type="text/javascript">';
        echo 'setTimeout(function () { swal("ERROR!","Student already exists!","error");';
        echo '}, 500);</script>';
    } else {

        if (empty($filename)) {
            $newfilename = 'image_placeholder.png';
        } else {

            $sms_code = time();
            //generate random file name
            $temp = explode(".", $_FILES["uploadedfile"]["name"]);
            $newfilename = $sms_code . '.' . end($temp);
            move_uploaded_file($_FILES["uploadedfile"]["tmp_name"], "../uploads/images/student_images/" . $newfilename);
        }

        if (mysqli_query($con, "INSERT INTO students (
            `student_name`,
            `student_code`,
            `student_email`,
            `student_phone`,
            `student_address`,
            `student_department`,
            `student_level`,
            `student_session_paid`,
            `student_transaction_id`,
            `student_date_paid`,
            `student_passport`,
            `student_barcode`,
            `student_status`,
            `student_image`,
            `student_payment_bank`,
            `school_id`,
            `admin_id`) VALUE (
            '$student_name',
            '$student_code',
            '$student_email',
            '$student_phone',
            '$student_address',
            '$student_department',
            '$student_level',
            '$student_session_paid',
            '$student_transaction_id',
            '$student_date_paid',
            '$student_passport',
            '$student_barcode',
            '$student_status',
            '$newfilename',
            '$student_payment_bank',
            '$school_id',
            '$admin_id')")) {
            echo '<script type="text/javascript">';
            echo 'setTimeout(function () { swal("Student Successfully Added!","Done!","success");';
            echo '}, 500);</script>';

            echo '<script type="text/javascript">';
            echo "setTimeout(function () { window.open('all_students.php','_self')";
            echo '}, 1500);</script>';

        } else {// display the error message
            echo '<script type="text/javascript">';
            echo 'setTimeout(function () { swal("ERROR!","Something Wrong!","error");';
            echo '}, 500);</script>';
        }


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
                        <li>
                            <i class="fa fa-check-square-o"></i> <a href="all_students.php">All Students</a>
                        </li>
                        <li class="active">
                            <i class="fa fa-check-square-o"></i> Add Student
                        </li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">

                    <div class="panel panel-default">
                        <div class="panel-heading">

                            <h3 class="card-title">Add student information</h3>

                        </div>


                        <form enctype="multipart/form-data" role="form" id="quickForm" method="post"
                              action="add_students.php">
                            <div class="panel-body">

                                <div class="form-group">

                                    <div class="form-group">
                                        <label for="exampleInputAdmin">Select School</label>
                                        <select class="form-control" name="school_id">

                                            <?php
                                            include('../core/db.php');

                                            $result = mysqli_query($con, "SELECT * FROM schools WHERE school_status='OPEN'");
                                            while ($row = mysqli_fetch_array($result)) {
                                                echo "<option value='" . $row['school_id'] . "'>" . $row['school_name'] . "</option>";

                                            }
                                            echo "</select>";

                                            ?>
                                    </div>
                                </div>


                                <div class="form-group ">
                                    <label for="exampleInputImage">Student pic</label>


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
                                    <label for="exampleInputCustomerName">Student Name</label>
                                    <input type="text" name="student_name" class="form-control"
                                           id="exampleInputshopName"
                                           placeholder="Enter student Name">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Student Email Address</label>
                                    <input type="email" name="student_email" class="form-control"
                                           id="exampleInputEmail1"
                                           placeholder="Enter email address">
                                </div>


                                <div class="form-group">
                                    <label for="exampleInputPhone">Student Phone Number</label>
                                    <input type="tel" name="student_phone" class="form-control" id="exampleInputPhone"
                                           placeholder="Enter phone number">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputAddress">Student Address</label>
                                    <input type="text" name="student_address" class="form-control"
                                           id="exampleInputAddress"
                                           placeholder="Enter student address">
                                </div>


                                <div class="form-group">

                                    <div class="form-group">
                                        <label for="exampleStudentDepartment">Department</label>
                                        <select class="form-control" name="student_department"
                                                id="exampleStudentDepartment">

                                            <option value="EEE">EEE</option>
                                            <option value="AAA">AAA</option>

                                        </select>


                                    </div>
                                </div>

                                <div class="form-group">

                                    <div class="form-group">
                                        <label for="exampleStudentLevel">Level</label>
                                        <select class="form-control" name="student_level" id="exampleStudentLevel">

                                            <option value="100">100L</option>
                                            <option value="200">200L</option>
                                            <option value="300">300L</option>
                                            <option value="400">400L</option>
                                            <option value="500">500L</option>

                                        </select>


                                    </div>
                                </div>

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


                                <div class="form-group">

                                    <div class="form-group">
                                        <label for="exampleStudentStatus">Status</label>
                                        <select class="form-control" name="student_status" id="exampleStudentStatus">

                                            <option value="PAID">PAID</option>
                                            <option value="UNPAID">UNPAID</option>

                                        </select>


                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputTrx">Student Transaction ID</label>
                                    <input type="text" name="student_transaction_id" class="form-control"
                                           id="exampleInputTrx"
                                           placeholder="Enter student trx ID">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputDatePaid">Student Date Paid</label>
                                    <input type="text" name="student_date_paid" class="form-control"
                                           id="exampleInputDatePaid"
                                           placeholder="Enter student date paid">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputBank">Student Payment Bank</label>
                                    <input type="text" name="student_payment_bank" class="form-control"
                                           id="exampleInputBank"
                                           placeholder="Enter student payment bank">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputPassport">Student Passport</label>
                                    <input type="text" name="student_passport" class="form-control"
                                           id="exampleInputPassport"
                                           placeholder="Enter student passport">
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
                                <button type="submit" id="add_student" class="btn btn-primary"><i
                                            class="fa fa-check-circle"></i> Add student
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

    $(document).on('click', '#add_student', function (e) {


        $('#quickForm').validate({
            rules: {

                student_name: {
                    required: true
                },
                student_email: {
                    required: true,
                    email: true,
                },
                student_phone: {
                    required: true
                },
                student_address: {
                    required: true
                },
                student_department: {
                    required: true
                },
                student_level: {
                    required: true
                },

            },
            messages: {
                student_name: {
                    required: "Please enter student name"
                },
                email: {
                    required: "Please enter a email address",
                    email: "Please enter a valid email address"
                },
                student_phone: {
                    required: "Please enter student phone number"
                },
                student_address: {
                    required: "Please enter student address"
                },
                student_department: {
                    required: "Please enter student department"
                },
                student_level: {
                    required: "Please enter student level"
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

    $(document).on('click', '#add_student', function (e) {
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
