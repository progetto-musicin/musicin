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
        <article class="post">
            <header>
                <h2><?php echo htmlspecialchars($post['title']); ?></h2>
                <p><?php echo htmlspecialchars($post['created_at']); ?></p>
            </header>
            <section>
                <p><?php echo htmlspecialchars($post['content']); ?></p>
                
                <!-- Player audio -->
                <?php if (!empty($post['song'])): ?>
                    <audio controls>
                        <source src="<?php echo htmlspecialchars($post['song']); ?>" type="audio/mpeg">
                        Your browser does not support the audio element.
                    </audio>
                <?php endif; ?>

                <!-- Immagine post -->
                <?php if (!empty($post['image'])): ?>
                    <img src="<?php echo htmlspecialchars($post['image']); ?>" alt="Immagine del post">
                <?php endif; ?>
            </section>
            <footer>
                <ul>
                    <li><a href="#"><i class="bi bi-hand-thumbs-up"></i>Mi piace: <?php echo htmlspecialchars($dbh->getNumPostLikes($post['post_id'])); ?></a></li>
                    <li><a href="php/comments.php?post_id=<?php echo htmlspecialchars($post['post_id']); ?>"><i class="bi bi-chat"></i>Commenti</a></li>
                    </ul>
                </ul>
            </footer>
        </article>
    <?php endforeach; ?>
</section>
<?php endif; ?>