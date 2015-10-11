<?php
session_start();
if ($_SESSION["auth"] != true){
    header('location: login.php');
    die("Not authenticated");
}else{
    include "pages/head.php";

    include "pages/footer.php";
}