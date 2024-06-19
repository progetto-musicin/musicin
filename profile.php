<?php

require_once __DIR__ . '/bootstrap.php';

$templateParams["title"] = "Music.In - Profilo";
$templateParams["name"] = "profile";

/**
 * Recupera le informazione dell'id passato come parametro oppure
 * del proprio se vuoto o non presente.
 */
if(empty($_GET['id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = $_GET['id'];
}

$user = $dbh->getUserInfo($user_id);
$posts = $dbh->getUserPosts($user_id);

require __DIR__ . '/template/base.php';

?>
