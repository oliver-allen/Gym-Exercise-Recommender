<?php
/*Page to login or signup.
  Contains a signup and login buttons and has fields for username and password.
  Uses and login.php*/
  
  if(isset($_COOKIE["access"])){
    $accessStatus = $_COOKIE["access"];
  } else {
    $accessStatus = "";
  }
  setcookie( "access", "", time()-1);
?>

<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Popup if exercise info is not valid! -->
    <script>
      function popup(){
        var status = "<?php
          if(isset($accessStatus)){
            echo $accessStatus;
          }
        ?>";
        if(status != ""){
          alert(status);
        }
      }
      function checkEntrySignup() {
        var dom = document.getElementsByClassName('requireSignup');
        if(dom[0].value != "" && dom[1].value != ""){
          return true;
        }else{
          alert("Required fields missing");
          return false;
        }
      }
      function checkEntryLogin() {
        var dom = document.getElementsByClassName('requireLogin');
        if(dom[0].value != "" && dom[1].value != ""){
          return true;
        }else{
          alert("Required fields missing");
          return false;
        }
      }
    </script>

</head>
<body onload="popup()">
  <div id="signup">
    <form method="post" action="login.php">
      <h3>Sign up</h3>

      <p>Username:
        <input type="text" name="username" class="requireSignup"/>
      </p>

      <p>Password:
        <input type="password" name="password" class="requireSignup"/>
      </p>

      <p>
        <input type="submit" value="Sign Up" name="signup" onclick="return checkEntrySignup()"/>
      </p>

    </form>
  </div>

  <div id="login">
    <form method="post" action="login.php">
      <h3>Log in</h3>

      <p>Username:
        <input type="text" name="username" class="requireLogin"/>
      </p>

      <p>Password:
        <input type="password" name="password" class="requireLogin"/>
      </p>

      <p>
        <input type="submit" value="Log In" name="login" onclick="return checkEntryLogin()"/>
      </p>

    </form>
  </div>
</body>
</html>
