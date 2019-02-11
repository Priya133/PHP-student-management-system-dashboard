<?php 

include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
 
sec_session_start();
$redirect = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
if (login_check($mysqli) == false) header('Location: index.php?redirect='.$redirect.' ');

require 'inc/config.php'; ?>
<?php require 'inc/views/template_head_start.php'; ?>
<?php require 'inc/views/template_head_end.php'; ?>
<?php require 'inc/views/base_head.php'; ?>
<?php

// pre($_POST);

$id = $_POST['students'];

// echo $id;

$stu = get_stu_details ($id, $mysqli);

$stu_details = mysqli_fetch_array($stu, MYSQLI_ASSOC);

$row = get_all_stu_classes($id, $mysqli);

// pre($row);

while($data = mysqli_fetch_array($row, MYSQLI_ASSOC))
{
    $classes[] = $data;
}

// pre($classes);

?>
<!-- Page Header -->
<div class="content bg-gray-lighter">
    <div class="row items-push">
        <div class="col-sm-7">
            <h1 class="page-heading">
                <?php echo $stu_details['stu_name']; ?><small></small>
            </h1>
        </div>
        <div class="col-sm-5 text-right hidden-xs">
            <ol class="breadcrumb push-10-t">
                <li><a href="home.php">Dashboard</a></li>
                <li><a href="report.php">Reports</a></li>
                <li><a class="link-effect" href="">Student Wise Report</a></li>
            </ol>
        </div>
    </div>
</div>
<!-- END Page Header -->

<!-- Page Content -->
<div class="content">
    <div class="row">
        <div class="col-lg-6">
            <!-- Header BG Table -->
            <div class="block">
                <div class="block-header">
                    <h3 class="block-title"></h3>
                </div>
                <div class="block-content">
                    <?php
                        // pre($lecs);
                        // $total = $lecs->num_rows;

                        // echo "Total: " . $total;
                        foreach ($classes as $key) {
                            $abs_dates = [];
                            $lecs = get_all_lectures($key['cs_id'], $mysqli);
                            $dates = get_stu_absent_record($key['cs_id'], $id, $mysqli);
                            $cs_det = get_full_sub_name($key['cs_id'], $mysqli);
                    ?>
                    <div class="block-header">
                        <h3 class="block-title text-center"><?php echo $cs_det;  ?></h3>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <!-- END Header BG Table -->
        </div>
    </div>
</div>
<!-- END Page Content -->

<?php require 'inc/views/base_footer.php'; ?>
<?php require 'inc/views/template_footer_start.php'; ?>
<?php require 'inc/views/template_footer_end.php'; ?>