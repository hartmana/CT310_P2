<?php
$title = "Delete Friend";

include_once("inc/header.php");
include_once("lib/files.php");
include_once("lib/userOperations.php");
$dbh = Util::connectDB();
$user = $_SESSION['user'];

$util = new Util;

if (isset($_GET['user']) && isset($_GET['friend']))
{

	if ($util->deleteFriend($_GET['user'], $_GET['friend'], $dbh))
	{
		$_SESSION['deleted'] = true;
	}


}

echo '<div class="leftContent">';
echo '<hr/>';

if (isset($_SESSION['deleted']))
{
	echo 'Friend successfully deleted!';
}
else
{
	echo 'Sorry, friend could not be deleted!';
}

echo '<a href="profile.php?user=' . $user->id . '" >Go back</a>
		</div>';


include_once("inc/rightFriendsContent.php")
?>


<?php
include_once("inc/footer.php")
?>