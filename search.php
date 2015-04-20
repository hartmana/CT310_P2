<?php
$title = "Search Users";
$userName = isset($_GET['user']) ? $_GET['user'] : "";

include("inc/header.php");
include("lib/files.php");
?>
	<div class="leftContent">
		<h2>FriendSpace Users</h2>
		<hr/>

		<div id="search-list">
			<?php
			$dbh = Util::connectDB();
			$sql = "SELECT id FROM users";
			$query = $dbh->query($sql);
			$queryArray = $query->fetchAll(PDO::FETCH_COLUMN);

//			echo '<div class="user-list">';
			foreach ($queryArray as $id)
			{
				echo '<div class="userList">
									<a href="profile.php?user=' . $id . '">
										<img src="assets/img/profile' . $id . '.jpg" alt="profile"/>';

				$sql = "SELECT firstName FROM users WHERE id=$id";
				$query = $dbh->query($sql);
				$nameArray = $query->fetch(PDO::FETCH_ASSOC);

				echo '<br>' . $nameArray['firstName'] . '</a></div>';

				//if ($i == 3) break; // Just 2 profiles per page
			}

//			echo '</div>';

			?>
		</div>

		<!-- <div id="search-list">
			<div class="profile-thumb">
				<a href="user.php?user=leonardovolpatto">
					<img src="assets/img/profile5.jpg" alt="Profile 5's photo" />
					<span>Stephen Hizzle</span>
				</a>
			</div>

			<div class="profile-thumb">

				<a href="user.php?user=leonardovolpatto">
					<img src="assets/img/profile4.jpg" alt="Profile 4's photo" />
					<span>B. Gizzle</span>
				</a>
			</div>

			<div class="profile-thumb">
				<a href="user.php">
					<img src="assets/img/profile3.jpg" alt="Profile 3's photo" />
					<span>Chuck Nizzle</span>
				</a>
			</div>

			<div class="profile-thumb">
				<a href="user.php">
					<img src="assets/img/profile2.jpg" alt="Profile 2's photo" />
					<span>Stock Phizzle</span>
				</a>
			</div>

			<div class="profile-thumb">
				<a href="user.php">
					<img src="assets/img/profile1.jpg" alt="Profile 1's photo" />
					<span>Name</span>
				</a>
			</div>
		</div> -->

	</div>

	<!-- <div class="rightContent">

	</div> -->

<?php
include("inc/footer.php");
?>