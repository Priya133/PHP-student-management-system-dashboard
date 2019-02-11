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

<!-- Page Header -->
<div class="content bg-gray-lighter">
    <div class="row items-push">
        <div class="col-sm-7">
            <h1 class="page-heading">
                Add Student <small></small>
            </h1>
        </div>
        <div class="col-sm-5 text-right hidden-xs">
            <ol class="breadcrumb push-10-t">
                <li><a href="home.php">Dashboard</a></li>
                <li><a href="stu.php">Students</a></li>
                <li><a class="link-effect" href="">Add Student</a></li>
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
            <h2 class="content-heading">Student Details</h2>
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
                            // print_r($_POST); exit;
                            if ($_POST['stu_name'] != "" && $_POST['stu_mob']!= "" &&  $_POST['stu_parent_name']!= "" &&  $_POST['stu_parent_mob']!= ""){
                                if (check_mobile ($_POST['stu_mob'], $mysqli) == true){

                                    $stu_name = $_POST['stu_name'];
                                    $stu_mob = $_POST['stu_mob'];
                                    $stu_parent_name = $_POST['stu_parent_name'];
                                    $stu_parent_mob = $_POST['stu_parent_mob'];
                                    $stu_added_by = $_SESSION['user_id'];                      
                                    $stu_added_date = date('Y-m-d H:i:s');

                                    $courses = $_POST['courses'];

                                    // echo '<pre>'; print_r($courses); echo '</pre>'; exit;
                                    
                                    //echo $password;
                                    if (add_stu($stu_name, $stu_mob, $stu_parent_name, $stu_parent_mob, $stu_added_by, $stu_added_date, $mysqli) == true) {
                                        // Login success 
                                        $stu_id = $mysqli->insert_id;
                                        if (add_stu_cs ($courses, $stu_id, $stu_added_date, $mysqli) == true){
                                            echo "Student Added!";    
                                        }
                                        else {
                                            // Login failed 
                                            echo "Student could not be added. Please try again!";
                                        }
                                    }
                                         
                                    else {
                                            // Login failed 
                                        echo "Student could not be added. Please try again!";
                                    }
                                }
                                else{
                                    echo "Student with same mobile number already exists!";
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
                                    <input class="form-control" type="text" name="stu_name" id="stu_name" placeholder="Enter students name..">
                                    <label for="val-username2">Student's Name</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-9">
                                <div class="form-material">
                                    <input class="form-control" type="text" name="stu_mob" id="stu_mob" placeholder="Enter students mobile number..">
                                    <label for="val-email2">Student's Mobile Number</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-9">
                                <div class="form-material">
                                    <input class="form-control" type="text" name="stu_parent_name" id="stu_parent_name" placeholder="Enter students parent name..">
                                    <label for="val-username2">Student's Parent Name</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-9">
                                <div class="form-material">
                                    <input class="form-control" type="text" name="stu_parent_mob" id="stu_parent_mob" placeholder="Enter students parent mobile number..">
                                    <label for="val-email2">Student's Parent Mobile Number</label>
                                </div>
                            </div>
                        </div>
                        <?php
                         //   $queryset = get_parent_cs_id();
                            // $row = mysqli_fetch_array($queryset, MYSQLI_ASSOC); 
                         //    foreach ($queryset as $row)
                       //  {
                        ?>
                        <div class="form-group">
                            <!-- <label class="col-xs-12"><?php echo $row['cs_name']; ?></label> -->
                            <?php 
                            $queryset1 = get_parent_cs_id(73, $mysqli);
                            // while ($row1 = mysqli_fetch_array($queryset1, MYSQLI_ASSOC))
                            foreach ($queryset1 as $row1)
                            {
                            ?>
                            <div class="col-xs-12">
                                <div class="checkbox">
                                    <label for="example-checkbox1">
                                        <input type="checkbox" id="courses[]" name="courses[]" value="<?php echo $row1['cs_id']; ?>"> <?php echo $row1['cs_name']; ?>
                                    </label>
                                </div>
                            </div>
                            <?php
                                }
                            ?>
                        </div>
                        <?php
                          //  }
                        ?>
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