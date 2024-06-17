<?php
session_start();
define("UPLOAD_DIR", "./upload/");
require_once("utils/functions.php");

if (isset($_GET['testing'])) {
    $_SESSION['user_id'] = 1;   // temporaneamente per testing
}

// Verifica se l'utente è loggato
if (!isUserLoggedIn() && basename($_SERVER['PHP_SELF']) != 'login.php') {
    header("Location: login.php"); // Reindirizza alla pagina di login se l'utente non è loggato
    exit();
}

require_once("db/connessione-db.php");

?>