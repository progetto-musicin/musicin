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
$following = $dbh->getFollowing($profile_user_id);

function isFollowing($dbh, $user_id, $profile_user_id) {
    $following = $dbh->getFollowing($user_id);
    foreach ($following as $follow) {
        if ($follow['followed_id'] == $profile_user_id) {
            return true;
        }
    }
    return false;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action']) && isset($_POST['followed_id'])) {
        $followed_id = $_POST['followed_id'];
        if ($_POST['action'] == 'follow') {
            // inserisce il record nella tabella follows
            $query = "INSERT INTO follows (follower_id, followed_id) VALUES (:follower_id, :followed_id)";
            $stmt = $dbh->prepare($query);
            $stmt->bindParam(':follower_id', $user_id);
            $stmt->bindParam(':followed_id', $followed_id);
            $stmt->execute();
        } elseif ($_POST['action'] == 'unfollow') {
            // elimina il record dalla tabella follows
            $query = "DELETE FROM follows WHERE follower_id = :follower_id AND followed_id = :followed_id";
            $stmt = $dbh->prepare($query);
            $stmt->bindParam(':follower_id', $user_id);
            $stmt->bindParam(':followed_id', $followed_id);
            $stmt->execute();
        }
        header("Location: following.php?user_id=$profile_user_id");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Seguiti di <?php echo htmlspecialchars($dbh->getUserInfo($profile_user_id)['username']); ?></title>
</head>
<body>
    <h1>Seguiti di <?php echo htmlspecialchars($dbh->getUserInfo($profile_user_id)['username']); ?></h1>
    <ul>
        <?php foreach ($following as $followed): ?>
            <?php $followed_info = $dbh->getUserInfo($followed['followed_id']); ?>
            <li>
                <img src="<?php echo htmlspecialchars($followed_info['profile_image']); ?>" alt="Immagine Profilo" style="width: 50px; height: auto;">
                <?php echo htmlspecialchars($followed_info['username']); ?>
                <form method="post">
                    <input type="hidden" name="followed_id" value="<?php echo htmlspecialchars($followed['followed_id']); ?>">
                    <?php if (isFollowing($dbh, $user_id, $followed['followed_id'])): ?>
                        <button type="submit" name="action" value="unfollow">Smetti di seguire</button>
                    <?php else: ?>
                        <button type="submit" name="action" value="follow">Segui</button>
                    <?php endif; ?>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
