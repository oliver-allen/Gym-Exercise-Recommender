<?php

if(isset($_POST['submit'])){

  if(array_key_exists('check',$_POST)){
    $checked = $_POST['check'];

    require 'mysql_connection.php';
    if (!$dbc) {
      die("Connection failed: " . mysqli_connect_error());
    }
    $names = "name='$checked[0]'";
    for($i=1; $i<count($checked); $i++){
      $names = $names . " OR name='$checked[$i]'";
    }

    $update = mysqli_query($dbc, "UPDATE $table SET lastDone=NOW() WHERE $names");
    if(!$update) {
      die("Error select all. " . mysqli_error($dbc));
    }
    mysqli_close($dbc);

    $message = "$checked[0]";
    for($i=1; $i<count($checked); $i++){
      $message = $message . ", $checked[$i]";
    }
    $message = $message . " was updated successfully";
    header( "Location: index.php?status=$message" );

  } else {
    echo "Nothing selected";
  }
}
 ?>
