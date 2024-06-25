<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../bootstrap.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id']; 
    $name = $_POST['name'] ? $_POST['name'] : null;
    $surname = $_POST['surname'] ? $_POST['surname'] : null;
    $genre_id = $_POST['genre'] ? $_POST['genre'] : null;

    try {
        $dbh->updateProfileInfo($user_id, $name, $surname, $genre_id);

        header("Location: ../profile.php");
        exit();

    } catch (PDOException $e) {
        echo "Errore PDO: " . $e->getMessage();
    }
}

?>