<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$correctAnswers = [
    "q1" => "B",
    "q2" => "A",
    "q3" => "D",
    "q4" => "B",
    "q5" => "B"
];

if (isset($_POST['reset'])) {
    unset($_SESSION['results']);
    header(header: "Location: qcm_csrf.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $results = array_fill_keys(array_keys($correctAnswers), 'incorrect');

    $allowedAnswers = ['A', 'B', 'C', 'D'];
    foreach ($correctAnswers as $question => $correct_answer) {
        if (isset($_POST[$question]) && in_array($_POST[$question], $allowedAnswers)) {
            $results[$question] = ($_POST[$question] == $correct_answer) ? 'correct' : 'incorrect';
        }
    }

    $_SESSION['results'] = $results;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz - QCM</title>
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
    }

    .quiz-container {
        max-width: 600px;
        margin: 50px auto;
        background: white;
        border-radius: 8px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        padding: 30px;
    }

    .question {
        margin-top: 20px;
        font-size: 1.2rem;
    }

    .answer-option {
        margin: 10px 0;
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
    <div class="quiz-container">
        <h1 class="text-center mb-4">Quiz: CSRF</h1>
        <br>
        <form method="POST" action="" class="mt-3">
            <button type="submit" name="reset" class="btn btn-danger">Reset Questions</button>
        </form>
        <br>
        <form id="quizForm" method="POST">
            <div class="question">
                <p><strong>1. Qu'est-ce qu'une attaque CSRF (Cross-Site Request Forgery) ?</strong>
                    <?php if (isset($_SESSION['results']['q1']) && $_SESSION['results']['q1'] == 'correct')
                        echo '<span class="text-success">✔️</span>'; ?>
                    <?php if (isset($_SESSION['results']['q1']) && $_SESSION['results']['q1'] == 'incorrect')
                        echo '<span class="text-danger">❌</span>'; ?>
                </p>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q1" id="q1a" value="A">
                    <label class="form-check-label" for="q1a">Une attaque qui permet de voler des cookies d'un
                        utilisateur via un script malveillant.</label>
                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q1" id="q1b" value="B">
                    <label class="form-check-label" for="q1b">Une attaque qui exploite la confiance d'un utilisateur
                        authentifié pour effectuer des actions malveillantes sur un site.</label>
                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q1" id="q1c" value="C">
                    <label class="form-check-label" for="q1c">Une attaque qui permet d'exécuter du code à distance sur
                        un serveur vulnérable.</label>
                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q1" id="q1d" value="D">
                    <label class="form-check-label" for="q1d">Une attaque qui permet à un attaquant de récupérer des
                        informations sensibles dans des fichiers téléchargés.</label>
                </div>
            </div>
            <br>
            <div class="question">
                <p><strong>2. Dans quel cas l'usage d'un token CSRF est inefficace pour protéger contre les attaques
                        ?</strong>
                    <?php if (isset($_SESSION['results']['q2']) && $_SESSION['results']['q2'] == 'correct')
                        echo '<span class="text-success">✔️</span>'; ?>
                    <?php if (isset($_SESSION['results']['q1']) && $_SESSION['results']['q2'] == 'incorrect')
                        echo '<span class="text-danger">❌</span>'; ?>
                </p>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q2" id="q2a" value="A">
                    <label class="form-check-label" for="q2a">Lorsque le token est inclus dans l'URL de la
                        requête</label>
                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q2" id="q2b" value="B">
                    <label class="form-check-label" for="q2b">Lorsque l'utilisateur est connecté via un réseau public
                        non sécurisé</label>
                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q2" id="q2c" value="C">
                    <label class="form-check-label" for="q2c">Lorsque le serveur ne vérifie pas le type MIME des
                        fichiers envoyés</label>
                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q2" id="q2d" value="D">
                    <label class="form-check-label" for="q2d">Lorsque les cookies de session ne sont pas correctement
                        sécurisés avec l'attribut HttpOnly</label>
                </div>
            </div>
            <br>
            <div class="question">
                <p><strong>3. Pourquoi est-il important d'utiliser un token CSRF par formulaire et de ne jamais
                        réutiliser un token ?</strong>
                    <?php if (isset($_SESSION['results']['q3']) && $_SESSION['results']['q3'] == 'correct')
                        echo '<span class="text-success">✔️</span>'; ?>
                    <?php if (isset($_SESSION['results']['q3']) && $_SESSION['results']['q3'] == 'incorrect')
                        echo '<span class="text-danger">❌</span>'; ?></p>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q3" id="q3a" value="A">
                    <label class="form-check-label" for="q3a">Pour éviter la perte de sessions lors d'une requête
                        malveillante</label>
                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q3" id="q3b" value="B">
                    <label class="form-check-label" for="q3b">Pour garantir que les requêtes GET sont plus
                        sécurisées</label>
                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q3" id="q3c" value="C">
                    <label class="form-check-label" for="q3c">Pour simplifier le stockage des tokens dans la session du
                        serveur</label>
                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q3" id="q3d" value="D">
                    <label class="form-check-label" for="q3d">Pour rendre l'attaque plus difficile à automatiser, car
                        chaque formulaire génère un token unique</label>
                </div>
            </div>
            <br>
            <div class="question">
                <p><strong>4. Comment un token CSRF fonctionne-t-il pour prévenir les attaques CSRF ?</strong>
                    <?php if (isset($_SESSION['results']['q4']) && $_SESSION['results']['q4'] == 'correct')
                        echo '<span class="text-success">✔️</span>'; ?>
                    <?php if (isset($_SESSION['results']['q4']) && $_SESSION['results']['q4'] == 'incorrect')
                        echo '<span class="text-danger">❌</span>'; ?></p>
                </p>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q4" id="q4a" value="A">
                    <label class="form-check-label" for="q4a">Il est envoyé dans le cookie et vérifie la validité de la
                        session</label>
                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q4" id="q4b" value="B">
                    <label class="form-check-label" for="q4b">Il est inclus dans chaque requête HTTP et doit
                        correspondre à celui stocké dans la session du serveur</label>
                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q4" id="q4c" value="C">
                    <label class="form-check-label" for="q4c">Il est utilisé pour crypter les requêtes envoyées à
                        l'application</label>
                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q4" id="q4d" value="D">
                    <label class="form-check-label" for="q4d">Il est placé dans l'URL de chaque requête pour vérifier
                        l'origine de la requête</label>
                </div>
            </div>
            <br>
            <div class="question">
                <p><strong>5. Quel mécanisme de sécurité est couramment utilisé pour se protéger contre les attaques
                        CSRF ?</strong>
                    <?php if (isset($_SESSION['results']['q5']) && $_SESSION['results']['q5'] == 'correct')
                        echo '<span class="text-success">✔️</span>'; ?>
                    <?php if (isset($_SESSION['results']['q5']) && $_SESSION['results']['q5'] == 'incorrect')
                        echo '<span class="text-danger">❌</span>'; ?></p>
                </p>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q5" id="q5a" value="A">
                    <label class="form-check-label" for="q5a">L'utilisation de cookies de session sécurisés avec
                        l'attribut HttpOnly</label>
                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q5" id="q5b" value="B">
                    <label class="form-check-label" for="q5b">L'ajout d'un token CSRF unique dans chaque formulaire
                        soumis</label>
                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q5" id="q5c" value="C">
                    <label class="form-check-label" for="q5c">Le chiffrement des requêtes HTTP avec HTTPS</label>
                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q5" id="q5d" value="D">
                    <label class="form-check-label" for="q5d">La validation des headers HTTP pour vérifier l'origine des
                        requêtes</label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary w-100 mt-4">Submit</button>
        </form>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>