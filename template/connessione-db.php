<?php
$servername = "localhost"; // Indirizzo del server MySQL
$username = "root"; // Nome utente MySQL
$password = ""; // Password MySQL (lascia vuoto se non hai impostato una password)
$dbname = "login_music_in"; // Nome del database MySQL
$port = 8883; // Porta MySQL (se diversa dalla porta predefinita)

try {
    $dbh = new PDO("mysql:host=$servername;port=$port;dbname=$dbname", $username, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbh->exec("SET NAMES utf8mb4");
    // echo "Connessione al database riuscita!";
} catch(PDOException $e) {
    echo "Connessione al database fallita: " . $e->getMessage();
    die();
}


