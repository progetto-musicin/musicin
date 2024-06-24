<?php

require_once __DIR__ . "/../bootstrap.php";

$user_id = getCurrentUserId();
echo $dbh->getNumUnreadNotifications($user_id);
