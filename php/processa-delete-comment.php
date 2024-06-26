<?php

require_once __DIR__ . '/../bootstrap.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_SESSION['user_id']) && !empty($_POST['post_id']) && !empty($_POST['comment_id'])) {
        $user_id = $_SESSION['user_id'];
        $post_id = $_POST['post_id'];
        $comment_id = $_POST['comment_id'];

        $result = $dbh->deleteComment($user_id, $comment_id);

        if ($result) {
            header("Location: " . "/comments.php?post_id=" . $post_id);
            exit();
        } else {
            die("Si è verificato un errore durante l'eliminazione del commento.");
        }
    } else {
        die("Errore: Tutti i campi sono obbligatori per eliminare un commento.");
    }
}

?>