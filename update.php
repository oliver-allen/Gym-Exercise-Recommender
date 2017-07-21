<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css" />
    <script>
      function filter(){
        var input = document.getElementById("searchBar");
        var filter = input.value.toUpperCase();
        var table = document.getElementById("myTable");
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
    <div id="results">
      <form action="process.php" method="post">
        <table border="1" id="myTable">
          <tr>
            <th>Select</th><th>Name</th><th>Primary</th><th>Secondary</th><th>Bilateral</th><th>Equipment</th>
          </tr>
          <?php

            require 'mysql_connection.php';
            if (!$dbc) {
              die("Connection failed: " . mysqli_connect_error());
            }

            $entries = mysqli_query($dbc, "SELECT * FROM $table");
            if(!$entries) {
              die("Error select all. " . mysqli_error($dbc));
            }

            while ($row = mysqli_fetch_array($entries, MYSQLI_NUM)) {
              echo "<tr><td><input type='checkbox' name='check' /></td>";
              for($i=0; $i<count($row)-1; $i++){
                echo "<td>" . $row[$i] . "</td>";
              }
              echo "</tr>";
            }

            mysqli_close($dbc);
            //create table of all
           ?>

         </table>
         <input type="submit" value="Update" name="update" />
         <input type="button" value="Back" onclick="window.location = 'index.php'" />
      </form>
    </div>
  </div>

</body>
</html>
