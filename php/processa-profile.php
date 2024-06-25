<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

require_once '../db/dbhelper.php';

if (session_status() == PHP_SESSION_NONE)
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $user_id = $_SESSION['user_id']; 
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $genre_id = $_POST['genre'];
    
        $db = new DatabaseHelper('localhost', 'root', '', 'music_in', '3306');
    
        try {
            $query = "UPDATE users SET name = :name, surname = :surname WHERE id = :user_id";
            $stmt = $db->getConnection()->prepare($query);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':surname', $surname);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();
    
            $query_check = "SELECT * FROM usergenres WHERE user_id = :user_id";
            $stmt_check = $db->getConnection()->prepare($query_check);
            $stmt_check->bindParam(':user_id', $user_id);
            $stmt_check->execute();
            $result = $stmt_check->fetch(PDO::FETCH_ASSOC);
    
            if ($result) {
                $query_update_genre = "UPDATE usergenres SET genre_id = :genre_id WHERE user_id = :user_id";
                $stmt_update_genre = $db->getConnection()->prepare($query_update_genre);
                $stmt_update_genre->bindParam(':genre_id', $genre_id);
                $stmt_update_genre->bindParam(':user_id', $user_id);
                $stmt_update_genre->execute();
            } else {
                $query_insert_genre = "INSERT INTO usergenres (user_id, genre_id) VALUES (:user_id, :genre_id)";
                $stmt_insert_genre = $db->getConnection()->prepare($query_insert_genre);
                $stmt_insert_genre->bindParam(':user_id', $user_id);
                $stmt_insert_genre->bindParam(':genre_id', $genre_id);
                $stmt_insert_genre->execute();
            }
    
            header("Location: ../profile.php");
            exit();

        } catch (PDOException $e) {
            echo "Errore PDO: " . $e->getMessage();
        }
    }
    ?>
    