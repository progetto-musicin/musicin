<?php

require_once __DIR__ . '/../bootstrap.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $notification_id = $_POST["notification_id"];
    if (!empty($user_id) && !empty($notification_id)) {
        $result = $dbh->deleteNotification($user_id, $notification_id);
        if ($result) {
            header("Location: /notifications.php");
            exit();
        } else {
            die("Si è verificato un errore durante l'eliminazione della notifica.");
        }
    } else {
        die("Errore: Tutti i campi sono obbligatori per eliminare una notifica.");
    }
}

?>