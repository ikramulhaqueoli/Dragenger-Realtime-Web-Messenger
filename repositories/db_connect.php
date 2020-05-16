<?php
	$dbserverName="localhost";
	$dbusername="root";
	$dbpassword="";
	$db_name="dragenger_db";
	function execute($query)
	{
		global $dbserverName,$dbusername,$dbpassword,$db_name;
		$conn=mysqli_connect($dbserverName,$dbusername,$dbpassword,$db_name);
		mysqli_query($conn,$query);
		return true;
	}
	function get($query)
	{
		$data=array();
		global $dbserverName,$dbusername,$dbpassword,$db_name;
		$conn=mysqli_connect($dbserverName,$dbusername,$dbpassword,$db_name);
		$result=mysqli_query($conn,$query);
		if(mysqli_num_rows($result) > 0)
		{
			while($row=mysqli_fetch_assoc($result))
			{
				$entity=array();
				foreach($row as $k=>$v)
				{
					$entity[$k]=$row[$k];
				}
				$data[]=$entity;
			}
		}
		return $data;
	}
?>