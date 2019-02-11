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

// echo "ID: " . $sel_user_id;

$row = [];

$queryset = get_stu_details ($sel_user_id, $mysqli);
$row = mysqli_fetch_array($queryset, MYSQLI_ASSOC);

// pre($row);

$queryset1 = get_cs_stu_details ($sel_user_id, $mysqli);

while ($data = $queryset1->fetch_assoc())
{
    $rows[] = $data;
}

foreach ($rows as $key) {
    $row1[] = $key['cs_id'];
}
// echo "<pre>"; print_r($row1); echo "</pre>";
?>

<!-- Page Header -->
<div class="content bg-gray-lighter">
    <div class="row items-push">
        <div class="col-sm-7">
            <h1 class="page-heading">
                Update Student <small></small>
            </h1>
        </div>
        <div class="col-sm-5 text-right hidden-xs">
            <ol class="breadcrumb push-10-t">
                <li><a href="home.php">Dashboard</a></li>
                <li><a href="stu.php">Students</a></li>
                <li><a class="link-effect" href="">Update Student</a></li>
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
                        if (isset($_POST['stu_parent_name'], $_POST['stu_name'], $_POST['stu_mob'], $_POST['stu_parent_mob'])) {

                            // echo "Row: " . $row['email'] . "<br /> POST: " . $_POST['user_email'];

                            if ($row['stu_mob'] == $_POST['stu_mob']){
                    
                                $stu_name = $_POST['stu_name'];
                                $stu_parent_name = $_POST['stu_parent_name'];
                                $stu_mob = $_POST['stu_mob'];
                                $stu_parent_mob = $_POST['stu_parent_mob'];
                                $current_user_id = $sel_user_id; //Current User Id.
                                $stu_updated_by = $_SESSION['user_id'];                      
                                $stu_updated_date = date('Y-m-d H:i:s');

                                $courses = $_POST['courses'];        
                                //echo $password;
                                if (update_stu($stu_name, $stu_mob, $stu_parent_name, $stu_parent_name, $stu_parent_mob, $stu_updated_by, $stu_updated_date, $current_user_id, $mysqli) == true) {
                                    // Login success
                                    if (update_stu_cs($courses, $stu_updated_date, $current_user_id, $mysqli)){
                                        $queryset = get_stu_details ($sel_user_id, $mysqli);
                                        $row = mysqli_fetch_array($queryset, MYSQLI_ASSOC);

                                        unset($row1);
                                        unset($data);
                                        unset($rows);

                                        $queryset1 = get_cs_stu_details ($sel_user_id, $mysqli);

                                        while ($data = $queryset1->fetch_assoc())
                                        {
                                            $rows[] = $data;
                                        }

                                        foreach (@$rows as $key) {
                                            @$row1[] = @$key[''];
                                        }

                                        // echo "ROW1: "; print_r($row1); exit;

                                        echo "Update Successful!";
                                    }
                                    else {
                                        // Login failed 
                                        echo "Update Unsuccessful. Please try again!";
                                    }
                                } 
                                else {
                                    // Login failed 
                                    echo "Update Unsuccessful. Please try again!";
                                }
                            }
                            else{
                                if (check_mobile ($_POST['stu_mob'], $mysqli) == false){
                                    echo "Student with same mobile number already exists!";
                                }
                                else {
                                    $stu_name = $_POST['stu_name'];
                                    $stu_parent_name = $_POST['stu_parent_name'];
                                    $stu_mob = $_POST['stu_mob'];
                                    $stu_parent_mob = $_POST['stu_parent_mob'];
                                    $current_user_id = $sel_user_id; //Current User Id.
                                    $stu_updated_by = $_SESSION['user_id'];                      
                                    $stu_updated_date = date('Y-m-d H:i:s'); 
                                    
                                    //echo $password;
                                    if (update_stu($stu_name, $stu_mob, $stu_parent_name, $stu_parent_name, $stu_parent_mob, $stu_updated_by, $stu_updated_date, $current_user_id, $mysqli) == true) {
                                        // Login success
                                        if (update_stu_cs($courses, $stu_updated_date, $current_user_id, $mysqli)){
                                            $queryset = get_stu_details ($sel_user_id, $mysqli);
                                            $row = mysqli_fetch_array($queryset, MYSQLI_ASSOC);

                                            $queryset1 = get_cs_stu_details ($sel_user_id, $mysqli);
                                            while ($data = $queryset1->fetch_assoc())
                                            {
                                                $rows[] = $data;
                                            }

                                            foreach ($rows as $key) {
                                                $row1[] = $key['cs_id'];
                                            }
                                            echo "Update Successful!";
                                        }
                                        else {
                                            // Login failed 
                                            echo "Update Unsuccessful. Please try again!";
                                        }
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
                                    <input class="form-control" type="text" name="stu_name" id="stu_name" value="<?php echo $row['stu_name']; ?>" placeholder="Enter students name..">
                                    <label for="val-username2">Student's Name</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-9">
                                <div class="form-material">
                                    <input class="form-control" type="text" name="stu_mob" id="stu_mob" value="<?php echo $row['stu_mob']; ?>" placeholder="Enter students mobile number..">
                                    <label for="val-email2">Student's Mobile Number</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-9">
                                <div class="form-material">
                                    <input class="form-control" type="text" name="stu_parent_name" id="stu_parent_name" value="<?php echo $row['stu_parent_name']; ?>" placeholder="Enter students parent name..">
                                    <label for="val-username2">Student's Parent Name</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-9">
                                <div class="form-material">
                                    <input class="form-control" type="text" name="stu_parent_mob" id="stu_parent_mob" value="<?php echo $row['stu_parent_mob']; ?>" placeholder="Enter students parent mobile number..">
                                    <label for="val-email2">Student's Parent Mobile Number</label>
                                </div>
                            </div>
                        </div>
                        <?php
                            
                        //    $queryset2 = get_parent_cs();
                            #$test = get_parent_cs2();
                        //    $i = 0;
                            // $row = mysqli_fetch_array($queryset, MYSQLI_ASSOC);
                         //   foreach ($queryset2 as $row2)
                         //   {
                        ?>
                        <div class="form-group">
                            <!-- <label class="col-xs-12"><?php echo $row2['cs_name']; ?></label> -->
                            <?php

                            $queryset3 = get_parent_cs_id(73, $mysqli);

                            // pre($queryset3);

                            // while ($row3 = mysqli_fetch_array($queryset3, MYSQLI_ASSOC))
                            foreach ($queryset3 as $row3)
                            {
                            ?>
                            <div class="col-xs-12">
                                <div class="checkbox">
                                    <label for="example-checkbox1">
                                        <input type="checkbox" id="courses[]" name="courses[]" value="<?php echo $row3['cs_id']; ?>" <?php if (in_array($row3['cs_id'], $row1)) echo "checked"; else echo "lol"; ?> > <?php echo $row3['cs_name']; ?>
                                    </label>
                                </div>
                            </div>
                            <?php
                                }
                            ?>
                        </div>
                        <?php
                           // $i++;}
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