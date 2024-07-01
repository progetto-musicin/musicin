<li class="list-group-item d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center">
        <div class="me-3">
            <?php if (!empty($user['profile_image']) && file_exists(UPLOAD_DIR . $user['profile_image'])): ?>
                <img src="<?php echo UPLOAD_DIR . htmlspecialchars($user['profile_image']); ?>" alt="Immagine Profilo" class="avatar-rounded img-fluid" style="width: 50px; height: 50px;">
            <?php else: ?>
                <svg xmlns="http://www.w3.org/2000/svg" width="50px" height="50px" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                    <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
                </svg>
            <?php endif; ?>
        </div>
        <a href="profile.php?id=<?php echo htmlspecialchars($user['id']); ?>">
            <?php echo htmlspecialchars($user['username']); ?>
        </a>
    </div>
    <form method="post" class="mb-0">
        <input type="hidden" name="followed_id" value="<?php echo htmlspecialchars($user['id']); ?>">
        <?php if (isFollowing($dbh, getCurrentUserId(), $user['id'])): ?>
            <button type="submit" name="action" value="unfollow" class="btn btn-outline-danger">Smetti di seguire</button>
        <?php else: ?>
            <button type="submit" name="action" value="follow" class="btn btn-outline-primary">Segui</button>
        <?php endif; ?>
    </form>
</li>