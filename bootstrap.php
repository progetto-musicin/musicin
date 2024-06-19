<?php
session_start();
require_once("utils/constants.php");
require_once("utils/functions.php");

if (isset($_GET['testing'])) {
    $_SESSION['user_id'] = 1;   // temporaneamente per testing
}

// Verifica se l'utente è loggato
if (!isUserLoggedIn() && (basename($_SERVER['PHP_SELF']) != 'login.php' || basename($_SERVER['PHP_SELF']) != 'register.php')) {
    header("Location: login.php"); // Reindirizza alla pagina di login se l'utente non è loggato
    exit();
}

require_once("db/connessione-db.php");

?>