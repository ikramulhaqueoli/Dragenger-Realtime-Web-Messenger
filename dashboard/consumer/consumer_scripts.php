<head>
	<script>
		var current_consumer_id = -1;
		function assignListResultResponse(responseText)
		{
			if(responseText.length > 10)
			{
				document.getElementById("search_result").classList.add('user-tile');
				document.getElementById("search_result").innerHTML = responseText;
			}
			else
			{
				document.getElementById("search_result").classList.remove('user-tile');
				document.getElementById("search_result").innerHTML = '<span style="color:white;margin:10px"><i>No users found!</i></span>';
			}
		}
		function get_friends()
		{
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function()
			{
				if(xhttp.readyState == 4 && xhttp.status == 200)
				{
					assignListResultResponse(xhttp.responseText);
				}
			}
			xhttp.open("GET","../../repositories/consumer_repository.php?get_friends_list=true", true);
			xhttp.send();
		}
		function search_friends()
		{
			var keyword = document.getElementById("search_friends_box").value;
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function()
			{
				if(xhttp.readyState == 4 && xhttp.status == 200)
				{
					assignListResultResponse(xhttp.responseText);
				}
			}
			xhttp.open("GET","../../repositories/consumer_repository.php?search_friend_keyword="+keyword, true);
			xhttp.send();
		}
		function search_users()
		{
			var keyword = document.getElementById("search_users_box").value;
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function()
			{
				if(xhttp.readyState == 4 && xhttp.status == 200)
				{
					assignListResultResponse(xhttp.responseText);
				}
			}
			xhttp.open("GET","../../repositories/consumer_repository.php?search_consumer_keyword="+keyword, true);
			xhttp.send();
		}
		function get_friend_reqs()
		{
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function()
			{
				if(xhttp.readyState == 4 && xhttp.status == 200)
				{
					assignListResultResponse(xhttp.responseText);
				}
			}
			xhttp.open("GET","../../repositories/consumer_repository.php?get_friend_req_list=true", true);
			xhttp.send();
		}
		function search_friend_reqs()
		{
			var keyword = document.getElementById("search_reqs_box").value;
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function()
			{
				if(xhttp.readyState == 4 && xhttp.status == 200)
				{
					assignListResultResponse(xhttp.responseText);
				}
			}
			xhttp.open("GET","../../repositories/consumer_repository.php?search_friend_req_keyword="+keyword, true);
			xhttp.send();
		}
		function load_table_list(evt,option)
		{
			tablinks = document.getElementsByClassName("tablinks");
			for (i = 0; i < tablinks.length; i++) 
			{
				tablinks[i].className = tablinks[i].className.replace(" active", "");
			}
			if(option == "show_friends")
			{
				document.getElementById('friend_list_btn').style.display = "block";
					evt.currentTarget.className += " active";
					document.getElementById('list_div').innerHTML = '<h3 class="listheadercss">Friend List</h3><input type="text"id="search_friends_box"class="search_bar"placeholder="🔍 Search friends"value=""onkeyup="search_friends();"><div id="search_result"></div>';
					get_friends();
			}
			else if(option == "add_friend")
			{
				document.getElementById('friend_add_btn').style.display = "block";
					evt.currentTarget.className += " active";
					document.getElementById('list_div').innerHTML = '<h3 class = "listheadercss">Add Friend</h3><input type="text"id="search_users_box"class="search_bar"placeholder="🔍 Search users"value=""onkeyup="search_users();"><div id="search_result"></div>';
			}
			else if(option == "friend_requests")
			{
				document.getElementById('friend_req_btn').style.display = "block";
					evt.currentTarget.className += " active";
					document.getElementById('list_div').innerHTML = '<h3 class = "listheadercss">Friend Requests</h3><input type="text"id="search_reqs_box"class="search_bar"placeholder="🔍 Search friend requests"value=""onkeyup="search_friend_reqs();"><div id="search_result"></div>';
					get_friend_reqs();
			}
		}
		function add_friend(userId)
		{
			var data = "user_id=" + userId;
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function()
			{
				if(xhttp.readyState == 4 && xhttp.status == 200)
				{
					document.getElementById("user_btn_div_"+userId).innerHTML='<button class="button-error" onclick="remove_request('+userId+');">Remove Request</button>';
				}
			}
			xhttp.open("POST","../../repositories/consumer_repository.php", true);
			xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhttp.send(data+"&ajax_consumer_purpose=add_friend");
		}
		function remove_friend(userId)
		{
			var friend_name = document.getElementById("name_"+userId).innerHTML;
			if(!confirm("Remove Friend "+friend_name+"?")) return;
			var data = "user_id=" + userId;
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function()
			{
				if(xhttp.readyState == 4 && xhttp.status == 200)
				{
					document.getElementById("user_btn_div_"+userId).innerHTML='<button class="button-success" onclick="add_friend('+userId+');">Add Friend</button>';
				}
			}
			xhttp.open("POST","../../repositories/consumer_repository.php", true);
			xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhttp.send(data+"&ajax_consumer_purpose=remove_friend");
		}
		function remove_request(userId)
		{
			var friend_name = document.getElementById("name_"+userId).innerHTML;
			if(!confirm("Remove Friend Request with "+friend_name+"?")) return;
			var data = "user_id=" + userId;
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function()
			{
				if(xhttp.readyState == 4 && xhttp.status == 200)
				{
					document.getElementById("user_btn_div_"+userId).innerHTML='<button class="button-success" onclick="add_friend('+userId+');">Add Friend</button>';
				}
			}
			xhttp.open("POST","../../repositories/consumer_repository.php", true);
			xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhttp.send(data+"&ajax_consumer_purpose=remove_request");
		}
		function accept_request(userId)
		{
			var data = "user_id=" + userId;
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function()
			{
				if(xhttp.readyState == 4 && xhttp.status == 200)
				{
					document.getElementById("user_btn_div_"+userId).innerHTML='<button class="button-error" onclick="remove_friend('+userId+');">Unfriend</button>';;
				}
			}
			xhttp.open("POST","../../repositories/consumer_repository.php", true);
			xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhttp.send(data+"&ajax_consumer_purpose=accept_request");
		}
		function load_profile(userId,friend_state)
		{
			//friend_state 0 means, not_friend_and_no_firend_request
			//friend_state 1 means, logged_in_user_sent_friend_request
			//friend_state 2 means, other_side_user_sent_friend_request
			//friend_state 3 means, both_are_currently_friend

			var post_data = "user_id=" + userId;
			post_data += "&friend_state=" + friend_state;
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function()
			{
				if(xhttp.readyState == 4 && xhttp.status == 200)
				{
					document.getElementById("consumer_details_div").innerHTML = xhttp.responseText;
					if(friend_state == 3) load_conversation(userId);
				}
			}
			xhttp.open("POST","../../repositories/consumer_repository.php", true);
			xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhttp.send(post_data+"&ajax_consumer_purpose=load_profile");
			current_consumer_id = -1;
		}
		function load_conversation(userId)
		{

			var my_id = <?php echo $_SESSION["id"]; ?>;
			var my_name = <?php echo '"'.$_SESSION["name"].'"'; ?>;
			var my_username = <?php echo '"'.$_SESSION["username"].'"'; ?>;
			var my_img_src = document.getElementById("profileimg_"+my_id).src;

			var other_id = userId;
			var other_name = document.getElementById("name_"+userId).innerHTML;
			var other_username = document.getElementById("username_"+userId).innerHTML;
			var other_img_src = document.getElementById("profileimg_"+userId).src;

			var user_heading_div = '<table><tr><td><img style="margin-left:10px; "src="'+other_img_src+'"height="75px"width="75px"></td><td><table><tr><td><h2 style="margin:10px;">'+other_name+'</h2></td><td><span id="activity_show_span"style="margin-left:50px;"></span></td></tr>';
			user_heading_div += '<tr><td><h3 style="font-style:italic; margin-left:10px; margin-bottom:10px">'+other_username+'</h3></td></tr></table></td></tr></table>';
			document.getElementById("user_heading_div").innerHTML = user_heading_div;

			var message_sending_div = '<textarea id="message-text-box" class="message-text-box" rows="1" onkeydown="autosizeMessageBox();" style="" placeholder="Type a message" onkeypress="if(event.keyCode === 13) send_message_to('+userId+');"></textarea>';
			message_sending_div += '<button id="send_btn" class="button-success" style="width:10%;height:45px;font-style:bold;" onclick="send_message_to('+userId+');">Send</button>';
			document.getElementById("message_sending_div").innerHTML = message_sending_div;
			current_consumer_id = userId;
			refresh_message(current_consumer_id);
		}
		function send_message_to(userId)
		{
			var text = document.getElementById("message-text-box").value;
			var inputOk = false;
			for(var i = 0; i < text.length; i++)
			{
				if(text.charAt(i) != ' ' && text.charAt(i) != '\n')
				{
					inputOk = true;
					break;
				}
			}
			if(!inputOk)
			{
				document.getElementById("message-text-box").value = "";
				return;
			}

			var post_data = "user_id=" + userId;
			post_data += "&message_text=" + text;

			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function()
			{
				if(xhttp.readyState == 4 && xhttp.status == 200)
				{
					document.getElementById("message-text-box").value = "";
					autosizeMessageBox();
				}
			}
			xhttp.open("POST","../../repositories/consumer_repository.php", true);
			xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhttp.send(post_data+"&ajax_consumer_purpose=send_message");
		}
		function refresh_message()
		{
			var userId = current_consumer_id;
			if(userId == -1) return;
			var post_data = "user_id=" + userId;
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function()
			{
				if(xhttp.readyState == 4 && xhttp.status == 200)
				{
					if(xhttp.responseText.length <= 10) return;
					var new_message_row = document.createElement("tr");
					var new_message_col = document.createElement("td");
					new_message_col.innerHTML = xhttp.responseText;
					new_message_row.appendChild(new_message_col);
					var newMsgDiv = document.getElementById("messages_div");
					newMsgDiv.appendChild(new_message_row);
					newMsgDiv.scrollTop = newMsgDiv.scrollHeight;
				}
			}
			xhttp.open("POST","../../repositories/consumer_repository.php", true);
			xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhttp.send(post_data+"&ajax_consumer_purpose=refresh_messages");
		}
		function refresh_activity()
		{
			var userId = current_consumer_id;
			if(userId == -1) return;
			var post_data = "user_id=" + userId;
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function()
			{
				if(xhttp.readyState == 4 && xhttp.status == 200)
				{
					var last_active = xhttp.responseText;
					var activity_status = "";
					if(last_active == -1)
					{
						document.getElementById("activity_show_span").innerHTML = "";
					}
					else if(last_active > 60*60) 
					{
						activity_status = 'Active about ' + Math.round(last_active / 60 / 60) + ' hours ago';
						document.getElementById("activity_show_span").style.cssText = "color:rgb(150,150,150)";
					}
					else if(last_active > 60) 
					{
						activity_status = 'Active about ' + Math.round(last_active / 60) + ' minutes ago';
						document.getElementById("activity_show_span").style.cssText = "color:rgb(173, 173, 173)";
					}
					else if(last_active > 45) 
					{
						activity_status = 'Active about ' + last_active + ' seconds ago';
						document.getElementById("activity_show_span").style.cssText = "color:rgb(212, 212, 212)";
					}
					else 
					{
						activity_status = 'Active now';
						document.getElementById("activity_show_span").style.cssText = "color:rgb(0, 199, 43)";
					}
					document.getElementById("activity_show_span").innerHTML = activity_status;
				}
			}
			xhttp.open("POST","../../repositories/consumer_repository.php", true);
			xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhttp.send(post_data+"&ajax_consumer_purpose=refresh_activity");
		}
		
		//refresh_activity();
		//refresh_message();

		//refresh_continuously
		setInterval(refresh_message, 3000);
		setInterval(refresh_activity, 15000);

		//auto_resizable_text_area
		function autosizeMessageBox(){
		  var el = document.getElementById("message-text-box");
		  setTimeout(function(){
		    el.style.cssText = '-moz-box-sizing:content-box';
		    el.style.cssText = 'height:' + el.scrollHeight + 'px';
		  },0);
		}
	</script>
</head>