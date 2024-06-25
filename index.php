<?php

//require_once 'bootstrap.php';

// Controlla se l'utente è loggato
if (isset($_COOKIE['user_logged_in']) && $_COOKIE['user_logged_in'] == true) {
    // Utente loggato, imposta i parametri per il feed
    $templateParams["title"] = "Music.In - Home";
    $templateParams["name"] = "feed";
    require 'template/base.php';
} else {
    // Utente non loggato, reindirizza alla pagina di login
    header('Location: template/login.html');
    exit(); // Assicurati di terminare lo script dopo il reindirizzamento
}

?>
