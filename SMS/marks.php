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

<!-- Page JS Plugin CSS -->
<link rel="stylesheet" href="assets/js/plugins/select2/select2.min.css">
<link rel="stylesheet" href="assets/js/plugins/select2/select2-bootstrap.css">


<!-- Page Header -->
<div class="content bg-gray-lighter">
    <div class="row items-push">
        <div class="col-sm-7">
            <h1 class="page-heading">
                Send SMS <small></small>
            </h1>
        </div>
        <div class="col-sm-5 text-right hidden-xs">
            <ol class="breadcrumb push-10-t">
                <li><a href="home.php">Dashboard</a></li>
                <!-- <li><a href="stu.php">Students</a></li> -->
                <li><a class="link-effect" href="">Send SMS</a></li>
            </ol>
        </div>
    </div>
</div>
<!-- END Page Header -->

<!-- Page Content -->
<div class="content content-narrow">
    <!-- Forms Row -->
    <div class="row">
        <div class="col-lg-6">
            <!-- Material Forms Validation -->
            <h2 class="content-heading">SMS</h2>
            <div class="block">
                <!-- <div class="block-header">
                    <ul class="block-options">
                        <li>
                            <button type="button"><i class="si si-settings"></i></button>
                        </li>
                    </ul>
                    <h3 class="block-title">Validation</h3>
                </div> -->
                <div class="block-content block-content-narrow">
                    <!-- jQuery Validation (.js-validation-material class is initialized in js/pages/base_forms_validation.js) -->
                    <!-- For more examples you can check out https://github.com/jzaefferer/jquery-validation -->
                    <form class="js-validation-material form-horizontal push-10-t" action="send_sms.php" method="get">
                        <div class="form-group">
                            <div class="col-xs-12">    
                                <div class="form-material">
                                    <select class="js-select2 form-control" id="courses" name="courses" style="width: 100%;" data-placeholder="Choose one..">
                                        <option></option><!-- Required for data-placeholder attribute to work with Chosen plugin -->
                                        <?php
                            
                                            $queryset = get_parent_cs($mysqli);
                                            // $row = mysqli_fetch_array($queryset, MYSQLI_ASSOC); 
                                            while ($row = mysqli_fetch_array($queryset, MYSQLI_ASSOC))
                                            {

                                            $queryset1 = get_sub_cs($row['cs_id'], $mysqli);

                                            foreach ($queryset1 as $row1)
                                            {
                                            ?>
                                            <option value="<?php echo $row1['cs_id']; ?>"> <?php echo $row1['cs_parent_name'] . " - " . $row1['cs_name']; ?> </option>
                                            <?php
                                                }
                                            }
                                        ?>
                                    </select>
                                    <label for="example2-select2">Select Course</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">    
                            <div class="col-xs-12">
                                <div class="form-material">
                                    <select class="js-select2 form-control" id="sms" name="sms" style="width: 100%;" data-placeholder="Choose one..">
                                        <option></option><!-- Required for data-placeholder attribute to work with Chosen plugin -->
                                        <option value="1"> Student </option>
                                        <option value="2"> Parent </option>
                                    </select>
                                    <label for="example2-select2">Select whom to send SMS</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <button class="btn btn-sm btn-primary" type="submit">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- END Material Forms Validation -->
        </div>
    </div>
    <!-- END Forms Row -->
</div>
<!-- END Page Content -->

<?php require 'inc/views/base_footer.php'; ?>
<?php require 'inc/views/template_footer_start.php'; ?>

<!-- Page JS Plugins -->
<script src="<?php echo $one->assets_folder; ?>/js/plugins/jquery-validation/jquery.validate.min.js"></script>

<!-- Page JS Code -->
<script src="<?php echo $one->assets_folder; ?>/js/pages/base_forms_validation.js"></script>
<script src="assets/js/plugins/select2/select2.full.min.js"></script>
<script>
    $(function () {
        // Init page helpers (BS Datepicker + BS Colorpicker + Select2 + Masked Input + Tags Inputs plugins)
        App.initHelpers(['select2']);
    });
</script>


<?php require 'inc/views/template_footer_end.php'; ?>