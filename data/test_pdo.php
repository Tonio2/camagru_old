<?php
try {
  $pdo = new PDO("mysql:host=mariadb;dbname=camagru", "root", "camagru");
  foreach($pdo->query("SELECT * FROM User") as $row) {
    print_r($row);
  }
  $pdo = null;
} catch (PDOException $e) {
  print "Error!: " . $e->getMessage() . "<br/>";
  die();
}
?>
