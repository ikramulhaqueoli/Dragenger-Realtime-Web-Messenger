<?php
	require "repositories/login_manager.php";
	echo $_COOKIE["username"]." - ".$_COOKIE["user_password"];
	$notify = "";
	if(isset($_GET["notify"])) $notify = "?notify=".$_GET["notify"];
	if(validate_login_session() || (isset($_COOKIE["username"]) && isset($_COOKIE["user_password"]) && try_login($_COOKIE["username"], $_COOKIE["user_password"], true)))
	{
		header('Location: dashboard/'.$_SESSION["type"]."/index.php".$notify);
	}
	else
	{
		header("Location: login.php".$notify);
	}
?>