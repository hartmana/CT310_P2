<?php
$title = "Edit Profile";

include_once("inc/header.php");
include_once("lib/files.php");
include_once("lib/userOperations.php");
$dbh = Util::connectDB();
$user = $_SESSION['user'];

if (isset($_POST['button']))
{
	$firstName = $_POST['firstname'];
	$lastName = $_POST['lastname'];
	$phone = $_POST['phone'];
	$email = $_POST['email'];
	$gender = $_POST['gender'];
	$description = $_POST['description'];
	$sql = "UPDATE users SET firstName ='$firstName', lastName='$lastName', phoneNumber='$phone',
 								email='$email', gender = '$gender', profileDescription='$description' WHERE id = $user->id";
	$query = $dbh->query($sql);

	$sql = "SELECT * FROM users WHERE id = $user->id";
	$query = $dbh->query($sql);
	$queryArray = $query->fetch(PDO::FETCH_ASSOC);

	$user = new user($queryArray['id'], $queryArray['username'], $queryArray['firstName'],
		$queryArray['lastName'], $queryArray['password'], $queryArray['gender'],
		$queryArray['email'], $queryArray['phoneNumber'], $queryArray['accessLevel'], $queryArray['profileDescription']);
	$_SESSION['user'] = $user;;

}

echo '<div class="leftContent">';
echo '<hr/>';

if (!isset($_POST['button']))
{


	echo '<h2>' . $user->firstName . ' ' . $user->lastName . '</h2>';
	echo '<img class="profile-pic" src="assets/img/profile' . $user->id . '.jpg" alt="' . $user->firstName . '\'s image profile">';

	echo '<div class="wrap-textarea">';
	echo '<form id="form1" name="form1" method="post" action="profileEdit.php?user=' . $user->id . '">';
	echo '<label for="firstname">First Name</label>';
	echo '<input type="text" id="firstname" name="firstname" rows="2" cols="20" value="' . $user->firstName . '"/>';

	echo '<label for="lastname">Last Name</label>';
	echo '<input type="text" id="lastname" name="lastname" cols="20" value="' . $user->lastName . '"/>';

	echo '<label for="email">Email Address</label>';
	echo '<input type="text" id="email" name="email" cols="20" value="' . $user->email . '"/>';

	echo '<label for="phoneNumber">Phone Number</label>';
	echo '<input type="text" id="phone" name="phone" cols="20" value="' . $user->phoneNumber . '"/>';

	echo '<label for="gender">Gender</label>';
	echo '<input type="text" id="gender" name="gender" cols="20" value="' . $user->gender . '"/>';

	echo '<label for="description">Description</label>';
	echo '<textarea name="description" id="description" rows="25" cols="50">';

	echo $user->profileDescription;

	echo '</textarea>';
	echo '<input type="submit" name="button" id="button" value="Save"/>';

	echo '</form></div>';

}
else
{
	echo '<div class="save-success"><h4>Successfully saved!</h4>
			<a href="profile.php?user=' . $user->id . '" >Go back</a>
			</div>';
}
?>
	<form action="upload.php" method="post" enctype="multipart/form-data">
		<input type="hidden" value = "<?php echo $profile->id; ?>" name = "id">
		Select image to upload:
		<input type="file" name="fileToUpload" id="fileToUpload">
		<input type="submit" value="Upload Image" name="submit">
	</form>


	<?php


if (isset($_SESSION["PicErrors"]))
{
	echo '<h3 style= color:red >' . $_SESSION["PicErrors"] . '</h3>';
	unset($_SESSION["PicErrors"]);

}
?>

	</div>


<?php
include_once("inc/rightContent.php")
?>


<?php
include_once("inc/footer.php")
?>