<?php
// Configurazione per la connessione al database MySQL
$servername = "localhost"; // Indirizzo del server MySQL
$username = "root"; // Nome utente MySQL
$password = ""; // Password MySQL (lascia vuoto se non hai impostato una password)
$dbname = "music_in"; // Nome del database MySQL

// Connessione a MySQL utilizzando PDO
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Imposta il modo PDO di gestione degli errori su eccezione
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Imposta il set di caratteri UTF-8 per la connessione
    $conn->exec("SET NAMES utf8mb4");
    // echo "Connessione al database riuscita!";
} catch(PDOException $e) {
    echo "Connessione al database fallita: " . $e->getMessage();
    // Termina lo script se non riesci a connetterti al database
    die();
}
?>