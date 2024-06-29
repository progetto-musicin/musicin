<article class="card card-body" id="comment-<?php echo $comment['id']; ?>">
    <p><?php echo nl2br(htmlspecialchars($comment['content'])); ?></p>
    <p><small class="text-muted">Creato da: <a href="/profile.php?id=<?php echo $comment["user_id"] ?>"><?php echo htmlspecialchars($dbh->getUserInfo($comment['user_id'])['username']); ?></a> alle: <?php echo htmlspecialchars($comment['created_at']); ?></small></p>
<?php if ($user_id == $comment['user_id']): ?>
    <!-- Elimina Commento Button trigger modal -->
    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#eliminaCommento<?php echo $comment['id']; ?>Modal">
        <i class="bi bi-trash"></i>Elimina Commento
    </button>
    <!-- Elimina Commento Modal -->
    <div class="modal fade" id="eliminaCommento<?php echo $comment['id']; ?>Modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="eliminaCommento<?php echo $comment['id']; ?>ModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="eliminaCommento<?php echo $comment['id']; ?>ModalLabel">Elimina Commento</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Confermi di voler eliminare il commento "<?php echo htmlspecialchars($comment['content']); ?>"?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                    <!-- <button type="button" class="btn btn-primary">Elimina</button> -->
                    <form action="php/processa-delete-comment.php" method="post">
                        <input type="hidden" name="post_id" value="<?php echo htmlspecialchars($comment['post_id']); ?>">
                        <input type="hidden" name="comment_id" value="<?php echo htmlspecialchars($comment['id']); ?>">
                        <button type="submit" class="btn btn-danger"><i class="bi bi-trash"></i>Elimina Commento</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
</article>