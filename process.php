<?php
/*
Updates the lastDone for an exercise in the database.
  Uses home.php
*/
session_start();

if(isset($_POST['submit'])){

  if(array_key_exists('check',$_POST)){
    $checked = $_POST['check'];

    //Database connection
    require 'mysql_connection.php';
    connectToExercises();

    //List of exercises to update
    $names = "name='$checked[0]'";
    for($i=1; $i<count($checked); $i++){
      $names = $names . " OR name='$checked[$i]'";
    }

    //Update database
    $user = $_SESSION["user"];
    $update = mysqli_query($dbc, "UPDATE $user SET lastDone=NOW() WHERE $names")
    OR die("Error select all. " . mysqli_error($dbc));

    //Get names of exercies to update.
    $message = "$checked[0]";
    for($i=1; $i<count($checked); $i++){
      $message = $message . ", $checked[$i]";
    }
    //message to sent back to home.php
    $message = $message . " was updated successfully";
    setcookie("status", $message);
    echo "<script>window.location.href = 'home.php';</script>";
  }

} else {
  echo "<script>window.location.href = 'home.php';</script>";
}
 ?>
