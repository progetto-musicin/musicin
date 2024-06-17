<?php
session_start();
define("UPLOAD_DIR", "./upload/");
require_once("utils/functions.php");
// require_once("db/database.php");
// $dbh = new DatabaseHelper("localhost", "root", "", "musicin", 3306);

// if (!isUserLoggedIn() && basename($_SERVER['PHP_SELF']) != 'login.php') {
//     header("Location: login.php");
//     exit;
// }
?>