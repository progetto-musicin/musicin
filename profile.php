<?php

require_once __DIR__ . '/bootstrap.php';

// Verifica se l'utente è loggato
$isLoggedIn = isset($_SESSION['user_id']);
$loggedInUserId = $isLoggedIn ? $_SESSION['user_id'] : null;

/**
 * Recupera le informazione dell'id passato come parametro oppure
 * del proprio se vuoto o non presente.
 */
if(empty($_GET['id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = $_GET['id'];
}
$isMyProfile = getCurrentUserId() == $user_id ? true : false;

$user = $dbh->getUserInfo($user_id);
$posts = $dbh->getUserPosts($user_id);
$genres = $dbh->getAllGenres();

$templateParams["title"] = "Music.In - Profilo";
$templateParams["name"] = "profile";
require __DIR__ . '/template/base.php';

?>
