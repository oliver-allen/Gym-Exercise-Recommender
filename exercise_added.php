<html>
<body>

  <?php
  if(isset($_POST['submit'])){

    $_name = $_POST['name'];
    $_primary = $_POST['primary'];
    $_secondary = $_POST['secondary'];
    $_lateral = (array_key_exists('lateral',$_POST)) ? 1 : 0;
    $_equipment = $_POST['equipment'];

    require 'mysql_connection.php';
    if (!$dbc) {
      die("Connection failed: " . mysqli_connect_error());
    }

    $createTable="CREATE TABLE IF NOT EXISTS $table (
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
    echo "$_name, $_primary, $_secondary, NOW(), $_lateral, $_equipment";
    $query = "INSERT INTO $table (name, primaryPart, secondaryPart, lastDone, bilateral, equipment)
    VALUES ('$_name', '$_primary', '$_secondary', NOW(), '$_lateral', '$_equipment')";

    $insert = mysqli_query($dbc, $query);
    if(!$insert){
      die("Error inserting to database. " . mysqli_error($dbc));
    }

    $entries = mysqli_query($dbc, "SELECT * FROM $table");
    if(!$entries) {
      die("Error select all. " . mysqli_error($dbc));
    }
    while ($row = mysqli_fetch_assoc($entries)) {
      print_r($row);
      echo "<br/>";
    }

    mysqli_close($dbc);

    header( 'Location: list.html' );

  } else {
    echo "Something wrong. Exercise added not through submit";
  }
   ?>

</body>
</html>
