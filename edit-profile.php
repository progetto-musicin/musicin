<?php

require_once __DIR__ . '/bootstrap.php';

$user_id = $_SESSION['user_id'];

$user = $dbh->getUserInfo($user_id);
$genres = $dbh->getAllGenres();

$templateParams["title"] = "Music.In - Modifica Profilo";
$templateParams["name"] = "edit-profile";
require __DIR__ . '/template/base.php';

?>