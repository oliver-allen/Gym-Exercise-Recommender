<?php

if(!date_default_timezone_set('NZ')){
  die("Error setting default time zone");
}

$database = 'exercises';
$userTable = 'users';

//Connect to db
$dbc = mysqli_connect('localhost', 'root', 'root')
OR die('Not connected : ' . mysql_error());

//Create exercise database if not exist
$createDB="CREATE DATABASE IF NOT EXISTS $database";
$result = mysqli_query($dbc, $createDB)
OR die("Error creating database. " . mysqli_error($dbc));

mysqli_select_db($dbc, $database)
  OR die("Could not connect to table" . $GLOBALS['exerciseDB']);

?>
