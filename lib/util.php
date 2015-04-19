<?php

/*
 * Util class
 * 
 * @author Felipe Volpatto	Feb 17, 2015
 */

class util
{
	private static $dbPath = "db/p2.db";

	public static function fileNotFound()
	{
		echo 'File not found!';
	}

	/**
	 * test ip: 129.82.192.154 (my local's ip)
	 * test ip: 10.84
	 **/
	public static function isIpValid()
	{
		$ip = $_SERVER['REMOTE_ADDR'];

		if ($ip == "::1")
		{
			return true;
		}

		$ipValues = explode('.', $ip);

		return (($ipValues[0] == 129 && $ipValues[1] == 82)
			|| ($ipValues[0] == 10 && $ipValues[1] == 84));
	}

	public static function sanitizeData($data)
	{
		return strip_tags($data);
	}

	public static function createUsername($name)
	{
		$name = strtolower($name);

		return $name;
	}

	public static function salt($name, $password)
	{
//		echo '<br>Name: ' . $name;
//		echo '<br>Salt: ' . substr($name, 0, 1) . substr($name, count($name)-2, 1);

		// Salt with the first character and the last character
		$first = substr($name, 0, 1);
		$last = substr($name, count($name) - 2, 1);

		$salt = $first . $last;

//		echo 'Salt: ' . $salt;
		return md5($salt . $password);
	}

	public static function connectDB()
	{
		try
		{

			$dbh = new PDO("sqlite:" . Util::$dbPath);
			ini_set('display_errors', 'On');
			error_reporting(E_ALL);
			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			return $dbh;

		}
		catch (PDOException $e)
		{
			/* If you get here it is mostly a permissions issue
			* or that your path to the database is wrong
			*/
			echo '<pre class="bg-danger">';
			echo 'Connection failed: ' . $e->getMessage();
			echo '</pre>';
			die;
		}
	}

	/**
	 * Function to remove friend of the user
	 * @param $userID        user's ID with friend to remove
	 * @param $friendID        user's ID of friend to remove
	 * @param $dbh            database handle
	 */
	public function deleteFriend($userID, $friendID, $dbh)
	{

		$sql = "DELETE FROM friends WHERE userID=$userID AND userFriendID=$friendID";
		$sql2 = "DELETE FROM friends WHERE userID=$friendID AND userFriendID=$userID";

		try
		{
			$query = $dbh->query($sql);
			$result = $query->fetch(PDO::FETCH_ASSOC);

			$query = $dbh->query($sql2);
			$result = $query->fetch(PDO::FETCH_ASSOC);

			return true;
		}
		catch (PDOException $pdoE)
		{
			echo "Failed removing friend! " . $pdoE->getMessage();
		}

		return false;

	}

	/**
	 * Function to addfriend of the user
	 * @param $userID        user's ID with friend to add
	 * @param $friendID        user's ID of friend to add
	 * @param $dbh            database handle
	 */
	public function addFriend($userID, $friendID, $dbh)
	{



		$sql = "INSERT INTO friends VALUES($userID, $friendID)";
		$sql2 = "INSERT INTO friends VALUES($friendID, $userID)";
		$sqlRemove = "DELETE FROM pendFriends WHERE userID=$userID AND pendFriendID=$friendID";

		try
		{
			$query = $dbh->query($sql);
			$result = $query->fetch(PDO::FETCH_ASSOC);

			$query = $dbh->query($sql2);
			$result = $query->fetch(PDO::FETCH_ASSOC);

			$query = $dbh->query($sqlRemove);
			$result = $query->fetch(PDO::FETCH_ASSOC);

			return true;
		}
		catch (PDOException $pdoE)
		{
			echo "Failed adding friend! " . $pdoE->getMessage();
		}

		return false;
	}

	/**
	 * Function to addfriend of the user
	 * @param $userID        user's ID with friend to add
	 * @param $friendID        user's ID of friend to add
	 * @param $dbh            database handle
	 */
	public function requestFriend($userID, $friendID, $dbh)
	{

		// IF the user is requesting himself to be a friend
		if(strcmp($userID, $friendID) == 0)
			return "You want to be friends with yourself? Cute. But sorry, not possible.";

		$sqlCheck = "SELECT * FROM pendFriends WHERE userID=$userID AND pendFriendID=$friendID";
		$sql = "INSERT INTO pendFriends VALUES($userID, $friendID)";

		try
		{
			$query = $dbh->query($sqlCheck);
			$result = $query->fetchAll(PDO::FETCH_ASSOC);

			if (count($result) > 0)
			{
				return "User has already been requested to be your friend!";
			}

			$query = $dbh->query($sql);
			$result = $query->fetch(PDO::FETCH_ASSOC);

			return true;
		}
		catch (PDOException $pdoE)
		{
			echo "Failed requesting friend! " . $pdoE->getMessage();
		}

		return false;
	}

