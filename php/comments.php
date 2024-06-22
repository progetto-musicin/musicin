<?php
// Abilita la visualizzazione di tutti gli errori e avvisi
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Includi il file dbhelper.php che contiene la definizione della classe DatabaseHelper
require_once '../db/dbhelper.php';

// Funzione per reindirizzare l'utente alla pagina del profilo
function redirectToProfile() {
    header("Location: ../template/profile.php");
    exit();
}

// Verifica se il metodo POST è stato utilizzato per inviare un nuovo commento
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Controlla che tutti i campi siano stati inviati correttamente
    if (isset($_POST['content']) && isset($_POST['user_id']) && isset($_POST['post_id'])) {
        // Recupera i dati inviati dal form
        $content = $_POST['content'];
        $user_id = $_POST['user_id'];
        $post_id = $_POST['post_id'];

        try {
            // Crea un'istanza della classe DatabaseHelper per gestire la connessione al database
            $dbh = new DatabaseHelper('localhost', 'root', '', 'music_in', '3306');

            // Aggiungi il commento utilizzando il metodo addComment definito in DatabaseHelper
            $result = $dbh->addComment($content, $user_id, $post_id);

            if ($result) {
                // Commento aggiunto con successo, reindirizza alla pagina del profilo
                redirectToProfile();
            } else {
                echo "Si è verificato un errore durante l'aggiunta del commento.";
            }
        } catch (PDOException $e) {
            // Gestione dell'errore di connessione al database
            echo "Connessione al database fallita: " . $e->getMessage();
        }
    } else {
        echo "Errore: Tutti i campi sono obbligatori per aggiungere un commento.";
    }
}

// Recupera il post_id dal parametro GET
if (isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];

    try {
        // Crea un'istanza della classe DatabaseHelper per gestire la connessione al database
        $dbh = new DatabaseHelper('localhost', 'root', '', 'music_in', '3306');

        // Ottieni il post specificato dal post_id utilizzando il metodo getPostById definito in DatabaseHelper
        $post = $dbh->getPostById($post_id);

        if (!$post) {
            die("Il post specificato non esiste.");
        }

        // Ottieni tutti i commenti per questo post utilizzando il metodo getCommentsByPostId definito in DatabaseHelper
        $comments = $dbh->getCommentsByPostId($post_id);
    } catch (PDOException $e) {
        // Gestione dell'errore di connessione al database
        echo "Connessione al database fallita: " . $e->getMessage();
    }
} else {
    die("Errore: Parametro post_id mancante.");
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commenti<?php echo $post_id; ?></title>

    <!-- Includi stili personalizzati -->
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
        <h1>Commenti per il post "<?php echo htmlspecialchars($post['title']); ?>"</h1>

        <!-- Visualizza il post -->
        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title"><?php echo htmlspecialchars($post['title']); ?></h5>
                <p class="card-text"><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
            </div>
        </div>

        <!-- Form per aggiungere un nuovo commento -->
            <div>
                <h5 class="card-title">Aggiungi un commento</h5>
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="form-group">
                        <label for="content">Scrivi il tuo commento</label>
                        <textarea class="form-control" id="content" name="content" rows="3" required></textarea>
                    </div>
                    <input type="hidden" name="user_id" value="1"> <!-- Esempio: l'utente con id 1 -->
                    <input type="hidden" name="post_id" value="<?php echo htmlspecialchars($post_id); ?>">
                    <button type="submit" class="btn btn-primary">Commenta</button>
                </form>
            </div>

        <!-- Visualizza tutti i commenti -->
        <div>
            <h5>Visualizza i commenti</h5>
            <?php if (empty($comments)): ?>
                <p>Non sono presenti commenti</p>
            <?php else: ?>
                <?php foreach ($comments as $comment): ?>
                        <div>
                            <p><?php echo nl2br(htmlspecialchars($comment['content'])); ?></p>
                            <p><small class="text-muted">Creato : <?php echo htmlspecialchars($comment['created_at']); ?></small></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

    <!-- Includi Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
