<?php

require_once __DIR__ . '/../bootstrap.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['content']) && isset($_SESSION['user_id']) && isset($_POST['post_id'])) {
        $content = $_POST['content'];
        $user_id = $_SESSION['user_id'];
        $post_id = $_POST['post_id'];

        $result = $dbh->addComment($content, $user_id, $post_id);

        if ($result) {
            header("Location: " . "/comments.php?post_id=" . $post_id);
            exit();
        } else {
            die("Si è verificato un errore durante l'aggiunta del commento.");
        }
    } else {
        die("Errore: Tutti i campi sono obbligatori per aggiungere un commento.");
    }
}

/*
<?php
require_once __DIR__ . '/../bootstrap.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['content'], $_SESSION['user_id'], $_POST['post_id'])) {
        $content = trim($_POST['content']);
        $user_id = intval($_SESSION['user_id']);
        $post_id = intval($_POST['post_id']);

        if (empty($content)) {
            die("Errore: Il contenuto del commento non può essere vuoto.");
        }

        $result = $dbh->addComment($content, $user_id, $post_id);

        if ($result) {
            header("Location: /comments.php?post_id=" . $post_id);
            exit();
        } else {
            die("Si è verificato un errore durante l'aggiunta del commento.");
        }
    } else {
        die("Errore: Tutti i campi sono obbligatori per aggiungere un commento.");
    }
}
?>
*/
