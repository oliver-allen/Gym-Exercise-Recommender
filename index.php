<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css" />
    <script>
      function popup(){
        var status = "<?php echo $_GET["status"]; ?>";
        if(status != ""){
          alert(status);
        }
      }
    </script>
</head>
<body onload="popup()">

  <div id="container">
    <div id="buttons">
      <input type="button" value="Add Excercise" onclick="window.location = 'add_exercise.php'" />
      <input type="button" value="Update Excercise" onclick="window.location = 'update.php'" />
    </div>
    <div class="results"
    <table border="1" id="resultTable">
      <tr>
        <th>Name</th><th>Primary</th><th>Secondary</th><th>Bilateral</th><th>Equipment</th>
      </tr>
      <?php
  </div>

</body>
</html>
