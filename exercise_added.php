<!--
Add exercise to the database.
  Uses exercise-added.php, muscles.txt, equipment.txt
!-->
<?php
  if(isset($_POST['submit'])){

    $_name = $_POST['name'];
    $_primary = $_POST['primary'];
    $_secondary = $_POST['secondary'];
    $_equipment = $_POST['equipment'];

    //Database connection
    require 'mysql_connection.php';
    if (!$dbc) {
      die("Connection failed: " . mysqli_connect_error());
    }

    //Database insert query
    $query = "INSERT INTO $table (name, primaryPart, secondaryPart, equipment, lastDone)
    VALUES ('$_name', '$_primary', '$_secondary', '$_equipment', NOW())";

    $insert = mysqli_query($dbc, $query);
    if(!$insert){
      die("Error inserting to database. " . mysqli_error($dbc));
    }

    mysqli_close($dbc);

    //Redirect to index.php and transfer status
    $message = "Exercise $_name was added successfully";
    echo "<script>window.location.href = 'index.php?status=$message';</script>";
    //header( 'Location: index.php' );

  } else {
    echo "Something wrong. Exercise added not through submit";
  }
?>
