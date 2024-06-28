<h2>Seguiti di <?php echo htmlspecialchars($dbh->getUserInfo($profile_user_id)['username']); ?></h2>
<ul>
    <?php foreach ($following as $followed): ?>
        <?php $followed_info = $dbh->getUserInfo($followed['followed_id']); ?>
        <li>
            <img src="<?php echo UPLOAD_DIR . htmlspecialchars($followed_info['profile_image']); ?>" alt="Immagine Profilo" style="width: 50px; height: auto;">
            <?php echo htmlspecialchars($followed_info['username']); ?>
            <form method="post">
                <input type="hidden" name="followed_id" value="<?php echo htmlspecialchars($followed['followed_id']); ?>">
                <?php if (isFollowing($dbh, $user_id, $followed['followed_id'])): ?>
                    <button type="submit" name="action" value="unfollow">Smetti di seguire</button>
                <?php else: ?>
                    <button type="submit" name="action" value="follow">Segui</button>
                <?php endif; ?>
            </form>
        </li>
    <?php endforeach; ?>
</ul>