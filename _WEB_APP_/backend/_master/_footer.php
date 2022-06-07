<?php
/**
 * This file may not be redistributed in whole or significant part.
 * ---------------- THIS IS NOT FREE SOFTWARE ----------------
 *
 *
 * @file        _footer.php
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
?>

<script type="text/javascript">
    $(window).bind('load', function () {
        $('#cbn_overlay').fadeOut();
    });

    function reload() {
        location.reload();
    }
</script>

<script type="text/javascript">

    function customAlert(formclass, type, link) {

        swal({
                title: "Are you sure ?",
                text: "Are you sure want to continue ?",
                type: type,
                showCancelButton: true,
                confirmButtonColor: 'green',
                confirmButtonText: 'Yes !',
                cancelButtonText: "No !",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function (isConfirm) {
                if (isConfirm) {
                    swal("Done!", "Congratulations !", "success");
                    if (formclass !== '') {
                        $(formclass).submit();
                    }
                    if (link !== '') {
                        window.location = link;
                    }
                } else {
                    swal("Cancelled", "Action was cancelled :)", "error");
                }
            });

        return false;
    }

</script>


<script type="text/javascript">
    $('.navbar-lower').affix({
        offset: {top: 50}
    });
</script>


</BODY>
</HTML>

