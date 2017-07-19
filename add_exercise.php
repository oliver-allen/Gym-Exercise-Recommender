<html>
<body>

  <form method="post" action="exercise_added.php">
    <p>Exercise Name:
      <input type="text" name="name">
    </p>
    <p>Primary Muscle Group:
      <select name ="primary" >
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
      <select name ="secondary" >
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
    <p>Unilateral Exercise:
      <input type="checkbox" name="lateral"/>
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
    <p>
      <input type="submit" value="submit" name="submit">
    </p>
  </form>

</body>
</html>
