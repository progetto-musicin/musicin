<?php

require_once __DIR__ . '/bootstrap.php';

$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

$users = [];

if (!empty($searchTerm)) {
    try {
        $stmt = $dbh->getConnection()->prepare("
            SELECT u.id, u.username, u.name, u.surname, g.name as genre, u.image as profile_image,
                   COUNT(DISTINCT f1.follower_id) AS followers_count,
                   COUNT(DISTINCT f2.followed_id) AS followings_count
            FROM users u
            LEFT JOIN follows f1 ON u.id = f1.followed_id
            LEFT JOIN follows f2 ON u.id = f2.follower_id
            LEFT JOIN genres g ON u.genre_id = g.id
            WHERE u.username LIKE :search OR u.name LIKE :search OR u.surname LIKE :search OR g.name LIKE :search
            GROUP BY u.id, u.username, u.name, u.surname, g.name, u.image
        ");
        $stmt->bindValue(':search', '%' . $searchTerm . '%', PDO::PARAM_STR);
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        die("Errore durante l'esecuzione della query: " . $e->getMessage());
    }
}

$templateParams = [
    "title" => "Risultati della Ricerca",
    "name" => "search",
    "users" => $users
];

require __DIR__ . '/template/base.php';
?>
