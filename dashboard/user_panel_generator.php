<center>
	<table>
<?php
	session_start();
	$option = "";
	$button_name = "";
	$img_path = '../../res/default_profile';
	$img_files = glob('../data/images/profile/'.$_SESSION["id"].'_*');
	foreach ($img_files as $single_file)
	{
		$img_path = "../".$single_file;
		break;
	}

	if(isset($_GET["option"]))
	{
		if($_GET["option"] == "details_only")
		{
			$option = "edit_profile";
			$button_name = "Edit Profile";
			echo '<tr><td><center><div class="profile_imagecss">';
			echo '<img id="profileimg_'.$_SESSION["id"].'"src="'.$img_path.'"alt="'.$_SESSION["name"].'"height="130px"width="130px"id="preview_image">';
			echo '</div></center></td></tr>';
			echo '<tr><td><h2 style="margin-top:3%;">'.$_SESSION["name"]."</h2></td></tr>";
			echo '<tr><td><h3 style="text-align:center;margin-top:0%;"><i>'.$_SESSION["username"].'</i></h3></td></tr>';
		}
		else if($_GET["option"] == "edit_profile")
		{
			$option = "details_only";
			$button_name = "Back";
			echo '<tr><td colspan="2"><center><div class="profile_imagecss">';
			echo '<img id="preview_image"src="'.$img_path.'"alt="'.$_SESSION["name"].'"height="150px"width="150px">';
			echo '<div id="change_btn"><button class="dark_btncss"onclick="change_profile_image(true)">Change</button></div>';
			echo '</div></center></td></tr>';
			echo '<tr><td colspan="2"><div id="save_img_btns"></div></td></tr>';
			echo '<tr><td colspan="2"id="profile_image_err"></td></tr>';
			echo '<tr><td> Name </td><td><input type="text"id="name"placeholder="Name"value="'.$_SESSION["name"].'"></td></tr>';
			echo '<tr><td colspan="2"id="name_err"></td></tr>';
			echo '<tr><td> Username </td><td><input type="text"id="username"placeholder="Username"value="'.$_SESSION["username"].'"></td></tr>';
			echo '<tr><td colspan="2"id="username_err"></td></tr>';
			echo '<tr><td> Email </td><td><input type="text"id="email"placeholder="Email"value="'.$_SESSION["email"].'"></td></tr>';
			echo '<tr><td colspan="2"id="email_err"></td></tr>';
			echo '<tr><td> Gender </td><td><select id="gender">
			                <option ';if($_SESSION["gender"] == "Male") echo 'selected';echo'>Male</option>
			                <option ';if($_SESSION["gender"] == "Female") echo 'selected';echo'>Female</option>
            			</select></td></tr>';
            echo '<tr><td> Birth Date </td><td><input type="date" id="birthdate" name="birthdate" value="'.$_SESSION["birthdate"].'"></td></tr>';
			echo '<tr><td> New Password </td><td><input type="password"id="new_password"placeholder="🔑"></td></tr>';
			echo '<tr><td colspan="2"id="new_pass_err"></td></tr>';
			echo '<tr><td> Confirm Password </td><td><input type="password"id="con_password"placeholder="🔑"></td></tr>';
			echo '<tr><td colspan="2"id="con_pass_err"></td></tr>';
			echo '<tr><td> Old Password </td><td><input type="password"id="old_password"placeholder="🔑"></td></tr>';
			echo '<tr><td colspan="2"id="old_pass_err"></td></tr>';
			echo '<tr><td></td><td><input type="button"id="submit"class="button-success"value="Save Changes"onclick="save_changes()"></td></tr>';
		}
		else if($_GET["option"] == "change_profile_image")
		{
			$option = "details_only";
			$button_name = "Back";
			echo '<tr><td colspan="2"><center><div class="profile_imagecss">';
			echo '<img id="preview_image"src="'.$img_path.'"alt="'.$_SESSION["name"].'"height="150px"width="150px">';
			echo '<button class="dark_btncss"onclick="">Change</button>';
			echo '</div></center></td></tr>';
			echo '<tr><td colspan="2"id="profile_image_err"></td></tr>';
			echo '<tr><td> Name </td><td><input type="text"id="name"placeholder="Name"value="'.$_SESSION["name"].'"></td></tr>';
			echo '<tr><td colspan="2"id="name_err"></td></tr>';
			echo '<tr><td> Username </td><td><input type="text"id="username"placeholder="Username"value="'.$_SESSION["username"].'"></td></tr>';
			echo '<tr><td colspan="2"id="username_err"></td></tr>';
			echo '<tr><td> Email </td><td><input type="text"id="email"placeholder="Email"value="'.$_SESSION["email"].'"></td></tr>';
			echo '<tr><td colspan="2"id="email_err"></td></tr>';
			echo '<tr><td> Gender </td><td><select id="gender">
			                <option ';if($_SESSION["gender"] == "Male") echo 'selected';echo'>Male</option>
			                <option ';if($_SESSION["gender"] == "Female") echo 'selected';echo'>Female</option>
            			</select></td></tr>';
            echo '<tr><td> Birth Date </td><td><input type="date" id="birthdate" name="birthdate" value="'.$_SESSION["birthdate"].'"></td></tr>';
			echo '<tr><td> New Password </td><td><input type="password"id="new_password"placeholder="🔑"></td></tr>';
			echo '<tr><td colspan="2"id="new_pass_err"></td></tr>';
			echo '<tr><td> Confirm Password </td><td><input type="password"id="con_password"placeholder="🔑"></td></tr>';
			echo '<tr><td colspan="2"id="con_pass_err"></td></tr>';
			echo '<tr><td> Old Password </td><td><input type="password"id="old_password"placeholder="🔑"></td></tr>';
			echo '<tr><td colspan="2"id="old_pass_err"></td></tr>';
			echo '<tr><td></td><td><input type="button"id="submit"value="Save Changes"onclick="save_changes()"></td></tr>';
		}
	}
?>
	</table>
	<button class="button-secondary"style="margin-bottom:5%"onclick='load_user_details(<?php echo '"'.$option.'"'; ?>)'><?php echo $button_name;?></button>
</center>