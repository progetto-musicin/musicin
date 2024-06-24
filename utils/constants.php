<?php

// define("UPLOAD_DIR_SAVE", $_SERVER["DOCUMENT_ROOT"] . "./upload/");
define("UPLOAD_DIR_SAVE", __DIR__ . "/../upload/");
define("UPLOAD_DIR", "./upload/");

enum NotificationType: int {
    case LIKE = 0;
    case COMMENT = 1;
    case FOLLOW = 2;
    case POST = 3;
}

