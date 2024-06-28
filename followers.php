<?php

require_once __DIR__ . '/bootstrap.php';

$profile_user_id = $_GET['user_id'];
$followers = $dbh->getFollowers($profile_user_id);

$templateParams["title"] = "Music.In - Follower";
$templateParams["name"] = "followers";
require __DIR__ . '/template/base.php';

?>