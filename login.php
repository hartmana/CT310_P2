<?php
$title = "LOGIN PAGE";
include 'inc/header.php';
?>
<form method="post" action="login.php">

	<table>
		<tr>
			<td>
			</td>
			<td></td>
		</tr>
		<tr>
			<td><b>Username:</b></td>
			<td><input type="text" name="username"/></td>
		</tr>
		<tr>
			<td><b>Password:</b></td>
			<td><input type="password" name="password"/></td>
		</tr>

		<tr>
			<td><input type="submit" value="Login" name="submit"/></td>
			<td><input type="reset" value="Reset" name="reset"/></td>
	</table>
</form>

<?php

$authenticate = false;

$dbh = Util::connectDB();


if (isset($_POST['submit']))
{
	$enteredName = strip_tags($_POST['username']);
	$enteredPassword = strip_tags($_POST['password']);
	$sql = "SELECT * FROM users WHERE username='$enteredName'";

	$query = $dbh->query($sql);
	$queryArray = $query->fetch(PDO::FETCH_ASSOC);
	$sql_password = $queryArray['password'];


	if (Util::salt(Util::sanitizeData($enteredName), Util::sanitizeData($enteredPassword)) == $sql_password)
	{
		global $authenticate;
		$authenticate = true;

		$user = new user($queryArray['id'], $queryArray['username'], $queryArray['firstName'],
			$queryArray['lastName'], $queryArray['password'], $queryArray['gender'],
			$queryArray['email'], $queryArray['phoneNumber'], $queryArray['accessLevel'], $queryArray['profileDescription']);
		$_SESSION['user'] = $user;
		$_SESSION['login'] = true;

		header("Location: secondaryAuth.php");


	}

	if ($authenticate == false)
	{
		echo "Invalid username or password.";
	}
}
?>
<?php include 'inc/footer.php'; ?>

