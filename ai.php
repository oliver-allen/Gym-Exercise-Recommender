<!--
Decide exercises to recommend.
  Embedded in a table in index.php
!-->
<?php

  //Score last done desending based on day only.
  //Score bilateral by formula using days / count
  //Score equipment by formula using days / count
  //Score muscleGroupPrimary by formula using days / count
  //Score muscleGroupSecondary by formula using days / count

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
    bilateral TINYINT(1),
    lastDone DATETIME )";
  $result = mysqli_query($dbc, $createTable) ;

  if(!$result) {
    die("Error creating table. " . mysqli_error($dbc));
  }

  $entries = mysqli_query($dbc, "SELECT * FROM $table ORDER BY lastDone DESC");
  if(!$entries) {
    die("Error select all. " . mysqli_error($dbc));
  }

  //Create score and set to number of days since exercise done.
  $exercises = array();
  $now = new DateTime(date("Y-m-d H:i:s"));
  while ($row = mysqli_fetch_assoc($entries)) {
    $date = new DateTime($row['lastDone']);
    $dif = $now->diff($date)->format('%a');
    $row['score'] = $dif;
    $row['bilateral'] = $row['bilateral'] ? 'YES' : 'NO';
    //Add exercises to array.
    array_push($exercises, $row);
  }

  //Create subset for further scoring. Most recent 15 exercises.
  $subset = array();
  $num = count($exercises) < 15 ? count($exercises) : 15;
  for ($i = 0; $i < $num; $i++) {
    array_push($subset, $exercises[$i]);
  }

  //Create score for equipment based on subset of exercises.
  $equipmentScore = getScore($subset, "equipment.txt", 'equipment');
  //Create score for primary muscles based on subset of exercises.
  $primaryMuscleScore = getScore($subset, "muscles.txt", 'primaryPart');
  //Create score for primary muscles based on subset of exercises.
  $secondaryMuscleScore = getScore($subset, "muscles.txt", 'secondaryPart');
  //Create score for bilateral based on subset of exercises
  $bilateralScore = bilateral($subset);

  //Apply the different type of scores to each exercise score value.
  foreach ($exercises as $key => $exercise) {
    $score = $exercise['score'];
    $score += 0.1*($bilateralScore[$exercise['bilateral'] == 'YES' ? 'bilateral' : 'unilateral']);
    $score += 0.2*($equipmentScore[$exercise['equipment']]);
    $score += 0.3*($secondaryMuscleScore[$exercise['secondaryPart']]);
    $score += 0.4*($primaryMuscleScore[$exercise['primaryPart']]);
    $exercise['score'] = round($score, 3);
    $exercises[$key] = $exercise;
  }
  //Sort exercises by score biggest to smallest
  usort($exercises, "cmp");

  //Print middle of table for recommended exercises
  foreach ($exercises as $exercise) {
    $values = array_values($exercise);
    echo "<tr>";
    for($i=0; $i<count($values)-2; $i++){
      echo "<td>" . $values[$i] . "</td>";
    }
    //Add score column
    echo "<td>" . $values[$i+1] . "</td>";
    echo "</tr>";
  }

  mysqli_close($dbc);


  function getScore($subset, $fileName, $rowType){

    $file = file($fileName);
    //Remove special characters from equipment list
    foreach ($file as $key => $value) {
      $file[$key] = preg_replace('/[^A-Za-z0-9\-]/', '', $value);
    }
    //If 'secondaryPart' then add None to options
    if($rowType == 'secondaryPart'){
      array_push($file, 'None');
    }
    //Initialise arrays
    $count = array();
    $days = array();
    $score = array();
    foreach ($file as $line) {
      $count[$line] = 0;
      $days[$line] = 0;
      $score[$line] = 0;
    }

    //Add count for equipment and days.
    foreach ($subset as $row) {
      $daysAgo = $row['score'];
      $type = $row[$rowType];
      $count[preg_replace('/[^A-Za-z0-9\-]/', '', $type)] += 1;
      $days[preg_replace('/[^A-Za-z0-9\-]/', '', $type)] += $daysAgo;
    }

    //Determine a score for each equip
    $max = 1;
    foreach ($file as $line) {
      if($count[$line] != 0){
        $score[$line] = round($days[$line] / $count[$line]);
      }
      //Update max score
      if($score[$line] > $max){
        $max = $score[$line];
      }
    }

    //Make scores a weighting out of 1
    foreach ($file as $line) {
      if($count[$line] != 0){
        $score[$line] = round($score[$line] / (2 * $max), 3);
        if($score[$line] == 0 && $count[$line] < 4){
          $score[$line] = 1 - $count[$line] * 0.05;
        }
      } else {
        $score[$line] = 1;
      }
    }

    return $score;
  }

  function bilateral($subset){

    //Initialise arrays
    $count = array('bilateral' => 0, 'unilateral' => 0 );
    $days = array('bilateral' => 0, 'unilateral' => 0 );
    $score = array('bilateral' => 0, 'unilateral' => 0 );

    //Add count for type and days.
    foreach ($subset as $row) {
      $daysAgo = $row['score'];
      $bilateral = $row['bilateral'];
      $count[$bilateral == 'YES' ? 'bilateral' : 'unilateral'] += 1;
      $days[$bilateral == 'YES' ? 'bilateral' : 'unilateral'] += $daysAgo;
    }

    //Determine a score for each type
    $max = 1;
    foreach (array_keys($count) as $type) {
      if($count[$type] != 0){
        $score[$type] = round($days[$type] / $count[$type], 3);
      }
      //Update max score
      if($score[$type] > $max){
        $max = $score[$type];
      }
    }

    //Make scores a weighting out of 1
    foreach (array_keys($count) as $type) {
      if($score[$type] != 0){
        $score[$type] = round($score[$type] / (2 * $max));
        if($score[$type] == 0 && $count[$type] < 4){
          $score[$type] = 1 - $count[$type] * 0.05;
        }
      } else {
        $score[$type] = 1;
      }
    }

    return $score;
  }

  function cmp($a, $b){
    if($a['score'] == $b['score']){
      return 0;
    }
    return ($a['score'] > $b['score']) ? -1 : 1;
  }

  function val_sort($array, $key) {
    print_r($array);
  	foreach($array as $k=>$v) {
  		$b[] = $v[$key];
  	}
    print_r($b);
  	asort($b);

  	foreach($b as $k=>$v) {
  		$c[] = $array[$k];
  	}

  	return $c;
  }
 ?>
