<?php

@session_start();

function loginUser($userrow)
{
	$_SESSION['userid'] = $userrow['id'];
	$_SESSION['username'] = $userrow['username'];
	if($userrow['admin'] == 1)
	{
		$_SESSION['admin'] = 1;
	}
}

function isLoggedIn()
{
	return isset($_SESSION['userid']) && intval($_SESSION['userid']) != 0;
}

function drawWarriorSelect()
{
	$warriors = SQL_getAllWarriors();
	foreach($warriors as $playerid=>$player)
	{
		foreach($player['warriors'] as $warrior)
		{
			echo "<option value='".$warrior['id']."'>".$player['ownername']."->".$warrior['name']."</option>";
		}
	}
}

?>
