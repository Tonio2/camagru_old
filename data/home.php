<?php
require_once "auth.php";
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Home - Camagru</title>
  </head>
  <body>
    <p>Welcome <?=$_SESSION['name']?> !</p>
    <a href="/logout.php"><button>Logout</button></a>
  </body>
</html>
