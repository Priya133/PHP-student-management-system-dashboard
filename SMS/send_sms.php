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

<?php

    if (isset($_GET['courses']) && isset($_GET['sms'])){
        $cs_id = $_GET['courses'];
        $whom = $_GET['sms'];

        $sql = 'SELECT `stu_name`, `stu_mob`, `stu_parent_mob` FROM  `students` WHERE stu_id IN ( SELECT stu_id FROM stu_cs WHERE cs_id = '.$cs_id.' )';

        $row = $mysqli->query($sql);

        while($data = $row->fetch_array()){
            $result[] = $data;
        }
    }

    // pre($result);
?>

<!-- Page Header -->
<div class="content bg-gray-lighter">
    <div class="row items-push">
        <div class="col-sm-7">
            <h1 class="page-heading">
                Send Marks SMS <small></small>
            </h1>
        </div>
        <div class="col-sm-5 text-right hidden-xs">
            <ol class="breadcrumb push-10-t">
                <li><a href="home.php">Dashboard</a></li>
                <!-- <li><a href="stu.php">Students</a></li> -->
                <li><a class="link-effect" href="">Send Marks SMS</a></li>
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
            <h2 class="content-heading">Marks SMS</h2>
            <div class="block">
                <?php
                    if(isset($_POST['outof'])){
                        // pre($_POST);

                        $outof = $_POST['outof'];
                        $topic = $_POST['topic'];

                        // echo "CS ID: " . $_GET['courses'];

                        for ($i=0; $i<=count($_POST['marks']); $i++){

                            $message = "";
                            $numbers = "";

                            if (!empty($_POST["marks"][$i])){
                                if ($whom == 2){
                                    $message = 'Your child ('.$result[$i]["stu_name"].') has secured '.$_POST["marks"][$i].' / '.$outof.' in '.get_full_sub_name($cs_id, $mysqli).' ('.$topic.'). Preeti Miss Group Tuitions.';
                                    // echo "<br />";
                                    $numbers = $result[$i]["stu_parent_mob"];
                                }
                                elseif ($whom == 1){
                                    $message = 'Your have secured '.$_POST["marks"][$i].' / '.$outof.' in '.get_full_sub_name($cs_id, $mysqli).'. Preeti Miss Group Tuitions.';
                                    // echo "<br />";
                                    $numbers = $result[$i]["stu_mob"];
                                }

                                // echo $message; exit;

                                $senderid = 'PMGTCH';

                                $apiURL = 'http://sms.jashparekh.com/submitsms.jsp?user=JPAREKH&key=a826124380XX&mobile='.urlencode($numbers).'&message='.urlencode($message).'&senderid='.urlencode($senderid).'&accusage=1';

                                // echo $apiURL; exit;

                                $output = file_get_contents($apiURL);
                            }
                            else{
                                if ($whom == 2){
                                    $message = 'Your child ('.$result[$i]["stu_name"].') has missed '.get_full_sub_name($cs_id, $mysqli).' ('.$topic.') test. Preeti Miss Group Tuitions.';
                                    // echo "<br />";
                                    $numbers = $result[$i]["stu_parent_mob"];
                                }
                                elseif ($whom == 1){
                                    $message = 'Your have missed '.get_full_sub_name($cs_id, $mysqli).' test. Preeti Miss Group Tuitions.';
                                    // echo "<br />";
                                    $numbers = $result[$i]["stu_mob"];
                                }

                                $senderid = 'PMGTCH';

                                $apiURL = 'http://sms.jashparekh.com/submitsms.jsp?user=JPAREKH&key=a826124380XX&mobile='.urlencode($numbers).'&message='.urlencode($message).'&senderid='.urlencode($senderid).'&accusage=1';

                                // echo $apiURL; exit;

                                // $output = file_get_contents($apiURL);
                            }
                        }

                        echo "Messages sent";
                    }
                ?>
                <div class="block-content block-content-narrow">
                    <!-- jQuery Validation (.js-validation-material class is initialized in js/pages/base_forms_validation.js) -->
                    <!-- For more examples you can check out https://github.com/jzaefferer/jquery-validation -->
                    <?php if (isset($result)){ ?>
                    <form class="js-validation-material form-horizontal push-10-t" action="" method="post">
                        <div class="form-group">
                            <div class="col-sm-9">
                                <div class="form-material">
                                    <input class="form-control" type="text" id="topic" name="topic" placeholder="Please enter topic name">
                                    <label for="material-text">Topic Name</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-9">
                                <div class="form-material">
                                    <input class="form-control" type="text" id="outof" name="outof" placeholder="Please enter out of marks">
                                    <label for="material-text">Out of Marks</label>
                                </div>
                            </div>
                        </div>
                        <?php
                            foreach($result as $key=>$value){
                        ?>

                        <div class="form-group">
                            <div class="col-sm-9">
                                <div class="form-material">
                                    <input class="form-control" type="text" id="marks[]" name="marks[]" placeholder="Please enter marks for <?php echo $value['stu_name']; ?>">
                                    <label for="material-text">Marks for <?php echo $value['stu_name']; ?></label>
                                </div>
                            </div>
                        </div>

                        <?php
                            }
                        ?> 
                        <div class="form-group">
                            <div class="col-xs-12">
                                <button class="btn btn-sm btn-primary" type="submit">Submit</button>
                            </div>
                        </div>
                    </form>
                    <?php } ?>
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