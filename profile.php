<?php

require_once __DIR__ . '/bootstrap.php';

/**
 * Recupera le informazione dell'id passato come parametro oppure
 * del proprio se vuoto o non presente.
 */
$isMyProfile = false;
if(empty($_GET['id'])) {
    $user_id = $_SESSION['user_id'];
    $isMyProfile = true;
} else {
    $user_id = $_GET['id'];
}

$user = $dbh->getUserInfo($user_id);
$posts = $dbh->getUserPosts($user_id);
$genres = $dbh->getAllGenres();

$templateParams["title"] = "Music.In - Profilo";
$templateParams["name"] = "profile";
require __DIR__ . '/template/base.php';

?>
