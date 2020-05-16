<?php
    require "../../header.php";
    require "../../repositories/login_manager.php";
    if(isset($_GET["notify"]))
    {
        echo 
        '<script>
            document.getElementById("notify_div").innerHTML = "'.$_GET["notify"].'"
        </script>';
    }
    if(!validate_login_session())
    {
        header("Location: index.php");
        return;
    }
    $name_err = "";
    $username_err = "";
    $email_err = "";
    $gender_err = "";
    $password_err = "";
    $confirmpassword_err = "";
    $signup_err = "";
    $type_err = "";
    $success_message = "";
    $input_okay = true;

    $name = "";
    $username = "";
    $email = "";
    $gender = "";
    $type = "";

    if(isset($_POST["signup"]))
    {
        if(empty($_POST["name"]))
        {
            $name_err = '<span style="color:red">Empty name field!</span>';
            $input_okay = false;
        }
        else if(strlen($_POST["name"]) < 2)
        {
            $name_err = '<span style="color:red">Name is invalid!</span>';
            $input_okay = false;
        }
        if(empty($_POST["username"]))
        {
            $username_err = '<span style="color:red">Empty username field!</span>';
            $input_okay = false;
        }
        else if(strlen($_POST["username"]) < 5)
        {
            $username_err = '<span style="color:red">Username is invalid!</span>';
            $input_okay = false;
        }
        if(empty($_POST["email"]))
        {
            $email_err = '<span style="color:red">Empty username field!</span>';
            $input_okay = false;
        }
        else if(strlen($_POST["email"]) < 5)
        {
            $username_err = '<span style="color:red">Username is invalid!</span>';
            $input_okay = false;
        }
        if(!isset($_POST["gender"]) || empty($_POST["gender"]))
        {
            $gender_err = '<span style="color:red">You must select your gender!</span>';
            $input_okay = false;
        }
        if(!isset($_POST["type"]) || empty($_POST["type"]))
        {
            $type_err = '<span style="color:red">You must select user type!</span>';
            $input_okay = false;
        }
        if(strlen($_POST["password"]) < 5)
        {
            $password_err = '<span style="color:red">Empty password field!</span>';
            $input_okay = false;
        }
        else if(strlen($_POST["password"]) < 5)
        {
            $password_err = '<span style="color:red">Password is invalid!</span>';
            $input_okay = false;
        }
        else if($_POST["password"] != $_POST["confirmpassword"])
        {
            $confirmpassword_err = '<span style="color:red">Password doesn&#39t match!</span>';
            $input_okay = false;
        }

        if($input_okay)
        {
            if(username_exists($_POST["username"]))
            {
                $username_err = '<span style="color:red">Username is already being used!</span>';
                $input_okay = false;
            }
            if(email_exists($_POST["email"]))
            {
                $email_err = '<span style="color:red">Email is already being used!</span>';
                $input_okay = false;
            }
        }
        
        if($input_okay)
        {
            insert();
            $success_message = '<span style="color:green">Welcome <b>'.$_POST['name'].'</b>!<br>Signed up successfully. Go to <a href="login.php">Log In</a>.</span>';
            $_POST = array();
        }
        else
        {
            $name = $_POST["name"];
            $username = $_POST["username"];
            $email = $_POST["email"];
            $type = $_POST["type"];
            if(isset($_POST["gender"])) $gender = $_POST["gender"];
        }
    }
?>
<html>
    <head>
        <title>Member Sign up | Administrator | Dragenger</title>
        <link rel="stylesheet"type="text/css"href="../../styles/dstyle.css">
    </head>

    <body class="bodycss">
        <br><h3 class="headercss">Member Sign up | Admin | Dragenger</h3>
		<div>
			<img src="../../res/icon.png" class="logo-animator">
		</div>
        <form action="" method="post">
            <input type="text"name="name"placeholder="Name"class="textfieldcss"value=<?php echo $name ?>>
            <br>
            <?php echo $name_err; ?>
            <br>
            <input type="text"name="username"placeholder="Username"class="textfieldcss"value=<?php echo $username ?>>
            <br>
            <?php echo $username_err; ?>
            <br>
            <input type="email"name="email"placeholder="Email"class="textfieldcss"value=<?php echo $email ?>>
            <br>
            <?php echo $email_err; ?>
            <br>
            <select name="gender"class="textfieldcss">
                <option value="" disabled selected>Select Gender</option>
                <option <?php if($gender=="Male") echo "selected"?> >Male</option>
                <option <?php if($gender=="Female") echo "selected"?> >Female</option>
            </select>
            <br>
            <?php echo $gender_err; ?>
            <br>
            <select name="type"class="textfieldcss">
                <option value="" disabled selected>Select Admin Type</option>
                <option <?php if($type=="Administrator") echo "selected"?> value="administrator">Administrator</option>
                <option <?php if($type=="Moderator") echo "selected"?> value="moderator">Moderator</option>
            </select>
            <br>
            <?php echo $type_err; ?>
            <br>
            <input type="password"name="password"placeholder="Password"class="textfieldcss">
            <br>
            <?php echo $password_err; ?>
            <br>
            <input type="password"name="confirmpassword"placeholder="Confirm Password"class="textfieldcss">
            <br>
            <?php echo $confirmpassword_err; ?>
            <br>
            <input type="submit"name="signup"value="Sign up"class="buttoncss">
            <br>
            <?php echo $signup_err; ?>
            <br>
        </form>

        <?php include "footer.php"; ?>
    </body>
</html>