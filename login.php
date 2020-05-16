<?php
    require "header.php";
	require "repositories/login_manager.php";
	if(validate_login_session())
	{
		header("Location: index.php");
		return;
	}
    $keyword_err = "";
    $password_err = "";
    $login_err = "";
    $input_okay = true;
    $login_verfied = false;

    $keyword = "";

    if(isset($_POST["login"]))
    {
        if(empty($_POST["keyword"])) 
        {
            $keyword_err = '<span style="color:red">Empty username field!</span>';
            $input_okay = false;
        }
        else if(strlen($_POST["keyword"]) < 4) 
        {
            $keyword_err = '<span style="color:red">Username is invalid!</span>';
            $input_okay = false;
        }
        else 
        {
            $keyword = $_POST["keyword"];
        }
        if(strlen($_POST["password"]) == 0)
        {
            $password_err = '<span style="color:red">Empty password field!</span>';
            $input_okay = false;
        }
        else if(strlen($_POST["password"]) < 5) 
        {
            $password_err = '<span style="color:red">Password is invalid!</span>';
            $input_okay = false;
        }
		else
		{
			$user_password = $_POST["password"];
		}
        if($input_okay)
        {
			$remember = false;
			if(isset($_POST["remember"]) && $_POST["remember"]=="true") $remember = true;
			if(try_login($keyword, $user_password, $remember))
			{
				header('Location: dashboard/'.$_SESSION["type"]);
			}
			else
			{
				$login_err = '<span style="color:red">Incorrect username/email or password!</span>';
			}
        }
    }
?>
<html>
    <head>
        <title>Login | Dragenger</title>
        <link rel="stylesheet"type="text/css"href="styles/dstyle.css">
    </head>

    <body class="bodycss">
        <h3 class="headercss" style="padding-top:30px;font-size: 30px;">Login | Dragenger</h3>
        <img src="res/icon.png" class="logo-animator">
        <form action="" method="post">
            <input type="text"name="keyword"placeholder="Username or email"class="textfieldcss"value=<?php echo $keyword?>>
            <br>
            <?php echo $keyword_err; ?>
            <br>
            <input type="password"name="password"placeholder="Password"class="textfieldcss">
            <br>
            <?php echo $password_err; ?>
			<br>
            <input type="checkbox"name="remember"value="true"><span> Remember Login </span>
            <input type="submit"name="login"value="Log in"class="buttoncss">
            <br>
            <?php echo $login_err; ?>
            <br>
        </form>

        Or, <a href="signup.php"class="buttoncss"><b>Sign up now</b></a>
    </body>
</html>