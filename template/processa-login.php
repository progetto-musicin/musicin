<?php
session_start();
require_once '../db/connessione-db.php';

// Verifica se il form è stato inviato
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query per selezionare l'utente dal database
    $query_select = "SELECT id, username, password FROM users WHERE username = :username";
    $stmt_select = $dbh->prepare($query_select);
    $stmt_select->bindParam(':username', $username);
    $stmt_select->execute();
    $user = $stmt_select->fetch(PDO::FETCH_ASSOC);

    // Verifica se l'utente esiste e la password è corretta
    if ($user && password_verify($password, $user['password'])) {
        // Login riuscito, salva le informazioni dell'utente in sessione
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        // Reindirizzamento alla dashboard o a una pagina protetta
        header("Location: base.php");
        exit;
    } else {
        echo "Credenziali non valide. Riprova.";
    }
}
