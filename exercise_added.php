<?php
/*<!--
Add exercise to the database.
  Uses exercise-added.php, muscles.txt, equipment.txt
!-->*/

  session_start();

  if(isset($_POST['submit'])){

    $_name = $_POST['name'];
    $_primary = $_POST['primary'];
    $_secondary = $_POST['secondary'];
    $_equipment = $_POST['equipment'];
    $_bilateral = (array_key_exists('bilateral',$_POST)) ? 1 : 0;
    $message = "";

    //Database connection
    require 'mysql_connection.php';
    connectToExercises();

    //Database insert query
    $user = $_SESSION["user"];
    $query = "INSERT INTO $user (name, primaryPart, secondaryPart, equipment, lastDone, bilateral)
    VALUES ('$_name', '$_primary', '$_secondary', '$_equipment', NOW(), '$_bilateral')";

    $insert = mysqli_query($dbc, $query);
    if(!$insert){
      $message = $_name . " already exists";
    }

    //Redirect to home.php and transfer status
    if(empty($message)){
      $message = "Exercise $_name was added successfully";
    }
    setcookie("status", $message);
    echo "<script>window.location.href = 'home.php';</script>";

  } else {
    echo "Something wrong. Exercise added not through submit";
  }
?>
