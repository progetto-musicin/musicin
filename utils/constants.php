<?php

define("UPLOAD_DIR", "./upload/");

enum NotificationType: int {
    case LIKE = 0;
    case COMMENT = 1;
    case FOLLOW = 2;
    case POST = 3;
}

