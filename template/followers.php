<h2>Follower di <?php echo htmlspecialchars($dbh->getUserInfo($profile_user_id)['username']); ?></h2>
<ul class="list-group list-group-flush">
    <?php foreach ($followers as $follower): ?>
        <?php $follower_info = $dbh->getUserInfo($follower['follower_id']); ?>
        <li class="list-group-item d-flex align-items-center">
            <img src="<?php echo UPLOAD_DIR . htmlspecialchars($follower_info['profile_image']); ?>" alt="Immagine Profilo" class="avatar img-fluid me-3" style="width: 50px; height: 50px;">
            <?php echo htmlspecialchars($follower_info['username']); ?>
        </li>
    <?php endforeach; ?>
</ul>
