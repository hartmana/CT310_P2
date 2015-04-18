<?php
$title = "Profile Page";

include("inc/header.php");
include("lib/files.php");
include("lib/userOperations.php");
$dbh = Util::connectDB();
$user = false;

$sql = "SELECT * FROM users WHERE id = \"$_GET[user]\"";
$query = $dbh->query($sql);
$queryArray = $query->fetch(PDO::FETCH_ASSOC);
$profile = new user($queryArray['id'], $queryArray['username'], $queryArray['firstName'],
	$queryArray['lastName'], $queryArray['password'], $queryArray['gender'],
	$queryArray['email'], $queryArray['phoneNumber'], $queryArray['accessLevel'], $queryArray['profileDescription']);


if (isset($_SESSION['user']))
{
	$user = $_SESSION['user'];
}
$util = new util();

?>

<div class="leftContent">
	<?php
	//print_r($userName);

	echo '<hr>
			<h2>' . $profile->firstName . ' ' . $profile->lastName . '</h2>';

	echo '<img class="profile-pic" src="assets/img/profile' . $profile->id . '.jpg" alt="' . $profile->firstName . '\'s image profile">';


	echo '<p>' . $profile->profileDescription . '</p>';





	?>

	<hr/>
	<?php
	if ($util->isIpValid() && $user && ($user->id == $profile->id))
	{
		echo '<p><a href="profileEdit.php?user=' . $profile->username . '">Edit Profile Information</a></p>';
	}
	if (isset($_SESSION['login']) && isset($_SESSION['securityCheck']))
	{
		echo '<div id="profileInfo">
					<h3>Contact Info</h3>
					<p>Email: ' . $profile->email . '</p>
					<p>Phone Number: ' . $profile->phoneNumber . '</p>
				</div>';
	}
	echo '</div>';

	if (isset($_SESSION['user']))
	{
		include_once("inc/rightFriendsContent.php");
	}
	else
	{

		include_once("inc/rightContent.php");
	}
	?>

	<?php
	include("inc/footer.php")
	?>
