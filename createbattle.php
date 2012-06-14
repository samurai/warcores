<?php
require_once("includes/environment.php");

if(!isLoggedIn())
{
	die("You need to <a href='login.php'>log in</a>."); // TODO: this needs to be functionalized
}

if(isset($_POST['submit']))
{
	$rounds = intval($_POST['rounds']);
	$core_size = intval($_POST['core_size']);
	$tie_cycles = intval($_POST['tie_cycles']);
	$max_size = intval($_POST['max_size']);
	$min_distance = intval($_POST['min_distance']);
	$warrior1 = intval($_POST['warrior1']);
	$warrior2 = intval($_POST['warrior2']);
	if($rounds == 0 || $core_size == 0 || $tie_cycles == 0 || $max_size == 0 || $warrior1 == 0 || $warrior2 == 0)
	{
		echo "Bad inputs when trying to create battle";
	}
	else // got our data, dewit
	{
		$battleid = SQL_createBattle($rounds, $core_size, $tie_cycles, $max_size, $min_distance);
		SQL_addWarriorToBattle($battleid, $warrior1, 1);
		SQL_addWarriorToBattle($battleid, $warrior2, 2);
	}
}
?>

<form action='' method='post'>
<table>
<!-- TODO: should add tool-tips to these fields explaining their meaning in pmars config -->
	<tr>
		<th>Core Size: </th>
		<td><input type='text' name='core_size' value='8000' /></td>
	</tr>
	<tr>
		<th>Rounds to Play: </th>
		<td><input type='text' name='rounds' value='1' /></td>
	</tr>
	<tr>
		<th>Tie Cycles: </th>
		<td><input type='text' name='tie_cycles' value='80000' /></td>
	</tr>
	<tr>
		<th>Max Warrior Size: </th>
		<td><input type='text' name='max_size' value='100' /></td>
	</tr>
	<tr>
		<th>Minimum Distance Between Warriors: </th>
		<td><input type='text' name='min_distance' value='0' /></td>
	</tr>
	<tr>
		<th>Warrior #1: </th>
		<td>
			<select name='warrior1'>
			<?php drawWarriorSelect(); ?>
			</select>
		</td>
	</tr>
	<tr>
		<th>Warrior #2: </th>
		<td>
			<select name='warrior2'>
			<?php drawWarriorSelect(); ?>
			</select>
		</td>
	</tr>
</table>
<input type='submit' name='submit' value='BATTLE!' />
</form>

