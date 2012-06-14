<?php
require_once("config.php");

//connect function?
function sql_connect()
{
	global $PSQL_HOST,$PSQL_PORT,$PSQL_USER,$PSQL_PASS,$PSQL_DB;
	$constr = "host=$PSQL_HOST port=$PSQL_PORT dbname=$PSQL_DB user=$PSQL_USER password=$PSQL_PASS";
	pg_connect($constr);
}


//user management functions
function SQL_usernameExists($username)
{
	$username = htmlentities($username, ENT_QUOTES);
	$sql_checkUser = "SELECT * FROM players WHERE username='$username'";
	$row = pg_fetch_assoc(pg_query($sql_checkUser));
	return isset($row['id']);
}

function SQL_emailExists($email)
{
	$email = htmlentities($email, ENT_QUOTES);
	$sql_checkEmail = "SELECT * FROM players WHERE email='$email'";
	$row = pg_fetch_assoc(pg_query($sql_checkEmail));
	return isset($row['id']);

}

function SQL_createUser($username, $password, $email)
{
	$email = htmlentities($email, ENT_QUOTES);
	$username = htmlentities($username, ENT_QUOTES);
	$password = htmlentities($password, ENT_QUOTES); // this should be coming as sha1 anyways, but just in case :P
	$sql_insertUser = "INSERT INTO players (username, password, email) VALUES ('$username','$password','$email') RETURNING id";
	$row = pg_fetch_assoc(pg_query($sql_insertUser));
	if(isset($row['id']))
	{
		return $row['id'];
	}
	return 0;
}

function SQL_loginUser($username, $password)
{
	$username = htmlentities($username, ENT_QUOTES);
	$password = htmlentities($password, ENT_QUOTES); // again, this is sha1 coming in, paranoia++
	$sql_validateUser = "SELECT * FROM players WHERE username='$username' AND password='$password'";
	$row = pg_fetch_assoc(pg_query($sql_validateUser));
	return $row;
}

function SQL_getPlayerByID($pid)
{
	if(intval($pid) == 0)
	{
		return Array();
	}
	$sql_getPlayer = "SELECT id,username,admin FROM players WHERE id='$pid'";
	return pg_fetch_assoc(pg_query($sql_getPlayer));
}

//warrior management functions

function SQL_warriorExists($userid, $warrior_name)
{
	$userid = intval($userid);
	$warrior_name = htmlentities($warrior_name, ENT_QUOTES);
	$sql_checkWarrior = "SELECT id FROM warriors WHERE owner='$userid' AND name='$warrior_name'";
	$row = pg_fetch_assoc(pg_query($sql_checkWarrior));
	return isset($row['id']) && intval($row['id']) != 0;
}

function SQL_createWarrior($name, $notes, $code, $userid)
{
	$name = htmlentities($name, ENT_QUOTES);
	$notes = htmlentities($notes, ENT_QUOTES);
	$code = htmlentities($code, ENT_QUOTES);
	$userid = intval($userid);
	$create_time = time();
	$sql_createWarrior = "INSERT INTO warriors (name, notes, code, owner) VALUES ('$name','$notes','$code','$userid') RETURNING id";
	$row = pg_fetch_assoc(pg_query($sql_createWarrior));
	if(isset($row['id']))
	{
		return $row['id'];
	}
	return 0;
}

function SQL_getAllWarriors()
{
	$sql_getWarriors = "SELECT id,name,owner FROM warriors ORDER BY owner ASC";
	$res = pg_query($sql_getWarriors);
	$warriors = Array();
	while($row = pg_fetch_assoc($res))
	{
		if(!in_Array($row['owner'],array_keys($warriors)))
		{
			$player = SQL_getPlayerByID($row['owner']);
			$warriors[$row['owner']] = Array('ownername'=>$player['username'],'warriors'=>Array());
		}
		$warriors[$row['owner']]['warriors'][$row['id']] = $row;
	}

	return $warriors;
}

//battle management functions

function SQL_createBattle($rounds=1, $core_size=8000, $tie_cycles=80000, $max_size=100, $min_distance=0)
{
	$rounds = intval($rounds);
	$core_size = intval($core_size);
	$tie_cycles = intval($tie_cycles);
	$max_Size = intval($max_size);
	$min_distance = intval($min_distance);
	$battle_time = time();
	$sql_createBattle = "INSERT INTO battle (rounds, core_Size, tie_cycles, max_size, min_distance, battle_time) VALUES ('$rounds','$core_size','$tie_cycles','$max_size','$min_distance','$battle_time') RETURNING id";
	$row = pg_fetch_assoc(pg_query($sql_createBattle));
	$bid = $row['id'];
	return $bid;
}

function SQL_addWarriorToBattle($battleid, $warriorid, $position)
{
	$battleid = intval($battleid);
	$warriorid = intval($warriorid);
	$position = intval($position);
	$sql_addWarrior = "INSERT INTO battle_has_warrior (battleid, warriorid, position) VALUES ('$battleid','$warriorid','$position') RETURNING id";
	$row = pg_fetch_assoc(pg_query($sql_addWarrior));
	return $row['id']; //relationid
}

?>

