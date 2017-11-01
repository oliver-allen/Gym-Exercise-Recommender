<?php

if(!date_default_timezone_set('NZ')){
  die("Error setting defualt time zone");
}

$dbc = @mysqli_connect('localhost', 'root', 'root', 'exercises')
OR die('Could not connect to MySQL ' . mysqli_connect_error());
$table = "exercise";
$userTable = "user";

?>
