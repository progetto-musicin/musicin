<h2>Centro Notifiche</h2>

<section>
    <?php if (empty($notifications)) : ?>
        <p>Non hai ancora nessuna notifica.</p>
    <?php else : ?>
        <ul>
            <?php foreach ($notifications as $notification) : ?>
                <li>
                    <?php switch ($notification['type']):
                    case NotificationType::LIKE: ?>
                        <a href="profile.php?id=<?php echo $notification['creator_id']; ?>"><?php echo $notification['username']; ?></a> ha messo mi piace al tuo <a href="post.php?id=<?php echo $notification['post_id']; ?>">post</a>.
                    <?php break; ?>
                    <?php case NotificationType::COMMENT: ?>
                        <a href="profile.php?id=<?php echo $notification['creator_id']; ?>"><?php echo $notification['username']; ?></a> ha <a href="post.php?id=<?php echo $notification["post_id"]; ?>#<?php echo $notification["comment_id"]; ?>">commentato</a> il tuo <a href="post.php?post_id=<?php echo $notification['post_id']; ?>">post</a>.
                    <?php break; ?>
                    <?php case NotificationType::FOLLOW: ?>
                        <a href="profile.php?id=<?php echo $notification['creator_id']; ?>"><?php echo $notification['username']; ?></a> ha iniziato a seguirti.
                    <?php break; ?>
                    <?php case NotificationType::POST: ?>
                        <a href="profile.php?id=<?php echo $notification['creator_id']; ?>"><?php echo $notification['username']; ?></a> ha pubblicato un nuovo <a href="post.php?id=<?php echo $notification['post_id']; ?>">post</a>.
                    <?php break; ?>
                    <?php endswitch; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</section>