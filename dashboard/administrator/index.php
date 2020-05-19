<?php
    require "../../header.php";
	require "../../repositories/login_manager.php";
	if(!validate_login_session())
	{
		header("Location: ../../index.php");
		return;
	}
?>
<html>
    <head>
        <title><?php echo "Administrative Dashboard"; ?></title>
		<link rel="stylesheet"type="text/css"href="..\..\styles\dstyle.css">
    </head>
    <body class="bodycss">
		<form>
			<fieldset>
				<legend class="headercss">Admin</legend>
				<center>
					<table class="headercss">
						<tr>
							<td>
								<a ><ul type="none"><li><input type="button" onclick='location.href="member_signup.php"' class="button-success"style="margin-right:5%;"value = "New Member Registration"></li></ul></a>
							</td>
						</tr><br><br>
						<tr>    
							<td>
								<a ><ul type="none"><li><input type="button" onclick='location.href="member_deletion.php"' class="button-error"style="margin-right:5%;"value = "Delete a member"></li></ul></a>
							</td>
						</tr>
						<tr>
							<td>
								<a ><ul type="none"><li><input type="button" onclick='location.href="member_show_all.php"' class="button-warning"style="margin-right:5%;"value = "Show all members"></li></ul></a>
							</td>
						</tr>
						<tr>
							<td>
								<a ><ul type="none"><li><input type="button" onclick='location.href="user_show_all.php"' class="button-secondary"style="margin-right:5%;"value = "Show all users"></li></ul></a>
							</td>
						</tr>
						</tr>
					</table>
					<br><a ><ul type="none"><li><input type="button" onclick='location.href="../../repositories/login_manager.php?req=logout"' class="button-error"style="margin-right:5%;"value = "Log Out"></li></ul></a>
				</center>
			</fieldset>
		</form>
    </body>
</html>