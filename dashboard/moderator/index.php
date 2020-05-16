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
        <title><?php echo "Moderative Dashboard"; ?></title>
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
								<a ><ul type="none"><li><input type="button" onclick='location.href="consumer_deletion.php"' class="button-error"style="margin-right:5%;"value = "Delete a Consumer"></li></ul></a>
							</td>
						</tr>
						<tr>
							<td>
								<a ><ul type="none"><li><input type="button" onclick='location.href="consumer_show_all.php"' class="button-success"style="margin-right:5%;"value = "Show all Consumers"></li></ul></a>
							</td>
						</tr>
					</table>
					<br><a ><ul type="none"><li><input type="button" onclick='location.href="../../repositories/login_manager.php?req=logout"' class="button-error"style="margin-right:5%;"value = "Log Out"></li></ul></a>
				</center>
			</fieldset>
		</form>
    </body>
</html>