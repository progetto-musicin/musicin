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
            <li><a href="#"><i class="bi bi-hand-thumbs-up"></i>Mi piace: <?php echo htmlspecialchars($dbh->getNumPostLikes($post['id'])); ?></a></li>
            <li><a href="comments.php?post_id=<?php echo htmlspecialchars($post['id']); ?>"><i class="bi bi-chat"></i>Commenti</a></li>
        </ul>
    </footer>
</article>