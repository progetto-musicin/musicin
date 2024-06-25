<?php
require '../db/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    // verifica se l'username o l'email sono già in uso
    $sql = "SELECT COUNT(*) FROM users WHERE username = :username OR email = :email";
    $stmt = $conn->prepare($sql); 
    $stmt->bindParam(':username', $username); 
    $stmt->bindParam(':email', $email); 
    $stmt->execute();
    $count = $stmt->fetchColumn();

    if ($count > 0) {  // se username o email sono già in uso
        $error_message = "Username o email già in uso. Riprova.";
        header('Location: register.html?error=' . urlencode($error_message));
        exit();
    }

    // hash della password con una salatura automatica
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // inserisco i dati nel database
    $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
    $stmt = $conn->prepare($sql); 
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hashed_password);

    if ($stmt->execute()) {  // se l'inserimento è andato a buon fine reindirizza alla pagina di login
        echo "Registrazione avvenuta con successo!";
        header('Location: login.html');
        exit();
    } else {  // se c'è stato un errore durante l'inserimento reindirizza con un messaggio di errore
        $error_message = "Errore durante la registrazione. Riprova.";
        header('Location: register.html?error=' . urlencode($error_message));
        exit();
    }
}
?>
