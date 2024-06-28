<?php
session_start();
//$_SESSION['user_id'] = 1; // Imposta temporaneamente l'ID utente su 1 (admin)
require_once __DIR__ . '/../db/dbhelper.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$dbh = new DatabaseHelper('localhost', 'root', '', 'music_in', '3306');
$user = $dbh->getUserInfo($user_id);

// Recupera i generi musicali disponibili dal database
$genres = $dbh->getAllGenres();

if (!$genres) {
    echo "Errore nel recupero dei generi musicali.";
    exit();
}

// Recupera il numero di follower e di seguiti
$numFollowers = $dbh->getNumFollowers($user_id);
$numFollowing = $dbh->getNumFollowing($user_id);
?>

<?php if (empty($user)): ?>
    <h2>Utente non trovato.</h2>
<?php else: ?>
<section>
    <article>
        <header>
            <img src="" alt="" /> <!-- avatar -->
            <h1><?php echo htmlspecialchars($user['username']); ?></h1>

            <!-- Immagine Profilo -->
            <img src="<?php echo htmlspecialchars($user['profile_image']); ?>" alt="Immagine Profilo">

            <!-- Numero di Follower e Seguiti -->
            <ul>
                <li><a href="template/followers.php?user_id=<?php echo htmlspecialchars($user_id); ?>">Followers: <?php echo htmlspecialchars($numFollowers); ?></a></li>
                <li><a href="template/following.php?user_id=<?php echo htmlspecialchars($user_id); ?>">Seguiti: <?php echo htmlspecialchars($numFollowing); ?></a></li>
            </ul>

        </header>
    </article>
</section>

<h2>Modifica Profilo</h2>
<form action="php/processa-profile.php" method="post" enctype="multipart/form-data">
    <label for="name">Nome:</label>
    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required><br>

    <label for="surname">Cognome:</label>
    <input type="text" id="surname" name="surname" value="<?php echo htmlspecialchars($user['surname']); ?>" required><br>

    <label for="image">Immagine Profilo:</label>
    <input type="file" id="image" name="image"><br>
    <?php if ($user['profile_image']): ?>
        <img src="<?php echo htmlspecialchars($user['profile_image']); ?>" alt="Immagine Profilo" style="width: 100px; height: auto;"><br>
    <?php endif; ?>

    <!-- Selezione del genere musicale preferito -->
    <label for="genre">Genere Musicale Preferito:</label>
    <select id="genre" name="genre">
        <?php foreach ($genres as $genre): ?>
            <option value="<?php echo $genre['id']; ?>" <?php if ($user['genre_id'] == $genre['id']) echo 'selected'; ?>><?php echo htmlspecialchars($genre['name']); ?></option>
        <?php endforeach; ?>
    </select><br>

    <input type="submit" name="submit" value="Aggiorna Profilo">
</form>

<!-- Visualizzazione dei post -->
<section class="post-grid">
    <?php
    $posts = $dbh->getUserPosts($user_id);
    foreach ($posts as $post): ?>
        <?php require __DIR__ . "/post.php"; ?>
    <?php endforeach; ?>
</section>
<?php endif; ?>
