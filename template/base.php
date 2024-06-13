<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title><?php echo $templateParams["titolo"]; ?></title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel='stylesheet' type='text/css' media='screen' href='/css/style-index.css'>
    <script src='/js/main.js'></script>
</head>
<body class="bg-light">
    <div class="container-fluid">
        <header>
            <div class="row">
                <h1>Music.In</h1>
                <a href="#"><i class="bi bi-bell"></i></a>
            </div>
        </header>

        <nav>
            <form class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
            <ul>
                <li><a href="index.php"><i class="bi bi-house"></i>Home</a></li>
                <li><a href="profile.php"><i class="bi bi-person"></i>Profilo</a></li> <!-- in php linka a username proprio -->
            </ul>
        </nav>

        <main>
            <?php if(isset($templateParams["nome"])) { require($templateParams["nome"] . ".php"); } ?>
        </main>

        <footer>
            <p>Copyright &copy; 2024 Music.In</p>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </div>
</body>
</html>