<article id="comment-<?php echo $comment['id']; ?>">
    <p><?php echo nl2br(htmlspecialchars($comment['content'])); ?></p>
    <p><small class="text-muted">Creato : <?php echo htmlspecialchars($comment['created_at']); ?></small></p>
</article>

/*
<article id="comment-<?php echo $comment['id']; ?>">
    <p><?php echo nl2br(htmlspecialchars($comment['content'])); ?></p>
    <p><small class="text-muted">Creato: <?php echo htmlspecialchars($comment['created_at']); ?></small></p>
    <?php if (isset($_SESSION['user_id']) && $comment['user_id'] == $_SESSION['user_id']): ?>
        <form method="POST" action="php/elimina-commento.php" onsubmit="return confirm('Sei sicuro di voler eliminare questo commento?');">
            <input type="hidden" name="comment_id" value="<?php echo $comment['id']; ?>">
            <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
            <button type="submit" class="btn btn-danger">Elimina</button>
        </form>
    <?php endif; ?>
</article>

*/