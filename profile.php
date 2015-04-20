<?php
$title = "Profile Page";

include("inc/header.php");
include("lib/files.php");
include("lib/userOperations.php");
$dbh = Util::connectDB();
$user = false;

$sql = "SELECT * FROM users WHERE id = \"$_GET[user]\"";
$query = $dbh->query($sql);
$queryArray = $query->fetch(PDO::FETCH_ASSOC);
$profile = new user($queryArray['id'], $queryArray['username'], $queryArray['firstName'],
    $queryArray['lastName'], $queryArray['password'], $queryArray['gender'],
    $queryArray['email'], $queryArray['phoneNumber'], $queryArray['accessLevel'], $queryArray['profileDescription']);


if (isset($_SESSION['user']))
{
    $user = $_SESSION['user'];
}
$util = new util();

?>

<div class="leftContent">
    <?php

    echo '<hr>
			<h2>' . $profile->firstName . ' ' . $profile->lastName . '</h2>';



    echo '<div class="profile-thumb"><img src="assets/img/profile' . $profile->id . '.jpg" alt="' . $profile->firstName . '\'s image profile"> </div>';

    // IF the user is logged in and not viewing their own page
    if ($user && $user->id != $profile->id)
    {
//        echo '<hr>';

        // IF the two users are friends
        if ($util->isFriend($user->id, $profile->id, $dbh))
        {
            echo '<div class="profFriendStatus"><h3>Friends</h3> <a href="deleteFriend.php?user=' . $user->id . '&friend=' . $profile->id . '">Remove</a></div>';
        }
        // ELSE IF there is a pending friend request from that user
        else if($util->isPendFriend($profile->id, $user->id, $dbh))
        {
            echo '<div class="profFriendStatus"><h3>Pending Friend Request</h3> <a href="addFriend.php.php?user=' . $user->id . '&friend=' . $profile->id . '">Accept</a>&nbsp;&nbsp;<a href="cancelRequest.php?user=' . $user->id . '&friend=' . $profile->id . '">Cancel</a></div>';
        }
        // ELSE they are not friends
        else
        {
            echo '<div class="profFriendStatus"><h3><a href="friendRequest.php?user=' . $user->id . '&friend=' . $profile->id . '">Request Friend</a></h3></div>';
        }

//        echo '<hr>';

    }


    echo    '<h4>Description:</h4>
             <p>' . $profile->profileDescription . '</p>';


    if ( /* $util->isIpValid() && */
        $user && ($user->id == $profile->id)
    )
    {
        echo '<p><a href="profileEdit.php?user=' . $profile->username . '">Edit Profile Information</a></p>';
    }
    if (isset($_SESSION['login']) && isset($_SESSION['securityCheck']))
    {

        echo '<div id="profileInfo">
                    <hr>
					<h3>Contact Info</h3>
					<p>Email: ' . $profile->email . '</p>
					<p>Phone Number: ' . $profile->phoneNumber . '</p>
				</div>';
    }
    echo '</div>';

    if (isset($_SESSION['user']))
    {
        include_once("inc/rightFriendsContent.php");
    } else
    {

        include_once("inc/rightContent.php");
    }
    ?>

    <?php
    include("inc/footer.php")
    ?>
