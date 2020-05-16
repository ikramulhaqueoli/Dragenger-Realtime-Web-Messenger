<center><div id="notify_div"class="headercss"></div></center>
 <?php
 	if(isset($_GET["notify"]))
    {
        echo 
        '<script>
            document.getElementById("notify_div").innerHTML = "'.$_GET["notify"].'";
            setTimeout(function(){ document.getElementById("notify_div").innerHTML = "";}, 3500);
        </script>';
    }
 ?>