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
  $sql = mysqli_query($dbc, "SELECT equipment, lastDone FROM $table WHERE lastDone >= NOW() - INTERVAL 7 DAY");
  if(!$sql) {
    die("Error select all. " . mysqli_error($dbc));
  }

  //Order based on equipment used from last 7 days
  $equipmentScore = equipment($sql);
  print_r($equipmentScore);

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
    //Remove special characters from equipment list
    foreach ($equipment as $key => $value) {
      $equipment[$key] = preg_replace('/[^A-Za-z0-9\-]/', '', $value);
    }
    //Initialise arrays
    $count = array();
    $days = array();
    $score = array();
    foreach ($equipment as $equip) {
      $count[$equip] = 0;
      $days[$equip] = 0;
      $score[$equip] = 0;
    }
    //Current time
    $now = new DateTime(date("Y-m-d H:i:s"));

    //Find difference between now and each entry and count to arrays
    while ($row = mysqli_fetch_assoc($data)) {
      $date = new DateTime($row['lastDone']);
      $type = $row['equipment'];
      $count[preg_replace('/[^A-Za-z0-9\-]/', '', $type)] += 1;
      $days[preg_replace('/[^A-Za-z0-9\-]/', '', $type)] += $now->diff($date)->format('%d');
    }

    //Determine a score for each equip
    foreach ($equipment as $equip) {
      if($count[$equip] != 0){
        $score[$equip] = round($days[$equip] / $count[$equip] + $count[$equip]);
      }
    }
    return $score;

  }
 ?>
