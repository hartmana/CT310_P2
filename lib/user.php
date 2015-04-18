<?php

/*
 * User Class
 * functions to manipulate user data
 * 
 */


class user
{


	public function __construct($id, $username, $firstName, $lastName, $password, $gender,
								$email, $phoneNumber, $accessLevel, $profileDescription)
	{
		$this->id = $id;
		$this->username = $username;
		$this->firstName = $firstName;
		$this->lastName = $lastName;
		$this->password = $password;
		$this->gender = $gender;
		$this->email = $email;
		$this->phoneNumber = $phoneNumber;
		$this->accessLevel = $accessLevel;
		$this->profileDescription = $profileDescription;

	}
}

?>
