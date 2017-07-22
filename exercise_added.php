<html>
<head>
</head>
<body>

  <?php
  if(isset($_POST['submit'])){

    $_name = $_POST['name'];
    $_primary = $_POST['primary'];
    $_secondary = $_POST['secondary'];
    $_lateral = (array_key_exists('lateral',$_POST)) ? "True" : "False";
    $_equipment = $_POST['equipment'];

    require 'mysql_connection.php';
    if (!$dbc) {
      die("Connection failed: " . mysqli_connect_error());
    }

    $createTable="CREATE TABLE IF NOT EXISTS $table (
			name VARCHAR(50) primary key not null,
      primaryPart TEXT,
      secondaryPart TEXT,
      bilateral TEXT,
      equipment TEXT,
      lastDone DATETIME)";
    $result = mysqli_query($dbc, $createTable) ;

    if(!$result) {
      die("Error creating table. " . mysqli_error($dbc));
    }
    $query = "INSERT INTO $table (name, primaryPart, secondaryPart, bilateral, equipment, lastDone)
    VALUES ('$_name', '$_primary', '$_secondary', '$_lateral', '$_equipment', NOW())";

    $insert = mysqli_query($dbc, $query);
    if(!$insert){
      die("Error inserting to database. " . mysqli_error($dbc));
    }

    $entries = mysqli_query($dbc, "SELECT * FROM $table");
    if(!$entries) {
      die("Error select all. " . mysqli_error($dbc));
    }

    mysqli_close($dbc);

    $message = "Exercise $_name was added successfully";
    echo "<script>window.location.href = 'index.php?status=$message';</script>";
    //header( 'Location: index.php' );

  } else {
    echo "Something wrong. Exercise added not through submit";
  }
   ?>

</body>
</html>
