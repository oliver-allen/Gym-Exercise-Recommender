<?php
/*<!--
Signup and login a user using database.
  Uses
!-->*/
  //Database connection
  require '../mysql_connection.php';
  if (!$dbc) {
    die("Connection failed: " . mysqli_connect_error());
  }

  //Create table if doesn't exist
  $createTable="CREATE TABLE IF NOT EXISTS $userTable (
    username VARCHAR(50) primary key not null,
    password VARCHAR(50) not null
  )";
  $result = mysqli_query($dbc, $createTable) ;

  if(!$result) {
    die("Error creating table. " . mysqli_error($dbc));
  }

  //If signup button was clicked
  if(isset($_POST['signup'])){
    $_username = $_POST['username'];
    $_password = $_POST['password'];

    //Database insert query
    $query = "INSERT INTO $userTable (username, password)
    VALUES ('$_username', '$_password')";

    $insert = mysqli_query($dbc, $query);
    if(!$insert){
      setcookie("status", $_username." already exists");
      echo "<script>window.location.href = 'access.php';</script>";
    } else {
      unset($_COOKIE["status"]);
      echo "<script>window.location.href = '../home.php';</script>";
    }
  }

  //If login button was clicked
  if(isset($_POST['login'])){
    $_username = $_POST['username'];
    $_password = $_POST['password'];

    //Database select query
    $query = "SELECT * FROM $userTable WHERE username='$_username' AND password='$_password'";
    $entries = mysqli_query($dbc, $query);
    if(!$entries || (mysqli_num_rows($entries) != 1) ){
      setcookie("status", "Username/Password is incorrect");
      echo "<script>window.location.href = 'access.php';</script>";
    } else {
        unset($_COOKIE["status"]);
        echo "<script>window.location.href = '../home.php';</script>";
    }

  }
?>
