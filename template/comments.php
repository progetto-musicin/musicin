<h2>Commenti per il post "<?php echo htmlspecialchars($post['title']); ?>"</h1>

<!-- <section class="card mt-4">
    <div class="card-body">
        <h3 class="card-title"><?php echo htmlspecialchars($post['title']); ?></h5>
        <p class="card-text"><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
    </div>
</section> -->

<section>
    <?php require __DIR__ . "/post.php" ?>
</section>

<section>
    <h3 class="card-title">Aggiungi un commento</h5>
    <form method="POST" action="php/processa-commento.php">
        <div>
            <label for="content">Scrivi il tuo commento</label>
            <textarea class="form-control" id="content" name="content" rows="3" required></textarea>
        </div>
        <input type="hidden" name="post_id" value="<?php echo htmlspecialchars($post_id); ?>">
        <button type="submit" class="btn btn-primary">Commenta</button>
    </form>
</section>

<section>
    <h3>Visualizza i commenti</h5>
    <?php if (empty($comments)): ?>
        <p>Non sono presenti commenti</p>
    <?php else: ?>
        <?php foreach ($comments as $comment): ?>
            <?php require __DIR__ . "/comment.php" ?>
        <?php endforeach; ?>
    <?php endif; ?>
</section>