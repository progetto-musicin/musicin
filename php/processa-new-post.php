<?php

require_once __DIR__ . "/../bootstrap.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $content = $_POST['content'];
    $user_id = $_SESSION['user_id'];

    if ($dbh->createPost($user_id, $content)) {
        // Reindirizza al profilo dopo aver pubblicato il post
        header("Location: /profile.php");
        exit();
    } else {
        echo "Errore nella pubblicazione del post.";
    }
}
