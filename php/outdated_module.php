<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum - Discussions</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: "Inter", serif;
            font-optical-sizing: auto;
            font-weight: 300;
            font-style: normal;
            padding: 0;
            margin: 0;
        }

        .home_container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            padding: 10px;
        }

        .home_container img {
            width: 50px;
            height: 50px;
        }
    </style>
</head>

<body>
    <div class="home_container">
        <img id="homeImage" src="../img/accueil.png" alt="Accueil" onclick="window.location.href='index_exercices.php'">
    </div>
    <div class="container mt-5">
        <header class="d-flex justify-content-between">
            <h1>Forum des Développeurs</h1>
            <div>
                <span><strong>Bienvenue, Jean !</strong></span>
                <a href="#" class="btn btn-danger btn-sm ml-2">Déconnexion</a>
            </div>
        </header>

        <h2 class="mt-4">Discussions récentes</h2>

        <div class="list-group">
            <a href="#" class="list-group-item list-group-item-action">
                <h5 class="mb-1">Problème de sécurité dans PHP</h5>
                <p class="mb-1">Comment exploiter une vulnérabilité dans PHP ?</p>
                <small>Posté par Alice</small>
            </a>
            <a href="#" class="list-group-item list-group-item-action">
                <h5 class="mb-1">Frameworks PHP modernes</h5>
                <p class="mb-1">Quel framework PHP est le plus sécurisé ?</p>
                <small>Posté par Bob</small>
            </a>
            <a href="#" class="list-group-item list-group-item-action">
                <h5 class="mb-1">Les dernières versions de PHPUnit</h5>
                <p class="mb-1">Quel impact a la dernière mise à jour de PHPUnit ?</p>
                <small>Posté par Jean</small>
            </a>
        </div>

        <hr>

        <h3>Poster une réponse</h3>
        <form action="#" method="POST">
            <div class="mb-3">
                <label for="reply" class="form-label">Votre réponse</label>
                <textarea class="form-control" id="reply" name="reply" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Poster</button>
        </form>
        <!-- PHPUnit -->

        <footer class="mt-4 text-center">
            <p>© 2025 Forum des Développeurs - Tous droits réservés</p>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>