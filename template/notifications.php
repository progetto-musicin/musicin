<section>
    <h2>Centro Notifiche</h2>
    <?php if (empty($notifications)) : ?>
        <p>Non hai ancora nessuna notifica.</p>
    <?php else : ?>
        <ul class="list-group">
            <?php foreach ($notifications as $notification) : ?>
                <li class="list-group-item <?php if (!$notification["was_read"]) { echo 'fw-bold';} ?>">
                    <?php /* <p><?php echo htmlspecialchars(($notification['created_at'])); ?></p> */ ?>
                    <p class=""><?php echo htmlspecialchars((new DateTime($notification['created_at']))->format('d/m/Y H:i:s')); ?></p>
                    <?php /* <p><?php echo htmlspecialchars((new DateTime($notification['created_at']))->format('d F Y H:i:s')); ?></p> */ ?>
                    <p class="">
                        <?php switch ($notification['type']):
                        case NotificationType::LIKE->value: ?>
                            <i class="bi bi-hand-thumbs-up"></i>
                            <a href="profile.php?id=<?php echo htmlspecialchars($notification['creator_id']); ?>"><?php echo htmlspecialchars($dbh->getUserInfo($notification['creator_id'])['username']); ?></a> ha messo mi piace al tuo <a href="comments.php?post_id=<?php echo htmlspecialchars($notification['post_id']); ?>"> post</a>.
                        <?php break; ?>
                        <?php case NotificationType::COMMENT->value: ?>
                            <i class="bi bi-chat"></i>
                            <a href="profile.php?id=<?php echo htmlspecialchars($notification['creator_id']); ?>"><?php echo htmlspecialchars($dbh->getUserInfo($notification['creator_id'])['username']); ?></a> ha <a href="comments.php?post_id=<?php echo htmlspecialchars($notification["post_id"]); ?>#comment-<?php echo htmlspecialchars($notification["comment_id"]); ?>">commentato il tuo post</a>.
                        <?php break; ?>
                        <?php case NotificationType::FOLLOW->value: ?>
                            <i class="bi bi-person-plus"></i>
                            <a href="profile.php?id=<?php echo htmlspecialchars($notification['creator_id']); ?>"><?php echo htmlspecialchars($dbh->getUserInfo($notification['creator_id'])['username']); ?></a> ha iniziato a seguirti.
                        <?php break; ?>
                        <?php case NotificationType::POST->value: ?>
                            <?php /* <i class="bi bi-music-note"></i> */ ?>
                            <i class="bi bi-file-plus"></i>
                            <a href="profile.php?id=<?php echo htmlspecialchars($notification['creator_id']); ?>"><?php echo htmlspecialchars($dbh->getUserInfo($notification['creator_id'])['username']); ?></a> ha pubblicato un nuovo <a href="comments.php?post_id=<?php echo htmlspecialchars($notification['post_id']); ?>">post</a>.
                        <?php break; ?>
                        <?php endswitch; ?>
                        <form action="php/processa-delete-notification.php" method="post">
                            <input type="hidden" name="notification_id" value="<?php echo htmlspecialchars($notification['notification_id']); ?>">
                            <button type="submit" class="btn btn-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </p>
                </li>
                <?php $dbh->setNotificationRead($notification["notification_id"]); ?>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</section>