<?php
/*
  Signout and remove session.
  Uses login.php
*/
session_start();

// remove all session variables
session_unset();
//destroy the session
session_destroy();

echo "<script>window.location.href = 'access.php';</script>";
?>
