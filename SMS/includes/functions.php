<?php
include_once 'psl-config.php';
include_once 'password_compatibility_library.php';
require 'mail.php';
require 'login.php';
require 'registration.php';
include_once 'user_agent.php';
include_once 'db_connect.php';


date_default_timezone_set('Asia/Kolkata');

function pre($arr){
	echo "<pre>";
	print_r($arr);
	echo "</pre>";
}

//Session start 
function sec_session_start() {
    $session_name = 'sec_session_id';   // Set a custom session name
    $secure = SECURE;
    // This stops JavaScript being able to access the session id.
    $httponly = true;
    // Forces sessions to only use cookies.
    if (ini_set('session.use_only_cookies', 1) === FALSE) {
        header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
        exit();
    }   
    // Gets current cookies params.
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"],
        $cookieParams["path"], 
        $cookieParams["domain"], 
        $secure,
        $httponly);
    // Sets the session name to the one set above.
    session_name($session_name);
    session_start();            // Start the PHP session 
    session_regenerate_id();    // regenerated the session, delete the old one. 
}

function getTotalstudents($mysqli){
    $row = [];
    $sql = 'select count(*) as count from students;';
    $stmt = $mysqli->prepare($sql);
    $stmt->execute();
    $stmt->bind_result($count);
    while ($stmt->fetch()) {
        $row[] = array(
            'count'=> $count);
    }
    return ($row);
}

function getTotalcourses($mysqli){
    $row = [];
    $sql = 'select count(*) as count from courses where cs_parent_id=73;';
    $stmt = $mysqli->prepare($sql);
    $stmt->execute();
    $stmt->bind_result($count);
    while ($stmt->fetch()) {
        $row[] = array(
            'count'=> $count);
    }
    return ($row);
}

function getTotalusers($mysqli){
    $row = [];
    $sql = 'select count(*) as count from users;';
    $stmt = $mysqli->prepare($sql);
    $stmt->execute();
    $stmt->bind_result($count);
    while ($stmt->fetch()) {
        $row[] = array(
            'count'=> $count);
    }
    return ($row);
}

//Get All Users

function view_user() {

    global $mysqli;

    $stmt = $mysqli->prepare(
        "SELECT
            user_id,user_name,user_email FROM users"
    );
    $stmt->execute();
    $stmt->bind_result(
        $user_id,
        $user_name,
        $user_email
    );

    while ($stmt->fetch()) {
        $row[] = array(
            'user_id'            => $user_id,
            'user_name'          => $user_name,
            'user_email'         => $user_email
        );
    }
    $stmt->close();
    return ($row);
}


//Get Account Details

function get_acc_details($id)
{
    global $mysqli;
    $stmt = $mysqli->prepare(
        "SELECT
        user_id,user_name,user_email
        FROM users WHERE user_id = ? "
    );
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result(
        $user_id,
        $user_name,
        $user_email
    );
    while ($stmt->fetch()) {
        $row[] = array(
            'user_id'            => $user_id,
            'user_name'          => $user_name,
            'user_email'         => $user_email
        );
    }
    $stmt->close();
    if(@$row)
        return $row;
    else
        echo '<H2>NO USER WITH THIS ID EXIST<H2>';

}

//Update Account

function update_user($user_name, $user_email, $current_user_id)
{
    global $mysqli;
    $stmt = $mysqli->prepare(
        "UPDATE users
         set user_name = ? , user_email = ?  where user_id = ?"
    );
    $stmt->bind_param("ssi", $user_name,$user_email,$current_user_id);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
}


//Update Account

function update_account($email, $username, $id, $mysqli) {
	    if ($mysqli->query("UPDATE `users` SET `user_name`='$username',`user_email`='$email' WHERE `user_id`='$id' ") == true){
		$_SESSION['email'] = $email;
		$_SESSION['username'] = $username;
		return true;	
		}
		else 
		return false;															
}

//Change Password

