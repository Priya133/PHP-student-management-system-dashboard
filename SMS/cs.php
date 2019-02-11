<?php require 'inc/config.php'; ?>
<?php require 'inc/views/template_head_start.php'; 

include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
 
sec_session_start();
$redirect = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
if (login_check($mysqli) == false) header('Location: index.php?redirect='.$redirect.' ');

if (isset($_GET['id']))
    $id = $_GET['id'];
else
    $id = "";
?>

<!-- Page JS Plugins CSS -->
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/datatables/jquery.dataTables.min.css">

<?php require 'inc/views/template_head_end.php'; ?>
<?php require 'inc/views/base_head.php'; ?>

<!-- Page Header -->
<div class="content bg-gray-lighter">
    <div class="row items-push">
        <div class="col-sm-7">
            <h1 class="page-heading">
                Courses <small></small>
            </h1>
        </div>
        <div class="col-sm-5 text-right hidden-xs">
            <ol class="breadcrumb push-10-t">
                <li>Dashboard</li>
                <li><a class="link-effect" href="">Courses</a></li>
            </ol>
        </div>
    </div>
</div>
<!-- END Page Header -->

<!-- Page Content -->
<div class="content">

    <!-- Dynamic Table Simple -->
    <div class="block">
        <div class="block-header">
            <div class="block-options">
                <a href="add_cs.php?id=<?php echo $id; ?>"><button class="btn btn-minw btn-rounded btn-default" type="button">Add Course</button></a>
            </div>
            <h3 class="block-title"><?php if ($id == "") { ?> Courses <?php } else { echo get_course_name($id); } ?><small></small></h3>
        </div>
        <div class="block-content">
            <!-- DataTables init on table by adding .js-dataTable-simple class, functionality initialized in js/pages/base_tables_datatables.js -->
            <table class="table table-bordered table-striped js-dataTable-full">
                <thead>
                    <tr>
                        <th style="width: 75%;">Name</th>
                        <th class="text-center" style="width: 25%;">Actions</th>
                        <th class="text-center" style="width: 0px; visibility: collapse; line-height: 0; display: none"></th>
                        <th class="hidden-xs" style="width: 0px; visibility: collapse; line-height: 0; display: none">Access</th>
                        <th class="text-center" style="width: 0px; visibility: collapse; line-height: 0; display: none"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $queryset = view_all_cs($mysqli);
                    $i = 1;
                    while ($row1 = mysqli_fetch_array($queryset, MYSQLI_ASSOC))
                        {
                    ?>
                    <tr>
                        <td class="font-w600"><?php echo $row1['cs_name']; ?></td>
                        <td class="text-center">
                            <div class="btn-group">
                                <!-- <a href="add_cs_stu.php?id=<?php echo $row1['cs_id']; ?>" class="btn btn-xs btn-default"><i class="si si-symbol-male"></i></a> -->
                                <?php if ($id == "") { ?>
                                <!--<a href="cs.php?id=<?php echo $row1['cs_id']; ?>" class="btn btn-xs btn-default"><i class="fa fa-university"></i></a>-->
                                <?php } else { ?>
                                <a href="edit_cs.php?id=<?php echo $row1['cs_id']; ?>" class="btn btn-xs btn-default"><i class="fa fa-file-text-o"></i></a>
                                <?php } ?>
                                <a href="edit_cs.php?id=<?php echo $row1['cs_id']; ?>" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
                                <a href="del_cs.php?id=<?php echo $row1['cs_id']; ?>" class="btn btn-xs btn-default"><i class="fa fa-times"></i></a>
                            </div>
                        </td>
                        <td style="width: 0px; line-height: 0; visibility: collapse; display: none" class="text-center"><?php echo $i; ?></td>
                        <td style="width: 0px; line-height: 0; visibility: collapse; display: none" class="text-center"><?php echo $i; ?></td>
                        <td style="width: 0px; line-height: 0; visibility: collapse; display: none" class="text-center"><?php echo $i; ?></td>
                    </tr>

                    <?php        
                            // $i++;
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- END Dynamic Table Simple -->
</div>
<!-- END Page Content -->

<?php require 'inc/views/base_footer.php'; ?>
<?php require 'inc/views/template_footer_start.php'; ?>

<!-- Page JS Plugins -->
<script src="<?php echo $one->assets_folder; ?>/js/plugins/datatables/jquery.dataTables.min.js"></script>

<!-- Page JS Code -->
<script src="<?php echo $one->assets_folder; ?>/js/pages/base_tables_datatables.js"></script>

<?php require 'inc/views/template_footer_end.php'; ?>