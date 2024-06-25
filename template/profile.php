<?php if (empty($user)): ?>
    <h2>Utente non trovato.</h2>
<?php else: ?>
<section>
    <article>
        <header>
            <h2><?php echo htmlspecialchars($user['username']); ?></h2>

            <!-- Immagine Profilo -->
            <img src="<?php echo htmlspecialchars($user['profile_image']); ?>" alt="Immagine Profilo">

            <!-- Numero di Follower e Seguiti -->
            <ul>
                <li><a href="#">Followers: <?php echo htmlspecialchars($dbh->getNumFollowers($user_id)); ?></a></li>
                <li><a href="#">Seguiti: <?php echo htmlspecialchars($dbh->getNumFollowing($user_id)); ?></a></li>
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