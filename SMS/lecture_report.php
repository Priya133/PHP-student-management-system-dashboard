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

$id = $_POST['courses'];

$class = get_full_sub_name($id, $mysqli); //get_cs_details ($id, $mysqli);

// $class = mysqli_fetch_array($queryset, MYSQLI_ASSOC);

$lecs = get_all_lectures($id, $mysqli);

$studs = get_all_students($id, $mysqli);
$test_stud = get_all_students2($id);
foreach($test_stud as $row1)
{
    $students1[] = $row1;
}


// pre($students);

?>
<!-- Page Header -->
<div class="content bg-gray-lighter">
    <div class="row items-push">
        <div class="col-sm-7">
            <h1 class="page-heading">
                <?php echo $class; ?><small></small>
            </h1>
        </div>
        <div class="col-sm-5 text-right hidden-xs">
            <ol class="breadcrumb push-10-t">
                <li><a href="home.php">Dashboard</a></li>
                <li><a href="report.php">Reports</a></li>
                <li><a class="link-effect" href="">Subject Wise Report</a></li>
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
                        $total = $lecs->num_rows;

                        // echo "Total: " . $total;

                            // $value = get_parent_sub_name($key, $id, $mysqli);
                            // pre($value);
                            // echo $key['att_date'];
                            // $date = strtotime($key['att_date']);
                            
                    ?>
                    <table class="table table-striped table-borderless table-header-bg">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 50px;">#</th>
                                <th>Student</th>
                                <!-- <th>Percentage</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $i =1;
                            foreach ($students1 as $row)
                                {

                                // echo $percent;
                            ?>
                            <tr>
                                <td class="text-center"><?php echo $i; ?></td>
                                <td><?php echo $row['stu_name']; ?></td>
                                <!-- <td class="text-center"></td>   -->
                            </tr>
                            <?php  $i++;} ?>
                        </tbody>
                    </table>
                    <?php  ?>
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