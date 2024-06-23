<?php
// Abilita la visualizzazione di tutti gli errori e avvisi
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Includi il file dbhelper.php che contiene la definizione della classe DatabaseHelper
require_once __DIR__ . '/../db/dbhelper.php';


// Verifica se una sessione è già avviata
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verifica se l'utente è loggato
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.html');
    exit();
}

$user_id = $_SESSION['user_id'];

try {
    // Crea un'istanza della classe DatabaseHelper per gestire la connessione al database
    $dbh = new DatabaseHelper('localhost', 'root', '', 'music_in', '3306');

    // Recupera gli ID degli utenti seguiti
    $following = $dbh->getFollowing($user_id);

    // Estrai solo gli ID degli utenti seguiti
    $following_ids = array_map(function($follow) {
        return $follow['followed_id'];
    }, $following);

    // Recupera i post degli utenti seguiti
    if (!empty($following_ids)) {
        $placeholders = implode(',', array_fill(0, count($following_ids), '?'));
        $stmt = $dbh->conn->prepare("SELECT posts.*, users.username FROM posts JOIN users ON posts.user_id = users.id WHERE user_id IN ($placeholders) ORDER BY posts.created_at DESC");
        $stmt->execute($following_ids);
        $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $posts = [];
    }
} catch (PDOException $e) {
    echo "Connessione al database fallita: " . $e->getMessage();
    die();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feed</title>
    <link rel="stylesheet" href="">
</head>
<body>
    <div>
        <h1>Feed</h1>
        <?php if (empty($posts)): ?>
            <p>Non sono presenti nuovi post</p>
        <?php else: ?>
            <?php foreach ($posts as $post): ?>
                    <div>
                        <h5><?php echo htmlspecialchars($post['title']); ?></h5>
                        <h6>Pubblicato da : <?php echo htmlspecialchars($post['username']); ?> alle :  <?php echo htmlspecialchars($post['created_at']); ?></h6>
                        <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
                    </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>
</html>
