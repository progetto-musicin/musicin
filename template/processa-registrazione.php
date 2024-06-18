<?php
require_once 'connessione-db.php';

// Verifica se il form è stato inviato
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $email = $_POST['email'];

    // Verifica se l'username o l'email sono già registrati
    $query_check = "SELECT COUNT(*) FROM users WHERE username = :username OR email = :email";
    $stmt_check = $dbh->prepare($query_check);
    $stmt_check->bindParam(':username', $username);
    $stmt_check->bindParam(':email', $email);
    $stmt_check->execute();

    // Debug della query (opzionale)
    if ($stmt_check->errorInfo()[0] !== '00000') {
        print_r($stmt_check->errorInfo()); // Mostra l'errore della query se presente
    }

    $count = $stmt_check->fetchColumn();

    if ($count > 0) {
        echo "Username o email già in uso.";
    } else {
        // Inserimento dell'utente nel database
        $query_insert = "INSERT INTO users (username, password, email, created_at) VALUES (:username, :password, :email, NOW())";
        $stmt_insert = $dbh->prepare($query_insert);
        $stmt_insert->bindParam(':username', $username);
        $stmt_insert->bindParam(':password', $password);
        $stmt_insert->bindParam(':email', $email);

        if ($stmt_insert->execute()) {
            // Reindirizzamento alla pagina di login dopo la registrazione
            header("Location: login.html");
            exit;
        } else {
            echo "Errore durante la registrazione: " . $stmt_insert->errorInfo()[2];
        }
    }
}


