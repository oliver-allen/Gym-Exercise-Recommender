<?php
//Database connection info
$host   =   "dbprojects.eecs.qmul.ac.uk";
$user   =   "oa309";
$pass   =   "eNHjGEoNa03Jt";
$db   =   "oa309";

$link  =  mysql_connect ( $host , $user , $pass ); //Connect to localhost storage
if (!$link ) {
  die( 'Could not connect: ' . mysql_error ());
}

$db_selected  =  mysql_select_db ( $db ,  $link ); // Select the correct db
if (!$db_selected ) {
    die ( 'Can\'t use $db : ' . mysql_error ());
}

//Function for others to use to get the number of blog entries.
function rowCount() {
  $result = mysql_query("SELECT * FROM blogs"); // All in table
	return mysql_num_rows($result); //number of rows = blogs
}
?>
