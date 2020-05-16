<?php
    require "../../header.php";
    require "../../repositories/login_manager.php";
    if(!validate_login_session())
    {
        header("Location: ../../index.php");
        return;
    }
    $member_uname_err = "";
    if(isset($_POST["consumer_uname"]))
    {
        if(strlen($_POST["consumer_uname"]) == 0) $member_uname_err = '<span style="color:red">Empty Consumer username!</span>';
        else
        {
            if(delete_consumer($_POST["consumer_uname"]))
            {
                echo '<script>alert("Hey! If Consumer '.$_POST['consumer_uname'].' exists, then he/she has been deleted.!");</script>';
            }
        }
    }
?>
<html>
    <head>
        <title>Delete a Consumer | Moderator | Dragenger</title>
        <link rel="stylesheet"type="text/css"href="..\..\styles\dstyle.css">
    </head>

    <body class="bodycss">
        <br><h3 class="headercss">Delete a Consumer</h3>
        <div>
            <img src="..\..\res\icon.png" class="logo-animator">
        </div>

        <form action="" method="post">
            <input type="text"name="consumer_uname"placeholder="Enter a consumer username" class="textfieldcss">
            <input type="submit"name="delete_consumer"value="Delete Consumer"class="buttoncss" class="buttoncss">
            <br>
            <?php echo $member_uname_err; ?>
            <br>
        </form>
        <?php include "footer.php"; ?>
    </body>
</html>