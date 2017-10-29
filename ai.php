<!--
Decide exercises to recommend.
  Embedded in a table in index.php
!-->
<?php

  //order of last done desending based on day only.
  //order dumbell/barbell used most (bilateral)
  //equipment type

  //Database connection
  require 'mysql_connection.php';
  if (!$dbc) {
    die("Connection failed: " . mysqli_connect_error());
  }

  //Create table if doesn't exist
  $createTable="CREATE TABLE IF NOT EXISTS $table (
    name VARCHAR(50) primary key not null,
    primaryPart TEXT,
    secondaryPart TEXT,
    equipment TEXT,
    lastDone DATETIME)";
  $result = mysqli_query($dbc, $createTable) ;

  if(!$result) {
    die("Error creating table. " . mysqli_error($dbc));
  }

  $entries = mysqli_query($dbc, "SELECT * FROM $table ORDER BY lastDone ASC");
  if(!$entries) {
    die("Error select all. " . mysqli_error($dbc));
  }

  //filter based on equipment used over the last 7 days, recent has more weighting
  $sql = mysqli_query($dbc, "SELECT equipment, lastDone FROM exercise WHERE lastDone >= NOW() - INTERVAL 7 DAY");
  if(!$sql) {
    die("Error select all. " . mysqli_error($dbc));
  }

  //equipment($sql);


  //Print middle of table for recommended exercises
  while ($row = mysqli_fetch_array($entries, MYSQLI_NUM)) {
    echo "<tr>";
    for($i=0; $i<count($row)-1; $i++){
      echo "<td>" . $row[$i] . "</td>";
    }
    echo "</tr>";
  }

  mysqli_close($dbc);





  function equipment($data){

    $equipment = file("equipment.txt");
    $array = array();
    foreach ($equipment as $equip) {
      $array[$equip] = 0;
    }
    $now = DateTime(date("Y-m-d H:i:s"));
    echo "Time = $now now </br>";
    while ($row = mysqli_fetch_assoc($data)) {
      $date = $row['lastDone'];
      echo $now->diff($date)->format('%a');
    }


    //Find difference between now and each entry. Multiply that equipment type by diff and add to array.


    //$array = mysqli_fetch_assoc($data);
    //print_r($array);
  }
 ?>
