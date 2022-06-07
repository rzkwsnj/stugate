<?php
/**
 * This file may not be redistributed in whole or significant part.
 * ---------------- THIS IS NOT FREE SOFTWARE ----------------
 *
 *
 * @file        bulk_import_students.php
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

if (isset($_GET['dl'])) {
    $name = 'students.csv';
    $path = '../uploads/' . $name;
    $size = filesize($path);
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header("Content-length:" . $size);
    header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=\"" . basename($name) . "\";");
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    ob_clean();
    flush();
    readfile('../uploads/' . $name);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $mimes = array('application/vnd.ms-excel', 'text/plain', 'text/csv', 'text/tsv');
    if (in_array($_FILES['file']['type'], $mimes)) {

        $file = $_FILES['file']['tmp_name'];
        $handle = fopen($file, "r");
        $count = 0;
        while (($filesop = fgetcsv($handle, 1000, ",")) !== false) {
            $student_name = $filesop[0];
            $student_code = generateStudentCode(10);
            $student_email = xss_clean($filesop[1]);
            $student_phone = xss_clean($filesop[2]);
            $student_address = xss_clean($filesop[3]);
            $student_department = xss_clean($filesop[4]);
            $student_level = xss_clean($filesop[5]);
            $student_session_paid = xss_clean($filesop[6]);
            $student_transaction_id = xss_clean($filesop[7]);
            $student_date_paid = xss_clean($filesop[8]);
            $student_passport = xss_clean($filesop[9]);
            $student_status = xss_clean($filesop[10]);
            $student_payment_bank = xss_clean($filesop[11]);
            $school_id = xss_clean($filesop[12]);
            $admin_id = xss_clean($filesop[13]);

            $count++;
            if ($count > 1) {
                $result = mysqli_query($con, "SELECT * FROM students WHERE student_code='$student_code' OR student_transaction_id='$student_transaction_id' AND admin_id='$admin_id'");
                $num_rows = mysqli_num_rows($result);

                if ($num_rows > 0) {
                    echo '<script type="text/javascript">';
                    echo 'setTimeout(function () { swal("ERROR!","Duplicate Student transaction ID / Code data, please re-check!","error");';
                    echo '}, 500);</script>';
                } else {

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
				            '$student_status',
				            'image_placeholder.png',
				            '$student_payment_bank',
				            '$school_id',
				            '$admin_id')")) {
                        echo '<script type="text/javascript">';
                        echo 'setTimeout(function () { swal("All Students Successfully Added!","Done!","success");';
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

        }

    } else {
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
                    <button class="navbar-toggle collapsed" type="button" data-toggle="collapse"
                            data-target="#bs-navbar"
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
                                <i class="fa fa-check-square-o"></i> Bulk Import Students
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">

                                <h3 class="card-title">Bulk Import Students</h3>
                                <button type="button"
                                        onclick="location.href = 'bulk_import_students.php?dl=students.csv';"
                                        class="btn btn-success float-right">Download CSV template <i
                                            class='fa fa-download'></i>
                                </button>
                            </div>


                            <form enctype="multipart/form-data" role="form" id="quickForm" method="post"
                                  action="bulk_import_students.php">
                                <div class="panel-body">

                                    <div class="form-group ">
                                        <label for="exampleInputCSV">CSV File</label>


                                        <div class="custom-file">
                                            <input type="hidden" class="custom-file-input" id="fileupload"
                                                   name="MAX_FILE_SIZE"
                                                   value="2000000"/>

                                            Choose a csv file to upload:<br> <input class="btn btn-default"
                                                                                    name='file' type='file' id='file'/>
                                        </div>
                                    </div>


                                </div>
                                <div class="panel-footer">
                                    <button type="submit" id="bulk_import_student" class="btn btn-dark"><i
                                                class="fa fa-bars"></i> Import students
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

    <script src="../<?php echo BOOTSTRAP_COMPONENT_JS; ?>" type="text/javascript"></script>
    <script src="../<?php echo GLOBAL_COMPONENTS; ?>fancybox/source/jquery.fancybox.pack.js"
            type="text/javascript"></script>
    <!-- jquery-validation -->
    <script src="../<?php echo JQUERY_VALIDATE_JS; ?>"></script>
    <script src="../<?php echo JQUERY_VALIDATE_ADDITIONAL_JS; ?>"></script>
    <script type="text/javascript">

        $(document).on('click', '#bulk_import_student', function (e) {


            $('#quickForm').validate({
                rules: {

                    file: {
                        required: true
                    },

                },
                messages: {
                    file: {
                        required: "Please select a CSV file"
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

        $(document).on('click', '#bulk_import_student', function (e) {
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