<?php
  try {
    $pdo = new PDO("mysql:host=mariadb;dbname=camagru", "root", "camagru");
  } catch (PDOException $e) {
    print 'Error: ' . $e->getMessage() . '<br />';
    die();
  }
?>
