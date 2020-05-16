<?php
	require "user_repository.php";
	function try_login($keyword,$user_password,$remember)
	{
		devalidate_cookie();
		$_SESSION = array();
		$user_data = get_user($keyword,$user_password);
		$login_verfied = false;
		if(isset($user_data['id']))
		{
			$login_verfied = true;
			$_SESSION = array_merge($_SESSION, $user_data);
		}
		
		if($login_verfied)
		{
			$_POST = array();
			if($remember)
			{
				setcookie("username", $_SESSION['username'], time() + (86400 * 30), "/");				//30 days validity
				setcookie("user_password", $user_password, time() + (86400 * 30), "/");					//30 days validity
			}
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function validate_login_session()
	{
		if(isset($_SESSION['id']) && $_SESSION['id'] > 0) return true;
		session_unset();
		return false;
	}
	
	function devalidate_cookie()
	{
		setcookie("username", "null", time() - 3600, "/");
		setcookie("user_password", "null", time() - 3600, "/");
	}

	if(isset($_GET["req"]))
	{
		if($_GET["req"] == "logout")
		{
			devalidate_cookie();
			session_unset();
			header("Location: ../index.php");
		}
	}
?>