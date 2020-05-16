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
        <title>Admin-panel members' list | Administrator | Dragenger</title>
        <link rel="stylesheet"type="text/css"href="..\..\styles\dstyle.css">
    </head>

    <body class="bodycss">
        <div class="headercss">
			<fieldset style="height: 500px;">
			<legend class="headercss">Admin-panel members' list</legend>
            <?php 
                $members_data = get_all_members();
                echo '<center><table style="width: 1200px; height: 150px;" class="centercss" border="1">';
                echo "<div>
                    <tr>
                    <td>ID</td>
                    <td>Type</td>
                    <td>Name</td>
                    <td>Username</td>
                    <td>Email</td>
                    <td>Gender</td>
                    </tr>
                </div>";
                foreach($members_data as $user)
                {
                    echo "<tr>";
                    
                        echo "<tr>";
                        echo "<td>".$user["id"]."</td>";
                        echo "<td>".$user["type"]."</td>";
                        echo "<td>".$user["name"]."</td>";
                        echo "<td>".$user["username"]."</td>";
                        echo "<td>".$user["email"]."</td>";
                        echo "<td>".$user["gender"]."</td>";
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