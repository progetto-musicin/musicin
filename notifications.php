<?php

require_once 'bootstrap.php';

$templateParams["title"] = "Notifiche";
$templateParams["name"] = "notifications";

$notifications = $dbh->getNotifications($_SESSION["user_id"]);

require 'template/base.php';

?>