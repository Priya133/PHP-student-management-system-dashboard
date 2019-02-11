<?php 

include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
 
sec_session_start();
$redirect = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
if (login_check($mysqli) == false) header('Location: index.php?redirect='.$redirect.' ');

require 'inc/config.php'; ?>
<?php require 'inc/views/template_head_start.php'; ?>
<?php require 'inc/views/template_head_end.php'; ?>
<?php require 'inc/views/base_head.php'; 

$sel_user_id= $_GET['id'];

$queryset = get_acc_details($sel_user_id);
$row = $queryset[0];
// print_r($row);
?>

<!-- Page Header -->
<div class="content bg-gray-lighter">
    <div class="row items-push">
        <div class="col-sm-7">
            <h1 class="page-heading">
                Update User <small></small>
            </h1>
        </div>
        <div class="col-sm-5 text-right hidden-xs">
            <ol class="breadcrumb push-10-t">
                <li><a href="home.php">Dashboard</a></li>
                <li><a href="users.php">Users</a></li>
                <li><a class="link-effect" href="">Update User</a></li>
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
            <h2 class="content-heading">User Details</h2>
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
                        if (isset($_POST['user_email'], $_POST['user_name'])) {

                            // echo "Row: " . $row['email'] . "<br /> POST: " . $_POST['user_email'];

                            if ($row['user_email'] == $_POST['user_email']){

                                $user_email = $_POST['user_email'];
                                $user_name = $_POST['user_name'];
                                $current_user_id = $sel_user_id; //Current User Id.
                                //echo $password;
                                if (update_user($user_name, $user_email, $current_user_id) == true) {
                                    // Login success
                                    $queryset = get_acc_details($sel_user_id);
                                    $row = $queryset[0];
                                    echo "Update Successful!";

                                    ?>
                    <?php
                                }
                                else {
                                    // Login failed
                                    echo "Update Unsuccessful. Please try again!";
                                }
                            }
                            else{
                                if (check_email ($_POST['user_email'], $mysqli) == false){
                                echo "User with same email address already exists!";}
                                else {
                                $user_email = $_POST['user_email'];
                                $user_name = $_POST['user_name'];
                                $current_user_id = $sel_user_id; //Current User Id.

                                //echo $password;
                                if (update_user($user_name, $user_email, $current_user_id) == true) {
                                    // Login success
                                    $queryset = get_acc_details($sel_user_id);
                                    $row = $queryset[0];
                                    echo "Update Successful!";
                                    }
                                    else {
                                        // Login failed
                                        echo "Update Unsuccessful. Please try again!";
                                    }
                                }
                            }

                        }
                    ?>
                    <form class="js-validation-material form-horizontal push-10-t" action="" method="post">
                        <div class="form-group">
                            <div class="col-sm-9">
                                <div class="form-material">
                                    <input class="form-control" type="text" name="user_name" id="user_name" value="<?php echo $row['user_name']; ?>" placeholder="Choose a nice username..">
                                    <label for="val-username2">Username</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-9">
                                <div class="form-material">
                                    <input class="form-control" type="text" name="user_email" id="user_email" value="<?php echo $row['user_email']; ?>" placeholder="Enter your valid email..">
                                    <label for="val-email2">Email</label>
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


<?php require 'inc/views/template_footer_end.php'; ?>