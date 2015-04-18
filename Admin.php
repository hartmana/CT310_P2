<?php

$title = "Admin";


include("inc/header.php");
include("lib/files.php");

if (!isset($_SESSION['admin']))
{
	header("Location: index.php");
}

// utility object
$util = new util();

// array for error messages
$errors = array();

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	if (empty($_POST["Firstname"]) || empty($_POST["Lastname"]))
	{
		$errors[] = "Full name is required";
	}
	if (empty($_POST["username"]))
	{
		$errors[] = "Name is required";
	}
	if (empty($_POST["secret_question"]))
	{
		$errors[] = "Secret question is required.";
	}
	if (empty($_POST["question_answer"]))
	{
		$errors[] = "Secret question response is required.";
	}
	if (empty($_POST["password"]))
	{
		$errors[] = "Password is required.";
	}



}

// IF form was submitted and there were no errors
if (isset($_POST['submit']) && empty($errors))
{

	// Try creating the user
	try
	{
		$userName = Util::sanitizeData($_POST["username"]);
		$userName = Util::createUsername($userName);
		$pass = Util::sanitizeData($_POST["password"]);
		$passmid = $pass;

		$secret_question = Util::sanitizeData($_POST["secret_question"]);
		$question_answer = Util::sanitizeData($_POST["question_answer"]);
		$firstName = Util::sanitizeData($_POST["Firstname"]);
		$lastName = Util::sanitizeData($_POST["Lastname"]);

		$res = $util->addUser($userName, $firstName, $lastName, $secret_question, $question_answer, $pass);


		// IF the result came with an error message
		if (is_string($res))
		{
			$_SESSION['made'] = false;
			array_push($errors, $res);
		}
		// ELSE IF the database failed
		else if(!$res)
		{
			$_SESSION['made'] = false;
			array_push($errors, "Could not create user do to database issues. Please try again.");
		}
		// ELSE GREAT SUCCESS
		else
		{
			$_SESSION['made'] = true;
		}


	}
	catch (PDOException $e)
	{
		echo $sql . "<br>" . $e->getMessage();
	}


}
// ELSE there was no post, unset our variables
else
{
	unset($_SESSION['made']);
}


?>
	<div class="leftContent">


		<form action="Admin.php" method="post">

			Username to add:<br/>
			<input type="text" name="username">
			<br/>
			First name, Last name:<br/>
			<input type="text" name="Firstname"> <input type="text" name="Lastname">
			<br/>
			Secret question:<br/>
			<input type="text" name="secret_question">
			<br/>
			Question answer:<br/>
			<input type="text" name="question_answer">
			<br/>
			Password:<br/>
			<input type="text" name="password">
			<br/>
			<input type="submit" name="submit" value="Create user">
		</form>




		<?php
		if (!empty($errors))
		{
			foreach ($errors as $err)
			{
				echo "<p style= color:red>" . $err . "</p>";
			}
		}

		if (isset($_SESSION['made']) && $_SESSION['made'] == true)
		{
			echo '	<div id="notice">
								Profile made succesfully <br/>
								Username is: ' . $userName . '<br/>
								Password is: ' . $passmid . '<br/>
								Secret Question: ' . $secret_question . '<br/>
								Secret Answer: Hopefully only you know that  <br/>
							</div>';

		}


		?>


	</div>

<?php
include_once("inc/rightContent.php");
include("inc/footer.php");
?>