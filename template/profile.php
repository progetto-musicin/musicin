<?php if (empty($user)): ?>
    <h2>Utente non trovato.</h2>
<?php else: ?>
<section class="border-bottom">
    <div class="d-flex justify-content-start align-items-center">
        <h2 class="pe-2"><?php echo htmlspecialchars($user['username']); ?></h2>
<?php if ($isMyProfile): ?>
    <a class="btn btn-outline-primary" href="edit-profile.php">Modifica Profilo</a>
<?php else: ?>

    <?php if (isset($_SESSION['user_id'])): ?>
            <?php if ($dbh->isFollowing($_SESSION['user_id'], $user_id)): ?>
                <form id="unfollowForm" action="php/processa-unfollow.php" method="post">
                    <input type="hidden" name="followed_id" value="<?php echo htmlspecialchars($user_id); ?>">
                    <button id="unfollowButton" type="submit" class="btn btn-outline-danger">Smetti di seguire</button>
                </form>
            <?php else: ?>
                <form id="followForm" action="php/processa-follow.php" method="post">
                    <input type="hidden" name="followed_id" value="<?php echo htmlspecialchars($user_id); ?>">
                    <button id="followButton" type="submit" class="btn btn-outline-primary">Segui</button>
                </form>
            <?php endif; ?>
        <?php else: ?>
            <a href="../profile.php" class="btn btn-primary">Accedi per seguire</a>
        <?php endif; ?>
<?php endif; ?>
    </div>
    <ul>
<?php if( (!empty($user["name"])) || (!empty($user["surname"])) ): ?>
    <li class="badge text-bg-primary">
        <?php if (!empty($user["name"])) { echo htmlspecialchars($user["name"]); if(!empty($user["surname"])) { echo htmlspecialchars(" "); } } ?>
        <?php if (!empty($user["surname"])) { echo htmlspecialchars($user["surname"]); } ?>
    </li>
<?php endif; ?>

<?php if (!empty($user["genre_id"])): ?>
    <li class="badge text-bg-primary">Genere preferito: <?php echo htmlspecialchars($dbh->getGenreName($user["genre_id"])); ?></li>
<?php endif; ?>
    </ul>

    <!-- Immagine Profilo -->
<?php if (!empty($user['profile_image'])): ?>
    <img src="<?php echo UPLOAD_DIR . htmlspecialchars($user['profile_image']); ?>" alt="Immagine Profilo" class="avatar">
<?php endif; ?>

    <!-- Numero di Follower e Seguiti -->
    <ul class="list-group list-group-horizontal" style="list-style: none;">
        <li class="p-2"><a class="btn btn-outline-primary" href="followers.php?user_id=<?php echo htmlspecialchars($user_id); ?>">Followers: <?php echo htmlspecialchars($dbh->getNumFollowers($user_id)); ?></a></li>
        <li class="p-2"><a class="btn btn-outline-primary" href="following.php?user_id=<?php echo htmlspecialchars($user_id); ?>">Seguiti: <?php echo htmlspecialchars($dbh->getNumFollowing($user_id)); ?></a></li>
    </ul>

</section>

<!-- Visualizzazione dei post -->
<section class="post-grid">
    <h2>Post</h2>
<?php if (empty($posts)): ?>
    <p>Nessun post disponibile.</p>
<?php else: ?>
    <?php foreach ($posts as $post): ?>
        <?php require __DIR__ . "/post.php" ?>
    <?php endforeach; ?>
<?php endif; ?>
</section>
<?php endif; ?>
