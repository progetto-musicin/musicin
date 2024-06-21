<?php
class DatabaseHelper {
    private $conn;

    public function __construct($servername, $username, $password, $dbname, $port) {
        // Connessione a MySQL utilizzando PDO
        try {
            $this->conn = new PDO("mysql:host=$servername;dbname=$dbname;port=$port", $username, $password);
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

    public function getConnection() {
        return $this->conn;
    }

    // Esempio di metodo per preparare una query
    public function prepare($query) {
        return $this->conn->prepare($query);
    }

    // Altri metodi...

    public function getUserInfo($user_id) {
        $query_user = "SELECT username, email, name, surname, image as profile_image FROM users WHERE id = :user_id";
        $stmt_user = $this->conn->prepare($query_user);
        $stmt_user->bindParam(':user_id', $user_id);
        $stmt_user->execute();
        $user = $stmt_user->fetch(PDO::FETCH_ASSOC);
        return $user;
    }

    public function getUserPosts($user_id) {
        $query = "SELECT id as post_id, user_id, title, content, image, song, created_at FROM posts WHERE user_id = :user_id ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $posts;
    }

    public function getFollowers($user_id) {}
    public function getFollowing($user_id) {}

    public function getNotifications($user_id) {
        $query = "SELECT id as notification_id, type, created_at, was_read, creator_id, post_id, comment_id FROM notifications WHERE receiver_id = :user_id ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $notifications;
    }

    public function createPost($user_id, $content) {
        $query = "INSERT INTO posts (user_id, content, created_at) VALUES (:user_id, :content, NOW())";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':content', $content);
        return $stmt->execute();
    }
}
?>
