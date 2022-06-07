<?php

/**
 * This file may not be redistributed in whole or significant part.
 * ---------------- THIS IS NOT FREE SOFTWARE ----------------
 *
 *
 * @file        install_guide/index.php
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
include('../core/helpers.php');
?>

<!DOCTYPE html>
<HTML lang="en" class="no-js">
<HEAD>
    <meta http-equiv="content-type" content="text/html;charset=utf-8">
    <title><?php echo APP_NAME; ?></title>
    <!-- Framework CSS -->
    <link rel="stylesheet" href="assets/blueprint-css/screen.css" type="text/css" media="screen, projection">
    <link rel="stylesheet" href="assets/blueprint-css/print.css" type="text/css" media="print">
    <link rel="stylesheet" href="assets/prism.css" data-noprefix>
    <!--[if lt IE 8]>
    <link rel="stylesheet" href="assets/blueprint-css/ie.css" type="text/css" media="screen, projection"><![endif]-->
    <link rel="stylesheet" href="assets/blueprint-css/plugins/fancy-type/screen.css" type="text/css"
          media="screen, projection">
    <style type="text/css" media="screen">
        p, table, hr {
            margin-bottom: 25px;
        }

        .box p {
            margin-bottom: 10px;
        }

        input[type=submit] {
            padding: 10px 25px;
            background: green;
            color: white;
            border: 0 none;
            cursor: pointer;
            -webkit-border-radius: 5px;
            border-radius: 5px;
        }
    </style>
</HEAD>


<BODY>
<div class="container">

    <h3 class="center alt">&ldquo;<?php echo APP_NAME; ?> &rdquo; Documentation by &ldquo;Rizki Wisnuaji&rdquo;
        v<?php echo APP_VERSION; ?></h3>

    <hr>

    <?php

    if (isset ($_POST["rzkwsnj_generate"])) :

        $newFile = "../themes/public/api/_stugate_";
        $fh = fopen($newFile, 'w');
        $name = "YOUR LICENSE KEY : RZKWSNJ-STUGATE-0";
        $random = uniqid() . rand(1, 99);
        $licenseApp = $name . $random;
        $theDate = $licenseApp . "\nDO NOT DELETE THIS FILE !\n" . date("F j, Y, g:i a");
        fwrite($fh, $theDate);
        fclose($fh);
        echo "<div align='center' class='success'><h3>Congratulations, You can <a href='../backend/dashboard.php'>LOGIN HERE</a></h3></div>";
    endif;

    ?>

    <hr>

    <h1 class="center"><img src="../themes/public/logo/STUGATE.png" width="300" alt="<?php echo APP_NAME; ?>"/><br/>&ldquo;<?php echo APP_NAME; ?>&rdquo;
    </h1>

    <div class="borderTop">
        <div class="span-6 colborder info prepend-1">
            <p class="prepend-top">
                <strong>
                    Created: 21/05/2022<br>
                    Updated: 25/05/2022<br>
                    By: rizkiwisnuaji<br>
                    Email: <a href="mailto:drg.rizkiwisnuaji@gmail.com">drg.rizkiwisnuaji@gmail.com</a><br>
                    Website: <a href="https://github.com/rzkwsnj" target="_blank">https://github.com/rzkwsnj</a>
                </strong>
            </p>
        </div><!-- end div .span-6 -->

        <div class="span-12 last">
            <p class="prepend-top append-0">Thank you for purchasing my application. If you have any questions that are
                beyond the scope of this help file, please feel free to email via my user page contact form <a
                        href="https://github.com/rzkwsnj" target="_blank">here</a>. Thanks so much!</p>
        </div>
    </div><!-- end div .borderTop -->

    <hr>

    <h2 id="toc" class="alt">Table of Contents</h2>
    <ol class="alpha">
        <li><a href="#check">Installation Check</a></li>
        <li><a href="#installcheck">System Check</a></li>
        <li><a href="#installation">Installation Guide</a></li>
        <li><a href="#Structures">Files and Structure</a></li>
        <li><a href="#credits">Sources and Credits</a></li>
    </ol>

    <hr>

    <h3 id="installcheck"><strong>A) Installation Check</strong> - <a href="#toc">top</a></h3>
    <?php

    if (!file_exists("../themes/public/api/_stugate_")) :

        echo "<div class='error'>ALERT ! You are NOT READY to use this APP, Please follow <a href='#installation'>THIS INSTALLATION GUIDE</a></div>";

    else :

        echo "<div class='success'><h3>Congratulations, You can <a href='../index.php'>LOGIN HERE</a></h3></div>";

    endif;

    ?>

    <hr>

    <h3 id="check"><strong>B) System Check</strong> - <a href="#toc">top</a></h3>
    <?php
    const TARGET_PHP_VERSION = '7.*';

    function isPhpOk($expectedVersion)
    {
        // Is this version of PHP greater than minimum version required?
        return version_compare(PHP_VERSION, $expectedVersion, '>=');
    }

    function isDatabaseDriverOk()
    {
        return extension_loaded('mysql') or extension_loaded('mysqli');
    }

    function isZlibOk()
    {
        return extension_loaded('zlib');
    }

    function isCurlOk()
    {
        return extension_loaded('curl');
    }

    function isMcryptOk()
    {
        return extension_loaded('mcrypt');
    }

    function isOpenSslOk()
    {
        return extension_loaded('openssl');
    }

    function isGdOk()
    {
        // Homeboy is not rockin GD at all
        if (!function_exists('gd_info')) :

            die('GD PHP extension is required.');

        endif;

        $gd_info = gd_info();
        $gd_version = preg_replace('/[^0-9\.]/', '', $gd_info['GD Version']);

        // If the GD version is at least 1.0
        return ($gd_version >= 1);
    }

    if (phpversion() < TARGET_PHP_VERSION) :

        echo "<div class='error'>Your PHP version is " . phpversion() . "! PHP " . TARGET_PHP_VERSION . " or higher required!</div>";
    else :

        echo "<div class='success'>You are running PHP " . phpversion() . "</div>";

    endif;

    if (!extension_loaded('mysqli')) :

        echo "<div class='error'>MySQL or MySQLi PHP exention missing!</div>";

    else :

        echo "<div class='success'>MySQL or MySQLi PHP exention loaded!</div>";

    endif;

    if (!extension_loaded('openssl')) :

        echo "<div class='error'>OPEN SSL PHP exention missing!</div>";

    else :

        echo "<div class='success'>OPEN SSL PHP exention loaded!</div>";

    endif;

    if (!is_writeable("../themes/public/api/")) :

        echo "<div class='error'>/themes/public/api/ is not writeable!</div>";

    else :

        echo "<div class='success'>/themes/public/api/ folder is writeable!</div>";

    endif;

    if (!is_writeable("../uploads/")) :

        echo "<div class='error'>/uploads folder is not writeable!</div>";

    else :

        echo "<div class='success'>/uploads folder is writeable!</div>";

    endif;

    if (!file_exists('../vendor/autoload.php')) :

        echo "<div class='error'>Please install composer and run 'sudo composer install && sudo composer update'</div>";

    else :

        echo "<div class='success'>composer was successfully installed !</div>";

    endif;
    ?>

    <hr>

    <h3 id="installation"><strong>C) Installation Guide</strong> - <a href="#toc">top</a></h3>
    <p>1. Firstly, create new database from phpmyadmin with name : <b>stugate</b>.</p>
    <p align="center"><img src="assets/images/create_db.png" width="600" alt=""/></p>
    <br/>

    <p>2. After that, open <b>core/db.php</b>, and type your <b>HOST</b>, <b>USER</b>, <b>PASSWORD</b>, and <b>DB NAME.
    </p>
    <?php $config_contents = file_get_contents('../core/db.php'); ?>
    <pre data-line="16,17,18,19"><code class="language-php"><?php echo $config_contents; ?></code></pre>
    <br/>

    <p>3. <b>COPY</b> this <b>SQL FILE</b>, and <b>PASTE</b> in <b>PHPMYADMIN SQL QUERY</b>.</p>
    <p align="center"><img width="90%" src="assets/images/sql.png"/></p>
    <br/>
    <?php $file_contents = file_get_contents('DB.sql'); ?>
    <pre>
        <code style="overflow: scroll;max-height: 30em;display: block;" class="language-php">
            <?php echo $file_contents; ?>
        </code>
    </pre>
    <br/>

    <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">

        <fieldset>
            <legend>4. PASTE INTO PHPMYADMIN SQL QUERY &amp; HIT <span style='color: green;'>GREEN</span> FINISH BUTTON
                :
            </legend>
            <p align="center"><img width="90%" src="assets/images/sql.png"/></p>
            <p align="center">

                <?php
                if (!file_exists("../themes/public/api/_stugate_")) :

                    echo "<a style='color: green; text-decoration: none; text-align: center; font-size: 30px;'>===> <input type='submit' name='rzkwsnj_generate' value='FINISH !'> <===</a>";

                else :

                    echo "<br><div class='success'><h3>Congratulations, You can <a href='../index.php'>LOGIN HERE</a></h3></div>";

                endif;
                ?>

            </p>

        </fieldset>
    </form>
    <br/>

    <p>5. Go to <b><a href='../index.php'>ADMINISTRATOR LOGIN PAGE</a></b> on your browser.</p>
    <p align="center"><b>THAT'S ALL !</b></p>

    <p>6. One <b><font color="red">IMPORTANT</font></b> thing : through the installation process, we create one file
        named <b>_stugate_</b> with no extension at <b>public/api/</b> folder. <b><font color="red">REMEMBER, DO NOT
                DELETE THIS FILE !</font></b>.</p>

    <p>7. If you have problems due to installation process, please feel free to email via my user page contact form <a
                href="http://codecanyon.net/user/rizkiwisnuaji">here</a> or <a href="mailto:drg.rizkiwisnuaji@gmail.com">drg.rizkiwisnuaji@gmail.com</a>
    </p>

    <hr>

    <h3 id="Structures"><strong>E) Files and Structure</strong> - <a href="#toc">top</a></h3>
    <p>The file is separated into sections using:</p>

    <pre>
<b>stugate</b>
├───<b>api</b>
├───<b>backend</b>
├───<b>core</b>
    ├───db.php
│   └───helpers.php
├───<b style="color: red;">install_guide</b>
├───<b>plugins</b>
├───<b>themes</b>
├───<b>uploads</b>
├───<b>vendor</b>
└──────.htaccess
└──────composer.json
└──────composer.lock
└──────index.php
</pre>

    <hr>

    <h3 id="credits"><strong>F) Sources and Credits</strong> - <a href="#toc">top</a></h3>

    <p>I've used the following framework, icons, favicon, file manager, Calendar or other files as listed.

    <ul>
        <li>Thank's to BOOTSTRAP - <a href="http://www.getbootstrap.com" target="_blank">www.getbootstrap.com</a></li>
        <li>Thank's to Clock Face - <a href="http://vitalets.github.io/clockface" target="_blank">www.vitalets.github.io/clockface</a>
        </li>
        <li>Thank's to Font Awesome - <a href="http://fontawesome.io/icons/" target="_blank">www.fontawesome.io</a></li>
        <li>Thank's to Icon Archive - <a href="http://www.iconarchive.com" target="_blank">www.iconarchive.com</a></li>
        <li>Thank's to Favicon - <a href="http://www.favicon.cc" target="_blank">www.favicon.cc</a></li>
    </ul>

    <hr>

    <p>Once again, thank you so much for supporting this application. As I said at the beginning, I'd be glad to help
        you if you have any questions relating to this application. No guarantees, but I'll do my best to assist.</p>

    <p class="append-bottom alt large"><strong>Rizki Wisnuaji</strong></p>
    <p><a href="#toc">Go To Table of Contents</a></p>

    <hr class="space">
</div><!-- end div .container -->
<script type="text/javascript" src="assets/prism.js"></script>
</BODY>
</HTML>