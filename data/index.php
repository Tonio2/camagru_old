<?php
require_once 'model.php';
require_once 'controllers.php';

$foo = ["bar"];
echo $foo;
print_r(error_get_last());


function myExceptionHandler ($e)
{
    error_log($e);
    http_response_code(500);
    if (filter_var(ini_get('display_errors'),FILTER_VALIDATE_BOOLEAN)) {
        echo $e;
    } else {
        echo "<h1>500 Internal Server Error</h1>
              An internal server error has been occurred.<br>
              Please try again later.";
    }
    exit;
}

set_exception_handler('myExceptionHandler');

register_shutdown_function(function ()
{
    echo 'lol';
    print_r(error_get_last());
    $error = error_get_last();
    print_r($error);
    if ($error !== null) {
        echo 'lol';
        // $e = new ErrorException(
        //     $error['message'], 0, $error['type'], $error['file'], $error['line']
        // );
        // myExceptionHandler($e);
    }
});

kdsjlfklkds();

session_start();

// Extract action
$uri = substr(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), 10);

// Handle protected routes
$private_urls = ['/upload'];
if (in_array($uri, $private_urls)) {
    if ($_SESSION['loggedin'] == FALSE) {
        throw new Exception("You must be authenticated to access this ressource", 403);
    }
    if ($_SESSION['activated'] == FALSE) {
        throw new Exception("Account not activated. Check your emails", 403);
    }
}

// Routing
if ($uri === '') {
    display_home();
} elseif ($uri === '/login') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (empty($_POST["uname"]) || empty($_POST["pwd"])) {
            throw new Exception("Please provide all fields", 400);
        } else {
            handle_login($_POST["uname"], $_POST["pwd"]);
        }
    } else {
        display_login();
    }
} elseif ($uri === '/logout') {
    handle_logout();
} elseif ($uri === '/register') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (empty($_POST["uname"]) || empty($_POST["pwd"]) || empty($_POST["mail"])) {
            throw new Exception("Please provide all fields", 400);
        } else {
            handle_register($_POST["uname"], $_POST["pwd"], $_POST["mail"]);
        }
    } else {
        display_register();
    }
} elseif ($uri === '/activate') {
    if (isset($_GET['mail'], $_GET['code'])) {
        handle_activation($_GET['mail'], $_GET['code']);
    } else {
        throw new Exception("Page Not Found", 404);
    }
}



// } elseif ('/login' === $route) {
//     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//         if (!isset($_POST["uname"], $_POST["pwd"])) {
//             error(400);
//         } else {
//             try_login($_POST["uname"], $_POST["pwd"]);
//         }
//     } else {
//         require "templates/login.php";
//     }
// } elseif ('/register' === $route) {
//     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//         if (!isset($_POST["uname"], $_POST["pwd"], $_POST["mail"])) {
//             header('HTTP/1.1 400 Bad Request');
//             echo '<html><body><h1>Bad Request</h1></body></html>';
//         } else {
//             try_register($_POST["uname"], $_POST["pwd"], $_POST['mail']);
//         }
//     } else {
//         require "templates/register.php";
//     }
// } elseif ('/logout' === $route) {
//     try_logout();
// } elseif ('/upload' === $route) {
//     if ($_SESSION['loggedin'] == TRUE) {
//         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//             handle_image_upload($_SESSION['uname'], $_FILES["file"]);
//         } else {
//             require "templates/image_form.php";
//         }
//     } else {
//         header("Location: /index.php/login");
//     }
// } else {
//     header('HTTP/1.1 404 Not Found');
//     echo '<html><body><h1>Page Not Found</h1></body></html>';
// }
