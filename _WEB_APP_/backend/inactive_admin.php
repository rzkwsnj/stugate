<?php
/**
 * This file may not be redistributed in whole or significant part.
 * ---------------- THIS IS NOT FREE SOFTWARE ----------------
 *
 *
 * @file        inactive_admin.php
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

if (isset($_SESSION['role']) AND $_SESSION['role'] == 'superuser') { 

	include('../core/db.php');
	include('../core/helpers.php');

	$id=xss_clean($_GET['id']);

	$result = mysqli_query($con, "SELECT * FROM admins WHERE admin_id='$id'");
	$num_rows = mysqli_num_rows($result);

	if ($num_rows == 0) {
	    echo "<script>alert('Something went wrong!')</script>";
		echo "<script>window.open('all_admins.php','_self')</script>";
	} else {
		$update=mysqli_query($con,"UPDATE admins SET admin_status=0  WHERE admin_id='$id'");
		if($update)
		{
			echo "<script>alert('Admin Inactivated!')</script>";
			echo "<script>window.open('all_admins.php','_self')</script>";
		}

		else
		{
			echo "<script>alert('Failed!')</script>";
			echo "<script>window.open('all_admins.php','_self')</script>";
		}
	}

} else {
	echo "<script>alert('Unauthorized!')</script>";
	echo "<script>window.open('dashboard.php','_self')</script>";
}
