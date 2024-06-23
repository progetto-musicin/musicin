<!-- <section class="card mt-4">
    <div class="card-body">
        <h3 class="card-title"><?php echo htmlspecialchars($post['title']); ?></h5>
        <p class="card-text"><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
    </div>
</section> -->

<!-- <div>
    <h5><?php echo htmlspecialchars($post['title']); ?></h5>
    <h6>Pubblicato da : <?php echo htmlspecialchars($post['username']); ?> alle :  <?php echo htmlspecialchars($post['created_at']); ?></h6>
    <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
</div> -->

<article class="post" id="post-<?php echo $post['id']; ?>">
    <header>
        <h2><?php echo htmlspecialchars($post['title']); ?></h2>
<?php if (!empty($post['username'])): ?>
    <p>Pubblicato da: <?php echo htmlspecialchars($post['username']); ?> alle: <?php echo htmlspecialchars($post['created_at']); ?></p>
<?php else: ?>
        <p><?php echo htmlspecialchars($post['created_at']); ?></p>
<?php endif; ?>
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