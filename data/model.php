<?php

require_once 'error.php';

function open_db()
{
    $pdo = new PDO('mysql:host=mariadb;dbname=camagr', 'root', 'camagru');
    return $pdo;
}

function  close_db(&$pdo)
{
    $pdo = null;
}

function send_mail($obj, $msg, $to)
{
    $from = 'noreply@camagru.fr';
    $headers = 'From: ' . $from . "\r\n" . 'Reply-To: ' . $from . "\r\n" . 'X-Mailer: PHP/' . phpversion() . "\r\n" . 'MIME-Version: 1.0' . "\r\n" . 'Content-Type: text/html; charset=UTF-8' . "\r\n";
    return mail($to, $obj, $msg, $headers);
}

function login($uname, $pwd)
{
    $pdo = open_db();
    $req = $pdo->prepare('SELECT * FROM User WHERE uname = :uname');
    if ($req->execute(['uname' => $uname])) {
        $user = $req->fetch();
        if ($user) {
            if (password_verify($pwd, $user['pwd'])) {
                session_regenerate_id();
                $_SESSION['loggedin'] = TRUE;
                $_SESSION['uname'] = $uname;
                $_SESSION['id'] = $user['id'];
                $_SESSION['activated'] = ($user['validation_code'] === 'activated') ? TRUE : FALSE;
                return 0;
            } else {
                return 2;
            }
        } else {
            return 1;
        }
    } else {
        throw new Exception("Cannot check User Table in database", 400);
    }
}

function register($uname, $pwd, $mail)
{
    $pdo = open_db();
    $req = $pdo->prepare('SELECT * FROM User WHERE uname = :uname');
    if ($req->execute(['uname' => $uname])) {
        if ($user = $req->fetch()) {
            return 1;
        }
        if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            return 2;
        }
        if (preg_match('/^[a-zA-Z0-9]+$/', $uname) == 0) {
            return 3;
        }
        if (strlen($pwd) > 20 || strlen($pwd) < 5) {
            return 4;
        }

        $req = $pdo->prepare('INSERT INTO User (uname, pwd, mail, validation_code) values (:uname, :pwd, :mail, :uniqid)');
        $hash = password_hash($pwd, PASSWORD_DEFAULT);
        $uniqid = uniqid();
        if ($req->execute(['uname' => $uname, 'pwd' => $hash, 'mail' => $mail, 'uniqid' => $uniqid])) {
            $obj = "Account Activation Required";
            $activation_link = 'http://localhost/index.php/activate?mail=' . $mail . '&code=' . $uniqid;
            $msg = '<p>Please click the following link to activate your account: <a href="' . $activation_link . '">' . $activation_link . '</a></p>';
            if (send_mail($obj, $msg, $mail)) {
                return 0;
            } else {
                return 5;
            }
        } else {
            throw new Exception("Error while creating user", 400);
        }
    } else {
        throw new Exception("Cannot check User Table in database", 400);
    }
}

function activate_account($mail, $code)
{
    $pdo = open_db();

    $req = $pdo->prepare('SELECT * FROM User WHERE mail = :mail AND validation_code = :code');
    if ($req->execute(['mail' => $mail, 'code' => $code])) {
        if ($req->fetch()) {
            $req = $pdo->prepare('UPDATE User SET validation_code = :newcode WHERE mail = :mail AND validation_code = :code');
            if ($req->execute(['newcode' => 'activated', 'mail' => $mail, 'code' => $code])) {
                return 0;
            } else {
                return 2;
            }
        } else {
            return 1;
        }
    } else {
        throw new Exception("Cannot check User Table in database", 400);
    }
}

function logout()
{
    session_destroy();
    header('Location: /index.php');
}

function add_image($user_uname, $img)
{
    $pdo = open_db();

    // File upload path
    $targetDir = "uploads/";
    $fileName = basename($img["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
    $req = $pdo->prepare('SELECT * FROM User WHERE uname = :uname');
    $req->execute(['uname' => $user_uname]);
    $user = $req->fetch();
    $user_id = $user['id'];

    if (!empty($img["name"])) {
        // Allow certain file formats
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
        if (in_array($fileType, $allowTypes)) {
            // Upload file to server
            if (move_uploaded_file($img["tmp_name"], $targetFilePath)) {
                // Insert image file name into database
                $req = $pdo->prepare('INSERT INTO Image (user_id, image) values (:user_id, :img)');
                if ($req->execute(['user_id' => $user_id, 'img' => $targetFilePath])) {
                    $statusMsg = "The file " . $fileName . " has been uploaded successfully.";
                } else {
                    $statusMsg = "File upload failed, please try again.";
                }
            } else {
                $statusMsg = "Sorry, there was an error uploading your file.";
            }
        } else {
            $statusMsg = 'Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.';
        }
    } else {
        $statusMsg = 'Please select a file to upload.';
    }

    // Display status message
    return $statusMsg;
}

function get_all_images()
{
    $pdo = open_db();

    $req = $pdo->prepare('SELECT * FROM Image');
    if ($req->execute()) {
        return $req->fetchAll();
    } else {
        throw new Exception("Cannot check User Table in database", 400);
    }
}
