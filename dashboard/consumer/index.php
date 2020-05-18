<?php
    require "../../header.php";
	require "../../repositories/login_manager.php";
	if(!validate_login_session())
	{
		header("Location: ../../index.php");
		return;
	}
	require "consumer_scripts.php";
?>
	<head>
        <link rel="stylesheet"type="text/css"href="../../styles/dstyle.css">
        <title><?php if(isset($_SESSION["name"])) echo $_SESSION["name"]; ?> | Dashboard </title>
    </head>
    <body class = "bodycss">
        <div class = "leftboxcss"style="height:auto;background-color:#000524;">
        	<br>
        	<input type="button" onclick="location.href='../../repositories/login_manager.php?req=logout'" class="button-error"style="margin-right:5%;"value = "Log out">
        	<br>
        	<div id="user_panel_div">
				<!-- here will be the azax html request hit -->
			</div>
            <div>
            	<center>
	                <div class="tab">
	                  <button class="tablinks" id="friend_list_btn" onclick="load_table_list(event,'show_friends')">Show Friends</button>
					  <button class="tablinks" id="friend_add_btn" onclick="load_table_list(event,'add_friend')">Add Friend</button>
					  <button class="tablinks" id="friend_req_btn" onclick="load_table_list(event,'friend_requests')">Friend Requests</button>
					</div>
	                <div id = "list_div"style="background-color:#5B5B5B;width:98%;margin-left:1%;margin-right:1%;border-radius:2%;height:350px;overflow-y: auto">
	                	<!-- here will be the list of add friend, friend requests and friend lists -->
	            	</div>
            	</center>
            </div>
        </div>
            
        <div class = "middleboxcss">
            <div id="user_heading_div" class="user_heading_div">
            	<!-- here will be users name and others -->
            </div>
            <div id="messages_div"class="messages_div">
            		<!-- here will be messages -->
            </div>
            <div id="message_sending_div">
            	<!-- here will be message sending options -->
            </div>
        </div>
		<?php require "../user_panel.php";?>
		<script>document.getElementById('friend_list_btn').click();</script>
		<div class = "rightboxcss">
			<div id="notification_message_div"class="headercss">
				<!-- here will be the azax html request hit -->
			</div>
			<div id="consumer_details_div">
				<!-- here will be the azax html request hit -->
			</div>
		</div>
		<audio id="notification_audio" src="../../res/done-for-you.ogg" preload="auto"></audio>
		<script>load_user_details("details_only");</script>
    </body> 
</html>