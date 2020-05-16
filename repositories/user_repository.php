<?php 
	require "db_connect.php";
	session_start();
	function insert() 
	{
		$type = 'consumer';
		if(isset($_POST["type"])) $type = strtolower($_POST["type"]);
		$query = "INSERT INTO users (Username,Name,Email,Password,Gender,Type) values ('".$_POST['username']."','".$_POST['name']."','".$_POST['email']."','".$_POST['password']."','".$_POST['gender']."','".$type."')";
		return execute($query);
	}
	
	function username_exists($username)
	{
		$query = "SELECT COUNT(Id) as count from Users WHERE Username = '".$username."'";
		$data = get($query);
		foreach($data as $row)
		{
			if($row["count"] > 0) return true;
		}
		return false;
	}
	
	function email_exists($email)
	{
		$query = "SELECT COUNT(Id) as count from Users WHERE Email = '".$email."'";
		$data = get($query);
		foreach($data as $row)
		{
			if($row["count"] > 0) return true;
		}
		return false;
	}

	function password_matches($user_password)
	{
		$query = "SELECT COUNT(Id) as count from Users WHERE Username = '".$_SESSION['username']."' and Password = '".$user_password."'";
		$data = get($query);
		foreach($data as $row)
		{
			if($row["count"] > 0) return true;
		}
		return false;
	}
	
	function get_user($keyword,$user_password)
	{
		$query = "SELECT * from Users WHERE (username = '".$keyword."' or email = '".$keyword."') and password = '".$user_password."'";
		$data = get($query);
		foreach($data as $row)
		{
			return $row;
		}
		return array();
	}

	function get_user_info($user_id)
	{
		$query = "SELECT id, name, username, birthdate, email, gender from Users WHERE id = " . $user_id;
		$data = get($query);
		foreach($data as $row)
		{
			return $row;
		}
		return array();
	}

	function update_user($user_data)
	{
		$birthdate = $user_data['birthdate'];
		if($birthdate != "NULL") $birthdate = "'" . $birthdate . "'";
		$query = "UPDATE users SET Username = '".$user_data['username']."',Name = '".$user_data['name']."',Email = '".$user_data['email']."',Password = '".$user_data['new_password']."',Gender = '".$user_data['gender']."', Birthdate = ".$birthdate." WHERE Id = ".$user_data['id']." and Password = '".$user_data['old_password']."';";
		return execute($query);
	}

	function delete_member($username)
	{
		$query = "DELETE FROM Users WHERE username = '".$username."' and type <> 'consumer'";
		return execute($query);
	}

	function delete_consumer($username)
	{
		$query = "SELECT id FROM Users WHERE username = '".$username."' and type = 'consumer'";
		$data = get($query);
		foreach ($data as $user) {
			$query = "DELETE FROM messages WHERE sender_id = ".$user["id"]." or receiver_id = ".$user["id"];
			execute($query);
			$query = "DELETE FROM friend_list WHERE user_id_1 = ".$user["id"]." or user_id_2 = ".$user["id"];
			execute($query);
			$query = "DELETE FROM friend_req_list WHERE sender_id = ".$user["id"]." or receiver_id = ".$user["id"];
			execute($query);
			$query = "DELETE FROM Users WHERE id = ".$user["id"]." and type = 'consumer'";
			return execute($query);
		}
	}

	function get_all_members()
	{
		$query = "SELECT * FROM users WHERE type <> 'consumer'";
		return get($query);
	}

	function get_all_consumers()
	{
		$query = "SELECT * FROM users WHERE type = 'consumer'";
		return get($query);
	}

	if(isset($_POST["user_panel_purpose"]))
	{
		$user_purpose = $_POST["user_panel_purpose"];
		if($user_purpose == "check")
		{
			if(isset($_POST["email_post"]))
			{
				if(email_exists($_POST["email_post"])) echo 'email;';
			}
			if(isset($_POST["username_post"]))
			{
				if(username_exists($_POST["username_post"])) echo 'username;';
			}
			if(isset($_POST["old_pass_post"]))
			{
				if(!password_matches($_POST["old_pass_post"])) echo 'old_password;';
			}
		}
		else if($user_purpose == "update")
		{
			if(!password_matches($_POST["old_pass_post"]))
			{
				echo '<span style="color:red">Old Password is invalid</span>';
				return;
			}
			$user_data = array();
			if(isset($_POST["id_post"])) $user_data["id"] = $_POST["id_post"];
			if(isset($_POST["name_post"])) $user_data["name"] = $_POST["name_post"];
			if(isset($_POST["email_post"])) $user_data["email"] = $_POST["email_post"];
			if(isset($_POST["username_post"])) $user_data["username"] = $_POST["username_post"];
			if(isset($_POST["gender_post"])) $user_data["gender"] = $_POST["gender_post"];
			if(isset($_POST["birthdate_post"])) $user_data["birthdate"] = $_POST["birthdate_post"];
			if(isset($_POST["new_pass_post"])) $user_data["new_password"] = $_POST["new_pass_post"];
			else $user_data["new_password"] = $_POST["old_pass_post"];
			if(isset($_POST["old_pass_post"])) $user_data["old_password"] = $_POST["old_pass_post"];
			if(update_user($user_data))
			{
				$_SESSION = get_user($user_data["email"],$user_data["new_password"]);
				echo '<span style="color:green">User informations<br>updated successfully!</span>';
			}
			else
			{
				echo '<span style="color:red">User informations<br>update failed!</span>';
			}
		}
	}
	
?>