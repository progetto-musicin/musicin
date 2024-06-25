<?php
require '../db/db.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    $sql = "SELECT password FROM users WHERE username = :username";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // login riuscito
        setcookie("user_logged_in", true, time() + (86400 * 30), "/"); // 86400 = 1 giorno
        header('Location: ../index.php');
        exit();
    } else {
        $error_message = "Credenziali non valide. Riprova.";
        header('Location: login.html?error=' . urlencode($error_message));
        exit();
    }
}


$html = file_get_contents('login.html');

// se c'è un errore di login, messaggio di errore
if (isset($login_error)) {
    $error_html = "<p style='color: red;'>$login_error</p>";
    $html = str_replace('<form id="loginForm"', $error_html . '<form id="loginForm"', $html);
}

echo $html;
?>
