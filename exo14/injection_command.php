<?php
$flag="OWASP{INJECTION_BYPASS_HARD}";
$output = "";
if (isset($_GET['ip'])) {
    $ip = $_GET['ip'];

if (preg_match('/[&|>;`>]/', $ip)) {
    die("Caractères interdits détectés !");
}

$blacklist = array("cmp","xargs","find","nl","file","read","printf","dd"," ", "strings", "ls", "cat", "xxd", "tac", "awk", "sed", "cut", "id", "more", "less", "tail", "head", "pwd", "rm" , "cd", "mkdir", "whoami");

foreach ($blacklist as $forbidden) {
    if (preg_match('/\b' . preg_quote($forbidden, '/') . '\b/', strtolower($ip))) {
        die("Mot interdit détecté !");
    }
}

$output = shell_exec("ping -c 2 " . $ip);
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test de ping</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">
    <style>
    body {
        font-family: "Inter", serif;
        font-optical-sizing: auto;
        font-weight: 300;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100vh;
        background-color: #f4f4f4;
        position: relative;
    }

    .home_container {
        position: absolute;
        top: 10px;
        left: 10px;
    }

    .home_container img {
        width: 50px;
        height: 50px;
        cursor: pointer;
    }

    .container {
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    input,
    button {
        padding: 10px;
        margin: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    button {
        background-color: #28a745;
        color: white;
        cursor: pointer;
    }

    pre {
        text-align: left;
        background: #eee;
        padding: 10px;
        border-radius: 4px;
    }
    </style>
</head>

<body>
    <div class="home_container">
        <img id="homeImage" src="../img/accueil.png" alt="Accueil" onclick="window.location.href='../index_exercices.php'">
    </div>
    <div class="container">
        <h2>Ping une adresse IP</h2>
        <form method="GET">
            <input type="text" name="ip" placeholder="Entrez une adresse IP" required>
            <button type="submit">Envoyer</button>
        </form>

        <?php
        if ($output) {
            echo "<pre>$output</pre>";
        }
        ?>
    </div>
</body>

</html>