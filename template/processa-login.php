<?php

require_once "bootstrap.php";

// Definizione delle variabili e inizializzazione con valori vuoti
$username = $password = "";
$username_err = $password_err = "";

// Processamento dei dati del form quando viene inviato
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Verifica se il campo username non è vuoto
    if (empty(trim($_POST["username"]))) {
        $username_err = "Inserisci il tuo username.";
    } else {
        $username = trim($_POST["username"]);
    }

    // Verifica se il campo password non è vuoto
    if (empty(trim($_POST["password"]))) {
        $password_err = "Inserisci la tua password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validazione delle credenziali inserite
    if (empty($username_err) && empty($password_err)) {
        // Query SQL per selezionare l'utente dal database
        $sql = "SELECT user_id, username, password FROM users WHERE username = :username";

        if ($stmt = $conn->prepare($sql)) {
            // Associa le variabili alla dichiarazione preparata come parametri
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);

            // Imposta i parametri
            $param_username = $username;

            // Esegui la dichiarazione preparata
            if ($stmt->execute()) {
                // Verifica se l'utente esiste, quindi verifica la password
                if ($stmt->rowCount() == 1) {
                    if ($row = $stmt->fetch()) {
                        $user_id = $row["user_id"];
                        $username = $row["username"];
                        $hashed_password = $row["password"];
                        if (password_verify($password, $hashed_password)) {
                            // Password corretta, avvia una nuova sessione
                            session_start();

                            // Memorizza i dati nella sessione
                            $_SESSION["user_id"] = $user_id;
                            $_SESSION["username"] = $username;

                            // Reindirizza l'utente alla pagina base.php dopo il login
                            header("location: base.php");
                            exit;
                        } else {
                            // Messaggio di errore se la password non è valida
                            $password_err = "La password che hai inserito non è valida.";
                        }
                    }
                } else {
                    // Messaggio di errore se l'username non esiste
                    $username_err = "Nessun account trovato con questo username.";
                }
            } else {
                echo "Oops! Qualcosa è andato storto. Riprova più tardi.";
            }

            // Chiudi la dichiarazione
            unset($stmt);
        }
    }

    // Chiudi la connessione
    unset($conn);
}
?>
