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

      require 'sqlConnect.php';
      $createTable="CREATE TABLE IF NOT EXISTS exercise (
  			name TEXT primary key not null,
        primaryPart TEXT,
	      secondaryPart TEXT,
	      lastDone DATETIME,
	      bilateral INTEGER,
	      equipment TEXT)";
      if(!mysql_query($createTable)) { // Show alert if error
        echo "Error creating table";
      }

      $query = "INSERT INTO exercise (name, primaryPart, secondaryPart, lastDone, bilateral, equipment)
      VALUES ($_name, $_primary, $_secondary, NOW(), $_lateral, $_equipment)";

      $insert = mysqli_query( $query);
      if(!$insert){
        echo mysqli_error();
      }
      mysqli_close($dbc);

    } else {
      echo "Missing required fields";
    }
  }
   ?>


</body>
</html>
