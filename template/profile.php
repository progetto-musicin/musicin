<?php if (empty($user)): ?>
    <h2>Utente non trovato.</h2>
<?php else: ?>
<section class="border-bottom">
    <h2><?php echo htmlspecialchars($user['username']); ?></h2>

    <!-- Immagine Profilo -->
<?php if (!empty($user['profile_image'])): ?>
    <img src="<?php echo UPLOAD_DIR . htmlspecialchars($user['profile_image']); ?>" alt="Immagine Profilo">
<?php endif; ?>

    <!-- Numero di Follower e Seguiti -->
    <ul>
        <li><a href="/followers.php?user_id=<?php echo htmlspecialchars($user_id); ?>">Followers: <?php echo htmlspecialchars($dbh->getNumFollowers($user_id)); ?></a></li>
        <li><a href="/following.php?user_id=<?php echo htmlspecialchars($user_id); ?>">Seguiti: <?php echo htmlspecialchars($dbh->getNumFollowing($user_id)); ?></a></li>
    </ul>

<?php if ($isMyProfile): ?>
    <a href="edit-profile.php">Modifica Profilo</a>
<?php endif; ?>
    <ul>
<?php if (!empty($user["name"])): ?>
        <li>Nome: <?php echo htmlspecialchars($user["name"]); ?></li>
<?php endif; ?>
<?php if (!empty($user["surname"])): ?>
        <li>Nome: <?php echo htmlspecialchars($user["surname"]); ?></li>
<?php endif; ?>
<?php if (!empty($user["genre_id"])): ?>
        <li>Genere preferito: <?php echo htmlspecialchars($dbh->getGenreName($user["genre_id"])); ?></li>
<?php endif; ?>
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