function change_password($password, $new_pass, $id, $mysqli) {
    // Using prepared statements means that SQL injection is not possible. 
    if ($stmt = $mysqli->prepare("SELECT user_password FROM users WHERE user_id = ? LIMIT 1")) {
        $stmt->bind_param('s', $id);  // Bind "$email" to parameter.
        $stmt->execute();    // Execute the prepared query.
        $stmt->store_result();
 
        // get variables from result.
        $stmt->bind_result($db_password);
        $stmt->fetch();
		
                if (password_verify($password, $db_password)) { //$db_password == $password 
                    // Password is correct!
                    $hash_cost_factor = (defined('HASH_COST_FACTOR') ? HASH_COST_FACTOR : null);
                    $user_password_hash = password_hash($new_pass, PASSWORD_DEFAULT, array('cost' => $hash_cost_factor));
                    $mysqli->query("UPDATE `users` SET `user_password`='$user_password_hash' WHERE `user_id`='$id' ");
                    // Password change successful.
                    return true;
                } 
            
         else {
            // No user exists.
            return false;
        }
    }
}

//--------------x-------------------x------------------x---------------x--------------------x-------------------x----------
	

//Delete User

function del_user($user_id, $mysqli) {
	
		if ($mysqli->query('DELETE FROM `users` WHERE user_id = "'.$user_id.'" ') == true){
		return true;	
		}
		else 
		return false;															
}
	

//--------------x-------------------x------------------x---------------x--------------------x-------------------x----------

//Get All Students
	
function view_stu() {

    global $mysqli;

    $stmt = $mysqli->prepare(
        "SELECT
            stu_id,stu_name,stu_mob,stu_parent_name,stu_parent_mob    
            FROM students"
    );
    $stmt->execute();
    $stmt->bind_result(
        $stu_id,
        $stu_name,
        $stu_mob,
        $stu_parent_name,
        $stu_parent_mob
    );

    while ($stmt->fetch()) {
        $row[] = array(
            'stu_id'            => $stu_id,
            'stu_name'          => $stu_name,
            'stu_mob'           => $stu_mob,
            'stu_parent_name'   => $stu_parent_name,
            'stu_parent_mob'    => $stu_parent_mob
        );
    }
    $stmt->close();
    return ($row);

}


