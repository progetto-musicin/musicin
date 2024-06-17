<?php
session_start();

// Verifica se l'utente è loggato
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Reindirizza alla pagina di login se l'utente non è loggato
    exit();
}

// Connessione al database
include_once "connessione-db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $content = $_POST['content'];
    $user_id = $_SESSION['user_id'];

    // Query per inserire il nuovo post nel database
    $query = "INSERT INTO posts (user_id, content, created_at) VALUES (:user_id, :content, NOW())";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':content', $content);

    if ($stmt->execute()) {
        // Reindirizza al profilo dopo aver pubblicato il post
        header("Location: my-profile.php");
        exit();
    } else {
        echo "Errore nella pubblicazione del post.";
    }
}
?>