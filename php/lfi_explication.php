<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SQL Injection Vulnerabilities</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            /* Light background color */
            color: #333;
            /* Dark text color */
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }

        .vuln-title {
            margin-top: 30px;
            font-size: 1.5rem;
            color: #007bff;
            /* Bootstrap primary color */
        }

        .example-code {
            background-color: #f0f0f0;
            /* Light gray for code blocks */
            padding: 10px;
            border-radius: 5px;
            overflow-x: auto;
            /* Allows scrolling for long code */
        }

        .patch-section {
            margin-top: 20px;
            padding: 10px;
            border: 1px solid #28a745;
            /* Green border for patch section */
            border-radius: 5px;
            background-color: #e9f7ef;
            /* Light green background */
        }

        .custom-form {
            max-width: 800px;
            margin: 50px auto;
            background: white;
            border-radius: 8px;
            box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
            padding: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
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

        .box {
            margin: 20px auto;
            padding: 10px;
            width: 100%;
            max-height: 300px;
            overflow-y: auto;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .alert {
            color: red;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="home_container">
        <img id="homeImage" src="../img/accueil.png" alt="Accueil" onclick="window.location.href='index_exercices.php'">
    </div>

    <div class="container">
        <h1 class="text-center mb-4">Comprendre les LFI (Local File Inclusion)</h1>

        <div class="vuln-title">C'est quoi une LFI</div>
        <p>La Local File Inclusion (LFI) est une vulnérabilité web qui permet à un attaquant d'inclure des fichiers locaux présents sur le serveur dans une page web.</p>

        <div class="vuln-title">1. Comment fonctionne une LFI ?</div>
        <br>
        <p>Une LFI se produit souvent lorsque l'application web inclut des fichiers basés sur des entrées utilisateur sans validation. </p>
        <br>
        <p>Voici un exemple simple intéractif avec le code php. Il y a une whitelist de page pour éviter de tout casser dans cette exemple.</p>
        <div class="example-code">
            <pre><code>
if (isset($_GET['file'])) {
    $file = $_GET['file'];
    $whitelist = ['../sql_explication.html'];
    if (in_array($file, $whitelist)) {
        echo "&lt;div class='box'&gt;";
        include $file;
        echo "&lt;/div&gt;";
    } else {
        echo "&lt;p class='alert'&gt;Fichier non autorisé ou introuvable.&lt;/p&gt;";
    }
}
    </code></pre>
        </div>

        <form method="GET" id="loginForm" class="custom-form">
            <div class="mb-3">
                <label for="file" class="form-label">Nom fichier</label>
                <input type="text" class="form-control" id="file" name="file" placeholder="Entrez un nom de fichier">
            </div>
            <button type="submit" class="btn btn-primary">Inclure</button>
        </form>

        <?php
        if (isset($_GET['file'])) {
            $file = $_GET['file'];
            $whitelist = ['../sql_explication.html'];
            if (in_array($file, $whitelist)) {
                echo "<div class='box'>";
                include $file;
                echo "</div>";
            } else {
                echo "<p class='alert'>Fichier non autorisé ou introuvable.</p>";
            }
        }
        ?>

        <div class="vuln-title">2. Un autre exemple</div>
        <br>
        <p>Dans cette exemple au lieu d'un include en php il utilise un header location.</p>

        <div class="example-code">
            <pre><code>
$page = $_GET['page'];
header('Location : ' .$page);
        </code></pre>
        </div>
        <br>
        <p>L'attaquant pourrait donc effectuer ces requetes.</p>
        <div class="example-code">
            <pre><code>http://exemple.com/index.php?page=../../../../etc/passwd</code></pre>
        </div>

        <div class="vuln-title">3. Comment essayer de contourner ?</div>
        <br>
        <p>Il existe plusieurs manière de contourner ces filtres comme encodage (UTF-8, double encodage, URL-encodage, ...).
            D'autre méthode comme le path truncation ou la manipulation des données. Quelques exemples :
        </p>

        <div class="example-code">
            <pre><code>
http://example.com/index.php?page=%252e%252e%252fetc%252fpasswd
http://example.com/index.php?page=%c0%ae%c0%ae/%c0%ae%c0%ae/%c0%ae%c0%ae/etc/passwd
http://example.com/index.php?page=../../../etc/passwd............[ADD MORE]
http://example.com/index.php?page=....//....//etc/passwd
http://example.com/index.php?page=..///////..////..//////etc/passwd
        </code></pre>
        </div>

        <div class="patch-section">
            <strong>Patch:</strong><br>
            <br>
            <p>- <strong>Validation des entrées utilisateur : </strong>Vérifier et limiter les valeurs possibles pour les paramètres.</p>
            <br>
            <p>- <strong>Utiliser des chemins absolus : </strong>Spécifier un répertoire fixe pour inclure des fichiers.</p>
            <br>
            <p>- <strong>Configurer le serveur : </strong>Désactiver les fonctions PHP risquées comme allow_url_include et allow_url_fopen.</p>
            <br>
            <p>- <strong>Configurer les permissions des fichiers pour limiter l'accès.</strong></p>
            <br>
            <p>- <strong>Éviter les messages d’erreur détaillés </strong></p>
        </div>
    </div>

    <script>
        function simulateSQLQuery() {
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;

            const sqlQuery = `SELECT * FROM users WHERE username = '${username}' AND password = '${password}';`;

            document.getElementById('example-code').innerHTML = `<pre><code>${sqlQuery}</code></pre>`;
        }
    </script>


    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>