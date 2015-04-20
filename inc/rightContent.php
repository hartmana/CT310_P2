<div class="rightContent">
	<?php
	$dbh = Util::connectDB();

	$user;

	if (isset($_SESSION['user']))
		$user = $_SESSION['user'];
	else $user = false;

	$sql = "SELECT id FROM users";
	$query = $dbh->query($sql);
	$queryArray = $query->fetchAll(PDO::FETCH_COLUMN);

	echo '<div class="user-list">
			<h2>Users</h2>

			<p>Users registered</p>';


	foreach ($queryArray as $id)
	{
		echo '<div class="profile-thumb">
									<a href="profile.php?user=' . $id . '">
										<img src="assets/img/profile' . $id . '.jpg" alt="profile"/></a>';

		$sql = "SELECT firstName FROM users WHERE id=$id";
		$query = $dbh->query($sql);
		$nameArray = $query->fetch(PDO::FETCH_ASSOC);


		if ($user)
		{
			echo '<div class="friendMod">' . $nameArray['firstName'];

            if(!$util->isFriend($user->id, $id, $dbh))
            {
                echo '&nbsp;&nbsp;&nbsp;<a href="friendRequest.php?user=' . $user->id . '&friend=' . $id . '">Add</a>';
            }
		}

		echo '</div>';

	}

	echo '</div>';

	?>
</div>