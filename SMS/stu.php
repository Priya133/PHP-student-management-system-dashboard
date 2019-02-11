<?php require 'inc/config.php'; ?>
<?php require 'inc/views/template_head_start.php'; 

include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
 
sec_session_start();
$redirect = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
if (login_check($mysqli) == false) header('Location: index.php?redirect='.$redirect.' ');

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
                Students <small></small>
            </h1>
        </div>
        <div class="col-sm-5 text-right hidden-xs">
            <ol class="breadcrumb push-10-t">
                <li>Dashboard</li>
                <li><a class="link-effect" href="">Students</a></li>
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
                <a href="add_stu.php"><button class="btn btn-minw btn-rounded btn-default" type="button">Add Student</button></a>
            </div>
            <h3 class="block-title">Students <small></small></h3>
        </div>
        <div class="block-content">
            <!-- DataTables init on table by adding .js-dataTable-simple class, functionality initialized in js/pages/base_tables_datatables.js -->
            <table class="table table-bordered table-striped js-dataTable-full">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th class="hidden-xs">Mobile</th>
                        <th class="hidden-xs">Parent Name</th>
                        <th class="text-center">Parent Mobile</th>
                        <th class="text-center" style="width: 10%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $queryset = view_stu();
                    $i =0;
                    foreach ($queryset as $row1)
                        {
                    ?>
                    <tr>
                        <td class="font-w600"><?php echo $row1['stu_name']; ?></td>
                        <td class="hidden-xs"><?php echo $row1['stu_mob']; ?></td>
                        <td class="font-w600"><?php echo $row1['stu_parent_name']; ?></td>
                        <td class="hidden-xs"><?php echo $row1['stu_parent_mob']; ?></td>
                        <td class="text-center">
                            <div class="btn-group">
                                <a href="edit_stu.php?id=<?php echo $row1['stu_id']; ?>" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
                                <a href="del_stu.php?id=<?php echo $row1['stu_id']; ?>" class="btn btn-xs btn-default"><i class="fa fa-times"></i></a>
                            </div>
                        </td>
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