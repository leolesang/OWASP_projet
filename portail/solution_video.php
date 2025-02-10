<?php

include('config.php');
$conn = getDbConnection();

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}


$exercise_id = isset($_GET['id']) ? $_GET['id'] : null;

if (!$exercise_id) {
    echo "ID de l'exercice manquant.";
    exit;
}

$sql = "SELECT lien FROM exercices WHERE id_exercice = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $exercise_id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($video_link);

if ($stmt->num_rows > 0) {
    $stmt->fetch();
    $video = '<iframe width="860" height="515" src="' . $video_link . '" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>';
} else {
    echo "Aucune solution vidéo disponible pour cet exercice.";
}


$stmt->close();
$conn->close();
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico">
    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/product/">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">
    <!-- Bootstrap core CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">


    <!-- Custom styles for this template -->
    <link href="../css/product.css" rel="stylesheet">
    <style>
        body {
            font-family: "Inter", serif;
            font-optical-sizing: auto;
            font-weight: 300;
            font-style: normal;
        }
    </style>
</head>

<body>

    <nav class="site-header sticky-top py-1">
        <div class="container d-flex flex-column flex-md-row justify-content-between">
            <a class="py-2" href="index_exercices.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="d-block mx-auto">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="14.31" y1="8" x2="20.05" y2="17.94"></line>
                    <line x1="9.69" y1="8" x2="21.17" y2="8"></line>
                    <line x1="7.38" y1="12" x2="13.12" y2="2.06"></line>
                    <line x1="9.69" y1="16" x2="3.95" y2="6.06"></line>
                    <line x1="14.31" y1="16" x2="2.83" y2="16"></line>
                    <line x1="16.62" y1="12" x2="10.88" y2="21.94"></line>
                </svg>
            </a>
            <a class="py-2 d-none d-md-inline-block" href="index_exercices.php"></a>
            <a class="py-2 d-none d-md-inline-block" href="index_exercices.php">Exercices</a>
            <a class="py-2 d-none d-md-inline-block" href="index_exercices.php"></a>
            <a class="py-2 d-none d-md-inline-block" href="logout.php">Déconnexion</a>
        </div>
    </nav>

    <div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center bg-light">
        <div class="col-md-5 p-lg-5 mx-auto my-5">
            <h1 class="display-4 font-weight-normal">Solution
            </h1>
            <p class="lead font-weight-normal">Voici comment résoudre l'exercice suivant.</p>
        </div>
        <div class="product-device box-shadow d-none d-md-block"></div>
        <div class="product-device product-device-2 box-shadow d-none d-md-block"></div>
    </div>

    <div class="d-md-flex flex-md-equal w-100 my-md-3 pl-md-3">
        <div class="bg-dark mr-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center text-white overflow-hidden">
            <div class="my-3 py-3">
                <h2 class="display-5">Dernière chance</h2>
                <p class="lead">La solution est a utiliser en dernier recours. Vous pouvez vous aider avec l'indice dans l'exercice ou relire les explications.</p>
            </div>
            <?php
            echo $video;
            ?>

        </div>
    </div>

</body>

</html>