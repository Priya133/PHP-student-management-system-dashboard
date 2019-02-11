<?php
include_once 'db_connect.php';
include_once 'functions.php';
 
sec_session_start(); // Our custom secure way of starting a PHP session.
 
if (isset($_POST['email'], $_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password']; // The hashed password.
	$url = (isset($_POST['url'])) ? $_POST['url'] : "";
 
    if (login($email, $password, $mysqli) == true) {
        // Login success
		
		$ip = $_SERVER['REMOTE_ADDR']?:($_SERVER['HTTP_X_FORWARDED_FOR']?:$_SERVER['HTTP_CLIENT_IP']);
		$now = date("Y-m-d H:i:s");
		$user_id = $_SESSION['user_id'];
		$ua_info = parse_user_agent();
		$user_agent =  "Platform: " . $ua_info['platform'] . " Browser: " . $ua_info['browser'] . " Browser Version: " . $ua_info['version'];
		//$user_agent = $_SERVER['HTTP_USER_AGENT'];	
		$mysqli->query(" INSERT INTO `user_session`(`user_id`, `login_date`, `ip`, `user_agent`) VALUES ('$user_id','$now','$ip', '$user_agent') "); 
		
		if ($url != "")
		header('Location: '.$url.' ');
		else		
        header('Location: ../home.php');
    } else {
        // Login failed 
        header('Location: ../index.php?error=1');
    }
} else {
    // The correct POST variables were not sent to this page. 
    echo 'Invalid Request';
}