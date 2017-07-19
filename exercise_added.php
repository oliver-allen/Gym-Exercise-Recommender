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
      } else {
        echo "Connected successfully\n";
      }

      $createTable="CREATE TABLE IF NOT EXISTS mytable (
  			name TEXT,
        primaryPart TEXT,
	      secondaryPart TEXT,
	      lastDone DATETIME,
	      bilateral INTEGER,
	      equipment TEXT)";

        echo "hi";
        $result = mysqli_query($dbc, $createTable) ;

      if(!$result) { // Show alert if error
        echo "Error creating table" . mysqli_error($dbc);
        exit();
      } else {
        echo "all good";
      }

      $query = "INSERT INTO mytable (name, primaryPart, secondaryPart, lastDone, bilateral, equipment)
      VALUES ('$_name', '$_primary', '$_secondary', NOW(), '$_lateral', '$_equipment')";

      $insert = mysqli_query($dbc, $query);
      echo "yay";
      if(!$insert){
        echo "shit";
        echo mysqli_error($dbc);
      } else {
        echo "query success\n";
        echo "  has" . mysqli_affected_rows($dbc) . "rows  ";
      }

$result = mysqli_query($dbc, "SELECT * FROM mytable");
$rows = mysqli_fetch_row($result);
print_r($rows);

      mysqli_close($dbc);

    } else {
      echo "Missing required fields";
    }
  }
   ?>


</body>
</html>
