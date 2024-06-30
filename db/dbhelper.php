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

    public function getLastInsertId() {
        return $this->conn->lastInsertId();
    }

    public function updateProfileInfo($user_id, $name, $surname, $genre_id) {
        $query = "UPDATE users SET name = :name, surname = :surname WHERE id = :user_id";
        $stmt = $this->getConnection()->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':surname', $surname);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();

        $query_genre = "UPDATE users SET genre_id = :genre_id WHERE id = :user_id";
        $stmt = $this->prepare($query_genre);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":genre_id", $genre_id);
        return $stmt->execute();
    }    

    public function updateProfileImage($user_id, $image_path) {
        $query = "UPDATE users SET image = :image_path WHERE id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':image_path', $image_path);
        $stmt->bindParam(':user_id', $user_id);
        return $stmt->execute();
    }

    public function getUserInfo($user_id) {
        $query_user = "SELECT username, email, name, surname, image as profile_image, genre_id FROM users WHERE id = :user_id";
        $stmt_user = $this->conn->prepare($query_user);
        $stmt_user->bindParam(':user_id', $user_id);
        $stmt_user->execute();
        $user = $stmt_user->fetch(PDO::FETCH_ASSOC);
        return $user;
    }

    public function getUserPosts($user_id) {
        $query = "SELECT posts.id as id, user_id, title, content, image, song, created_at FROM posts WHERE user_id = :user_id ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $posts;
    }
    public function getPostById($post_id) {
        $query = "SELECT posts.id as id, user_id, title, content, posts.image, song, created_at, users.username FROM posts JOIN users WHERE posts.id = :post_id and posts.user_id = users.id";
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

    public function isFollowing($follower_id, $followed_id) {
        $query = "SELECT COUNT(*) as count FROM follows WHERE follower_id = :follower_id AND followed_id = :followed_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':follower_id', $follower_id);
        $stmt->bindParam(':followed_id', $followed_id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] > 0;
    }

    public function followUser($follower_id, $followed_id) {
    try {
        $query = "INSERT INTO follows (follower_id, followed_id) VALUES (:follower_id, :followed_id)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':follower_id', $follower_id);
        $stmt->bindParam(':followed_id', $followed_id);
        $stmt->execute();

        $this->updateFollowerCount($followed_id);

        return true; 
    } catch (PDOException $e) {
        echo "Errore durante il follow: " . $e->getMessage();
        return false;
    }
}

private function updateFollowerCount($user_id) {
    try {
        $query = "UPDATE users SET num_followers = num_followers + 1 WHERE id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
    } catch (PDOException $e) {
        echo "Errore durante l'aggiornamento del contatore dei follower: " . $e->getMessage();
    }
}

    public function unfollowUser($follower_id, $followed_id) {
        $query = "DELETE FROM follows WHERE follower_id = :follower_id AND followed_id = :followed_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':follower_id', $follower_id);
        $stmt->bindParam(':followed_id', $followed_id);
        return $stmt->execute();
    }

    public function getNotifications($user_id) {
        $query = "SELECT id as notification_id, type, created_at, was_read, creator_id, post_id, comment_id FROM notifications WHERE receiver_id = :user_id ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $notifications;
    }

    public function getNumUnreadNotifications($user_id) {
        $query = "SELECT COUNT(*) as num_notifications FROM notifications WHERE receiver_id = :user_id AND was_read = 0";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result["num_notifications"];
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

    public function doesUserLikePost($user_id, $post_id) {
        $query = "SELECT COUNT(*) as num_likes FROM likes WHERE user_id = :user_id AND post_id = :post_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":post_id", $post_id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result["num_likes"] > 0;
    }

    public function createPost($user_id, $title, $content, $image_path, $audio_path) {
        $stmt = $this->prepare("INSERT INTO posts (user_id, title, content, image, song, created_at) VALUES (:user_id, :title, :content, :image, :song, NOW())");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':image', $image_path);
        $stmt->bindParam(':song', $audio_path);
        $result = $stmt->execute();
        if ($result) {
            $this->createPostNotification($user_id, $this->getLastInsertId());
        }
        return $result;
    }

    public function deletePost($user_id, $post_id) {
        if ($user_id != $this->getPostById($post_id)["user_id"]) {
            return false;
        }

        $this->conn->beginTransaction();

        $query_likes = "DELETE FROM likes WHERE post_id = :post_id";
        $stmt_likes = $this->conn->prepare($query_likes);
        $stmt_likes->bindParam(':post_id', $post_id);
        $res_likes = $stmt_likes->execute();

        $query_notifications_comments = "DELETE FROM notifications WHERE comment_id IN (SELECT id FROM comments WHERE post_id = :post_id)";
        $stmt_notifications_comments = $this->conn->prepare($query_notifications_comments);
        $stmt_notifications_comments->bindParam(':post_id', $post_id);
        $res_notifications_comments = $stmt_notifications_comments->execute();

        $query_comments = "DELETE FROM comments WHERE post_id = :post_id";
        $stmt_comments = $this->conn->prepare($query_comments);
        $stmt_comments->bindParam(':post_id', $post_id);
        $res_comments = $stmt_comments->execute();

        $query_notifications_post = "DELETE FROM notifications WHERE post_id = :post_id";
        $stmt_notifications_post = $this->conn->prepare($query_notifications_post);
        $stmt_notifications_post->bindParam(':post_id', $post_id);
        $res_notifications_post = $stmt_notifications_post->execute();

        $query = "DELETE FROM posts WHERE id = :post_id AND user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':post_id', $post_id);
        $stmt->bindParam(':user_id', $user_id);
        $res_posts = $stmt->execute();

        if (!$res_likes || !$res_notifications_comments || !$res_comments || !$res_notifications_post || !$res_posts) {
            $this->conn->rollBack();
            return false;
        }
        $this->conn->commit();
        return true;
    }

    public function deleteComment($user_id, $comment_id) {
        if ($user_id != $this->getCommentById($comment_id)["user_id"]) {
            return false;
        }
        $this->conn->beginTransaction();

        $query_notifications_comments = "DELETE FROM notifications WHERE comment_id = :comment_id";
        $stmt_notifications_comments = $this->conn->prepare($query_notifications_comments);
        $stmt_notifications_comments->bindParam(':comment_id', $comment_id);
        $res_notifications_comments = $stmt_notifications_comments->execute();

        $query = "DELETE FROM comments WHERE id = :comment_id AND user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':comment_id', $comment_id);
        $stmt->bindParam(':user_id', $user_id);
        $res_comment = $stmt->execute();

        if (!$res_notifications_comments || !$res_comment) {
            $this->conn->rollBack();
            return false;
        }
        $this->conn->commit();
        return true;
    }

    public function getCommentById($comment_id) {
        $query = "SELECT id, content, created_at, user_id, post_id FROM comments WHERE id = :comment_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':comment_id', $comment_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getCommentsByPostId($post_id) {
        $query = "SELECT id, content, created_at, user_id, post_id FROM comments WHERE post_id = :post_id ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':post_id', $post_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function addComment($content, $user_id, $post_id) {
        $query = "INSERT INTO comments (content, created_at, user_id, post_id) VALUES (:content, NOW(), :user_id, :post_id)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':post_id', $post_id);
        $result = $stmt->execute();
        if ($result) {
            $this->createCommentNotification($user_id, $post_id, $this->getLastInsertId());
        }
        return $result;
    }

    public function getAllGenres() {
        $query = "SELECT id, name FROM genres";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getGenreName($genre_id) {
        $query = "SELECT `name` FROM genres WHERE id = :genre_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":genre_id", $genre_id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result["name"];
    }

    public function getPostLikes($post_id) {
        $query = "SELECT u.username FROM likes l JOIN users u ON l.user_id = u.id WHERE l.post_id = :post_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":post_id", $post_id);
        $stmt->execute();
        $likes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $likes;
    }

    // Funzione privata base per creare una notifica
    private function createNotification($type, $receiver_id, $creator_id, $post_id, $comment_id) {
        if ($creator_id != $receiver_id) {
            $query = "INSERT INTO notifications (type, receiver_id, creator_id, post_id, comment_id) VALUES (:type, :receiver_id, :creator_id, :post_id, :comment_id)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':type', $type);
            $stmt->bindParam(':receiver_id', $receiver_id);
            $stmt->bindParam(':creator_id', $creator_id);
            $stmt->bindParam(':post_id', $post_id);
            $stmt->bindParam(':comment_id', $comment_id);
            $stmt->execute();
        }
    }
    // Crea una notifica di like per l'utente che ha creato il post
    public function createLikeNotification($creator_id, $post_id) {
        $post = $this->getPostById($post_id);
        $receiver_id = $post["user_id"];
        $this->createNotification(NotificationType::LIKE->value, $receiver_id, $creator_id, $post_id, NULL);
    }
    // Crea una notifica di commento per l'utente che ha creato il post
    public function createCommentNotification($creator_id, $post_id, $comment_id) {
        $post = $this->getPostById($post_id);
        $receiver_id = $post["user_id"];
        $this->createNotification(NotificationType::COMMENT->value, $receiver_id, $creator_id, $post_id, $comment_id);
    }
    // Crea una notifica di follow per l'utente che viene seguito
    public function createFollowNotification($followed_id, $follower_id) {
        $this->createNotification(NotificationType::FOLLOW->value, $followed_id, $follower_id, NULL, NULL);
    }
    // Crea una notifica di nuovo post per ogni follower dell'utente che lo ha creato
    public function createPostNotification($creator_id, $post_id) { // maybe creator_id is redundant here, we could get it from the post itself
        $followers_ids = $this->getFollowers($creator_id);
        $followers_ids = array_column($followers_ids, "follower_id");
        foreach ($followers_ids as $follower_id) {
            $this->createNotification(NotificationType::POST->value, $follower_id, $creator_id, $post_id, NULL);
        }
    }

    // Imposta una notifica come letta
    public function setNotificationRead($notification_id) {
        $query = "UPDATE notifications SET was_read = 1 WHERE id = :notification_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':notification_id', $notification_id);
        return $stmt->execute();
    }

    // Rimuove una notifica
    public function deleteNotification($user_id, $notification_id) {
        $query = "DELETE FROM notifications WHERE id = :notification_id AND receiver_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':notification_id', $notification_id);
        $stmt->bindParam(':user_id', $user_id);
        return $stmt->execute();
    }
}
?>
