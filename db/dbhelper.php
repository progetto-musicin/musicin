<?php

class DatabaseHelper {
    private $conn;

    public function __construct($servername, $username, $password, $dbname, $port) {
        // Connessione a MySQL utilizzando PDO
        try {
            $this->conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            // Imposta il modo PDO di gestione degli errori su eccezione
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // Imposta il set di caratteri UTF-8 per la connessione
            $this->conn->exec("SET NAMES utf8mb4");
            // echo "Connessione al database riuscita!";
        } catch(PDOException $e) {
            echo "Connessione al database fallita: " . $e->getMessage();
            // Termina lo script se non riesci a connetterti al database
            die();
        }
    }

    // Query per recuperare le informazioni dell'utente
    public function getUserInfo($user_id) {
        $query_user = "SELECT username, email, name, surname, image as profile_image FROM users WHERE id = :user_id";
        $stmt_user = $this->conn->prepare($query_user);
        $stmt_user->bindParam(':user_id', $user_id);
        $stmt_user->execute();
        $user = $stmt_user->fetch(PDO::FETCH_ASSOC);
        return $user;
    }

    // Query per recuperare i post dell'utente ordinati per data decrescente
    public function getUserPosts($user_id) {
        $query = "SELECT id as post_id, user_id, content, created_at FROM posts WHERE user_id = :user_id ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $posts;
    }

    public function getFollowers($user_id) {}
    public function getFollowing($user_id) {}
    public function getNotifications($user_id) {}

    public function createPost($user_id, $content) {
        // Query per inserire il nuovo post nel database
        $query = "INSERT INTO posts (user_id, content, created_at) VALUES (:user_id, :content, NOW())";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':content', $content);
        return $stmt->execute();
    }

}

?>