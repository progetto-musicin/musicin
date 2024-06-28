<?php

require_once __DIR__ . '/bootstrap.php';

if (isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];
    $post = $dbh->getPostById($post_id);
    if (!$post) {
        die("Il post specificato non esiste.");
    }
    $comments = $dbh->getCommentsByPostId($post_id);
} else {
    die("Errore: Parametro post_id mancante.");
}

$templateParams["title"] = "Music.In - Commenti";
$templateParams["name"] = "comments";
require __DIR__ . '/template/base.php';

?>

/*
<?php
require_once __DIR__ . '/bootstrap.php';

if (isset($_GET['post_id'])) {
    $post_id = intval($_GET['post_id']);
    $post = $dbh->getPostById($post_id);
    if (!$post) {
        die("Il post specificato non esiste.");
    }
    $comments = $dbh->getCommentsByPostId($post_id);
} else {
    die("Errore: Parametro post_id mancante.");
}

$templateParams["title"] = "Music.In - Commenti";
$templateParams["name"] = "comments";
$templateParams["post"] = $post;
$templateParams["comments"] = $comments;
require __DIR__ . '/template/base.php';
?>
*/