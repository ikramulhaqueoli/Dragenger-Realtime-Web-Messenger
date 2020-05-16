<?php
    require "../../header.php";
    require "../../repositories/login_manager.php";
    if(!validate_login_session())
    {
        header("Location: ../../index.php");
        return;
    }
    $member_uname_err = "";
    if(isset($_POST["member_uname"]))
    {
        if(strlen($_POST["member_uname"]) == 0) $member_uname_err = '<span style="color:red">Empty member uname!</span>';
        else
        {
            if(delete_member($_POST["member_uname"]))
            {
                echo '<script>alert("Hey! If Member(Admin or Moderator) '.$_POST['member_uname'].' exists, then he/she has been deleted.!");</script>';
            }
        }
    }
?>
<html>
    <head>
        <title>Delete a member | Administrator | Dragenger</title>
        <link rel="stylesheet"type="text/css"href="..\..\styles\dstyle.css">
    </head>

    <body class="bodycss">
        <br><h3 class="headercss">Delete a member</h3>
		<div>
			<img src="..\..\res\icon.png" class="logo-animator">
		</div>

        <form action="" method="post">
            <input type="text"name="member_uname"placeholder="Enter a member username" class="textfieldcss">
            <input type="submit"name="delete_member"value="Delete Member"class="buttoncss" class="buttoncss">
            <br>
            <?php echo $member_uname_err; ?>
            <br>
        </form>
        <?php include "footer.php"; ?>
    </body>
</html>