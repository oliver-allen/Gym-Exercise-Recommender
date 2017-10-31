<!--
Form to add exercise to the database.
  Contains an submit and back button and has fields for adding exercis info.
  Uses exercise-added.php, index.php, muscles.txt, equipment.txt
!-->
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css" />

    <!-- Popup is exercise info is not valid! -->
    <script>
      function checkEntry() {
        var dom = document.getElementsByClassName('require');
        if(dom[0].value != "" && dom[1].value != "Select a muscle" && dom[2].value != "Select a muscle"){
          return true;
        }else{
          alert("Required fields missing");
          return false;
        }
      }
    </script>

</head>
<body>

  <div id="container">
    <form method="post" action="exercise_added.php">

      <p>Exercise Name:
        <input type="text" name="name" class="require"/>
      </p>

      <p>Primary Muscle Group:
        <select name ="primary" class="require">
          <option selected="selected" disabled="disabled">Select a muscle</option>
          <?php
            $muscles = file("muscles.txt");
            foreach ($muscles as $muscle) {
              echo "<option>$muscle</option>";
            }
           ?>
        </select>
      </p>

      <p>Secondary Muscle Group:
        <select name ="secondary" class="require">
          <option selected="selected" disabled="disabled">Select a muscle</option>
          <option>None</option>
          <?php
            $muscles = file("muscles.txt");
            foreach ($muscles as $muscle) {
              echo "<option>$muscle</option>";
            }
           ?>
        </select>
      </p>

      <p>Equipment:
        <select name ="equipment">
          <?php
            $equipment = file("equipment.txt");
            foreach ($equipment as $equip) {
              echo "<option>$equip</option>";
            }
           ?>
        </select>
      </p>

      <p>Bilateral Exercise:
        <input type="checkbox" name="bilateral"/>
      </p>

      <p>
        <input type="submit" value="submit" name="submit" onclick="return checkEntry()"/>
        <input type="button" value="Back" onclick="window.location = 'index.php'" />
      </p>

    </form>
  </div>
</body>
</html>
