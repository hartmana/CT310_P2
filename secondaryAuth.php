<?php
$title = "SECURITY QUESTION";
include 'inc/header.php';

if ($_SESSION['login'] == false)
{
	header("Location: login.php");
}

$user = $_SESSION['user'];
$dbh = Util::connectDB();
?>
<form method="post" action="secondaryAuth.php">
	<table>
		<tr>
			<?php
			$sql = "SELECT * FROM questions WHERE questionID = $user->id";
			$query = $dbh->query($sql);
			$queryArray = $query->fetch(PDO::FETCH_ASSOC);
			$question = $queryArray['question'];
			$questionAnswer = $queryArray['questionAnswer'];
			?>

			<td><b><?php echo $question ?>: </b></td>
			<td><input type="text" name="answer"/></td>
		</tr>
		<tr>
			<td><input type="submit" value="Submit" name="submit"/></td>
			<td></td>
	</table>
</form>


<?php
$authenticate = false;
if (isset($_POST['submit']))
{
	// IF salted question and user entered response are valid
	if (Util::salt($question, $_POST['answer']) == $questionAnswer)
	{
		$_SESSION['secondaryAuth'] = true;
		$authenticate = true;

	}

	if ($authenticate)
	{
		$_SESSION['securityCheck'] = 1;

		if ($user->username == 'admin')
		{
			$_SESSION['admin'] = true;
		}
		header("Location: profile.php?user=" . $_SESSION['user']->id);

	}
	else
	{
		$_SESSION['error_question'] = true;
		$_SESSION['error_auth'] = NULL;

		header("Location: login.php");
	}
}

?>
<?php include 'inc/footer.php'; ?>
<div class="clear"></div>