function add_stu($stu_name, $stu_mob, $stu_parent_name, $stu_parent_mob, $stu_added_by, $stu_added_date, $mysqli){	
	
	if ($mysqli->query("INSERT INTO `students`(`stu_id`, `stu_name`, `stu_mob`, `stu_parent_name`, `stu_parent_mob`, `stu_added_by`, `stu_added_date`) VALUES
	 (NULL,'$stu_name','$stu_mob', '$stu_parent_name','$stu_parent_mob', '$stu_added_by','$stu_added_date') ") == true){	
		return true;	
		}
		else 
		return false;
	
	}
	
//Get Account Details

function get_stu_details ($sel_user_id, $mysqli){
	
	return $mysqli->query('SELECT * FROM students WHERE stu_id="'.$sel_user_id.'"');
}

//Update Account

function update_stu($stu_name, $stu_mob, $stu_parent_name, $stu_parent_name, $stu_parent_mob, $stu_updated_by, $stu_updated_date, $current_user_id, $mysqli) {
	
		if ($mysqli->query("UPDATE `students` SET `stu_name`='$stu_name',`stu_mob`='$stu_mob',`stu_parent_name`='$stu_parent_name',`stu_parent_mob`='$stu_parent_mob',
			`stu_updated_by`='$stu_updated_by',`stu_updated_date`='$stu_updated_date' WHERE `stu_id`='$current_user_id' ") == true){
		return true;	
		}
		else 
		return false;															
}

//Delete User

function del_stu($user_id, $mysqli) {

	if ($mysqli->query('DELETE FROM `stu_cs` WHERE stu_id = "'.$user_id.'" ') == true){
		if ($mysqli->query('DELETE FROM `students` WHERE stu_id = "'.$user_id.'" ') == true){
			return true;	
		}
		else 
			return false;
	}
	else 
		return false;
}

//Check Mobile Number
function check_mobile ($user_mobile, $mysqli){
    // Using prepared statements means that SQL injection is not possible. 
    if ($stmt = $mysqli->prepare("SELECT stu_mob FROM students WHERE stu_mob = ? LIMIT 1")) {
        $stmt->bind_param('s', $user_mobile);  // Bind "$email" to parameter.
        $stmt->execute();    // Execute the prepared query.
        $stmt->store_result();
 
        // get variables from result.
        $stmt->bind_result($user_db_email);
        $stmt->fetch();
 
        if ($stmt->num_rows == 1) return false;
		else return true;
	}
}

// Get Parent Classes

function get_parent_cs()
{
    global $mysqli;
    $stmt = $mysqli->prepare(
        "SELECT
        cs_id,cs_name,cs_parent_id
        FROM courses where cs_parent_id = ?"
    );
    $t = "";
    $stmt->bind_param("s",$t);
    $stmt->execute();
    $stmt->bind_result(
        $csid,
        $cs_name,
        $cs_parent_id
    );
    while ($stmt->fetch()) {
        $row[] = array(
            'cs_id'            => $csid,
            'cs_name'         => $cs_name,
            'cs_parent_id'    => $cs_parent_id
        );
    }
    $stmt->close();
    if(@$row)
        return $row;
    else
        echo '<H2>NO COURSE WITH THIS ID EXIST<H2>';

}

function get_parent_cs_id()
{
    global $mysqli;
    $stmt = $mysqli->prepare(
        "SELECT
        cs_id,cs_name,cs_parent_id
        FROM courses where cs_parent_id = ?"
    );
    $t = "73";
    $stmt->bind_param("s",$t);
    $stmt->execute();
    $stmt->bind_result(
        $csid,
        $cs_name,
        $cs_parent_id
    );
    while ($stmt->fetch()) {
        $row[] = array(
            'cs_id'            => $csid,
            'cs_name'         => $cs_name,
            'cs_parent_id'    => $cs_parent_id
        );
    }
    $stmt->close();
    if(@$row)
        return $row;
    else
        echo '<H2>NO COURSE WITH THIS ID EXIST<H2>';

}

// Get Parent Classes

function get_sub_cs ($id, $mysqli){	
	// return ($mysqli->query('SELECT * FROM `courses` WHERE cs_parent_id = '.$id.'') );
	$names = [];
	$sql = 'SELECT `cs_id`, `cs_name`, (SELECT `cs_name` FROM `courses` WHERE `cs_id` = 
		'.$id.') AS `cs_parent_name` FROM `courses` 
	WHERE `cs_parent_id` = '.$id.'';
	// echo $sql;
	$name = $mysqli->query($sql);

	while($row = mysqli_fetch_array($name, MYSQLI_ASSOC)){
		$names[] = $row;
	}

	// pre($names);

	return $names;
}

function add_stu_cs($courses, $stu_id, $stu_added_date, $mysqli){
	foreach ($courses as $key) {
        global $mysqli;
        $stmt = $mysqli->prepare(
            "INSERT INTO stu_cs(stu_id, cs_id, date_added) VALUES
	 		(?,?,?) "
        );
        $stmt->bind_param("iis", $stu_id,$key,$stu_added_date);
        $result = $stmt->execute();
        $stmt->close();
        if($result)
        $flag = 1;
	}
	if ($flag == 1){
		return true;
	}
	else{
		return false;
	}

}

function get_cs_stu_details ($sel_user_id, $mysqli){
	return ($mysqli->query('SELECT cs_id FROM `stu_cs` WHERE stu_id = '.$sel_user_id.'') );
}

function update_stu_cs($courses, $stu_updated_date, $current_user_id, $mysqli){

	if ($mysqli->query('DELETE FROM `stu_cs` WHERE stu_id = "'.$current_user_id.'" ') == true){

		foreach ($courses as $key) {
			if ($mysqli->query("INSERT INTO `stu_cs`(`id`, `stu_id`, `cs_id`, `date_added`) VALUES
		 		(NULL,'$current_user_id','$key', '$stu_updated_date') ") == true){	
				$flag = 1;	
			}
		}

		if ($flag == 1){
			return true;
		}
		else{
			return false;
		}
	}
	else{
		return false;
	}
	
}

function get_parent_sub_name($cs_id, $id, $mysqli){
	$name = $mysqli->query('SELECT `cs_name`, (SELECT `cs_name` FROM `courses` WHERE `cs_id` = (SELECT `cs_parent_id` FROM `courses` WHERE `cs_id` = '.$cs_id.')) AS `cs_parent_name` FROM `courses` WHERE `cs_id` = '.$cs_id.'');

	$row = mysqli_fetch_array($name, MYSQLI_ASSOC);

	$full_name['name'] = $row['cs_parent_name'] . " - " . $row['cs_name'];

	$total = $mysqli->query('SELECT count(`cs_id`) AS `total_count` FROM `attendance` WHERE `cs_id` = '.$cs_id.'');

	$row = mysqli_fetch_array($total, MYSQLI_ASSOC);

	$full_name['total'] = $row['total_count'];

	$sql = 'SELECT COUNT(`cs_id`) AS  `absent` FROM `attendance` WHERE cs_id = '.$cs_id.' AND (`absentee` LIKE "'.$id.'" OR `absentee` LIKE "%@'.$id.'" OR `absentee` LIKE "'.$id.'@%" OR `absentee` LIKE "%@'.$id.'@%")';

	// echo $sql;
	$absent = $mysqli->query($sql);

	$row1 = mysqli_fetch_array($absent, MYSQLI_ASSOC);

	// pre($row1);

	$full_name['absent'] = $row1['absent'];

	// SELECT * FROM `attendance` WHERE cs_id = 11 AND (`absentee` LIKE '6' OR `absentee` LIKE '%@6' OR `absentee` LIKE '6@%' OR `absentee` LIKE '%@6@%') 

	// pre($full_name);

	return $full_name;
}

//--------------x-------------------x------------------x---------------x--------------------x-------------------x----------


//Get All Students
	
function view_cs($id, $mysqli){	
	if ($id == "")
		$sql = 'SELECT * FROM courses WHERE cs_parent_id IS NULL OR cs_parent_id = ""';
	else
		$sql = 'SELECT * FROM courses WHERE cs_parent_id = '.$id.' ';
	// echo $sql; exit;
	return ($mysqli->query($sql));
    }
    
    function view_all_cs( $mysqli){	
      
            $sql = 'SELECT * FROM courses WHERE cs_parent_id = 73';
        
        // echo $sql; exit;
        return ($mysqli->query($sql));
        }

function add_cs($id, $stu_id, $cs_id, $date_added)
{
    global $mysqli;
    $stmt = $mysqli->prepare(
        "INSERT INTO stu_cs(`id`, `stu_id`, `cs_id`, `date_added`) VALUES
	 		(?,?,?,?) "
    );
        //"INSERT INTO stu_cs(`id`, `stu_id`, `cs_id`, `date_added`) VALUES
        $stmt->bind_param('siis', $id, $stu_id, $cs_id,$date_added);
    $result = $stmt->execute();
    $stmt->close(); 
    if($result)
        return true;
    else
        return false;
}


function add_courses($cs_name, $parent_id, $cs_added_by, $cs_added_date)
{
    global $mysqli;
    $stmt = $mysqli->prepare(
        "INSERT INTO courses(`cs_name`, `cs_parent_id`, `cs_added_by`, `cs_added_date`) VALUES
	 		(?,?,?,?) "
    );
        //"INSERT INTO stu_cs(`id`, `stu_id`, `cs_id`, `date_added`) VALUES
        $stmt->bind_param('siis', $cs_name, $parent_id, $cs_added_by,$cs_added_date);
    $result = $stmt->execute();
    $stmt->close(); 
    if($result)
        return true;
    else
        return false;
}
//Get Account Details

function get_cs_details ($sel_user_id, $mysqli){
	
	return $mysqli->query('SELECT * FROM courses WHERE cs_id='.$sel_user_id);
}


function update_cs($cs_name, $stu_updated_by, $stu_updated_date, $current_user_id)
{
    global $mysqli;
    $stmt = $mysqli->prepare('UPDATE courses SET cs_name = ?,cs_updated_by = ?,cs_updated_date = ? where cs_id=?');
    $stmt->bind_param('sisi', $cs_name,$stu_updated_by,$stu_updated_date,$current_user_id);
    $result = $stmt->execute();
    $stmt->close();
    if($result)
        return true;
    else
        return false;
}

//Delete User

function del_cs($sel_user_id, $mysqli) {
	
		if ($mysqli->query('DELETE FROM courses WHERE cs_id = '.$sel_user_id) == true){
		return true;	
		}
		else 
		return false;															
}

function get_course_name($id)
{
    global $mysqli;
    $stmt = $mysqli->prepare(
        'SELECT
        cs_name
        FROM courses WHERE cs_id = ?'
    );
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->bind_result(
        $cs_name
    );
    while ($stmt->fetch()) {
        $row= array(
            'cs_name'            => $cs_name
        );
    }
    $stmt->close();
    if(@$row)
        return $row[cs_name];
    else
        return false;

}

// --------------x------------------x----------------------x----------------x------------------------x----------------

// LECTURE REPORTS

function get_all_students($id, $mysqli){
	$sql = 'SELECT stu_id, stu_name FROM students WHERE stu_id IN (
			SELECT stu_id FROM stu_cs WHERE cs_id = '.$id.' )';
	// echo $sql;
	return ($mysqli->query($sql));
}

function get_all_students2($id)
{
    global $mysqli;
    $stmt = $mysqli->prepare(
        'SELECT stu_id, stu_name FROM students WHERE stu_id IN (
			SELECT stu_id FROM stu_cs WHERE cs_id = ? )'
    );
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->bind_result(
        $stu_id , $stu_name
    );
    while ($stmt->fetch()) {
        $row[] = array(
            'stu_id'            => $stu_id,
            'stu_name'          => $stu_name
        );
    }
    $stmt->close();
    if(@$row)
        return $row;
    else
        return false;

}



