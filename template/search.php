<h2><?php echo htmlspecialchars($templateParams["title"]); ?></h2>

<?php foreach ($templateParams["users"] as $user): ?>
    <div>
        <a href="profile.php?id=<?php echo $user['id']; ?>">
            Username: <?php echo htmlspecialchars($user['username']); ?><br>
        </a>
        Numero di follower: <?php echo $user['followers_count']; ?><br>
        Numero di seguiti: <?php echo $user['followings_count']; ?><br>
    </div>
    <br>
<?php endforeach; ?>

<?php if (empty($templateParams["users"])): ?>
    <p>Nessun utente trovato con l'ID '<?php echo htmlspecialchars($_GET['user_id'] ?? ''); ?>'</p>
<?php endif; ?>
