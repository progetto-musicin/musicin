<?php
session_start();
require_once(__DIR__ . "/utils/constants.php");
require_once(__DIR__ . "/utils/functions.php");

if (!file_exists(UPLOAD_DIR_SAVE)) {
    if (!mkdir(UPLOAD_DIR_SAVE, 0777, true)) {
        die("Errore nella creazione della cartella di upload");
    }
}

if (!empty($_GET['testing'])) {
    $_SESSION['user_id'] = $_GET['testing'];   // temporaneamente per testing
}

$pagesWithoutLogin = [
    "login.php",
    "register.php"
];

// Verifica se l'utente è loggato
if (!isUserLoggedIn() && (!in_array(basename($_SERVER['PHP_SELF']), $pagesWithoutLogin))) {
    header("Location: /login.html"); // Reindirizza alla pagina di login se l'utente non è loggato
    exit();
}

require_once(__DIR__ . "/db/connessione-db.php");

$user_id = getCurrentUserId();

?>