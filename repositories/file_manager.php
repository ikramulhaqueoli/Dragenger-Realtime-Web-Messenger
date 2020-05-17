<?php
	require "user_repository.php";
	if(isset($_POST["save_profile_image"]))
	{
		$resultHtml = "";
		$target_dir = "../data/images/profile/";
		$target_file = $target_dir . $_SESSION["id"].'_'.date_timestamp_get(date_create());
		$imageFileType = strtolower(pathinfo($_FILES["profile_image"]["name"],PATHINFO_EXTENSION));
		if($_FILES["profile_image"]["name"] == '' || $_FILES["profile_image"]["size"] == 0)
		{
			$resultHtml = "<span style='color:red'>You must select a valid image file.</span>";
		}
		else if ($_FILES["profile_image"]["size"] > (1024*1024) || $_FILES["profile_image"]["size"] < (50*1024))
		{
			$resultHtml = "<span style='color:red'>Invalid Image Size! Must be between 50KB to 1MB.</span>";
		}
		else if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png" && $imageFileType != "gif")
		{
			$resultHtml = "<span style='color:red'>Invalid Image Type. Must JPG, PNG or GIF</span>";
		}
		else
		{
			$img_files = glob('../data/images/profile/'.$_SESSION["id"].'_*');
			foreach ($img_files as $single_file)
			{
				unlink($single_file);
			}
			if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file))
			{
				$resultHtml = "<span style='color:green'>Image updated successfully!</span>";
			}
			else $resultHtml = "<span style='color:red'>Sorry! Image upload failed!</span>";
		}
		header("Location: ../index.php?notify=".$resultHtml);
	}
?>
