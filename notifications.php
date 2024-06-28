<?php

require_once __DIR__ . '/bootstrap.php';

$templateParams["title"] = "Music.In - Notifiche";
$templateParams["name"] = "notifications";

$notifications = $dbh->getNotifications($_SESSION["user_id"]);

require __DIR__ . '/template/base.php';

?>