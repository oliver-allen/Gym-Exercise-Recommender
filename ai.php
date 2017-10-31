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

  $entries = mysqli_query($dbc, "SELECT * FROM $table ORDER BY lastDone DESC");
  if(!$entries) {
    die("Error select all. " . mysqli_error($dbc));
  }

  //filter based on equipment used over the last 7 days, recent has more weighting
  $sql = mysqli_query($dbc, "SELECT equipment, lastDone FROM $table WHERE lastDone >= NOW() - INTERVAL 7 DAY");
  if(!$sql) {
    die("Error select all. " . mysqli_error($dbc));
  }

  //Create score and set to number of days since exercise done.
  $exercises = array();
  $now = new DateTime(date("Y-m-d H:i:s"));
  while ($row = mysqli_fetch_assoc($entries)) {
    $date = new DateTime($row['lastDone']);
    $dif = $now->diff($date)->format('%a');
    $row['score'] = $dif;
    //Add exercises to array.
    array_push($exercises, $row);
  }

  //Create subset for further scoring. Most recent 15 exercises.
  $subset = array();
  for ($i = 0; $i < 15; $i++) {
    array_push($subset, $exercises[$i]);
  }

  //Create score for equipment based on subset of exercises.
  $equipmentScore = equipment($subset);
  print_r($equipmentScore);

/*
  $dayBuckets = array();
  $now = new DateTime(date("Y-m-d H:i:s"));
  //Print middle of table for recommended exercises
    while ($row = mysqli_fetch_assoc($entries)) {
    $date = new DateTime($row['lastDone']);
    $dif = $now->diff($date)->format('%d');
    if(!array_key_exists($dif, $dayBuckets)){
      $dayBuckets[$dif] = array();
    }
    array_push($dayBuckets[$dif], $row);
    echo "<tr>";
    for($i=0; $i<count($row)-1; $i++){
      echo "<td>" . $row[$i] . "</td>";
    }
    echo "</tr>";
  }
  print_r($dayBuckets);
*/
  mysqli_close($dbc);



  function equipment($subset){

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

    //Add count for equipment and days.
    foreach ($subset as $row) {
      $daysAgo = $row['score'];
      $type = $row['equipment'];
      $count[preg_replace('/[^A-Za-z0-9\-]/', '', $type)] += 1;
      $days[preg_replace('/[^A-Za-z0-9\-]/', '', $type)] += $daysAgo;
    }

    //Determine a score for each equip
    $max = 0;
    foreach ($equipment as $equip) {
      if($count[$equip] != 0){
        $score[$equip] = round($days[$equip] / $count[$equip] + $count[$equip]);
        //Update max score
        if($score[$equip] > $max){
          $max = $score[$equip];
        }
      }
    }

    //Invert scores
    foreach ($equipment as $equip) {
        $score[$equip] = $max - $score[$equip];
    }
    
    return $score;

  }
 ?>
