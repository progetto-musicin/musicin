<h2>Follower di <?php echo htmlspecialchars($dbh->getUserInfo($profile_user_id)['username']); ?></h2>
<ul class="list-group list-group-flush">
    <?php foreach ($followers as $follower): ?>
        <?php $follower_info = $dbh->getUserInfo($follower['follower_id']); ?>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <?php if (!empty($follower_info['profile_image']) && file_exists(UPLOAD_DIR . $follower_info['profile_image'])): ?>
                    <img src="<?php echo UPLOAD_DIR . htmlspecialchars($follower_info['profile_image']); ?>" alt="Immagine Profilo" class="avatar-rounded img-fluid me-3" style="width: 50px; height: 50px;">
                <?php else: ?>
                    <img src="path/to/default-image.jpg" alt="Immagine Profilo Default" class="avatar img-fluid me-3" style="width: 50px; height: 50px;">
                <?php endif; ?>
                <a href="profile.php?user_id=<?php echo htmlspecialchars($follower['follower_id']); ?>">
                    <?php echo htmlspecialchars($follower_info['username']); ?>
                </a>
            </div>
            <form method="post" class="mb-0">
                <input type="hidden" name="followed_id" value="<?php echo htmlspecialchars($follower['follower_id']); ?>">
                <?php if (isFollowing($dbh, $user_id, $follower['follower_id'])): ?>
                    <button type="submit" name="action" value="unfollow" class="btn btn-outline-danger">Smetti di seguire</button>
                <?php else: ?>
                    <button type="submit" name="action" value="follow" class="btn btn-outline-primary">Segui</button>
                <?php endif; ?>
            </form>
        </li>
    <?php endforeach; ?>
</ul>
