<?php
/*
Update when exercise was last done and persist in database.
  Contains an submit and back button and has list of exercises with tickbox.
  Uses process.php, index.php
*/
session_start();
?>

<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Filter table rows from searchbar !-->
    <script>
      function filter(){
        var input = document.getElementById("searchBar");
        var filter = input.value.toUpperCase();
        var table = document.getElementById("exerciseTable");
        var tr = table.getElementsByTagName("tr");
        var td;
        // Loop through all table rows, and hide those who don't match the search query
        for (var i = 0; i < tr.length; i++) {
          td = tr[i].getElementsByTagName("td")[1]; //Get name field
          if (td) {
            if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
              tr[i].style.display = "";
            } else {
              tr[i].style.display = "none";
            }
          }
        }
      }
    </script>
</head>
<body>

  <div id="container">

    <div id="search">
      <input type="text" id="searchBar" onkeyup="filter()" placeholder="Search for exercises...">
    </div>

    <div class="results">
      <form action="process.php" method="post">
        <table border="1" id="exerciseTable">
          <tr>
            <th>Select</th><th>Name</th><th>Primary</th><th>Secondary</th><th>Equipment</th><th>Bilateral</th>
          </tr>

          <?php
          //Database connection
            require 'mysql_connection.php';
            connectToExercises();

            //Redirect if not logged in
            if(!isset($_SESSION["user"])){
              echo "<script>window.location.href = 'users/access.php';</script>";
            } else {
            
              //Database get all exercises query
              $user = $_SESSION["user"];
              $entries = mysqli_query($dbc, "SELECT * FROM $user")
              OR die("Error select all. " . mysqli_error($dbc));

              //Add all exercises to table
              while ($row = mysqli_fetch_array($entries, MYSQLI_NUM)) {
                echo "<tr><td class='centre'><input type='checkbox' name='check[]' value='$row[0]'/></td>";
                for($i=0; $i<count($row)-2; $i++){
                  echo "<td>" . $row[$i] . "</td>";
                }
                echo "<td>" . ($row[$i] ? 'YES' : 'NO') . "</td>";
                echo "</tr>";
              }
            }
           ?>

         </table>

         <input type="submit" value="Update" name="submit" />
         <input type="button" value="Back" onclick="window.location = 'home.php'" />
      </form>
    </div>
  </div>

</body>
</html>
