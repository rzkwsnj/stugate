<?php
/**
 * This file may not be redistributed in whole or significant part.
 * ---------------- THIS IS NOT FREE SOFTWARE ----------------
 *
 *
 * @file        index.php
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

if ( ! file_exists ( 'themes/public/api/_stugate_') ) :
    $url = 'install_guide/index.php';
    header('location: '.$url);
else :

    global $con;
    session_start();

    include('core/helpers.php');

    $status = "SUCCESS";
    $res = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $email = xss_clean($_POST['email']);
        $password = valueEncryptDecrypt('encrypt', $_POST['password']);


        if (empty($email)) {
            $res .= "Please Enter Valid Email Address !.";
            $status = "ERROR";
        }


        if (empty($password)) {
            $res .= "Please Enter Your password !.";

            $status = "ERROR";
        }

        if ($status == "SUCCESS") {

            include('core/db.php');


            $result = mysqli_query($con, "SELECT * FROM superusers WHERE superuser_email='$email' and superuser_password='$password'");

            $count = mysqli_num_rows($result);

            $result2 = mysqli_query($con, "SELECT * FROM admins WHERE admin_email='$email' and admin_password='$password' AND admin_status=1");

            $count2 = mysqli_num_rows($result2);


            if ($count == 1) {

                $row = mysqli_fetch_array($result);

                $_SESSION['email'] = $row['superuser_email'];
                $_SESSION['role'] = "superuser";
                $_SESSION['key'] = (rand(1000, 9999));


                header("location:backend/dashboard.php");
            } else if ($count2 == 1) {

                $row = mysqli_fetch_array($result2);

                $_SESSION['admin_id'] = $row['admin_id'];
                $_SESSION['admin_status'] = $row['admin_status'];
                $_SESSION['admin_type'] = $row['admin_type'];
                $_SESSION['email'] = $row['admin_email'];
                $_SESSION['role'] = "generaluser";
                $_SESSION['key'] = (rand(1000, 9999));


                header("location:backend/dashboard.php");
            } else {

                $res = "Invalid Credentials !!!";

            }
        }

    }

endif;


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="robots" content="noindex, nofollow">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo APP_NAME; ?></title>
    <meta name="description" content="<?php echo APP_NAME; ?>"/>
    <meta name="keywords" content="<?php echo APP_INITIAL; ?>"/>
    <meta name="author" content="rizkiwisnuaji"/>
    <link rel="shortcut icon" href="<?php echo PUBLIC_DIR; ?>ico/favicon.ico">
    <link rel="stylesheet" href="<?php echo BACKEND_ASSETS_CSS; ?>auth.css" type="text/css"/>
    <link rel="stylesheet" href="<?php echo PUBLIC_ASSETS; ?>font-awesome/css/font-awesome.min.css" type="text/css"/>
    <link rel="stylesheet" href="<?php echo GLOBAL_COMPONENTS; ?>gritter/css/jquery.gritter.css" type="text/css"/>

</head>
<body>

<div class="container">

    <section class="main">

        <div align="center" style="padding-top: 30px;">

            <img src="<?php echo PUBLIC_DIR; ?>logo/STUGATE.png" alt="" width="200px;">
            <!--            <img src="https://chart.googleapis.com/chart?chs=400x400&cht=qr&chl=rzkwsnj&chld=L|1&choe=UTF-8" alt="" width="100px;">-->

        </div>

        <div class="form-login">

            <form action="index.php" method="post">

                <p>
                    <label for="login">E-mail</label>
                    <input type="text" name="email" placeholder="E-mail" required>
                </p>
                <p>
                    <label for="password">Password</label>
                    <input type="password" name='password' placeholder="Password" required>
                </p>

                <br>

                <p>
                    <input type="submit" name="submit" value="SECURE LOGIN">
                </p>

            </form>

        </div>


    </section>

</div>

<script src="<?php echo JQUERY_COMPONENT; ?>" type="text/javascript"></script>
<script src="<?php echo GLOBAL_COMPONENTS; ?>backstretch/jquery.backstretch.min.js"></script>
<script type="text/javascript">
    $.backstretch([
        "<?php echo BACKEND_ASSETS_IMG; ?>auth/1.jpg",
        "<?php echo BACKEND_ASSETS_IMG; ?>auth/2.jpg",
        "<?php echo BACKEND_ASSETS_IMG; ?>auth/3.jpg"
    ], {
        fade: 2000,
        duration: 10000
    });
</script>
<script src="<?php echo GLOBAL_COMPONENTS; ?>gritter/js/jquery.gritter.min.js" type="text/javascript"></script>

<?php if ($_SERVER["REQUEST_METHOD"] == "POST") { ?>
    <script>
        $.gritter.add({
            // (string | mandatory) the heading of the notification
            title: '<i class="fa fa-meh-o"></i> Something went wrong !',
            // (string | mandatory) the text inside the notification
            text: "<i><?php echo $res ?></i>",
            class_name: 'gritter-alert gritter-icon'
        });
    </script>
<?php } ?>

</body>
</html>
