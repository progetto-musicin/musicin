<h2>Follower di <?php echo htmlspecialchars($dbh->getUserInfo($profile_user_id)['username']); ?></h2>
<ul>
    <?php foreach ($followers as $follower): ?>
        <?php $follower_info = $dbh->getUserInfo($follower['follower_id']); ?>
        <li>
            <img src="<?php echo UPLOAD_DIR . htmlspecialchars($follower_info['profile_image']); ?>" alt="Immagine Profilo" style="width: 50px; height: auto;">
            <?php echo htmlspecialchars($follower_info['username']); ?>
        </li>
    <?php endforeach; ?>
</ul>