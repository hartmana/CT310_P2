<?php
$title = "Request Friend";

include_once("inc/header.php");
include_once("lib/files.php");
include_once("lib/userOperations.php");

$dbh = Util::connectDB();
$user = $_SESSION['user'];
$_SESSION['added'] = false;

$util = new Util;

$rVal;

if (isset($_GET['user']) && isset($_GET['friend']))
{

	$rVal = $util->requestFriend($_GET['user'], $_GET['friend'], $dbh);

	if (!is_string($rVal))
	{
		$_SESSION['added'] = true;
	}

}

echo '<div class="leftContent">';
echo '<hr/>';

if (isset($_SESSION['added']) && $_SESSION['added'] == true)
{
	echo 'User friend request sent!';
}
else if (is_string($rVal))
{
	echo $rVal;
}
else
{
	echo 'Sorry, friend could not be added!';
}

echo '<a href="profile.php?user=' . $user->id . '" >Go back</a>
		</div>';


include_once("inc/rightFriendsContent.php")
?>


<?php
include_once("inc/footer.php")
?>