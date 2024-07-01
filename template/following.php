<h2>Seguiti di <?php echo htmlspecialchars($dbh->getUserInfo($profile_user_id)['username']); ?></h2>
<ul class="list-group list-group-flush">
    <?php foreach ($following as $followed): ?>
        <?php $user = $dbh->getUserInfo($followed['followed_id']); ?>
        <?php require __DIR__ . "/follow-follower-item.php"; ?>
    <?php endforeach; ?>
</ul>
