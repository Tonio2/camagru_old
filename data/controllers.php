<?php

function display_home()
{
    $imgs = get_all_images();
    print_r($_SESSION);
    $msg = $_SESSION['msg'];
    require "templates/home.php";
}

function handle_login($uname, $pwd)
{
    $status_code = login($uname, $pwd);
    if ($status_code == 0) {
        header("Location: /index.php");
    } else {
        $status_msg = ["Cannot find user", "Wrong password"];
        $msg = $status_msg[$status_code - 1];
        require "templates/login.php";
    }
}

function display_login() {
    if ($_SESSION['loggedin'] == TRUE) {
        header("Location: /index.php/home");
        exit;
    }
    require "templates/login.php";
}

function handle_logout()
{
    session_destroy();
    session_start();
    $_SESSION['msg'] = "You have successfully logged out. Hope to see you back soon ! ;)";
    header('Location: /index.php');
}

function handle_register($uname, $pwd, $mail)
{
    $status_code = register($uname, $pwd, $mail);
    $status_msg = [
        "We've created your account and sent you an email to " . $mail,
        "Sorry ! This username is already taken",
        "Please provide a valid email",
        "Please provide a valid username",
        "Your password must be between 5 and 20 characters",
        "We've created your account but we've failed to send you an email. You can try to resend it in the profile section later."
    ];
    $msg = $status_msg[$status_code];
    require "templates/register.php";
}

function display_register() {
    require 'templates/register.php';
}

function handle_activation($mail, $code) {
    $status_code = activate_account($mail, $code);
    $msg = "Hello";
    header("Location: /index.php/login");
}

// done



function handle_image_upload($user_uname, $img)
{
    $msg = add_image($user_uname, $img);
    require "templates/image_form.php";
}

function try_mail()
{
    $message = "Line 1\r\nLine 2\r\nLine 3";

    // In case any of our lines are larger than 70 characters, we should use wordwrap()
    $message = wordwrap($message, 70, "\r\n");

    // Send
    mail('labalette.freelance@gmail.com', 'My Subject', $message);
}
