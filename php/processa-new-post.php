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

    // Percorsi dei file caricati
    $image_path = null;
    $audio_path = null;

    // Gestione upload immagine
    if (!empty($_FILES['attachment']['name'])) {
        // $image_name = basename($_FILES['attachment']['name']);
        // $image_path = $image_name;
        // $full_path = UPLOAD_DIR_SAVE . $image_path;
        // if (!move_uploaded_file($_FILES['attachment']['tmp_name'], $full_path)) {
        //     echo "Si è verificato un errore durante il caricamento dell'immagine.";
        //     error_log("Errore caricamento immagine: " . $_FILES['attachment']['error']);
        //     error_log("Percorso destinazione immagine: " . $full_path);
        //     exit();
        // } else {
        //     // Logging per debugging
        //     error_log("Immagine caricata con successo: " . $full_path);
        // }

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
        // $audio_name = basename($_FILES['audio']['name']);
        // $audio_path = $audio_name;
        // $full_path = UPLOAD_DIR_SAVE . $audio_path;
        // if (!move_uploaded_file($_FILES['audio']['tmp_name'], $full_path)) {
        //     echo "Si è verificato un errore durante il caricamento dell'audio.";
        //     error_log("Errore caricamento audio: " . $_FILES['audio']['error']);
        //     error_log("Percorso destinazione audio: " . $full_path);
        //     exit();
        // } else {
        //     // Logging per debugging
        //     error_log("Audio caricato con successo: " . $full_path);
        // }

        list($result, $msg) = uploadSong(UPLOAD_DIR_SAVE, $_FILES['audio']);
        if ($result == 0) {
            echo("Errore caricamento immagine: " . $msg);
            error_log("Errore caricamento immagine: " . $msg);
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
