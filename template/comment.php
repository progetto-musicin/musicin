<article id="comment-<?php echo $comment['id']; ?>">
    <p><?php echo nl2br(htmlspecialchars($comment['content'])); ?></p>
    <p><small class="text-muted">Creato da: <a href="/profile.php?id=<?php echo $comment["user_id"] ?>"><?php echo htmlspecialchars($dbh->getUserInfo($comment['user_id'])['username']); ?></a> alle: <?php echo htmlspecialchars($comment['created_at']); ?></small></p>
</article>