<?php if (empty($user)): ?>
    <h2>Utente non trovato.</h2>
<?php else: ?>
<section>
    <article>
        <header>
            <img src="" alt="" /> <!-- avatar -->
            <h2><?php echo htmlspecialchars($user['username']); ?></h2>

            <!-- Immagine Profilo -->
            <img src="<?php echo htmlspecialchars($user['profile_image']); ?>" alt="Immagine Profilo">

            <!-- Numero di Follower e Seguiti -->
            <ul>
                <li><a href="#">Followers: <?php echo htmlspecialchars(getNumFollowers($user_id)); ?></a></li>
                <li><a href="#">Seguiti: <?php echo htmlspecialchars(getNumFollowing($user_id)); ?></a></li>
            </ul>
        </header>
    </article>
</section>
<!-- Visualizzazione dei post -->
<section class="post-grid">
    <?php foreach ($posts as $post): ?>
        <article class="post">
            <header>
                <img src="" alt="" /> <!-- avatar -->
                <h2>Title PlaceHolder</h2>
                <!-- <p>User PlaceHolder</p>  --> <!-- siamo dentro al profilo, serve specificare lo username comunque? -->
                <p><?php echo htmlspecialchars($post['created_at']); ?></p>
            </header>
            <section>
                <img src="" alt="" /> <!-- immagine post -->
                <p><?php echo htmlspecialchars($post['content']); ?></p>
            </section>
            <footer>
                <ul>
                    <li><a href="#"><i class="bi bi-hand-thumbs-up"></i>Mi piace: </a><?php echo htmlspecialchars(getPostLikes($post['post_id'])); ?></li>
                    <li><a href="#"><i class="bi bi-chat"></i>Commenti</a></li>
                </ul>
            </footer>
        </article>
    <?php endforeach; ?>
</section>
<?php endif; ?>