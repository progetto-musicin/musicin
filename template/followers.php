<h2>Follower di <?php echo htmlspecialchars($dbh->getUserInfo($profile_user_id)['username']); ?></h2>
<ul class="list-group list-group-flush">
    <?php foreach ($followers as $follower): ?>
        <?php $user = $dbh->getUserInfo($follower['follower_id']); ?>
        <?php require __DIR__ . "/follow-follower-item.php"; ?>
    <?php endforeach; ?>
</ul>
