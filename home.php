<!--
Homepage of application.
  Contains an add exercise and update button and shows a table of recommended exercises.
  Uses add_exercise.php, update.php and ai.php
!-->
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--Popup saying exercise was added successfully!-->
    <script>
      function popup(){
        var status = "<?php
          if(array_key_exists('status',$_GET)){
          echo $_GET["status"];
          }
        ?>";
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
    <div class="results">
      <table border="1" id="resultTable">
        <tr>
          <th>Name</th><th>Primary</th><th>Secondary</th><th>Equipment</th><th>Bilateral</th><th>Score</th>
        </tr>
        <?php
          require 'ai.php';
         ?>
       </table>
     </div>
  </div>

</body>
</html>
