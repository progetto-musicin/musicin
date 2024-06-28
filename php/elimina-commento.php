<?php
require_once __DIR__ . '/../bootstrap.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['comment_id'], $_SESSION['user_id'], $_POST['post_id'])) {
        $comment_id = intval($_POST['comment_id']);
        $user_id = intval($_SESSION['user_id']);
        $post_id = intval($_POST['post_id']);

        // Verifica che l'utente sia l'autore del commento
        $comment = $dbh->getCommentById($comment_id);
        if ($comment && $comment['user_id'] == $user_id) {
            $result = $dbh->deleteComment($comment_id);
            if ($result) {
                header("Location: /comments.php?post_id=" . $post_id);
                exit();
            } else {
                die("Errore durante l'eliminazione del commento.");
            }
        } else {
            die("Errore: Non sei autorizzato a eliminare questo commento.");
        }
    } else {
        die("Errore: Parametri mancanti.");
    }
}
?>
