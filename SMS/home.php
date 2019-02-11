<?php require 'inc/config.php'; ?>
<?php require 'inc/views/template_head_start.php'; 

include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
 
sec_session_start();
$redirect = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
if (login_check($mysqli) == false) header('Location: index.php?redirect='.$redirect.' ');

 print_r($_SESSION['user_id']);
?>

<!-- Page JS Plugins CSS -->
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/slick/slick.min.css">
<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/slick/slick-theme.min.css">

<?php require 'inc/views/template_head_end.php'; ?>
<?php require 'inc/views/base_head.php'; ?>

<!-- Page Header -->
<div class="content bg-image overflow-hidden" style="background-image: url('<?php echo $one->assets_folder; ?>/img/photos/photo3@2x.jpg');">
    <div class="push-50-t push-15">
        <h1 class="h2 text-white animated zoomIn">Dashboard</h1>
        <h2 class="h5 text-white-op animated zoomIn">Welcome <?php if (isset($_SESSION['username'])) echo $_SESSION['username']; else echo ""; ?></h2>
    </div>
</div>
<!-- END Page Header -->
<?php
$values = getTotalstudents($mysqli);

?>
<div class="row" style="padding-top:50px;">
<div class="md-lg-4">

    <?php foreach ($values as $value){ ?>

    <div class="col-md-4">
        <ul class="list-group">
            <li class="list-group-item">
                <b>Total Students</b>
            </li>
            <li class="list-group-item"><?php print $value['count'];?></li>
        </ul>
    </div>


<?php }?>

</div>
    
<?php
$values = getTotalcourses($mysqli);

?>
<div class="md-lg-4">

    <?php foreach ($values as $value){ ?>

    <div class="col-md-4">
        <ul class="list-group">
            <li class="list-group-item">
                <b>Total Courses</b>
            </li>
            <li class="list-group-item">
                <?php print $value['count'];?>
            </li>
        </ul>
    </div>


    <?php }?>

</div>

<?php
$values = getTotalusers($mysqli);

?>
<div class="md-lg-4">

    <?php foreach ($values as $value){ ?>

    <div class="col-md-4">
        <ul class="list-group">
            <li class="list-group-item">
                <b>Total Users</b>
            </li>
            <li class="list-group-item">
                <?php print $value['count'];?>
            </li>
        </ul>
    </div>


    <?php }?>

</div>

</div>
    <!--<div class="col-md-4">
        <ul class="list-group">
            <li class="list-group-item">
                <b>Computer Science</b>
            </li>
            <li class="list-group-item">Total Students enrolled</li>
            <li class="list-group-item">Third item</li>
        </ul>
    </div>
    <div class="col-md-4">
        <ul class="list-group">
            <li class="list-group-item">
                <b>Telecommunications</b>
            </li>
            <li class="list-group-item">Total Students enrolled</li>
            <li class="list-group-item">Third item</li>
        </ul>
    </div>
</div>-->



<?php require 'inc/views/base_footer.php'; ?>
<?php require 'inc/views/template_footer_start.php'; ?>

<!-- Page Plugins -->
<script src="<?php echo $one->assets_folder; ?>/js/plugins/slick/slick.min.js"></script>
<script src="<?php echo $one->assets_folder; ?>/js/plugins/chartjs/Chart.min.js"></script>

<!-- Page JS Code -->
<script src="<?php echo $one->assets_folder; ?>/js/pages/base_pages_dashboard.js"></script>
<script>
    $(function(){
        // Init page helpers (Slick Slider plugin)
        App.initHelpers('slick');
    });
</script>

<?php require 'inc/views/template_footer_end.php'; ?>