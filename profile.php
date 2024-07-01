<?php

require_once __DIR__ . '/bootstrap.php';

// Verifica se l'utente è loggato
$isLoggedIn = isset($_SESSION['user_id']);
$loggedInUserId = $isLoggedIn ? $_SESSION['user_id'] : null;

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

$isFollowing = false;
if ($isLoggedIn && !$isMyProfile) {
    $isFollowing = isFollowing($dbh, $loggedInUserId, $user_id);
}

$templateParams["title"] = "Music.In - Profilo";
$templateParams["name"] = "profile";
require __DIR__ . '/template/base.php';

?>
