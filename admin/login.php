<?php
session_start();
if (!file_exists("../config.json"))
    die("Please go to /install first");

require "../classes/config.class.php";

$dbConf = json_decode(file_get_contents("../config.json"), TRUE);

$mysqli = new mysqli(
    $dbConf["mysql"]["host"],
    $dbConf["mysql"]["username"],
    $dbConf["mysql"]["password"],
    $dbConf["mysql"]["dbname"]
);

$config = new config($mysqli, "BlueStatsAdmin");

$config->setDefault('username', 'admin');
$config->setDefault('password', 'admin');

if ((@$_POST["username"] != $config->get("username") || @$_POST["password"] != $config->get("password")) && (@$_SESSION["auth"] === FALSE || !isset($_SESSION["auth"]))) {

}
else {
    $_SESSION["auth"] = TRUE;
    header('location: index.php');
    die();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BlueStats | Admin | Login</title>
    <!-- Latest compiled and minified CSS & JS -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootswatch/3.3.4/paper/bootstrap.min.css">
    <script src="//code.jquery.com/jquery.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <style>
        body {
            padding-top: 40px;
            padding-bottom: 40px;
            background-color: #eee;
        }

        .form-signin {
            max-width: 330px;
            padding: 15px;
            margin: 0 auto;
        }

        .form-signin .form-signin-heading,
        .form-signin .checkbox {
            margin-bottom: 10px;
        }

        .form-signin .checkbox {
            font-weight: normal;
        }

        .form-signin .form-control {
            position: relative;
            height: auto;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            padding: 10px;
            font-size: 16px;
        }

        .form-signin .form-control:focus {
            z-index: 2;
        }

        .form-signin input[type="email"] {
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
        }

        .form-signin input[type="password"] {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }
    </style>
</head>
<body>
<div class="container">

    <form class="form-signin" method="post">
        <h2 class="form-signin-heading">Please sign in</h2>
        <label for="inputUser" class="sr-only">Username</label>
        <input type="text" id="inputUser" class="form-control" placeholder="Username" required="" autofocus=""
               name="username">
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" class="form-control" placeholder="Password" required=""
               name="password">
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
    </form>

</div>
</body>
</html>
