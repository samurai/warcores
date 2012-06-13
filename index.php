<?php
require_once("includes/environment.php");

if(!isLoggedIn())
{
	die("You should probably <a href='login.php'>log in</a>.");
}


echo "Welcome!  Nothing's here yet, but welcome all the same!";

?>
