<?php /*
<section class="card mt-4">
    <div class="card-body">
        <h3 class="card-title"><?php echo htmlspecialchars($post['title']); ?></h5>
        <p class="card-text"><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
    </div>
</section> -->

<!-- <div>
    <h5><?php echo htmlspecialchars($post['title']); ?></h5>
    <h6>Pubblicato da : <?php echo htmlspecialchars($post['username']); ?> alle :  <?php echo htmlspecialchars($post['created_at']); ?></h6>
    <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
</div>
*/ ?>

<article class="post" id="post-<?php echo $post['id']; ?>">
    <header>
        <h2><?php echo htmlspecialchars($post['title']); ?></h2>
<?php if (!empty($post['username'])): ?>
    <p>Pubblicato da: <a href="/profile.php?id=<?php echo $post["user_id"] ?>"><?php echo htmlspecialchars($post['username']); ?></a> alle: <?php echo htmlspecialchars($post['created_at']); ?></p>
<?php else: ?>
        <p><?php echo htmlspecialchars($post['created_at']); ?></p>
<?php endif; ?>
    </header>
    <div>
        <p><?php echo htmlspecialchars($post['content']); ?></p>
        
        <!-- Player audio -->
        <?php if (!empty($post['song'])): ?>
            <audio controls>
                <source src="<?php echo UPLOAD_DIR . htmlspecialchars($post['song']); ?>" type="audio/mpeg">
                Your browser does not support the audio element.
            </audio>
        <?php endif; ?>

        <!-- Immagine post -->
        <?php if (!empty($post['image'])): ?>
            <img src="<?php echo UPLOAD_DIR . htmlspecialchars($post['image']); ?>" alt="Immagine del post">
        <?php endif; ?>
    </div>

    <footer>
        <ul>
            <li>
            <button class="like-button" data-post-id="<?php echo htmlspecialchars($post['id']); ?>">
        <i class="bi bi-hand-thumbs-up"></i> Mi piace
            </button>
<span class="like-count"><?php echo htmlspecialchars($dbh->getNumPostLikes($post['id'])); ?></span>

            </li>
            <li><a href="comments.php?post_id=<?php echo htmlspecialchars($post['id']); ?>"><i class="bi bi-chat"></i> Commenti</a></li>
<?php if ($user_id == $post['user_id']): ?>
            <li>
                <!-- Elimina Post Button trigger modal -->
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#eliminaPost<?php echo $post['id']; ?>Modal">
                    <i class="bi bi-trash"></i>Elimina Post
                </button>
                <!-- Elimina Post Modal -->
                <div class="modal fade" id="eliminaPost<?php echo $post['id']; ?>Modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="eliminaPost<?php echo $post['id']; ?>ModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="eliminaPost<?php echo $post['id']; ?>ModalLabel">Elimina Post</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Confermi di voler eliminare il post con titolo "<?php echo htmlspecialchars($post['title']); ?>"?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                                <!-- <button type="button" class="btn btn-primary">Elimina</button> -->
                                <form action="php/processa-delete-post.php" method="post">
                                    <input type="hidden" name="post_id" value="<?php echo htmlspecialchars($post['id']); ?>">
                                    <button type="submit" class="btn btn-danger"><i class="bi bi-trash"></i>Elimina Post</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
<?php endif; ?>
        </ul>
    </footer>
</article>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="js/like.js"></script>