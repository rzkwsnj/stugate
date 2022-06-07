<?php
/**
 * This file may not be redistributed in whole or significant part.
 * ---------------- THIS IS NOT FREE SOFTWARE ----------------
 *
 *
 * @file        edit_student.php
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
        $query = mysqli_query($con, "SELECT * FROM students WHERE student_id='$getid'");
        $row = mysqli_fetch_assoc($query);
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $student_id = xss_clean($_POST['student_id']);
    $student_name = xss_clean($_POST['student_name']);
    $student_email = xss_clean($_POST['student_email']);
    $student_phone = xss_clean($_POST['student_phone']);
    $student_address = xss_clean($_POST['student_address']);
    $student_department = xss_clean($_POST['student_department']);
    $student_level = xss_clean($_POST['student_level']);
    $student_session_paid = xss_clean($_POST['student_session_paid']);
    $student_transaction_id = xss_clean($_POST['student_transaction_id']);
    $student_date_paid = xss_clean($_POST['student_date_paid']);
    $student_passport = xss_clean($_POST['student_passport']);
    $student_status = xss_clean($_POST['student_status']);
    $student_payment_bank = xss_clean($_POST['student_payment_bank']);
    $school_id = xss_clean($_POST['school_id']);
    $admin_id = xss_clean($_POST['admin_id']);

    $student_image = $_POST['student_image'];


    $query = mysqli_query($con, "SELECT * FROM students WHERE student_id='$student_id'");
    $row = mysqli_fetch_assoc($query);

    //get file name
    $filename = basename($_FILES['uploadedfile']['name']);

    if (empty($filename)) {
        $newfilename = $student_image;
    } else {

        $sms_code = time();
        //generate random file name
        $temp = explode(".", $_FILES["uploadedfile"]["name"]);
        $newfilename = $sms_code . '.' . end($temp);
        move_uploaded_file($_FILES["uploadedfile"]["tmp_name"], "../uploads/images/student_images/" . $newfilename);

    }

    $sql = mysqli_query($con, "UPDATE students SET 
        student_name='$student_name',
        student_email='$student_email',
        student_phone='$student_phone',
        student_address='$student_address',
        student_department='$student_department',
        student_level='$student_level',
        student_session_paid='$student_session_paid',
        student_transaction_id='$student_transaction_id',
        student_date_paid='$student_date_paid',
        student_passport='$student_passport',
        student_status='$student_status',
        student_image='$newfilename',
        student_payment_bank='$student_payment_bank' WHERE student_id='$student_id'");

    if ($sql) {
        echo '<script type="text/javascript">';
        echo 'setTimeout(function () { swal("Successfully updated!","Done!","success");';
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
                            <i class="fa fa-check-square-o"></i> Edit Student
                        </li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">

                            <h3 class="card-title">Update Student information</h3>

                        </div>


                        <form enctype="multipart/form-data" role="form" id="quickForm" method="post"
                              action="edit_student.php">
                            <div class="panel-body">

                                <div class="form-group">

                                    <input type="hidden" name="student_id" class="form-control"
                                           id="exampleInputCustomerName"
                                           value="<?php echo $row['student_id'] ?>">
                                </div>

                                <div class="form-group ">
                                    <label for="exampleInputImage">Student Pic</label>


                                    <div>
                                        <?php echo "<img src=\"../uploads/images/student_images/" . $row['student_image'] . "\" class=\"img-rounded\" width='200' height='200' alt=\"Student Image\">" ?>

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
                                    <input type="hidden" name="student_image" class="form-control"
                                           id="exampleInputImage"
                                           value="<?php echo $row['student_image'] ?>">


                                </div>
                                <div class="form-group">
                                    <label for="exampleInputshopName">Student Name</label>
                                    <input type="text" name="student_name" class="form-control"
                                           id="exampleInputshopName"
                                           value="<?php echo $row['student_name'] ?>">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Student Email address</label>
                                    <input type="email" name="student_email" class="form-control"
                                           id="exampleInputEmail1"
                                           value="<?php echo $row['student_email'] ?>">
                                </div>


                                <div class="form-group">
                                    <label for="exampleInputPhone">Student Phone Number</label>
                                    <input type="tel" name="student_phone" class="form-control" id="exampleInputPhone"
                                           value="<?php echo $row['student_phone'] ?>">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputAddress">Student Address</label>
                                    <input type="text" name="student_address" class="form-control"
                                           id="exampleInputAddress"
                                           value="<?php echo $row['student_address'] ?>">
                                </div>


                                <div class="form-group">

                                    <div class="form-group">
                                        <label for="exampleStudentDepartment">Department</label>
                                        <select class="form-control" name="student_department"
                                                id="exampleStudentDepartment">
                                            <option value="<?php echo $row['student_department'] ?>"><?php echo $row['student_department'] ?></option>
                                            <option value="EEE">EEE</option>
                                            <option value="AAA">AAA</option>

                                        </select>


                                    </div>
                                </div>

                                <div class="form-group">

                                    <div class="form-group">
                                        <label for="exampleStudentLevel">Level</label>
                                        <select class="form-control" name="student_level" id="exampleStudentLevel">
                                            <option value="<?php echo $row['student_level'] ?>"><?php echo $row['student_level'] ?></option>
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
                                            <option value="<?php echo $row['student_session_paid'] ?>"><?php echo $row['student_session_paid'] ?></option>
                                            <option value="2021/2022">2021/2022</option>
                                            <option value="2022/2023">2022/2023</option>

                                        </select>


                                    </div>
                                </div>


                                <div class="form-group">

                                    <div class="form-group">
                                        <label for="exampleSchoolStatus">Status</label>
                                        <select class="form-control" name="student_status" id="exampleSchoolStatus">
                                            <option value="<?php echo $row['student_status'] ?>"><?php echo $row['student_status'] ?></option>
                                            <option value="PAID">PAID</option>
                                            <option value="UNPAID">UNPAID</option>

                                        </select>


                                    </div>
                                </div>


                                <div class="form-group">
                                    <label for="exampleInputTrx">Student Transaction ID</label>
                                    <input type="text" name="student_transaction_id" class="form-control"
                                           id="exampleInputTrx"
                                           placeholder="Enter student trx ID"
                                           value="<?php echo $row['student_transaction_id'] ?>">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputDatePaid">Student Date Paid</label>
                                    <input type="text" name="student_date_paid" class="form-control"
                                           id="exampleInputDatePaid"
                                           placeholder="Enter student date paid"
                                           value="<?php echo $row['student_date_paid'] ?>">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputBank">Student Payment Bank</label>
                                    <input type="text" name="student_payment_bank" class="form-control"
                                           id="exampleInputBank"
                                           placeholder="Enter student payment bank"
                                           value="<?php echo $row['student_payment_bank'] ?>">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputPassport">Student Passport</label>
                                    <input type="text" name="student_passport" class="form-control"
                                           id="exampleInputPassport"
                                           placeholder="Enter student passport"
                                           value="<?php echo $row['student_passport'] ?>">
                                </div>


                            </div>
                            <div class="panel-footer">
                                <button type="submit" id="update_student" class="btn btn-primary"><i
                                            class="fa fa-check-circle"></i> Update
                                    Student Information
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
            ules: {

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

    $(document).on('click', '#update_student', function (e) {
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
