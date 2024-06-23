<?php if (empty($posts)): ?>
    <p>Non sono presenti nuovi post</p>
<?php else: ?>
    <?php foreach ($posts as $post): ?>
        <?php require __DIR__ . "/post.php" ?>
    <?php endforeach; ?>
<?php endif; ?>