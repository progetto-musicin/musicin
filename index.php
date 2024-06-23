<?php

require_once __DIR__ . '/bootstrap.php';

$user_id = getCurrentUserId();

// Recupera gli ID degli utenti seguiti
$following_ids = $dbh->getFollowing($user_id);

// Recupera i post degli utenti seguiti
if (!empty($following_ids)) {
    $stmt = $dbh->prepare("SELECT posts.*, users.username FROM posts JOIN users ON posts.user_id = users.id WHERE posts.user_id IN (SELECT followed_id FROM follows WHERE follower_id = :user_id) ORDER BY posts.created_at DESC");
    $stmt->bindParam(":user_id", $user_id);
    $stmt->execute();
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $posts = [];
}

$templateParams["title"] = "Music.In - Home";
$templateParams["name"] = "feed";
require __DIR__ . '/template/base.php';

?>
