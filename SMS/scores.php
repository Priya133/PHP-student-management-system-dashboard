<?php 

include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
 
sec_session_start();
$redirect = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
if (login_check($mysqli) == false) header('Location: index.php?redirect='.$redirect.' ');

require 'inc/config.php'; 

if (isset($_GET['id']))
    $id = $_GET['id'];
else
    $id = "";

// echo "ID: " . $id;

?>
<?php require 'inc/views/template_head_start.php'; ?>
<?php require 'inc/views/template_head_end.php'; ?>
<?php require 'inc/views/base_head.php'; ?>

<!-- Page Header -->
<div class="content bg-gray-lighter">
    <div class="row items-push">
        <div class="col-sm-7">
            <h1 class="page-heading">
                Add Course <small></small>
            </h1>
        </div>
        <div class="col-sm-5 text-right hidden-xs">
            <ol class="breadcrumb push-10-t">
                <li><a href="home.php">Dashboard</a></li>
                <li><a href="cs.php?id=<?php echo $id; ?>">Courses</a></li>
                <li><a class="link-effect" href="">Add Course</a></li>
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
            <h2 class="content-heading">Course Details</h2>
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
                    <?php  
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {

                            // echo $id;
                            if ($_POST['cs_name'] != ""){
                                $cs_name = $_POST['cs_name'];
                                $parent_id = $_POST['parent_id'];
                                $cs_added_by = $_SESSION['user_id'];                      
                                $cs_added_date = date('Y-m-d H:i:s');

                                if (add_cs($cs_name, $parent_id, $cs_added_by, $cs_added_date, $mysqli) == true) {
                                    // Login success 
                                    echo "Course Added!";
                                } 
                                else {
                                    // Login failed 
                                    echo "Course could not be added. Please try again!";
                                }
                            }
                            else{
                                echo "Please enter all the details!";
                            }
                        }
                    ?>
                    <form class="form-horizontal push-10-t push-10" action="base_forms_premade.html" method="post" onsubmit="return false;">
                        <div class="form-group">
                            <div class="col-xs-6">
                                <div class="form-material floating">
                                    <!-- <input class="form-control" type="text" id="contact3-firstname" name="contact3-firstname"> -->
                                    <label for="contact3-firstname">Firstname</label>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-material floating">
                                    <input class="form-control" type="text" id="scores[]" name="scores[]">
                                    <label for="contact3-lastname">Score</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <button class="btn btn-sm btn-info" type="submit"><i class="fa fa-send push-5-r"></i> Send Message</button>
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

<?php require 'inc/views/template_footer_end.php'; ?>