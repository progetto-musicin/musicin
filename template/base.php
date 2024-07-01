<!DOCTYPE html>
<html lang="it" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $templateParams["title"]; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel='stylesheet' type='text/css' href='css/common.css'>
<?php if (!empty($templateParams["css"])): ?>
    <link rel='stylesheet' type='text/css' href='css/<?php echo $templateParams["css"]; ?>.css'>
<?php endif; ?>
    <script src='js/common.js'></script>
<?php if (!empty($templateParams["js"])): ?>
    <script src='js/<?php echo $templateParams["js"]; ?>.js'></script>
<?php endif; ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/like.js"></script>
    <script src="js/follow.js"></script>
    <script src="js/share.js"></script>

    <link rel="icon" href="favicon.ico" type="image/x-icon">
</head>
<body class="bg-light d-flex flex-column h-100">

<?php
$username = $dbh->getUserInfo(getCurrentUserId())['username'];
$profile_image = $dbh->getUserInfo(getCurrentUserId())['profile_image'];
?>

    <div class ="position-fixed bottom-0 end-0 mb-3 me-3 z-3">
        <button class="btn btn-bd-primary py-2" onclick="topFunction()" id="scrollToTopBtn" title="Vai all'inizio della pagina">
            <span class="bi bi-arrow-up-circle"></span>
            <span class="visually-hidden">Vai all'inizio della pagina</span>
        </button>
    </div>

    <nav class="navbar navbar-expand-md navbar-light bg-light sticky-top">
        <div class="container justify-content-center border-bottom">
            <div class="col-12">
                <div class="d-flex flex-wrap">
                    <h1 class="flex-grow-1">
                        <a class="navbar-brand h1 fs-1" href="/">
                            <img src="/favicon.ico" alt="Logo Music.In" width="50" height="50">	
                            <span>Music.In</span>
                        </a>
                    </h1>
                    <div class="nav nav-pills align-items-center">
                        <a class="nav-link" href="profile.php">
                            <?php if (!empty($profile_image)): ?>
                                <img class="avatar-thumbnail img-thumbnail rounded-circle" src="<?php echo UPLOAD_DIR . htmlspecialchars($profile_image); ?>" alt="Immagine Profilo">
                            <?php else: ?>
                                <span class="bi bi-person-circle align-middle"></span>
                            <?php endif; ?>
                            <span class="d-none d-sm-inline align-middle"><?php echo htmlspecialchars($username); ?></span>
                        </a>
                        <a class="btn btn-outline-primary position-relative <?php markIfActive("notifications.php"); ?>" href="notifications.php">
                            <div class="text-nowrap">
                                <span class="bi bi-bell align-middle"></span>
                                <span class="d-none d-sm-inline ms-1 align-middle">Notifiche</span>
                                <span id="notification_counter" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-secondary">0</span>
                                <!-- <span id="notification_counter" class="border border-info px-1 rounded-pill rounded-5">0</span> -->
                                <!-- <span id="notification_counter" class="border border-info p-1">0</span> -->
                                <!-- <span id="notification_counter" class="d-flex justify-content-center align-items-center">0</span> -->
                            </div>
                        </a>
                    </div>
                </div>
                <form class="d-flex" role="search" action="search.php" method="get">
                    <label for="searchBar" class="visually-hidden">Cerca per nome o genere</label>
                    <input class="form-control me-2" type="search" id="searchBar" name="search" placeholder="Cerca per nome o genere..." aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Cerca</button>
                </form>

                <!-- <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button> -->
                <!-- <div class="px-5 navbar-collapse collapse" id="navbarCollapse"> -->
                <!-- <div class="px-5 navbar-collapse" id="navbarCollapse"> -->
                <div class="navbar-collapse" id="navbarCollapse">
                    <ul class="nav nav-pills col-12 col-lg-auto my-2 justify-content-center my-md-0 text-small">
                    <!-- <ul class="navbar-nav me-auto mb-2 mb-md-0"> -->
                        <?php
                        $navlinks = [
                            ["index.php", "bi-house", "Home"],
                            ["profile.php", "bi-person", "Profilo"],
                            ["new-post.php", "bi-plus-circle", "Nuovo Post"],
                            ["explore.php", "bi bi-music-note-list", "Esplora con SoundCloud"],
                            ["concerts.php", "bi bi-ticket-perforated", "Concerti con Ticketone"],
                            ["logout.php", "bi-box-arrow-right", "Logout"],
                        ];
                        ?>
                        <?php foreach ($navlinks as $navlink) : ?>
                            <li class="nav-item">
                                <a class="nav-link <?php markIfActive($navlink[0]); ?>" href="<?php echo $navlink[0]; ?>">
                                    <span class="bi <?php echo $navlink[1]; ?>"></span>
                                    <span class="d-none d-md-inline"><?php echo $navlink[2]; ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-shrink-0">
        <div class="container">
            <?php if(isset($templateParams["name"])) { require(__DIR__ . "/" . $templateParams["name"] . ".php"); } ?>
        </div>
    </main>

    <footer class="footer mt-auto py-3 bg-body-tertiary">
        <div class="container border-top">
            <p class="text-center text-body-secondary">Copyright &copy; 2024 Music.In</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
