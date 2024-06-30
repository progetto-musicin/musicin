<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../bootstrap.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

if (isset($_POST['followed_id'])) {
    $followedId = $_POST['followed_id'];
    $followerId = $_SESSION['user_id'];

    $success = $dbh->followUser($followerId, $followedId);

    if ($success) {
        $dbh->createFollowNotification($followedId, $followerId);
    } else {
        echo "Errore durante il follow dell'utente.";
        exit;
    }

    header("Location: ../profile.php?id=" . $followedId);
    exit;
} else {
    echo "ID dell'utente da seguire non fornito.";
    exit;
}

