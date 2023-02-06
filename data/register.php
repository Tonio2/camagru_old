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

      $req = $pdo->prepare("INSERT INTO User (username, password, email, activation_code) values (:username, :password, :email, :activation_code)");
      $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
      $unique_id = uniqid();
      if ( $req->execute(["username" => $_POST["username"], "password" => $password, "email" => $_POST["email"], "activation_code" => $unique_id]) ) {
        $from    = 'noreply@camagru.com';
        $subject = 'Account Activation Required';
        $headers = 'From: ' . $from . "\r\n" . 'Reply-To: ' . $from . "\r\n" . 'X-Mailer: PHP/' . phpversion() . "\r\n" . 'MIME-Version: 1.0' . "\r\n" . 'Content-Type: text/html; charset=UTF-8' . "\r\n";
        $activate_link = 'http://yourdomain.com/phplogin/activate.php?email=' . $_POST['email'] . '&code=' . $unique_id;
        $message = '<p>Please click the following link to activate your account: <a href="' . $activate_link . '">' . $activate_link . '</a></p>';
        mail($_POST['email'], $subject, $message, $headers);
        echo 'Please check your email to activate your account!';
      } else {
        echo 'Something went wrong';
      }
    }
  } else {
    echo 'Could not prepare statement';
  }
  $pdo = null;
?>

  
