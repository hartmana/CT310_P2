<?php
include_once("lib/config.php");
include_once("lib/util.php");
include_once("lib/user.php");
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="author" content=""/>
	<meta name="description" content=""/>
	<meta name="keywords" content=""/>

	<link rel="stylesheet" type="text/css" href="assets/css/style.css">


	<title><?php echo $title ?> - Social Network</title>

</head>
<body>
<header>
	<div id="page-logo">
		<a href="index.php">
			<div id="link-to-home">
				<h1>Friend Space<br/></h1>

				<h2><?php echo $title; ?></h2>
			</div>
		</a>
	</div>
	<nav>
		<ul>
			<?php
			echo '<li><a href="index.php">HOME</a></li>
					<li><a href="search.php?user=leonardovolpatto">SEARCH PAGE</a></li>';

			if (isset($_SESSION['secondaryAuth']))
			{
				echo '<li><a href="logout.php">LOG OUT</a></li>';
			}
			else
			{
				echo '<li><a href="login.php">LOGIN</a></li>';
			}
			if (isset($_SESSION['secondaryAuth']))
			{
				echo '<li><a href=profile.php?user=' . $_SESSION['user']->id . '>YOUR PAGE</a></li>';
			}
			if (isset($_SESSION['admin']))
			{
				if ($_SESSION['admin'] == true)
				{
					echo '<li><a href="Admin.php">ADMIN PAGE</a></li>';
				}
			}
			?>
		</ul>
	</nav>


</header>
<main>
