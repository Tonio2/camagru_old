<?php

function error($code, $msg = null) {
    $err_list = [ 400 => "Bad request", 403 => 'Acces Forbidden', 404 => "Page not found"];
    header('HTTP/1.1 ' . $code . ' Bad Request');
    require 'templates/error.php';
    exit();
}