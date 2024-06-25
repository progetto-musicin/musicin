<?php
require_once __DIR__ . "/../bootstrap.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['post_id'])) {
    $post_id = $_POST['post_id'];
    $user_id = $_SESSION['user_id'];

    // Verifica se l'utente ha già messo Mi Piace a questo post
    if (!$dbh->doesUserLikePost($user_id, $post_id)) {

        $query = "INSERT INTO likes (post_id, user_id) VALUES (:post_id, :user_id)";
        $stmt = $dbh->prepare($query);
        $stmt->bindParam(':post_id', $post_id);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();

        $newLikeCount = $dbh->getNumPostLikes($post_id);


        echo json_encode(['success' => true, 'newLikeCount' => $newLikeCount]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Hai già messo Mi Piace a questo post']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Richiesta non valida']);
}
?>
