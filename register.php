<?php
require_once("includes/environment.php");

//TODO: might need some sort of captcha/email verification


if(isset($_POST['submit']))
{
	if($_POST['password'] != $_POST['password2'])  //passwords dont match
	{
		echo "Your passwords don't match!\n";
	}
	elseif($_POST['password'] == '' || $_POST['username'] == '' || $_POST['email'] == '') //not enough  info
	{
		echo "Sadly, all fields are required.\n";
	}
	else //good to go, try and create the user
	{
		$username = htmlentities($_POST['username'],ENT_QUOTES);
		$password = sha1($_POST['password']);
		$email = htmlentities($_POST['email']);
		if(SQL_usernameExists($username))
		{
			echo "Sorry, that username is already in-use\n";
		}
		elseif(SQL_emailExists($email))
		{
			echo "Sorry, that email is already in-use\n";
		}
		else
		{
			$userid = intval(SQL_createUser($username, $password, $email));
			if($userid != 0)
			{
				echo "You're good to go! Feel free to <a href='login.php'>sign-in</a>\n";
			}
			else
			{
				echo "Err, no idea why, but we couldn't create your user =/ \n";
			}
		}
	}
}

?>

<form action='' method='post' >
<table>
	<tr>
		<th>Username:</th>
		<td><input type='text' name='username' /></td>
	</tr>
	<tr>
		<th>Password:</th>
		<td><input type='password' name='password' /></td>
	</tr>
	<tr>
		<th>Password (again):</th>
		<td><input type='password' name='password2' /></td>
	</tr>
	<tr>
		<th>Email:</th>
		<td><input type='text' name='email' /></td>
	</tr>
</table>
<input type='submit' name='submit' value='Register!' />
</form>
