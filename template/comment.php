<article id="comment-<?php echo $comment['id']; ?>">
    <p><?php echo nl2br(htmlspecialchars($comment['content'])); ?></p>
<?php if ($user_id == $comment['user_id']): ?>
    <form action="php/processa-delete-comment.php" method="post">
        <input type="hidden" name="post_id" value="<?php echo htmlspecialchars($comment['post_id']); ?>">
        <input type="hidden" name="comment_id" value="<?php echo htmlspecialchars($comment['id']); ?>">
        <button type="submit" class="btn btn-danger"><i class="bi bi-trash"></i>Elimina Commento</button>
    </form>
<?php endif; ?>
    <p><small class="text-muted">Creato da: <a href="/profile.php?id=<?php echo $comment["user_id"] ?>"><?php echo htmlspecialchars($dbh->getUserInfo($comment['user_id'])['username']); ?></a> alle: <?php echo htmlspecialchars($comment['created_at']); ?></small></p>
</article>