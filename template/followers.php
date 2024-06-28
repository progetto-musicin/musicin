<?php
session_start();
//$_SESSION['user_id'] = 1; // Imposta temporaneamente l'ID utente su 1 (admin)
require_once __DIR__ . '/../db/dbhelper.php'; // Usa __DIR__ per ottenere il percorso corretto

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if (!isset($_GET['user_id'])) {
    echo "User ID non fornito.";
    exit();
}

$profile_user_id = $_GET['user_id'];
$dbh = new DatabaseHelper('localhost', 'root', '', 'music_in', '3306');
$followers = $dbh->getFollowers($profile_user_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Follower di <?php echo htmlspecialchars($dbh->getUserInfo($profile_user_id)['username']); ?></title>
</head>
<body>
    <h1>Follower di <?php echo htmlspecialchars($dbh->getUserInfo($profile_user_id)['username']); ?></h1>
    <ul>
        <?php foreach ($followers as $follower): ?>
            <?php $follower_info = $dbh->getUserInfo($follower['follower_id']); ?>
            <li>
                <img src="<?php echo htmlspecialchars($follower_info['profile_image']); ?>" alt="Immagine Profilo" style="width: 50px; height: auto;">
                <?php echo htmlspecialchars($follower_info['username']); ?>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
