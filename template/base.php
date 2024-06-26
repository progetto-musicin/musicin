<!DOCTYPE html>
<html lang="it">
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
</head>
<body class="bg-light">
    <div class="container">
        <header>
            <div class="row">
                <h1><a href="/">Music.In</a></h1>
                <div class="container nav nav-pills align-items-center">
                    <a class="nav-link m-1 p-1 <?php markIfActive("notifications.php"); ?>" href="notifications.php"><i class="bi bi-bell"></i><span class="d-none d-md-inline">Notifiche:</span></a>
                    <span id="notification_counter" class="p-1">0</span>
                    <!-- <span id="notification_counter" class="border border-info px-1 rounded-pill rounded-5">0</span> -->
                    <!-- <span id="notification_counter" class="border border-info p-1">0</span> -->
                    <!-- <span id="notification_counter" class="d-flex justify-content-center align-items-center">0</span> -->
                </div>
            </div>
        </header>

        <nav class="navbar navbar-expand-md navbar-light bg-light">
            <div class="container">
                <form class="d-flex" role="search" action="search.php" method="get">
                    <select class="form-select me-2" name="search_type" aria-label="Tipo di ricerca">
                        <option value="username">Username</option>
                        <option value="genre">Genere</option>
                    </select>
                    <input class="form-control me-2" type="search" name="query" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
                <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="px-5 navbar-collapse collapse" id="navbarCollapse">
                    <ul class="nav nav-pills col-12 col-lg-auto my-2 justify-content-center my-md-0 text-small">
                    <!-- <ul class="navbar-nav me-auto mb-2 mb-md-0"> -->
                        <?php
                        $navlinks = [
                            ["index.php", "bi-house", "Home"],
                            ["profile.php", "bi-person", "Profilo"],
                            ["new-post.php", "bi-plus-circle", "Nuovo Post"],
                            ["logout.php", "bi-box-arrow-right", "Logout"],
                        ];
                        ?>
                        <?php foreach ($navlinks as $navlink) : ?>
                            <li class="nav-item">
                                <a class="nav-link <?php markIfActive($navlink[0]); ?>" href="<?php echo $navlink[0]; ?>">
                                    <i class="bi <?php echo $navlink[1]; ?>"></i>
                                    <span class=""><?php echo $navlink[2]; ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="container">
            <?php if(isset($templateParams["name"])) { require(__DIR__ . "/" . $templateParams["name"] . ".php"); } ?>
        </main>

        <div class="container">
            <footer class="py-3 my-4 border-top">
                <p class="text-center text-body-secondary">Copyright &copy; 2024 Music.In</p>
            </footer>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </div>
</body>
</html>
