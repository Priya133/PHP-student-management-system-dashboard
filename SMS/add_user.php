<?php 

include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
 
/*sec_session_start();
$redirect = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
if (login_check($mysqli) == false) header('Location: index.php?redirect='.$redirect.' ');*/

require 'inc/config.php'; ?>
<?php require 'inc/views/template_head_start.php'; ?>
<?php require 'inc/views/template_head_end.php'; ?>
<?php require 'inc/views/base_head.php'; ?>

<!-- Page Header -->
<div class="content bg-gray-lighter">
    <div class="row items-push">
        <div class="col-sm-7">
            <h1 class="page-heading">
                Add User <small></small>
            </h1>
        </div>
        <div class="col-sm-5 text-right hidden-xs">
            <ol class="breadcrumb push-10-t">
                <li><a href="home.php">Dashboard</a></li>
                <li><a href="users.php">Users</a></li>
                <li><a class="link-effect" href="">Add User</a></li>
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
                        
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            if ($_POST['user_password'] != "" && $_POST['user_password_conf']!= "" &&  $_POST['user_email']!= "" &&  $_POST['user_name']!= ""){
                                $pass = $_POST['user_password'];
                                $conf_pass = $_POST['user_password_conf'];
                                if ($pass != $conf_pass)
                                    echo "Passwords do no match";
                                else {
                                    if (check_email ($_POST['user_email'], $mysqli) == true){
                                        $user_email = $_POST['user_email'];
                                        $user_name = $_POST['user_name'];
                                        $user_password = $_POST['user_password'];
                                        $user_added_by = 40;
                                        $user_added_date = date('Y-m-d H:i:s');
                                        $user_type = 1;
                                        
                                        //echo $password;
                                        $test = add_user($user_name, $user_email, $user_password, $user_added_by, $user_added_date, $user_type, $mysqli);
                                        if ($test == true) {
                                            // Login success 
                                            echo "User Added!";
                                            } 
                                            else {
                                                // Login failed 
                                                echo "User could not be created. Please try again!";
                                            }
                                       // var_dump($test);
                                    }
                                    else{
                                        echo "User with same email address already exists!";
                                    }

                                }
                            }
                        else{
                            echo "Please enter all the details!";
                        }
                    }

                    ?>
                    <form class="js-validation-material form-horizontal push-10-t" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                        <div class="form-group">
                            <div class="col-sm-9">
                                <div class="form-material">
                                    <input class="form-control" type="text" name="user_name" id="user_name" placeholder="Choose a nice username..">
                                    <label for="val-username2">Username</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-9">
                                <div class="form-material">
                                    <input class="form-control" type="text" name="user_email" id="user_email" placeholder="Enter your valid email..">
                                    <label for="val-email2">Email</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-9">
                                <div class="form-material">
                                    <input class="form-control" type="password" id="user_password" name="user_password" placeholder="Choose a good one..">
                                    <label for="val-password2">Password</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-9">
                                <div class="form-material">
                                    <input class="form-control" type="password" id="user_password_conf" name="user_password_conf" placeholder="..and confirm it to be safe!">
                                    <label for="val-confirm-password2">Confirm Password</label>
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