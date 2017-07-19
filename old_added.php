<html>
<body>
  <?php
  if(isset($_POST['submit'])){

    $_name = $_POST['name'];
    $_primary = $_POST['primary'];
    $_secondary = $_POST['secondary'];
    $_lateral = (array_key_exists('lateral',$_POST)) ? 1 : 0;
    $_equipment = $_POST['equipment'];

    if(isset($_name) && isset($_primary) && isset($_equipment) && isset($_lateral) && $_name != "" && $_primary != "" && $_equipment != "" && $_lateral != ""){

      //require_once('../mysql_connection.php');
      $dbc = @mysqli_connect('localhost', 'root', 'root', 'exercises')
      OR die('Could not connect to MySQL ' . mysqli_connect_error());

      if (!$dbc) {
    die("Connection failed: " . mysqli_connect_error());
}

      $query = "INSERT INTO exercise (name, primaryPart, secondaryPart, lastDone, bilateral, equipment)
      VALUES ('$_name', '$_primary', '$_secondary', NOW(), '$_lateral', '$_equipment')";

      if (mysqli_query($dbc, $query)) {
    echo "New record created successfully";
    $query="SELECT * FROM exercise";
			$results = mysql_query($query);
      echo mysql_num_rows($result);
} else {
    echo "Error: " . $query . "<br>" . mysqli_error($dbc);
}

      /*$insert = mysqli_prepare($dbc, $query);
      mysqli_stmt_execute($insert);


      $affected_rows = mysqli_stmt_affected_rows($insert);
      echo $affected_rows;
      if($affected_rows == 1){

        echo 'Exercise Entered';

        mysqli_stmt_close($insert);
        mysqli_close($dbc);

      } else {
        echo 'Error Occurred<br />';
        echo mysqli_error();

        mysqli_stmt_close($insert);
        mysqli_close($dbc);
      }*/
    } else {
      echo "Missing required fields";
    }
  }
   ?>



</body>
</html>
