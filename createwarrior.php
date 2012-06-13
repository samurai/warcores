<?php
require_once("includes/environment.php");

if(!isLoggedIn())
{
	die("You need to <a href='login.php'>log in</a>."); // TODO: this needs to be functionalized
}

if(isset($_POST['submit']) && $_FILES['file']['error'] == 0)
{
	$name = htmlentities($_POST['name']);
	if(SQL_warriorExists($_SESSION['userid'],$name))
	{
		echo "You already have a warrior by that name.\n";
	}
	else
	{
		$filepath = $_FILES['file']['tmp_name'];
		$notes = htmlentities($_POST['notes']);
		//i dont think redcode uses anything that will get fubar'd by htmlentities
		//perhaps &, but i cant remember off the top of my head if that's a modifier
		$code = htmlentities(file_get_contents($filepath),ENT_QUOTES); 
		unlink($filepath);
		SQL_createWarrior($name, $notes, $code, $_SESSION['userid']);
	}
}

?>

<form action='' method='post' enctype='multipart/form-data'>
<table>
	<tr>
		<th>Name: </th>
		<td><input type='text' name='name' /></td>
	</tr>
	<tr>
		<th>Notes: </th>
		<td><input type='text' name='notes' /></td>
	</tr>
	<tr>
		<th>Code: </th>
		<td><input type='file' name='file' /></td>
	</tr>
</table>
<input type='submit' name='submit' value='Create bot' />
</form>
