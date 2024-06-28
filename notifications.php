<?php

require_once __DIR__ . '/bootstrap.php';

$notifications = $dbh->getNotifications($_SESSION["user_id"]);

$templateParams["title"] = "Music.In - Notifiche";
$templateParams["name"] = "notifications";
require __DIR__ . '/template/base.php';

?>