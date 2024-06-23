<?php if (empty($user)): ?>
    <h2>Utente non trovato.</h2>
<?php else: ?>
<section>
    <article>
        <header>
            <img src="" alt="" /> <!-- avatar -->
            <h2><?php echo htmlspecialchars($user['username']); ?></h2>

            <!-- Immagine Profilo -->
            <img src="<?php echo htmlspecialchars($user['profile_image']); ?>" alt="Immagine Profilo">

            <!-- Numero di Follower e Seguiti -->
            <ul>
                <li><a href="#">Followers: <?php echo htmlspecialchars($dbh->getNumFollowers($user_id)); ?></a></li>
                <li><a href="#">Seguiti: <?php echo htmlspecialchars($dbh->getNumFollowing($user_id)); ?></a></li>
            </ul>
        </header>
    </article>
</section>
<!-- Visualizzazione dei post -->
<section class="post-grid">
    <?php foreach ($posts as $post): ?>
        <?php require __DIR__ . "/post.php" ?>
    <?php endforeach; ?>
</section>
<?php endif; ?>