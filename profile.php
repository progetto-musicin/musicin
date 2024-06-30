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

// Funzione per verificare se l'utente loggato sta seguendo l'utente del profilo visualizzato
function isFollowing($follower_id, $followed_id, $dbh) {
    $followers = $dbh->getFollowers($followed_id);
    foreach ($followers as $follower) {
        if ($follower['follower_id'] == $follower_id) {
            return true;
        }
    }
    return false;
}

    $isFollowing = false;
if ($isLoggedIn && !$isMyProfile) {
    $isFollowing = isFollowing($loggedInUserId, $user_id, $dbh);
}

$templateParams["title"] = "Music.In - Profilo";
$templateParams["name"] = "profile";
require __DIR__ . '/template/base.php';

?>
