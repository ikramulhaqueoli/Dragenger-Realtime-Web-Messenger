<?php 
	require "user_repository.php";

	function get_consumer_list($query)
	{
		return get($query);
	}

	function user_profile_img_src($id)
	{
		$img_path = '../../res/default_profile';
   		$img_files = glob('../data/images/profile/'.$id.'_*');
		foreach ($img_files as $single_file)
		{
			return "../".$single_file;
		}
		return $img_path;
	}

	function generate_friendlist_response($data)
	{
		foreach ($data as $row)
		{
			echo '
					<table class="user-tile" onclick="javascript:load_profile('.$row["id"].',3)">
					<tr>
					<td style="width:20%;">
						<img src="'.user_profile_img_src($row["id"]).'"class="list-tile-image">
					</td>
					<td style="width:80%;">
						<table>
						<tr><td>
						<label class="list-name-label">'.$row["name"].'</label>
						</td></tr>
						<tr><td>
						<label class="list-username-label">@'.$row["username"].'</label>
						</td></tr>
						</table>
					</td>
					</tr>
					</table>
					';
		}
	}

	function generate_consumerlist_response($data)
	{
		foreach ($data as $row)
		{
			echo '
					<table class="user-tile" onclick="javascript:load_profile('.$row["id"].',0)">
					<tr>
					<td style="width:20%;">
						<img src="'.user_profile_img_src($row["id"]).'"class="list-tile-image">
					</td>
					<td style="width:80%;">
						<table>
						<tr><td>
						<label class="list-name-label">'.$row["name"].'</label>
						</td></tr>
						<tr><td>
						<label class="list-username-label">@'.$row["username"].'</label>
						</td></tr>
						</table>
					</td>
					</tr>
					</table>
					';
		}
	}

	function generate_friend_reqlist_response($data)
	{
		foreach ($data as $row)
		{
			$type_text = '<span style="color:rgb(0, 35, 87);font-style:italic;font-size:12px;text-align:right;white-space: nowrap;">Request received</span>';
			if($row["friend_state"] == 1) $type_text = '<span style="color:rgb(0, 92, 6);font-style:italic;font-size:12px;text-align:right;white-space: nowrap;">Request sent</span>';
			echo '
					<table class="user-tile" onclick="javascript:load_profile('.$row["id"].','.$row["friend_state"].')">
					<tr>
					<td style="width:20%;">
						<img src="'.user_profile_img_src($row["id"]).'"class="list-tile-image">
					</td>
					<td style="width:80%;">
						<table>
						<tr><td colspan="2">
						<label class="list-name-label">'.$row["name"].'</label>
						</td></tr>
						<tr><td>
						<label class="list-username-label">@'.$row["username"].'</label>
						</td><td style="text-align:right;padding:10px;">'.$type_text.'</td></tr>
						</table>
					</td>
					</tr>
					</table>
					';
		}
	}

	function generate_html_message_response($message_data)
	{
		if($message_data["sender_id"] != $_SESSION["id"])
		{
			echo '<div class="message-container"id="new_message_div"title="'.$message_data["id"].'">
  			<img src="'.user_profile_img_src($message_data["sender_id"]).'" alt="Avatar">
			  <span class="message-text"><p>'.$message_data["text"].'</p></span>
			  <span class="message-time-right">'.date("h:i A d M Y", strtotime($message_data["sent_time"])).'</span>
			</div>';
		}
		else
		{
			echo '<div class="message-container darker"id="new_message_div"title="'.$message_data["id"].'">
			  <img src="'.user_profile_img_src($message_data["sender_id"]).'" alt="Avatar" class="right">
			  <span class="message-text"><p>'.$message_data["text"].'</p></span>
			  <span class="message-time-left">'.date("h:i A d M Y", strtotime($message_data["sent_time"])).'</span>
			</div>';
		}
	}

	if(isset($_GET["search_friend_keyword"]))
	{
		$keyword = strtolower($_GET["search_friend_keyword"]);
		$query = "SELECT id, name, username, email, birthdate, gender FROM users WHERE id in (SELECT user_id_1 from friend_list where user_id_2 = ".$_SESSION["id"]."  union all SELECT user_id_2 from friend_list where user_id_1 = ".$_SESSION["id"].") and (LOWER(name) like '%".$keyword."%' or LOWER(username) like '%".$keyword."%' or LOWER(email) like '%".$keyword."%') and type = 'consumer' and id <> ".$_SESSION["id"].";";
		generate_friendlist_response(get_consumer_list($query));
	}
	
	else if(isset($_GET["get_friends_list"]))
	{
		$query = "SELECT id, name, username, email, birthdate, gender FROM users WHERE id in (SELECT user_id_1 from friend_list where user_id_2 = ".$_SESSION["id"]."  union all SELECT user_id_2 from friend_list where user_id_1 = ".$_SESSION["id"].") and type = 'consumer' and id <> ".$_SESSION["id"].";";
		generate_friendlist_response(get_consumer_list($query));
	}

	else if(isset($_GET["search_consumer_keyword"]))
	{
		$keyword = strtolower($_GET["search_consumer_keyword"]);
		if($keyword == '') return;
		$query = "SELECT id, name, username, email, birthdate, gender FROM users WHERE (LOWER(name) like '%".$keyword."%' or LOWER(username) like '%".$keyword."%' or LOWER(email) like '%".$keyword."%') and type = 'consumer' and id <> ".$_SESSION["id"]." and id not in (SELECT sender_id FROM friend_req_list WHERE receiver_id = ".$_SESSION["id"]." union all SELECT receiver_id FROM friend_req_list WHERE sender_id = ".$_SESSION["id"].") and id not in (SELECT user_id_1 from friend_list where user_id_2 = ".$_SESSION["id"]."  union all SELECT user_id_2 from friend_list where user_id_1 = ".$_SESSION["id"].");";
		generate_consumerlist_response(get_consumer_list($query));
	}

	else if(isset($_GET["get_friend_req_list"]))
	{
		$query = "(SELECT u.id, u.name, u.username, u.email, u.birthdate, u.gender, 1 as friend_state FROM users u WHERE id in (SELECT receiver_id from friend_req_list where sender_id = ".$_SESSION["id"].") and type = 'consumer') 
		union all 
		(SELECT u.id, u.name, u.username, u.email, u.birthdate, u.gender, 2 as friend_state FROM users u WHERE id in (SELECT sender_id from friend_req_list where receiver_id = ".$_SESSION["id"].") and type = 'consumer')";
		generate_friend_reqlist_response(get_consumer_list($query));
	}

	else if(isset($_GET["search_friend_req_keyword"]))
	{
		$keyword = strtolower($_GET["search_friend_req_keyword"]);
		$query = "SELECT u.id, u.name, u.username, u.email, u.birthdate, u.gender, fr.sender_id FROM users u, friend_req_list fr WHERE id in (SELECT sender_id from friend_req_list where receiver_id = ".$_SESSION["id"]." union all SELECT receiver_id from friend_req_list where sender_id = ".$_SESSION["id"].") and (LOWER(name) like '%".$keyword."%' or LOWER(username) like '%".$keyword."%' or LOWER(email) like '%".$keyword."%') and type = 'consumer' and id <> ".$_SESSION["id"].";";
		generate_friend_reqlist_response(get_consumer_list($query));
	}

	//ajax request methods
	if(isset($_POST["ajax_consumer_purpose"]))
	{
		if($_POST["ajax_consumer_purpose"]=="refresh_messages")
		{
			$user_id = $_POST["user_id"];
			$last_msg_id = 0;
			if(isset($_SESSION["user_last_msg_id_".$user_id])) $last_msg_id = $_SESSION["user_last_msg_id_".$user_id];
			$query = 'SELECT * FROM messages WHERE ((sender_id = '.$user_id.' and receiver_id = '.$_SESSION["id"].') or (receiver_id = '.$user_id.' and sender_id = '.$_SESSION["id"].')) and id > '.$last_msg_id.' order by id';
			$messages_data = get($query);
			foreach ($messages_data as $message_data)
			{
				generate_html_message_response($message_data);
				$last_msg_id = $message_data["id"];
			}
			$_SESSION["user_last_msg_id_".$user_id] = $last_msg_id;
		}
		if($_POST["ajax_consumer_purpose"]=="refresh_activity")
		{
			$query = 'UPDATE users SET last_active = sysdate() WHERE id = ' . $_SESSION["id"];
			execute($query);
			$query = 'SELECT TIME_TO_SEC(TIMEDIFF(sysdate(), last_active)) as timediff FROM users WHERE id = '.$_POST["user_id"].' and last_active IS NOT NULL';
			$data = get($query);
			foreach ($data as $activity_data)
			{
				echo $activity_data["timediff"];
				return;
			}
			echo -1;
		}
		else if($_POST["ajax_consumer_purpose"]=="add_friend")
		{
			$user_id = $_POST["user_id"];
			$my_id = $_SESSION["id"];
			$query = "INSERT INTO friend_req_list (sender_id,receiver_id) VALUES (".$my_id.",".$user_id.")";
			execute($query);
		}
		else if($_POST["ajax_consumer_purpose"]=="remove_friend")
		{
			$user_id = $_POST["user_id"];
			$my_id = $_SESSION["id"];
			$query = "DELETE FROM friend_list WHERE (user_id_1 = ".$user_id." and user_id_2 = ".$my_id.") or (user_id_2 = ".$user_id." and user_id_1 = ".$my_id.");";
			execute($query);
		}
		else if($_POST["ajax_consumer_purpose"]=="remove_request")
		{
			$user_id = $_POST["user_id"];
			$my_id = $_SESSION["id"];
			$query = "DELETE FROM friend_req_list WHERE (sender_id = ".$user_id." and receiver_id = ".$my_id.") or (sender_id = ".$my_id." and receiver_id = ".$user_id.");";
			execute($query);
		}
		else if($_POST["ajax_consumer_purpose"]=="accept_request")
		{
			$user_id = $_POST["user_id"];
			$my_id = $_SESSION["id"];
			$query = "DELETE FROM friend_req_list WHERE (sender_id = ".$user_id." and receiver_id = ".$my_id.") or (sender_id = ".$my_id." and receiver_id = ".$user_id.");";
			execute($query);
			$query = "INSERT INTO friend_list (user_id_1,user_id_2) VALUES (".$my_id.",".$user_id.")";
			execute($query);
		}
		else if($_POST["ajax_consumer_purpose"]=="load_profile")
		{
			$user_id = $_POST["user_id"];
			$data = get_user_info($user_id);
			$_SESSION["user_last_msg_id_".$user_id] = -1;
			echo '<center><div class="profile_imagecss">';
			echo '<img src="'.user_profile_img_src($user_id).'"alt="'.$data["name"].'"id="profileimg_'.$_POST["user_id"].'" style="margin-top:10%" height="130px"width="130px"id="preview_image">';
			echo '</div>';
			echo '<h2><span style="margin-top:3%;"id="name_'.$_POST["user_id"].'"name="'.$data["name"].'">'.$data["name"]."</span></h2>";
			echo '<h3><b><span style="font-style:italic;" id="username_'.$_POST["user_id"].'"name="'.$data["username"].'">@'.$data["username"].'</span></b></h3>';
			echo '<span style="font-size=12px; font-style:italic;">'.$data["email"].'</span><br><br>';
			echo '<span style="font-size=12px; font-style:italic;">'.$data["gender"].'</span><br><br>';
			if(isset($data["birthdate"])) echo '<span style="font-size=12px; font-style:italic;"> Birthdate: '.date_format(date_create($data["birthdate"]),"d M Y").'</span><br><br>';

			$friend_state = (int)$_POST["friend_state"];
			echo '<div id="user_btn_div_'.$user_id.'">';
			if($friend_state == 0)
			{
				echo '<button class="button-success" onclick="add_friend('.$user_id.');">Add Friend</button>';
			}
			else if($friend_state == 1)
			{
				echo '<button class="button-error" onclick="remove_request('.$user_id.');">Remove Request</button>';
			}
			else if($friend_state == 2)
			{
				echo '<button class="button-success" onclick="accept_request('.$user_id.');">Accept Request</button>';
				echo '<button class="button-error" onclick="remove_request('.$user_id.');">Remove Request</button>';
			}
			else if($friend_state == 3)
			{
				echo '<button class="button-error" onclick="remove_friend('.$user_id.');">Unfriend</button>';
			}
			echo '</div>';
		}
		else if($_POST["ajax_consumer_purpose"]=="send_message")
		{
			$user_id = $_POST["user_id"];
			$text = htmlspecialchars($_POST["message_text"]);
			$query = 'INSERT INTO messages (text,sender_id,receiver_id) values ("'.$text.'",'.$_SESSION["id"].','.$user_id.');';
			execute($query);
		}
	}

?>