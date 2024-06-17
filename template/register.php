<?php
session_start();

// Connessione al database
include_once "connessione-db.php";

// Inizializzazione delle variabili per i messaggi di errore
$username = $email = "";
$username_err = $email_err = $password_err = $confirm_password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validazione dell'username
    if (empty(trim($_POST["username"]))) {
        $username_err = "Inserisci un username.";
    } else {
        // Verifica se l'username è già in uso
        $sql = "SELECT id FROM users WHERE username = :username";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $param_username = trim($_POST["username"]);
            if ($stmt->execute()) {
                if ($stmt->rowCount() > 0) {
                    $username_err = "Questo username è già in uso.";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                echo "Oops! Qualcosa è andato storto. Riprova più tardi.";
            }
            unset($stmt);
        }
    }

    // Validazione dell'email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Inserisci un indirizzo email.";
    } else {
        // Verifica se l'email è già in uso
        $sql = "SELECT id FROM users WHERE email = :email";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
            $param_email = trim($_POST["email"]);
            if ($stmt->execute()) {
                if ($stmt->rowCount() > 0) {
                    $email_err = "Questa email è già registrata.";
                } else {
                    $email = trim($_POST["email"]);
                }
            } else {
                echo "Oops! Qualcosa è andato storto. Riprova più tardi.";
            }
            unset($stmt);
        }
    }

    // Validazione della password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Inserisci una password.";
    } elseif (strlen(trim($_POST["password"])) < 8) {
        $password_err = "La password deve contenere almeno 8 caratteri.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validazione della conferma password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Conferma la password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Le password non coincidono.";
        }
    }

    // Inserimento dei dati nel database se non ci sono errori di validazione
    if (empty($username_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err)) {
        $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);

            $param_username = $username;
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Cripta la password

            if ($stmt->execute()) {
                // Registrazione riuscita, reindirizza alla pagina di login
                header("location: login.php");
            } else {
                echo "Oops! Qualcosa è andato storto. Riprova più tardi.";
            }
            unset($stmt);
        }
    }

    unset($conn);
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrazione</title>
    <style>
        .wrapper { width: 360px; padding: 20px; }
        .wrapper h2 { text-align: center; margin-bottom: 20px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { font-weight: bold; }
        .form-group input { width: 100%; padding: 8px; box-sizing: border-box; }
        .form-group span { color: red; }
        .submit-btn { width: 100%; padding: 10px; background-color: #4CAF50; border: none; color: white; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Registrazione</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" value="<?php echo $username; ?>">
                <span><?php echo $username_err; ?></span>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="<?php echo $email; ?>">
                <span><?php echo $email_err; ?></span>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password">
                <span><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <label>Conferma Password</label>
                <input type="password" name="confirm_password">
                <span><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <button type="submit" class="submit-btn">Registrati</button>
            </div>
            <p>Hai già un account? <a href="login.php">Accedi qui</a>.</p>
        </form>
    </div>
</body>
</html>
