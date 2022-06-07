<?php
/**
 * This file may not be redistributed in whole or significant part.
 * ---------------- THIS IS NOT FREE SOFTWARE ----------------
 *
 *
 * @file        dashboard.php
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
    header("location:../index.php");

}

?>

<?php include_once '_master/_base.php'; ?>

<div id="wrapper">
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
                    <li class="nav-item active">
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
    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <p class="page-header">
                        <?php echo APP_NAME . " ver. " . APP_VERSION; ?>
                    </p>
                    <ol class="breadcrumb">
                        <li class="active">
                            <i class="fa fa-desktop"></i> Dashboard
                        </li>
                    </ol>
                </div>
            </div>
            <!-- /.row -->

            <?php
            include('../core/db.php');

            $count_student = mysqli_query($con, "SELECT * FROM students");
            $total_student = mysqli_num_rows($count_student);

            $count_user = mysqli_query($con, "SELECT * FROM users");
            $total_user = mysqli_num_rows($count_user);

            $count_admin = mysqli_query($con, "SELECT * FROM admins");
            $total_admin = mysqli_num_rows($count_admin);


            $count_school = mysqli_query($con, "SELECT * FROM schools");
            $total_school = mysqli_num_rows($count_school);

            ?>

            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <a href="all_students.php">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-group fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?php echo $total_student ?></div>
                                        <div>Total Students</div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </a>
                </div>

                <div class="col-lg-6 col-md-6">
                    <a href="all_schools.php">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-cubes fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?php echo $total_school ?></div>
                                        <div>Total Schools</div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </a>
                </div>
            </div>

            <div class="row">
                <?php if (isset($_SESSION['role']) and $_SESSION['role'] == 'superuser') { ?>
                    <div class="col-lg-6 col-md-6">
                        <a href="all_users.php">
                            <div class="panel panel-warning">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fa fa-list fa-5x"></i>
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <div class="huge"><?php echo $total_user ?></div>
                                            <div>Total Users</div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </a>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-6 col-md-6">
                        <a href="all_admins.php">
                            <div class="panel panel-danger">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fa fa-fw fa-user fa-5x"></i>
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <div class="huge"><?php echo $total_admin ?></div>
                                            <div>Total Admins</div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </a>
                    </div>
                <?php } else { ?>
                    <div class="col-lg-12 col-md-12">
                        <a href="all_users.php">
                            <div class="panel panel-warning">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fa fa-list fa-5x"></i>
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <div class="huge"><?php echo $total_user ?></div>
                                            <div>Total Users</div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </a>
                    </div>
                <?php } ?>
            </div>

            <hr>

            <div class="row">

                <div class="col-lg-12">

                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <i class="fa fa-group"></i> Latest Students
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>Session</th>


                                </tr>
                                </thead>
                                <tbody>
                                <?php

                                $sql = "SELECT * FROM students ORDER BY student_id DESC";
                                $result = mysqli_query($con, $sql);
                                $i = 1;
                                while ($row = mysqli_fetch_array($result)) {

                                    if ($i > 5) {
                                        break;
                                    }
                                    echo "<tr>";

                                    echo "<td>" . $i . "</td>";
                                    echo "<td><img src=\"https://chart.googleapis.com/chart?chs=100x100&cht=qr&chl=" . $row['student_code'] . "&chld=L|1&choe=UTF-8\" class=\"img-rounded\" width='100' height='100' alt=\"QR Code\"></td>";
                                    echo "<td>" . $row['student_name'] . "  <span class=\"label label-info\">NEW</span></td> ";
                                    echo "<td>" . $row['student_session_paid'] . "</td>";


                                    $i++;

                                    echo "</tr> ";
                                }

                                echo " </tbody>";
                                echo " </table>";

                                ?>

                        </div>
                        <!-- /.panel-body -->
                        <div class="panel-footer clearfix">
                            <button type="button" onclick="location.href = 'all_students.php';"
                                    class="btn btn-sm btn-success float-right"><i class='fa fa-eye'></i> View All
                                Students
                            </button>
                        </div>
                    </div>

                </div>


            </div>

            <hr/>

            <?php if (isset($_SESSION['role']) and $_SESSION['role'] == 'superuser') { ?>
                <div class="row">
                    <div class="col-lg-6">

                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <i class="fa fa-cubes"></i> Latest Schools
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Contact</th>
                                        <th>Address</th>


                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php

                                    $sql = "SELECT * FROM schools ORDER BY school_id DESC";
                                    $result = mysqli_query($con, $sql);
                                    $i = 1;
                                    while ($row = mysqli_fetch_array($result)) {

                                        if ($i > 5) {
                                            break;
                                        }
                                        echo "<tr>";

                                        echo "<td>" . $i . "</td>";
                                        echo "<td>" . $row['school_name'] . "  <span class=\"label label-warning\">NEW</span></td> ";
                                        echo "<td>" . $row['school_contact'] . "</td>";
                                        echo "<td>" . $row['school_address'] . "</td>";


                                        $i++;

                                        echo "</tr> ";
                                    }

                                    echo " </tbody>";
                                    echo " </table>";

                                    ?>
                            </div>
                            <!-- /.panel-body -->
                            <div class="panel-footer clearfix">
                                <button type="button" onclick="location.href = 'all_schools.php';"
                                        class="btn btn-sm btn-primary float-right"><i class='fa fa-eye'></i> View
                                    All
                                    Schools
                                </button>
                            </div>
                        </div>

                    </div>


                    <div class="col-lg-6">
                        <!-- TABLE: LATEST ADMINS -->
                        <div class="panel panel-danger">
                            <div class="panel-heading">
                                <i class="fa fa-fw fa-user"></i> Latest School Admins
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Contact</th>
                                        <th>Address</th>


                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php


                                    $sql = "SELECT * FROM admins ORDER BY admin_id DESC";
                                    $result = mysqli_query($con, $sql);
                                    $i = 1;
                                    while ($row = mysqli_fetch_array($result)) {
                                        if ($i > 5) {
                                            break;
                                        }

                                        echo "<tr>";

                                        echo "<td>" . $i . "</td>";
                                        echo "<td>" . $row['admin_name'] . "  <span class=\"badge bg-danger\">NEW</span></td> ";
                                        echo "<td>" . $row['admin_cell'] . "</td>";
                                        echo "<td>" . $row['admin_address'] . "</td>";

                                        $i++;

                                        echo "</tr> ";
                                    }

                                    echo " </tbody>";
                                    echo " </table>";

                                    ?>
                            </div>
                            <!-- /.panel-body -->
                            <div class="panel-footer clearfix">
                                <button type="button" onclick="location.href = 'all_admins.php';"
                                        class="btn btn-sm btn-danger float-right"><i class='fa fa-eye'></i> View
                                    All
                                    Admins
                                </button>
                            </div>
                        </div>

                        <!-- /.col-md-6 -->


                    </div>
                    <!-- /.col-md-6 -->


                    <!-- /.container-fluid -->
                </div>
                <!-- /.content -->
            <?php } ?>
        </div>

    </div>
</div>

<script src="../<?php echo BOOTSTRAP_COMPONENT_JS; ?>" type="text/javascript"></script>
<script src="../<?php echo GLOBAL_COMPONENTS; ?>fancybox/source/jquery.fancybox.pack.js"
        type="text/javascript"></script>
<script src="../<?php echo BACKEND_ASSETS_JS; ?>rzkwsnj.js"></script>

<?php include_once '_master/_footer.php'; ?>