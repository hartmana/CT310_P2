<?php
session_start();
$target_dir = "assets/img/";
$target_file = $target_dir . basename("profile" . $_POST["id"] . ".jpg");
$uploadOk = 1;
$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

// Check if image file is a actual image or fake image
if (isset($_POST["submit"]))
{
	$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
	if ($check !== false)
	{
		$uploadOk = 1;
	}
	else
	{
		$_SESSION["PicErrors"] = "File is not an image.";
		$uploadOk = 0;
	}
}

// Check file size is less than a MB
if ($_FILES["fileToUpload"]["size"] > 1000000)
{
	$_SESSION["PicErrors"] = "Sorry, your image is too large.";
	$uploadOk = 0;
}
// Allow certain file formats
if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif"
)
{
	$_SESSION["PicErrors"] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
	$uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0)
{
	header('Location: profile.php?user=' . $_POST["id"]);
// if everything is ok, try to upload file
}
else
{

	if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file))
	{
		header('Location: profile.php?user=' . $_POST["id"]);
	}
	else
	{
		header('Location: profile.php?user=' . $_POST["id"]);
	}
}
?> 