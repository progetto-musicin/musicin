<?php

require_once __DIR__ . '/../bootstrap.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_SESSION['user_id']) && !empty($_POST['post_id'])) {
        $user_id = $_SESSION['user_id'];
        $post_id = $_POST['post_id'];

        $result = $dbh->deletePost($user_id, $post_id);

        if ($result) {
            header("Location: " . "/index.php");
            exit();
        } else {
            die("Si è verificato un errore durante l'eliminazione del post.");
        }
    } else {
        die("Errore: Tutti i campi sono obbligatori per eliminare un post.");
    }
}

?>