<?php

// Clé secrète pour signer le JWT
$secret_key = "secret123";
if (!isset($_COOKIE['auth_token2'])) {
    // Création du JWT manuellement pour l'utilisateur "Jean"
    $header = base64_encode(json_encode(["alg" => "HS256", "typ" => "JWT"]));
    $payload = base64_encode(json_encode(["username" => "Jean", "role" => "user"]));
    $signature = base64_encode(hash_hmac('sha256', "$header.$payload", $secret_key, true));

    $jwt = "$header.$payload.$signature";
    setcookie("auth_token2", $jwt, time() + 3600, "/");
}

// Vérification du JWT et affichage du flag si admin
$flag = "OWASP{JWT_HACKED_LEVEL_2}";
$decoded = null;

if (isset($_COOKIE['auth_token2'])) {
    $token_parts = explode('.', $_COOKIE['auth_token2']);
    if (count($token_parts) === 3) {
        list($header_b64, $payload_b64, $signature_b64) = $token_parts;
        $decoded_header = json_decode(base64_decode($header_b64), true);
        if (isset($decoded_header['alg']) && $decoded_header['alg'] === "none") {
            // Accepter JWT sans signature si l'algorithme est "none"
            $decoded = json_decode(base64_decode($payload_b64));
        } else {
            // Vérifier la signature si l'algorithme est "HS256"
            $expected_signature = base64_encode(hash_hmac('sha256', "$header_b64.$payload_b64", $secret_key, true));
            if (hash_equals($expected_signature, $signature_b64)) {
                $decoded = json_decode(base64_decode($payload_b64));
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">
    <title>Forum Basique</title>
    <style>
        body {
            font-family: "Inter", serif;
            font-optical-sizing: auto;
            font-weight: 300;
            font-style: normal;
            padding: 0;
            margin: 0;
        }

        /* Navbar */
        nav {
            background-color: #333;
            color: white;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        nav img {
            width: 50px;
            height: 50px;
            cursor: pointer;
        }

        nav a {
            color: white;
            margin: 0 20px;
            text-decoration: none;
        }

        nav a:hover {
            text-decoration: underline;
        }

        /* Profil en haut */
        .profile {
            background-color: #444;
            color: white;
            padding: 10px;
            text-align: center;
        }

        .profile img {
            border-radius: 50%;
            width: 50px;
            height: 50px;
            margin-bottom: 10px;
        }

        /* Contenu du forum */
        .forum-container {
            max-width: 900px;
            margin: 30px auto;
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .forum-container h2 {
            text-align: center;
            color: #333;
        }

        /* Commentaires */
        .comment {
            background-color: #f9f9f9;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .comment .user {
            font-weight: bold;
            color: #333;
        }

        .comment .date {
            color: #888;
            font-size: 0.9em;
        }

        .comment .message {
            margin-top: 10px;
            color: #555;
        }

        .comment .message a {
            color: #007BFF;
            text-decoration: none;
        }

        .comment .message a:hover {
            text-decoration: underline;
        }

        /* Footer */
        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px 0;
            margin-top: 40px;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav>
        <img src="../img/accueil.png" alt="Accueil" onclick="window.location.href='index_exercices.php'">
        <div>
            <a href="#">Accueil</a>
            <a href="#">Forum</a>
            <a href="#">Messages</a>
            <a href="#">Mon Profil</a>
            <a href="#">Se Déconnecter</a>
        </div>
    </nav>

    <!-- Profil -->
    <div class="profile">
        <img src="https://randomuser.me/api/portraits/men/1.jpg" alt="Profil">
        <h3>Jean Dupont</h3>
        <?php if ($decoded && isset($decoded->role) && $decoded->role === "admin"): ?>
            <p>Rôle : Admin</p>
        <?php else : ?>
            <p>Rôle : Membre</p>
        <?php endif; ?>
    </div>

    <!-- Contenu du forum -->
    <div class="forum-container">
        <h2>Bienvenue sur le forum, Jean !</h2>
        <p>Ici, tu peux poster des messages et discuter avec d'autres utilisateurs.</p>

        <!-- Faux commentaires -->
        <div class="comment">
            <div class="user">Pierre Legrand</div>
            <div class="date">Publié le 3 février 2025</div>
            <div class="message">
                <p>Salut tout le monde ! J'adore ce forum, il y a tellement de discussions intéressantes !</p>
                <a href="#">Répondre</a>
            </div>
        </div>

        <div class="comment">
            <div class="user">Marie Durand</div>
            <div class="date">Publié le 2 février 2025</div>
            <div class="message">
                <p>Bonjour, je suis nouvelle ici. Est-ce que quelqu'un peut me donner des conseils pour débuter ?</p>
                <a href="#">Répondre</a>
            </div>
        </div>

        <div class="comment">
            <div class="user">Lucas Martin</div>
            <div class="date">Publié le 1er février 2025</div>
            <div class="message">
                <p>Salut, j'ai une question sur les forums en général. Comment savoir si un sujet est actif ?</p>
                <a href="#">Répondre</a>
            </div>
        </div>

        <?php if ($decoded && isset($decoded->role) && $decoded->role === "admin"): ?>
            <p><strong>
                    <center>Félicitations ! Voici ton flag : <?php echo $flag; ?></center>
                </strong></p>
        <?php endif; ?>
    </div>

</body>

</html>