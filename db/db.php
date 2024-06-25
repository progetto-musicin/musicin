<?php
$servername = "localhost";
$username = "prova123";
$password = "prova123";
$dbname = "musicin";

try {
    // Creare una nuova connessione PDO
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Impostare l'attributo PDO per generare eccezioni in caso di errore
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully"; 
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>