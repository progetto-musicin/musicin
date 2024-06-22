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
    public function getPostById($post_id) {
        $query = "SELECT id as post_id, user_id, title, content, image, song, created_at FROM posts WHERE id = :post_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':post_id', $post_id);
        $stmt->execute();
        $post = $stmt->fetch(PDO::FETCH_ASSOC);
        return $post;
    }

    public function getFollowers($user_id) {
        $query = "SELECT follower_id FROM follows WHERE followed_id = :followed_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":followed_id", $user_id);
        $stmt->execute();
        $followers_ids = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $followers_ids;
    }
    public function getFollowing($user_id) {
        $query = "SELECT followed_id FROM follows WHERE follower_id = :follower_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":follower_id", $user_id);
        $stmt->execute();
        $followed_ids = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $followed_ids;
    }

    public function getNotifications($user_id) {
        $query = "SELECT id as notification_id, type, created_at, was_read, creator_id, post_id, comment_id FROM notifications WHERE receiver_id = :user_id ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $notifications;
    }

    // Restituisce il numero di follower dell'utente con l'id passato come parametro
    public function getNumFollowers($user_id) {
        $query = "SELECT COUNT(*) as num_followers FROM follows WHERE followed_id = :followed_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":followed_id", $user_id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result["num_followers"];
    }

    // Restituisce il numero di utenti seguiti dall'utente con l'id passato come parametro
    public function getNumFollowing($user_id) {
        $query = "SELECT COUNT(*) as num_following FROM follows WHERE follower_id = :follower_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":follower_id", $user_id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result["num_following"];
    }

    // Restituisce il numero di like del post con l'id passato come parametro
    public function getNumPostLikes($post_id) {
        $query = "SELECT COUNT(*) as num_likes FROM likes WHERE post_id = :post_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":post_id", $post_id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result["num_likes"];
    }

    public function createPost($user_id, $content) {
        $query = "INSERT INTO posts (user_id, content, created_at) VALUES (:user_id, :content, NOW())";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':content', $content);
        return $stmt->execute();
    }

    // Funzione privata base per creare una notifica
    private function createNotification($type, $receiver_id, $creator_id, $post_id, $comment_id) {
        $query = "INSERT INTO notifications (type, receiver_id, creator_id, post_id, comment_id) VALUES (:type, :receiver_id, :creator_id, :post_id, :comment_id)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':receiver_id', $receiver_id);
        $stmt->bindParam(':creator_id', $creator_id);
        $stmt->bindParam(':post_id', $post_id);
        $stmt->bindParam(':comment_id', $comment_id);
        return $stmt->execute();
    }
    // Crea una notifica di like per l'utente che ha creato il post
    public function createLikeNotification($creator_id, $post_id) {
        $post = getPostById($post_id);
        createNotification(NotificationType::LIKE->value, $post["user_id"], $creator_id, $post_id, NULL);
    }
    // Crea una notifica di commento per l'utente che ha creato il post
    public function createCommentNotification($creator_id, $post_id, $comment_id) {
        $post = getPostById($post_id);
        createNotification(NotificationType::COMMENT->value, $post["user_id"], $creator_id, $post_id, $comment_id);
    }
    // Crea una notifica di follow per l'utente che viene seguito
    public function createFollowNotification($followed_id, $follower_id) {
        createNotification(NotificationType::FOLLOW->value, $followed_id, $follower_id, NULL, NULL);
    }
    // Crea una notifica di nuovo post per ogni follower dell'utente che lo ha creato
    public function createPostNotification($creator_id, $post_id) { // maybe creator_id is redundant here, we could get it from the post itself
        $followers_ids = getFollowers($creator_id);
        foreach ($followers_ids as $follower_id) {
            createNotification(NotificationType::POST->value, $follower_id, $creator_id, $post_id, NULL);
        }
    }
}
?>
