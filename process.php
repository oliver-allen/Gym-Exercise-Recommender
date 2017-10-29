<!--
Updates the lastDone for an exercise in the database.
  Uses index.php
!-->
<?php

if(isset($_POST['submit'])){

  if(array_key_exists('check',$_POST)){
    $checked = $_POST['check'];

    //Database connection
    require 'mysql_connection.php';
    if (!$dbc) {
      die("Connection failed: " . mysqli_connect_error());
    }

    //List of exercises to update
    $names = "name='$checked[0]'";
    for($i=1; $i<count($checked); $i++){
      $names = $names . " OR name='$checked[$i]'";
    }

    //Update database
    $update = mysqli_query($dbc, "UPDATE $table SET lastDone=NOW() WHERE $names");
    if(!$update) {
      die("Error select all. " . mysqli_error($dbc));
    }
    mysqli_close($dbc);

    //Get names of exercies to update.
    $message = "$checked[0]";
    for($i=1; $i<count($checked); $i++){
      $message = $message . ", $checked[$i]";
    }
    //message to sent back to index.php
    $message = $message . " was updated successfully";
    echo "<script>window.location.href = 'index.php?status=$message';</script>";

  } else {
    echo "Nothing selected";
  }
}
 ?>
