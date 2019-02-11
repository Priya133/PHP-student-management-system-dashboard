<?php

	function verify_user ($user_id, $activation_hash, $mysqli){

		if ($stmt = $mysqli->prepare("SELECT user_activation_hash FROM users WHERE user_id = ? LIMIT 1")) {
	        $stmt->bind_param('d', $user_id);  // Bind "$user_id" to parameter.
	        $stmt->execute();    // Execute the prepared query.
	        $stmt->store_result();
	 
	        // get variables from result.
	        $stmt->bind_result($user_activation_hash);
	        $stmt->fetch();

	        if ($user_activation_hash == $activation_hash){

	        	$act = 1;
	        	 
	        	$stmt = $mysqli->prepare("UPDATE `users` SET `user_active`=? WHERE `user_id`=? ");
				$stmt->bind_param('dd', $act, $user_id);
				return $stmt->execute();
			}

			else
				echo "Error";
			
		}
		
	}

	//Check if email exists
	function check_email ($user_email, $mysqli){
	    // Using prepared statements means that SQL injection is not possible. 
	    if ($stmt = $mysqli->prepare("SELECT user_email FROM users WHERE user_email = ? LIMIT 1")) {
	        $stmt->bind_param('s', $user_email);  // Bind "$email" to parameter.
	        $stmt->execute();    // Execute the prepared query.
	        $stmt->store_result();
	        // get variables from result.
	        $stmt->bind_result($user_db_email);
	        $stmt->fetch();
	 
	        if ($stmt->num_rows == 1) return false;
			else return true;
		}
	}

	//Add User
	function add_user($user_name, $user_email, $user_password, $user_added_by, $user_added_date, $user_type, $mysqli){

	    $hash_cost_factor = (defined('HASH_COST_FACTOR') ? HASH_COST_FACTOR : null);
	    $user_password_hash = password_hash($user_password, PASSWORD_DEFAULT, array('cost' => $hash_cost_factor));
	    $user_activation_hash = sha1(uniqid(mt_rand(), true));

	    $stmt = $mysqli->prepare("INSERT INTO `users`(`user_id`, `user_name`, `user_password`, `user_email`, `user_added_by`, `user_added_date`, `user_activation_hash`) 
	        VALUES (NULL,?,?,?,?,?,?)");
	    
	    if ($mysqli->query("INSERT INTO `users`(`user_id`, `user_name`, `user_password`, `user_email`, `user_added_by`, `user_added_date`, `user_activation_hash`) 
	        VALUES (NULL,'$user_name','$user_password_hash','$user_email', '$user_added_by', '$user_added_date', '$user_activation_hash') ") == true){

	        $postID = $mysqli->insert_id;
	        if ($mysqli->query("INSERT INTO `user_role`(`user_id`, `role_id`) VALUES ('$postID','$user_type') ") == true){
	        //if (email_registration ($postID, $user_email, $user_activation_hash) == true)
	            return true;
	        }      
	        
	    }
	    else 
	        return false;    
	}

?>