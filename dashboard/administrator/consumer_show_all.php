<?php
    session_start();
?>
<html>
    <head>
        <title>Consumers' list</title>
        <link rel="stylesheet"type="text/css"href="..\..\styles\dstyle.css">
    </head>

    <body class="bodycss">
        <div class="headercss">
			<fieldset style="height: 500px;">
			<legend class="headercss">Full Consumers' list</legend>	
            <?php 
                $dom = new DOMDocument('1.0','UTF-8');
                $dom->formatOutput = true;
                $dom->load('../../data/users_info.xml', LIBXML_NOBLANKS);
                
                $root = $dom->documentElement;
                $users = $root->getElementsByTagName('user');
                $max_user_uname = 0;
                $deleting_username = "";
                echo '<center><table style="width: 1200px; height: 150px;" class="centercss" border="1">';
                echo "<div>
                    <tr>
                    <td>ID</td>
                    <td>Type</td>
                    <td>First Name</td>
                    <td>Last Name</td>
                    <td>Username</td>
                    <td>Email</td>
                    <td>Gender</td>
                    </tr>
                </div>";
                foreach($users as $user)
                {
                    echo "<tr>";
                    if($user->getElementsByTagName('type')[0]->textContent == 'consumer')
                    {
                        echo "<tr>";
                        echo "<td>".$user->getAttribute('id')."</td>";
                        echo "<td>".$user->getElementsByTagName('type')[0]->textContent."</td>";
                        echo "<td>".$user->getElementsByTagName('fname')[0]->textContent."</td>";
                        echo "<td>".$user->getElementsByTagName('lname')[0]->textContent."</td>";
                        echo "<td>".$user->getElementsByTagName('uname')[0]->textContent."</td>";
                        echo "<td>".$user->getElementsByTagName('email')[0]->textContent."</td>";
                        echo "<td>".$user->getElementsByTagName('gender')[0]->textContent."</td>";
                        echo "</tr>";
                    }
                    echo "</tr>";
                }
                echo "</table></center>";
            ?>
			</fieldset>
        </div>
		Or, Go back to <a href="index.php">Administratie dashboard</a>
        <br><a href = "../../index.php">Log Out</a>
    </body>
</html>