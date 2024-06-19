<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $templateParams["title"]; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-light">
    <div class="container-fluid">
        <header>
            <div class="row">
                <h1>Music.In</h1>
                <a href="notifications.php"><i class="bi bi-bell"></i></a>
            </div>
        </header>

        <nav>
            <form class="d-flex" role="search" action="search.php" method="get">
                <select class="form-select me-2" name="search_type" aria-label="Tipo di ricerca">
                    <option value="username">Username</option>
                    <option value="genre">Genere</option>
                </select>
                <input class="form-control me-2" type="search" name="query" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
            <ul>
                <li><a href="index.php"><i class="bi bi-house"></i>Home</a></li>
                <li><a href="profile.php"><i class="bi bi-person"></i>Profilo</a></li>
                <li><a href="new-post.php"><i class="bi bi-plus-circle"></i>Nuovo Post</a></li>
                <li><a href="logout.php"><i class=""></i>Logout</a></li>
            </ul>
        </nav>

        <main>
            <?php if(isset($templateParams["name"])) { require("template/" . $templateParams["name"] . ".php"); } ?>
        </main>

        <footer>
            <p>Copyright &copy; 2024 Music.In</p>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </div>
</body>
</html>
