<?php
require_once __DIR__ . "/../bootstrap.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica che l'utente sia loggato
    if (!isset($_SESSION['user_id'])) {
        echo "Devi essere loggato per pubblicare un post.";
        exit();
    }

    $user_id = $_SESSION['user_id'];
    $title = $_POST['title'];
    $content = $_POST['content'];

    // Verifica che il titolo e il contenuto non siano vuoti
    if (empty($title) || empty($content)) {
        echo "Titolo e contenuto sono obbligatori.";
        exit();
    }

    // Percorsi dei file caricati
    $image_path = null;
    $audio_path = null;

    // Gestione upload immagine
    if (!empty($_FILES['attachment']['name'])) {
        list($result, $msg) = uploadImage(UPLOAD_DIR_SAVE, $_FILES['attachment']);
        if ($result == 0) {
            echo("Errore caricamento immagine: " . $msg);
            error_log("Errore caricamento immagine: " . $msg);
            exit();
        } else {
            $image_path = $msg;
        }
    }

    // Gestione upload audio
    if (!empty($_FILES['audio']['name'])) {
        list($result, $msg) = uploadSong(UPLOAD_DIR_SAVE, $_FILES['audio']);
        if ($result == 0) {
            echo("Errore caricamento audio: " . $msg);
            error_log("Errore caricamento audio: " . $msg);
            exit();
        } else {
            $audio_path = $msg;
        }
    }

    // Salvataggio post nel database
    try {
        $dbh->createPost($user_id, $title, $content, $image_path, $audio_path);
        header("Location: ../profile.php");
        exit();
    } catch (PDOException $e) {
        echo "Errore nella pubblicazione del post: " . $e->getMessage();
    }
}
?>