// Get all lectures

function get_all_lectures($id, $mysqli){
	$sql = 'SELECT * FROM `attendance` WHERE cs_id= "'.$id.'" ORDER BY  `att_date` ASC ';
	// echo $sql;
	return ($mysqli->query($sql));
}

function get_stu_att_details($stu_id, $id, $date, $mysqli){

	$sql = 'SELECT COUNT(`cs_id`) AS  `absent` FROM `attendance` WHERE cs_id = '.$id.' AND (`absentee` LIKE "'.$stu_id.'" OR `absentee` LIKE "%@'.$stu_id.'" OR `absentee` LIKE "'.$stu_id.'@%" OR `absentee` LIKE "%@'.$stu_id.'@%") AND att_date = "'.$date.'" ';

	// echo $sql;
	$result = $mysqli->query($sql);

	$count = mysqli_fetch_array($result, MYSQLI_ASSOC);

	// pre($count);

	return $count['absent'];
}

// STUDENT REPORTS

function get_all_stu_classes($id, $mysqli){
	$sql = 'SELECT * FROM stu_cs WHERE stu_id = '.$id.'';
	// echo $sql;
	return ($mysqli->query($sql));
}

function get_stu_absent_record($cs_id, $stu_id, $mysqli){
	return ($mysqli->query('SELECT  `id`,`att_date` FROM  `attendance` WHERE (`absentee` LIKE  "'.$stu_id.'" OR  `absentee` LIKE  "%@'.$stu_id.'" OR  `absentee` LIKE  "'.$stu_id.'@%" OR  `absentee` LIKE  "%@'.$stu_id.'@%" ) AND cs_id = '.$cs_id.' '));
}

function get_full_sub_name($cs_id, $mysqli){
	$name = $mysqli->query('SELECT `cs_name`, (SELECT `cs_name` FROM `courses` WHERE `cs_id` = (SELECT `cs_parent_id` FROM `courses` WHERE `cs_id` = '.$cs_id.')) AS `cs_parent_name` FROM `courses` WHERE `cs_id` = '.$cs_id.'');

	$data = mysqli_fetch_array($name, MYSQLI_ASSOC);

	// pre($data);

	$full_name =  $data['cs_name'];

	return $full_name;
}

