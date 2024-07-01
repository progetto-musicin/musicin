<h2><?php echo htmlspecialchars($templateParams["title"]); ?></h2>
<div class="d-flex flex-wrap gap-2">
<?php foreach ($templateParams["users"] as $user): ?>
    <div class="card mb-3" style="max-width: 540px;">
        <a class="list-group-item" href="profile.php?id=<?php echo $user['id']; ?>">
            <div class="row g-0 align-middle justify-content-center align-items-center">
                <div class="col-md-4 p-3 justify-content-center align-middle align-items-center d-flex" style="max-width: 100pt; height:auto;">
                    <!-- <img src="..." class="img-fluid rounded-start" alt="..."> -->
                    <?php if (!empty($user['profile_image'])): ?>
                        <img class="img-fluid rounded-start" src="<?php echo UPLOAD_DIR . htmlspecialchars($user['profile_image']); ?>" alt="Immagine profilo">
                    <?php else: ?>
                        <svg xmlns="http://www.w3.org/2000/svg" width="50%" height="50%" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                            <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
                        </svg>
                    <?php endif; ?>
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <!-- <h5 class="card-title">Card title</h5> -->
                        <!-- <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p> -->
                        <!-- <p class="card-text"><small class="text-body-secondary">Last updated 3 mins ago</small></p> -->
                        <h5 class ="card-title"><?php echo htmlspecialchars($user['username']); ?></h5>
                        <div class ="card-text">Numero di follower: <span class="badge text-bg-secondary"><?php echo $user['followers_count']; ?></span></div>
                        <div class ="card-text">Numero di seguiti: <span class="badge text-bg-secondary"><?php echo $user['followings_count']; ?></span></div>
                    </div>
                </div>
            </div>
        </a>
    </div>
<?php endforeach; ?>
</div>

<?php if (empty($templateParams["users"])): ?>
    <p>Nessun utente trovato con l'ID '<?php echo htmlspecialchars($_GET['user_id'] ?? ''); ?>'</p>
<?php endif; ?>
