<h2>Centro Notifiche</h2>
<section>
    <?php if (empty($notifications)) : ?>
        <p>Non hai ancora nessuna notifica.</p>
    <?php else : ?>
        <ul>
            <?php foreach ($notifications as $notification) : ?>
                <li>
                    <!-- <p><?php echo htmlspecialchars(($notification['created_at'])); ?></p> -->
                    <p><?php echo htmlspecialchars((new DateTime($notification['created_at']))->format('d/m/Y H:i:s')); ?></p>
                    <!-- <p><?php echo htmlspecialchars((new DateTime($notification['created_at']))->format('d F Y H:i:s')); ?></p> -->
                    <p>
                        <?php switch ($notification['type']):
                        case NotificationType::LIKE->value: ?>
                            <a href="profile.php?id=<?php echo htmlspecialchars($notification['creator_id']); ?>"><?php echo htmlspecialchars($dbh->getUserInfo($notification['creator_id'])['username']); ?></a> ha messo mi piace al tuo <a href="comments.php?post_id=<?php echo htmlspecialchars($notification['post_id']); ?>"> post</a>.
                        <?php break; ?>
                        <?php case NotificationType::COMMENT->value: ?>
                            <a href="profile.php?id=<?php echo htmlspecialchars($notification['creator_id']); ?>"><?php echo htmlspecialchars($dbh->getUserInfo($notification['creator_id'])['username']); ?></a> ha <a href="comments.php?post_id=<?php echo htmlspecialchars($notification["post_id"]); ?>#comment-<?php echo htmlspecialchars($notification["comment_id"]); ?>">commentato il tuo post</a>.
                        <?php break; ?>
                        <?php case NotificationType::FOLLOW->value: ?>
                            <a href="profile.php?id=<?php echo htmlspecialchars($notification['creator_id']); ?>"><?php echo htmlspecialchars($dbh->getUserInfo($notification['creator_id'])['username']); ?></a> ha iniziato a seguirti.
                        <?php break; ?>
                        <?php case NotificationType::POST->value: ?>
                            <a href="profile.php?id=<?php echo htmlspecialchars($notification['creator_id']); ?>"><?php echo htmlspecialchars($dbh->getUserInfo($notification['creator_id'])['username']); ?></a> ha pubblicato un nuovo <a href="comments.php?post_id=<?php echo htmlspecialchars($notification['post_id']); ?>">post</a>.
                        <?php break; ?>
                        <?php endswitch; ?>
                    </p>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</section>