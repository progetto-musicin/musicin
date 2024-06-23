<?php if (empty($posts)): ?>
    <p>Non sono presenti nuovi post</p>
<?php else: ?>
    <?php foreach ($posts as $post): ?>
        <!-- <div>
            <h5><?php echo htmlspecialchars($post['title']); ?></h5>
            <h6>Pubblicato da : <?php echo htmlspecialchars($post['username']); ?> alle :  <?php echo htmlspecialchars($post['created_at']); ?></h6>
            <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
        </div> -->
        <?php require __DIR__ . "/post.php" ?>
    <?php endforeach; ?>
<?php endif; ?>