<?php

require_once __DIR__ . '/bootstrap.php';

$_SESSION = array();
session_destroy();
header("Location: /login.html");
exit;