	/**
	 * Function to remove friend request
	 *
	 */
	public function removeFriendRequest($userID, $friendID, $dbh)
	{
		$sql = "DELETE FROM pendFriends WHERE userId='$friendID' AND pendFriendID='$userID'";

		try
		{

			$query = $dbh->query($sql);
			$result = $query->fetch(PDO::FETCH_ASSOC);

			return true;
		}
		catch (PDOException $pdoE)
		{
			echo "Failed requesting friend! " . $pdoE->getMessage();
		}

		return false;
	}

	/**
	 * Function to add a user
	 * @param $userName
	 * @param $firstName
	 * @param $lastName
	 * @param $secret_question
	 * @param $question_answer
	 * @param $pass
	 *
	 * @return  boolean  false for a database failure
	 *          true for successful user addition
	 *
	 * @return string for error message
	 *
	 */
	public function addUser($userName, $firstName, $lastName, $secret_question, $question_answer, $pass)
	{
		// Get actual password to be used
		$password = Util::salt($userName, $pass);

		// Get actual challenge answer to be used
		$challengeAnswer = Util::salt($secret_question, $question_answer);

		$checkForExisting = "SELECT * FROM users WHERE username=?";

		$insertNewUser = "INSERT INTO users (username, firstName, lastName, password) VALUES(?, ?, ?, ?)";

		$selectUsersID = "SELECT id FROM users WHERE username=?";

		$insertUsersChallenge = "INSERT INTO questions(questionID, question, questionAnswer) VALUES(?, ?, ?)";

		$deleteUser = "DELETE FROM users WHERE id=?";


		$dbh = self::connectDB();

		// Start the transaction
		if($dbh->beginTransaction())
		{
			try
			{


				/**
				 * First check for existing user
				 */
				$statement = $dbh->prepare($checkForExisting);

				// IF statement couldn't be prepared
				if (!$statement)
				{
					return false;
				}

				$statement->execute(array($userName));

				// IF statement couldn't be executed
				if (!$statement)
				{
					return false;
				}

				$result = $statement->fetch(PDO::FETCH_ASSOC);

				// IF user already exists
				if ($result)
				{
					return "User already exists!";
				}


				/**
				 * By this point, the user does not exist and we can create it
				 */
				$statement = $dbh->prepare($insertNewUser);

				// IF statement couldn't be prepared
				if (!$statement)
				{
					return false;
				}

				$statement->execute(array($userName, $firstName, $lastName, $password));

				// IF statement couldn't be executed
				if (!$statement)
				{
					$dbh->rollBack();
					return false;
				}


				/**
				 * The user has been created, get the users ID
				 */
				$statement = $dbh->prepare($selectUsersID);

				// IF statement couldn't be prepared
				if (!$statement)
				{
					$dbh->rollBack();
					return false;
				}

				$statement->execute(array($userName));

				// IF statement couldn't be executed
				if (!$statement)
				{
					$dbh->rollBack();
					return false;
				}

				$result = $statement->fetch(PDO::FETCH_ASSOC);

				// IF there was an error getting the new user's ID (somehow)
				if (!$result)
				{
					$dbh->rollBack();
					return false;
				}


				$insertedUserID = $result['id'];


				/**
				 * Add the user's challenge question/answer
				 */
				$statement = $dbh->prepare($insertUsersChallenge);

				// IF statement couldn't be prepared
				if (!$statement)
				{
					$dbh->rollBack();
					return false;
				}

				$statement->execute(array($insertedUserID, $secret_question, $challengeAnswer));

				// IF statement couldn't be executed
				if (!$statement)
				{
					$dbh->rollBack();
					return false;
				}


				// user successfully created
				$dbh->commit();

				return true;


			}
			catch (PDOException $pdoE)
			{
				return "Failed adding user: " . $pdoE->getMessage();
			}
		}
	}
}

?>
