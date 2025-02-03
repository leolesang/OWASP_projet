<?php
echo "<!-- TODO : corriger la classe des user pour son username et isAdmin -->";

$message = "";
if (isset($_GET['data'])) {
    $userData = base64_decode($_GET['data']);
    if ($userData === 'O:4:"User":2:{s:8:"username";s:5:"Admin";s:7:"isAdmin";b:1;}') {
        $message = "Bienvenue, admin! Voici ton flag: OWASP{Insecure_Deserialization}";
    } else {
        if ($userData === 'O:4:"User":2:{s:8:"username";s:4:"Jean";s:7:"isAdmin";b:0;}') {
            $message = "Bonjour Jean.";
        } else {
            $message = "Données invalides.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercice : Désérialisation Non Sécurisée</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            position: relative;
            /* Permet de positionner l'image correctement */
        }

        .home_container img {
            position: absolute;
            top: 10px;
            left: 10px;
            width: 50px;
            height: 50px;
            cursor: pointer;
        }

        .container {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
            text-align: center;
        }

        h1 {
            color: #007bff;
            margin-bottom: 1rem;
        }

        p {
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }

        .example-buttons {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .result {
            margin-top: 1.5rem;
            padding: 1rem;
            background-color: #e9ecef;
            border-radius: 4px;
            font-family: monospace;
        }

        .hidden {
            display: none;
        }
    </style>
</head>

<body>
    <div class="home_container">
        <img id="homeImage" src="../img/accueil.png" alt="Accueil" onclick="window.location.href='index_exercices.php'">
    </div>
    <div class="container">
        <h1>Exercice : Désérialisation Non Sécurisée</h1>
        <p>
            <strong>Objectif :</strong> Manipulez les données sérialisées pour devenir administrateur et obtenir le flag.
        </p>
        <form method="GET">
            <div class="example-buttons">
                <input type="text" hidden name="data" value="Tzo0OiJVc2VyIjoyOntzOjg6InVzZXJuYW1lIjtzOjQ6IkplYW4iO3M6NzoiaXNBZG1pbiI7YjowO30=">
                <button type="submit">Exemple : Jean (non admin)</button>
            </div>
        </form>
        <div class="result" id="result">
            <?php if ($message) echo $message; ?>
        </div>
    </div>
</body>

</html>