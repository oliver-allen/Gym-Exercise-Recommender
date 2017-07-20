<html>
<body>

  <?php
  if(isset($_POST['submit'])){

    $_name = $_POST['name'];
    $_primary = $_POST['primary'];
    $_secondary = $_POST['secondary'];
    $_lateral = (array_key_exists('lateral',$_POST)) ? 1 : 0;
    $_equipment = $_POST['equipment'];

    if( $_name != "" && $_primary != "" && $_secondary != "" ){

      require 'mysql_connection.php';
      if (!$dbc) {
        die("Connection failed: " . mysqli_connect_error());
      }

      $createTable="CREATE TABLE IF NOT EXISTS mytable (
  			name TEXT,
        primaryPart TEXT,
	      secondaryPart TEXT,
	      lastDone DATETIME,
	      bilateral INTEGER,
	      equipment TEXT)";
      $result = mysqli_query($dbc, $createTable) ;

      if(!$result) {
        die("Error creating table. " . mysqli_error($dbc));
      }

      $query = "INSERT INTO mytable (name, primaryPart, secondaryPart, lastDone, bilateral, equipment)
      VALUES ('$_name', '$_primary', '$_secondary', NOW(), '$_lateral', '$_equipment')";

      $insert = mysqli_query($dbc, $query);
      if(!$insert){
        echo mysqli_error($dbc);
      }


      $result = mysqli_query($dbc, "SELECT * FROM mytable");
      while ($row = mysqli_fetch_assoc($result)) {
        print_r($row);
        echo "<br/>";
      }

      mysqli_close($dbc);

    } else {
      echo "Missing required fields";
    }
  }
   ?>


</body>
</html>
