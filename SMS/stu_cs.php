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

$id = "";
if (isset($_GET['id']))
    $id = $_GET['id'];
else
    $id = "";

// echo "ID: " . $id;

$queryset = get_stu_details ($id, $mysqli);
$row = mysqli_fetch_array($queryset, MYSQLI_ASSOC);

// pre($row);

$queryset1 = get_cs_stu_details ($id, $mysqli);
while ($data = $queryset1->fetch_assoc())
{
    $rows[] = $data;
}

foreach ($rows as $key) {
    $row1[] = $key['cs_id'];
}

// pre($row1);

?>
<!-- Page Header -->
<div class="content bg-gray-lighter">
    <div class="row items-push">
        <div class="col-sm-7">
            <h1 class="page-heading">
                <?php echo $row['stu_name']; ?><small></small>
            </h1>
        </div>
        <div class="col-sm-5 text-right hidden-xs">
            <ol class="breadcrumb push-10-t">
                <li><a href="home.php">Dashboard</a></li>
                <li><a href="stu.php">Students</a></li>
                <li><a class="link-effect" href="">Student Classes</a></li>
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
                    <table class="table table-striped table-borderless table-header-bg">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 50px;">#</th>
                                <th>Classes</th>
                                <th>Attendance</th>
                                <th>Percentage</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $i = 1;
                                foreach ($row1 as $key) {
                                    $value = get_parent_sub_name($key, $id, $mysqli);
                                    // pre($value);
                            ?>
                            <tr>
                                <?php $present = ($value['total'] - $value['absent']); ?>
                                <?php $percent = ($value['total'] == 0 ? '100' : (($present / $value['total']) * 100)); ?>
                                <td class="text-center"><?php echo $i; ?></td>
                                <td><?php echo $value['name']; ?></td>
                                <td class="text-center"><?php echo ($present . " / " . $value['total']); ?></td>
                                <td class="text-center"><?php echo ($percent) . "%"; ?></td>  
                            </tr>
                            <?php $i++; } ?>
                        </tbody>
                    </table>
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