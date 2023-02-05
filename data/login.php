<?php
  require_once "db.php";
  session_start();
  if ( !isset($_POST['username'], $_POST['password'])) {
    exit('Missing username and/or password');
  }
  $req = $pdo->prepare("SELECT * FROM User WHERE username = :username");
  $req->execute(["username" => $_POST["username"]]);
  if ( $req->rowCount() == 1 ) {
    $user = $req->fetch();
    if (password_verify($_POST['password'], $user['password'])) {
      session_regenerate_id();
      $_SESSION['loggedin'] = TRUE;
      $_SESSION['name'] = $_POST['username'];
      $_SESSION['id'] = $user['id'];
      header('Location: home.php');
    } else {
      echo 'Wrong credentials';
    }
  } else {
    echo 'Wrong credentials';
  }
  $pdo = null;
?>
