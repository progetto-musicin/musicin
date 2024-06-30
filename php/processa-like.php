<?php
require_once __DIR__ . "/../bootstrap.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['post_id'])) {
    $post_id = $_POST['post_id'];
    $user_id = $_SESSION['user_id'];

    if (!$dbh->doesUserLikePost($user_id, $post_id)) {  //Add Like
        $query = "INSERT INTO likes (post_id, user_id) VALUES (:post_id, :user_id)";
        $stmt = $dbh->prepare($query);
        $stmt->bindParam(':post_id', $post_id);
        $stmt->bindParam(':user_id', $user_id);
        $success = $stmt->execute();

        if ($success) {
            $dbh->createLikeNotification($user_id, $post_id);
        }

        $newLikeCount = $dbh->getNumPostLikes($post_id);

        echo json_encode(['success' => true, 'newLikeCount' => $newLikeCount, 'action' => 'like']);
    } else {  //Remove Like
        $query = "DELETE FROM likes WHERE post_id = :post_id AND user_id = :user_id";
        $stmt = $dbh->prepare($query);
        $stmt->bindParam(':post_id', $post_id);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();

        $newLikeCount = $dbh->getNumPostLikes($post_id);

        echo json_encode(['success' => true, 'newLikeCount' => $newLikeCount, 'action' => 'unlike']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Richiesta non valida']);
}
?>
