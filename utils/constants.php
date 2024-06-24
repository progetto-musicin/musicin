<?php

define("UPLOAD_DIR", __DIR__ . "/../upload/");

enum NotificationType: int {
    case LIKE = 0;
    case COMMENT = 1;
    case FOLLOW = 2;
    case POST = 3;
}

