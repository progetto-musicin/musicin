<?php

require_once 'bootstrap.php';

$_SESSION = array();
session_destroy();
header("Location: /");
exit;
