<?php
  require_once "db.php";
  session_start();
  if ( !isset($_POST["username"], $_POST["email"], $_POST["password"]) ) {
    exit('Please complete the registration form');
  }
  if ( empty($_POST["username"]) || empty($_POST["email"]) || empty($_POST["password"]) ) {
    exit('Please complete the registration form');
  }
  $req = $pdo->prepare("SELECT * FROM User WHERE username = :username");
  if ( $req->execute(["username" => $_POST["username"]]) ) {
    if ($req->rowCount() == 1) {
      echo 'User already exists';
    } else {
      if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
	      exit('Email is not valid!');
      }
      if (preg_match('/^[a-zA-Z0-9]+$/', $_POST['username']) == 0) {
        exit('Username is not valid!');
      }
      if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5) {
	      exit('Password must be between 5 and 20 characters long!');
      }

      $req = $pdo->prepare("INSERT INTO User (username, password, email) values (:username, :password, :email)");
      $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
      if ( $req->execute(["username" => $_POST["username"], "password" => $password, "email" => $_POST["email"]]) ) {
        echo 'Registration succesful';
      } else {
        echo 'Something went wrong';
      }
    }
  } else {
    echo 'Could not prepare statement';
  }
  $pdo = null;
?>

  
