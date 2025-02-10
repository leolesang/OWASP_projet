<?php
if (isset($_GET['cmd'])) {
    $cmd = $_GET['cmd'];
    $output = shell_exec($cmd);
}
?>
<!DOCTYPE html>
<html lang="fr">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link
    href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
    rel="stylesheet">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercice : Reverse Shell</title>
    <style>
        body {
            font-family: "Inter", serif;
            font-optical-sizing: auto;
            font-weight: 300;
            font-style: normal;
        }

        header {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 1em 0;
        }

        .container {
            width: 80%;
            margin: 2em auto;
            background-color: white;
            padding: 2em;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
        }

        .instructions {
            background-color: #e0e0e0;
            padding: 1em;
            border-radius: 5px;
            margin-bottom: 1em;
        }

        code {
            background-color: #f7f7f7;
            padding: 0.2em 0.4em;
            font-size: 1em;
            border-radius: 4px;
        }

        .important {
            color: #e74c3c;
            font-weight: bold;
        }

        footer {
            text-align: center;
            font-size: 0.9em;
            color: #777;
            padding: 1em;
            background-color: #333;
            color: white;
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
    <header>
        <h1 style="color: #e0e0e0;">Exercice de Reverse Shell</h1>
    </header>
    <div class="home_container">
        <img id="homeImage" src="../img/accueil.png" alt="Accueil" onclick="window.location.href='index_exercices.php'">
    </div>
    <div class="container">
        <h2>Objectif :</h2>
        <p>Dans cet exercice, vous allez apprendre à exploiter un script PHP vulnérable pour obtenir un reverse shell.</p>

        <div class="instructions">
            <h3>Instructions :</h3>
            <ul>
                <li><b>Étape 1 :</b> Analysez le code source du fichier PHP pour comprendre comment il fonctionne.</li>
                <li><b>Étape 2 :</b> Identifiez la vulnérabilité qui permet d'exécuter des commandes arbitraires sur le serveur.</li>
                <li><b>Étape 3 :</b> Exploitez la vulnérabilité en envoyant une commande PHP via l'URL pour établir un reverse shell.</li>
                <li><b>Étape 4 :</b> Surveillez votre machine et capturez le reverse shell.</li>
                <li><b>Étape 5 :</b> Gagnez l'accès complet à la machine cible.</li>
            </ul>
        </div>

        <h3>Code source vulnérable :</h3>
        <p>Le code PHP suivant est vulnérable aux injections de commandes. Il permet d'exécuter des commandes sur le serveur via le paramètre <code>cmd</code> dans l'URL :</p>

        <pre>
&lt;?php
if (isset($_GET['cmd'])) {
    $cmd = $_GET['cmd'];
    $output = shell_exec($cmd);
    echo "&lt;pre&gt;$output&lt;/pre&gt;";
}
?&gt;
        </pre>

        <p>Votre objectif est d'exploiter cette vulnérabilité pour exécuter une commande permettant de récupérer un reverse shell.</p>

        <footer>
            <p>Bonne chance ! L'exercice est terminé lorsque vous avez récupéré le flag dans /root.</p>
        </footer>
    </div>
</body>

</html>