<html>
	<head>
		<script>
			function load_user_details($option)
			{
				var xhttp = new XMLHttpRequest();
				xhttp.onreadystatechange = function()
				{
					if(xhttp.readyState == 4 && xhttp.status == 200)
					{
						document.getElementById("user_panel_div").innerHTML = xhttp.responseText;
					}
				}
				xhttp.open("GET","../user_panel_generator.php?option="+$option, true);
				xhttp.send();
			}
			function change_profile_image($option)
			{
				if($option == true) 
				{
					document.getElementById("change_btn").innerHTML = "";
					document.getElementById("save_img_btns").innerHTML = 
					'<form id="img_select_form"action="../../repositories/file_manager.php"method="post"enctype="multipart/form-data"><input type="file"id="profile_image"name="profile_image"onchange="loadFile(event)"><input type="submit"name="save_profile_image"id="save_profile_image"class="button-success"value="Save Image"></form>';
				}
			}
			var profile_img_path = "";
			function save_changes()
			{
				var name = document.getElementById("name").value;
				var username = document.getElementById("username").value;
				var email = document.getElementById("email").value;
				var gender = document.getElementById("gender").value;
				var newPassword = document.getElementById("new_password").value;
				var conPassword = document.getElementById("con_password").value;
				var oldPassword = document.getElementById("old_password").value;
				var birthdate = document.getElementById("birthdate").value;
				var edit_verified = true;
				var post_update = "id_post="+<?php echo $_SESSION["id"]; ?>;
				var post_check = "id_post="+<?php echo $_SESSION["id"]; ?>;

				if(name.length <= 5)
				{
					document.getElementById("name_err").innerHTML = '<span style="color:red">Name is too small!</span>';
					edit_verified = false;
				}
				else
				{
					post_update += "&name_post="+name;
					document.getElementById("name_err").innerHTML = "";
				}
				if(username.length <= 5)
				{
					document.getElementById("username_err").innerHTML = '<span style="color:red">Username is too small!</span>';
					edit_verified = false;
				}
				else
				{
					if(username != <?php echo "'".$_SESSION["username"]."'";?>)
					{
						post_check += "&username_post="+username;
					}
					post_update += "&username_post="+username;
				}
				if(email.length <= 5)
				{
					document.getElementById("email_err").innerHTML = '<span style="color:red">Email is too small</span>';
					edit_verified = false;
				}
				else 
				{
					if(email != <?php echo "'".$_SESSION["email"]."'";?>)
					{
						post_check += "&email_post="+email;
					}
					post_update += "&email_post="+email;
				}
				if(birthdate.length <= 5) birthdate = <?php 
															if(isset($_SESSION["birthdate"])) echo "'".$_SESSION["birthdate"]."'"; 
															else echo "'NULL'";
														?>;
				post_update += "&birthdate_post="+birthdate;
				if(newPassword.length > 0)
				{
					if(newPassword.length <= 6)
					{
						document.getElementById("new_pass_err").innerHTML = '<span style="color:red">Password is too weak</span>';
						edit_verified = false;
					}
					else
					{
						post_update += "&new_pass_post="+newPassword;
					}
				}
				else document.getElementById("new_pass_err").innerHTML = "";
				if(newPassword != conPassword)
				{
					document.getElementById("con_pass_err").innerHTML = '<span style="color:red">Password mismatches</span>';
					edit_verified = false;
				}
				else document.getElementById("con_pass_err").innerHTML = "";
				if(oldPassword.length <= 5)
				{
					document.getElementById("old_pass_err").innerHTML = '<span style="color:red">Old Password is invalid</span>';
					edit_verified = false;
				}
				else
				{
					document.getElementById("old_pass_err").innerHTML = "";
					post_check += "&old_pass_post="+oldPassword;
					post_update += "&old_pass_post="+oldPassword;
				}
				post_update += "&gender_post="+gender;

				var xhttp = new XMLHttpRequest();
				xhttp.onreadystatechange = function()
				{
					if(xhttp.readyState == 4 && xhttp.status == 200)
					{
						var response = xhttp.responseText;
						if(response.indexOf("image") >= 0)
						{
							edit_verified = false;
							alert(response);
							if(response.indexOf("image_size_invalid") >= 0)
							{
								document.getElementById("profile_image_err").innerHTML = '<span style="color:red">Image size must be between 50KB to 1MB.</span>';
							}
							else if(response.indexOf("image_type_invalid") >= 0)
							{
								document.getElementById("profile_image_err").innerHTML = '<span style="color:red">Unsupported Image Type.<br>(Supported types: .JPG, .PNG, .GIF, .JPEG)</span>';
							}
						}
						else document.getElementById("profile_image_err").innerHTML = "";

						if(response.indexOf("email") >= 0)
						{
							document.getElementById("email_err").innerHTML = '<span style="color:red">Eamil already exists!</span>';
							edit_verified = false;
						}
						else document.getElementById("email_err").innerHTML = "";
						if(response.indexOf("username") >= 0)
						{
							document.getElementById("username_err").innerHTML = '<span style="color:red">Username already exists!</span>';
							edit_verified = false;
						}
						else document.getElementById("username_err").innerHTML = "";
						if(response.indexOf("old_password") >= 0)
						{
							document.getElementById("old_pass_err").innerHTML = '<span style="color:red">Password is incorrect!</span>';
							edit_verified = false;
						}
						else if(oldPassword.length != 0) document.getElementById("old_pass_err").innerHTML = "";
						post_check = "";
					}
				}
				xhttp.open("POST","../../repositories/user_repository.php", true);
				xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				xhttp.send(post_check+"&user_panel_purpose=check");

				if(edit_verified)
				{
					var xhttp = new XMLHttpRequest();
					xhttp.onreadystatechange = function()
					{
						if(xhttp.readyState == 4 && xhttp.status == 200)
						{
							document.getElementById("notification_message_div").innerHTML = xhttp.responseText;
							load_user_details("details_only");
							setTimeout(() => { document.getElementById("notification_message_div").innerHTML = ""; }, 3500);
						}
					}
					xhttp.open("POST","../../repositories/user_repository.php", true);
					xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					xhttp.send(post_update+"&user_panel_purpose=update");
				}
				else
				{
					document.getElementById("notification_message_div").innerHTML = '<span style="color:red">Saving changes unsuccessful!</span>';
					setTimeout(() => { document.getElementById("notification_message_div").innerHTML = ""; }, 3500);
				}
			}
			var loadFile = function(event) 
			{
				var file_property = document.getElementById("profile_image").files[0];
				profile_img_path = URL.createObjectURL(file_property);
				document.getElementById("preview_image").src = profile_img_path;
			};
		</script>
	</head>
</html>