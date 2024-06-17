<?php

require_once "bootstrap.php";

// Recupera le informazioni dell'utente loggato
$user_id = $_SESSION['user_id'];

$user = $dbh->getUserInfo($user_id);
$posts = $dbh->getUserPosts($user_id);
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Il mio profilo</title>
</head>
<body>
    <h2>Benvenuto, <?php echo htmlspecialchars($user['username']); ?>!</h2>
    
    <!-- Immagine Profilo -->
    <img src="<?php echo htmlspecialchars($user['profile_image']); ?>" alt="Immagine Profilo">
    
    <!-- Numero di Follower e Seguiti -->
    <p>Follower: <?php echo htmlspecialchars($user['num_followers']); ?></p>
    <p>Seguiti: <?php echo htmlspecialchars($user['num_following']); ?></p>
    
    <!-- Visualizzazione dei post -->
    <div class="post-grid">
        <?php foreach ($posts as $post): ?>
            <div class="post">
                <p><?php echo htmlspecialchars($post['content']); ?></p>
                <small>Postato il: <?php echo htmlspecialchars($post['created_at']); ?></small>
            </div>
        <?php endforeach; ?>
    </div>
    
    <!-- Link per creare un nuovo post -->
    <a href="new-post.php">Nuovo Post</a>
</body>
</html>
