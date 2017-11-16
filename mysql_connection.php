<?php

if(!date_default_timezone_set('NZ')){
  die("Error setting default time zone");
}

$exerciseDB = 'exercises';
$userTable = 'users';
$GLOBALS['exerciseDB'] = $exerciseDB;
$GLOBALS['userTable'] = $userTable;

//Connect to db
$dbc = mysqli_connect('localhost', 'root', 'root')
OR die('Not connected : ' . mysql_error());
$GLOBALS['dbc'] = $dbc;

//Create exercise database if not exist
$createDB="CREATE DATABASE IF NOT EXISTS $exerciseDB";
$result = mysqli_query($dbc, $createDB)
OR die("Error creating database. " . mysqli_error($dbc));
connectToExercises();

//Create user database if not exist
$createDB="CREATE DATABASE IF NOT EXISTS $userTable";
$result = mysqli_query($dbc, $createDB)
OR die("Error creating database. " . mysqli_error($dbc));
connectToUsers();

function connectToExercises(){
  mysqli_select_db($GLOBALS['dbc'], $GLOBALS['exerciseDB'])
  OR die("Could not connect to table" . $GLOBALS['exerciseDB']);
}

function connectToUsers(){
  mysqli_select_db($GLOBALS['dbc'], $GLOBALS['userTable'])
  OR die("Could not connect to table" . $GLOBALS['userTable']);
}
?>
