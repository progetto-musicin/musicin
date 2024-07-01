<?php

require_once __DIR__ . '/bootstrap.php';

$profile_user_id = $_GET['user_id'];
$following = $dbh->getFollowing($profile_user_id);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action']) && isset($_POST['followed_id'])) {
        $followed_id = $_POST['followed_id'];
        if ($_POST['action'] == 'follow') {
            // inserisce il record nella tabella follows
            $query = "INSERT INTO follows (follower_id, followed_id) VALUES (:follower_id, :followed_id)";
            $stmt = $dbh->prepare($query);
            $stmt->bindParam(':follower_id', $user_id);
            $stmt->bindParam(':followed_id', $followed_id);
            $stmt->execute();
        } elseif ($_POST['action'] == 'unfollow') {
            // elimina il record dalla tabella follows
            $query = "DELETE FROM follows WHERE follower_id = :follower_id AND followed_id = :followed_id";
            $stmt = $dbh->prepare($query);
            $stmt->bindParam(':follower_id', $user_id);
            $stmt->bindParam(':followed_id', $followed_id);
            $stmt->execute();
        }
        header("Location: following.php?user_id=$profile_user_id");
        exit();
    }
}

$templateParams["title"] = "Music.In - Seguiti di " . htmlspecialchars($dbh->getUserInfo($profile_user_id)['username']);
$templateParams["name"] = "following";
require __DIR__ . '/template/base.php';

?>