<?php
require_once("includes/environment.php");

if(isset($_POST['submit']) && isset($_POST['username']) && isset($_POST['password']))
{
	$username = htmlentities($_POST['username']);
	$password = sha1($_POST['password']);
	$userdata = SQL_loginUser($username,$password);
	if(isset($userdata['id']) && intval($userdata['id']) != 0)
	{
		loginUser($userdata);
		header("Location: index.php");
	}
}

?>


<form action='' method='post'>
<table>
	<tr>
		<th>Username: </th>
		<td><input type='text' name='username' /></td>
	</tr>
	<tr>
		<th>Password: </th>
		<td><input type='password' name='password' /></td>
	</tr>
</table>
<input type='submit' name='submit' value='Log in!' />
</form>
