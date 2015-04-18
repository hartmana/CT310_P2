<?php
$title = "Add Friend";

include_once("inc/header.php");
include_once("lib/files.php");
include_once("lib/userOperations.php");
$dbh = Util::connectDB();
$user = $_SESSION['user'];

$util = new Util;

if (isset($_GET['user']) && isset($_GET['friend']))
{

	if ($util->addFriend($_GET['user'], $_GET['friend'], $dbh))
	{
		$_SESSION['added'] = true;
	}


}

echo '<div class="leftContent">';
echo '<hr/>';

if (isset($_SESSION['added']))
{
	echo 'Friend successfully added!';
	$util->removeFriendRequest($_GET['user'], $_GET['friend'], $dbh);
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