<?php

require_once("dbhelper.php");

// Configurazione per la connessione al database MySQL
$servername = "localhost"; // Indirizzo del server MySQL
$username = "root"; // Nome utente MySQL
$password = ""; // Password MySQL (lascia vuoto se non hai impostato una password)
$dbname = "music_in"; // Nome del database MySQL
$port = 3306; // Porta di connessione

$dbh = new DatabaseHelper($servername, $username, $password, $dbname, $port);

?>
