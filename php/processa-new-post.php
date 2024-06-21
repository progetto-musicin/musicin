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
        $target_dir = __DIR__ . '/../uploads/';
        $image_path = $target_dir . basename($_FILES['attachment']['name']);
        if (!move_uploaded_file($_FILES['attachment']['tmp_name'], $image_path)) {
            echo "Si è verificato un errore durante il caricamento dell'immagine.";
            error_log("Errore caricamento immagine: " . $_FILES['attachment']['error']);
            error_log("Percorso destinazione immagine: " . $image_path);
            exit();
        } else {
            // Logging per debugging
            error_log("Immagine caricata con successo: " . $image_path);
        }
    }

    // Gestione upload audio
    if (!empty($_FILES['audio']['name'])) {
        $target_dir = __DIR__ . '/../uploads/';
        $audio_path = $target_dir . basename($_FILES['audio']['name']);
        if (!move_uploaded_file($_FILES['audio']['tmp_name'], $audio_path)) {
            echo "Si è verificato un errore durante il caricamento dell'audio.";
            error_log("Errore caricamento audio: " . $_FILES['audio']['error']);
            error_log("Percorso destinazione audio: " . $audio_path);
            exit();
        } else {
            // Logging per debugging
            error_log("Audio caricato con successo: " . $audio_path);
        }
    }

    // Salvataggio post nel database
    try {
        $stmt = $dbh->prepare("INSERT INTO posts (user_id, title, content, image, song, created_at) VALUES (:user_id, :title, :content, :image, :song, NOW())");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':image', $image_path);
        $stmt->bindParam(':song', $audio_path);
        $stmt->execute();
        header("Location: ../profile.php");
        exit();
    } catch (PDOException $e) {
        echo "Errore nella pubblicazione del post: " . $e->getMessage();
    }
}
?>
