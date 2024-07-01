<?php
require_once __DIR__ . '/../db/connessione-db.php';

function isValidPassword($password) {
    $lower = preg_match('/[a-z]/', $password);
    $upper = preg_match('/[A-Z]/', $password);
    $number = preg_match('/[0-9]/', $password);
    $special = preg_match('/[!@#$%^&*]/', $password);
    $length = strlen($password) >= 8;

    return $lower && $upper && $number && $special && $length;
}

// Verifica se il form è stato inviato
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    if (!isValidPassword($password)) {
        echo "La password non rispetta i criteri richiesti.";
        exit;
    }

    $passwordHashed = password_hash($password, PASSWORD_BCRYPT); //salatura della password

    // Verifica se l'username o l'email sono già registrati
    $query_check = "SELECT COUNT(*) FROM users WHERE username = :username OR email = :email";
    $stmt_check = $dbh->prepare($query_check);
    $stmt_check->bindParam(':username', $username);
    $stmt_check->bindParam(':email', $email);
    $stmt_check->execute();

    $count = $stmt_check->fetchColumn();

    if ($count > 0) {
        echo "Username o email già in uso.";
    } else {
        // Inserimento dell'utente nel database
        $query_insert = "INSERT INTO users (username, password, email) 
                         VALUES (:username, :password, :email)";
        $stmt_insert = $dbh->prepare($query_insert);
        $stmt_insert->bindParam(':username', $username);
        $stmt_insert->bindParam(':password', $passwordHashed);
        $stmt_insert->bindParam(':email', $email);

        if ($stmt_insert->execute()) {
            // Reindirizzamento alla pagina di login dopo la registrazione
            header("Location: ../login.html");
            exit;
        } else {
            echo "Errore durante la registrazione: " . $stmt_insert->errorInfo()[2];
        }
    }
}
?>
