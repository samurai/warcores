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


?>

