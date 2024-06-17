<?php
session_start();

// Verifica se l'utente è loggato, altrimenti reindirizza alla pagina di login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Includi il file di connessione al database
include_once "connessione-db.php";

// Recupera le informazioni dell'utente loggato
$user_id = $_SESSION['user_id'];

// Query per recuperare le informazioni dell'utente
$query_user = "SELECT username, num_followers, num_following, profile_image FROM users WHERE user_id = :user_id";
$stmt_user = $conn->prepare($query_user);
$stmt_user->bindParam(':user_id', $user_id);
$stmt_user->execute();
$user = $stmt_user->fetch(PDO::FETCH_ASSOC);

// Query per recuperare i post dell'utente ordinati per data decrescente
$query = "SELECT post_id, content, created_at FROM posts WHERE user_id = :user_id ORDER BY created_at DESC";
$stmt = $conn->prepare($query);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
