<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$searchTerm = isset($_GET['query']) ? $_GET['query'] : '';

$users = [];

if (!empty($searchTerm)) {
    try {
        $stmt = $dbh->getConnection()->prepare("
            SELECT u.id, u.username, u.name, u.surname, 
                   COUNT(DISTINCT f1.follower_id) AS followers_count,
                   COUNT(DISTINCT f2.followed_id) AS followings_count
            FROM users u
            LEFT JOIN follows f1 ON u.id = f1.followed_id
            LEFT JOIN follows f2 ON u.id = f2.follower_id
            WHERE u.username LIKE :search OR u.name LIKE :search OR u.surname LIKE :search
            GROUP BY u.id, u.username, u.name, u.surname
        ");
        $stmt->bindValue(':search', '%' . $searchTerm . '%', PDO::PARAM_STR);
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        die("Errore durante l'esecuzione della query: " . $e->getMessage());
    }
}

?>

<h2>Risultati della ricerca per '<?php echo htmlspecialchars($searchTerm); ?>'</h2>

<?php foreach ($users as $user): ?>
    <div>
        <a href="profile.php?id=<?php echo $user['id']; ?>">
            Username: <?php echo htmlspecialchars($user['username']); ?><br>
        </a>
        Numero di follower: <?php echo $user['followers_count']; ?><br>
        Numero di seguiti: <?php echo $user['followings_count']; ?><br>
    </div>
    <br>
<?php endforeach; ?>

<?php if (empty($users)): ?>
    <p>Nessun utente trovato con il termine di ricerca '<?php echo htmlspecialchars($searchTerm); ?>'</p>
<?php endif; ?>
