<div class="rightContent">
	<?php
	$user = $_SESSION['user'];

	$dbh = Util::connectDB();

	$friends;
	$pendFriends;

	try
	{
		global $friends;

		// Get users friends
		$sql = "SELECT userFriendID,firstName FROM friends AS F JOIN users AS u WHERE f.userID=" . $user->id . " AND f.userFriendID=u.id";
		$query = $dbh->query($sql);
		$friends = $query->fetchAll(PDO::FETCH_ASSOC);
	}
	catch (PDOException $e)
	{
		echo '<pre class="bg-danger">';
		echo 'Request for friends failed! ' . $e->getMessage();
		echo '</pre>';
		die;
	}

	echo '<div class="user-list">';

	echo '<h2>Friends</h2>';

	if (count($friends) == 0)
	{
		echo "You have no friends!<br>How sad are you?";
	}
	else
	{
		// FOR each friend of the user, display picture and name
		foreach ($friends as $friend)
		{

			echo '<div class="profile-thumb">
									<a href="profile.php?user=' . $friend['userFriendID'] . '">
										<img src="assets/img/profile' . $friend['userFriendID'] . '.jpg" alt="profile"/>
									</a>
										<br>
										<div class="friendMod">' . $friend['firstName'] . ' &nbsp;&nbsp;&nbsp;<a href="deleteFriend.php?user=' . $user->id . '&friend=' . $friend['userFriendID'] . '">Remove</a></div>

							</div>';
		}
	}

	echo '</div>';
	echo '<div class="user-list">';

	echo '<h2>Friend Requests</h2>';

	// Get users pending friend requests
	$sql = "SELECT U.id,U.firstName FROM users U JOIN pendFriends P WHERE P.pendFriendID=" . $user->id . " AND U.id=P.userID";

	try
	{
		global $pendFriends;

		$query = $dbh->query($sql);
		$pendFriends = $query->fetchAll(PDO::FETCH_ASSOC);
	}
	catch (PDOException $e)
	{
		/* If you get here it is mostly a permissions issue
		* or that your path to the database is wrong
		*/
		echo '<pre class="bg-danger">';
		echo 'Request for pending friends failed! ' . $e->getMessage();
		echo '</pre>';
		die;
	}

	if (count($pendFriends) == 0)
	{
		echo "0 new friend requests.";
	}
	else
	{
		// FOR each pending friend request, display picture and name of the requesting user
		foreach ($pendFriends as $pFriend)
		{

			echo '<div class="profile-thumb">
									<a href="profile.php?user=' . $pFriend['id'] . '">
										<img src="assets/img/profile' . $pFriend['id'] . '.jpg" alt="profile"/>
									</a>
										<br>
										<div class="friendMod">' . $pFriend['firstName'] . ' &nbsp;&nbsp;&nbsp;<a href="addFriend.php?user=' . $user->id . '&friend=' . $pFriend['id'] . '">Accept</a></div>

							</div>';
		}
	}

	echo '</div>';
	?>

</div>