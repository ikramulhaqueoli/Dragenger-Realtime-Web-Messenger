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
        <title>Moderator's consumers' list | Moderator | Dragenger</title>
        <link rel="stylesheet"type="text/css"href="..\..\styles\dstyle.css">
    </head>

    <body class="bodycss">
        <div class="headercss">
            <fieldset style="height: 500px;">
            <legend class="headercss">Moderator's consumers' list</legend>
            <?php 
                $consumers_data = get_all_consumers();
                echo '<center><table style="width: 1200px; height: 150px;" class="centercss" border="1">';
                echo "<div>
                    <tr>
                    <td>ID</td>
                    <td>Type</td>
                    <td>Name</td>
                    <td>Username</td>
                    <td>Email</td>
                    <td>Gender</td>
                    <td>Birthdate</td>
                    </tr>
                </div>";
                foreach($consumers_data as $user)
                {
                    echo "<tr>";
                    
                        echo "<tr>";
                        echo "<td>".$user["id"]."</td>";
                        echo "<td>".$user["type"]."</td>";
                        echo "<td>".$user["name"]."</td>";
                        echo "<td>".$user["username"]."</td>";
                        echo "<td>".$user["email"]."</td>";
                        echo "<td>".$user["gender"]."</td>";
                        if(isset($user["birthdate"])) echo "<td>".$user["birthdate"]."</td>";
                        else echo "<td></td>";
                        echo "</tr>";
                    
                    echo "</tr>";
                }
                echo "</table></center>";
            ?>
                
            </fieldset>
        </div>
        <?php include "footer.php"; ?>
    </body>
</html>