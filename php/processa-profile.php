<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../bootstrap.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id']; 
    $name = $_POST['name'] ? $_POST['name'] : null;
    $surname = $_POST['surname'] ? $_POST['surname'] : null;
    $genre_id = $_POST['genre'] ? $_POST['genre'] : null;

    $image = $_FILES['image'];
    if (!empty($image["name"])) {
        list($result, $msg) = uploadImage(UPLOAD_DIR_SAVE, $image);
        if($result == 1) {
            $image_path = $msg;
            $dbh->updateProfileImage($user_id, $image_path);
        } else {
            echo $msg;
            exit();
        }
    }

    try {
        $dbh->updateProfileInfo($user_id, $name, $surname, $genre_id);

        header("Location: ../profile.php");
        exit();

    } catch (PDOException $e) {
        echo "Errore PDO: " . $e->getMessage();
    }
}

?>