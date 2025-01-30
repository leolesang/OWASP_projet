<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$correctAnswers = [
    "q1" => "B",
    "q2" => "A",
    "q3" => "C",
    "q4" => "A"
];

if (isset($_POST['reset'])) {
    unset($_SESSION['results']);
    header(header: "Location: qcm_misconfig.php");
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
        <h1 class="text-center mb-4">Quiz: Misconfiguration</h1>
        <br>
        <form method="POST" action="" class="mt-3">
            <button type="submit" name="reset" class="btn btn-danger">Reset Questions</button>
        </form>
        <br>
        <form id="quizForm" method="POST">
            <div class="question">
                <p><strong>1. Qu'est-ce qu'une "misconfiguration" dans le contexte de la sécurité informatique
                        ?</strong>
                    <?php if (isset($_SESSION['results']['q1']) && $_SESSION['results']['q1'] == 'correct')
                        echo '<span class="text-success">✔️</span>'; ?>
                    <?php if (isset($_SESSION['results']['q1']) && $_SESSION['results']['q1'] == 'incorrect')
                        echo '<span class="text-danger">❌</span>'; ?>
                </p>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q1" id="q1a" value="A">
                    <label class="form-check-label" for="q1a">L'absence de chiffrement des données sensibles lors de
                        leur stockage.</label>
                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q1" id="q1b" value="B">
                    <label class="form-check-label" for="q1b">Une mauvaise configuration des serveurs, des systèmes ou
                        des applications qui peut exposer des données sensibles ou permettre des attaques.</label>
                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q1" id="q1c" value="C">
                    <label class="form-check-label" for="q1c">L'utilisation de mots de passe faibles pour les comptes
                        administratifs.</label>
                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q1" id="q1d" value="D">
                    <label class="form-check-label" for="q1d">Un manque d'authentification des utilisateurs sur une
                        application web.</label>
                </div>
            </div>
            <br>
            <div class="question">
                <p><strong>2. Quelle est la conséquence principale d'une mauvaise configuration des permissions sur un
                        serveur web ?</strong>
                    <?php if (isset($_SESSION['results']['q2']) && $_SESSION['results']['q2'] == 'correct')
                        echo '<span class="text-success">✔️</span>'; ?>
                    <?php if (isset($_SESSION['results']['q1']) && $_SESSION['results']['q2'] == 'incorrect')
                        echo '<span class="text-danger">❌</span>'; ?>
                </p>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q2" id="q2a" value="A">
                    <label class="form-check-label" for="q2a">Les utilisateurs malveillants peuvent accéder à des
                        répertoires et fichiers sensibles sur le serveur</label>
                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q2" id="q2b" value="B">
                    <label class="form-check-label" for="q2b">Les utilisateurs légitimes sont empêchés d'accéder aux
                        ressources qu'ils nécessitent</label>
                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q2" id="q2c" value="C">
                    <label class="form-check-label" for="q2c">Le serveur devient plus rapide</label>
                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q2" id="q2d" value="D">
                    <label class="form-check-label" for="q2d">Les utilisateurs sont automatiquement déconnectés après
                        une certaine période d'inactivité</label>
                </div>
            </div>
            <br>
            <div class="question">
                <p><strong>3.Pourquoi est-il important de désactiver les services non utilisés ou inutiles dans une
                        application ou sur un serveur ?
                    </strong>
                    <?php if (isset($_SESSION['results']['q3']) && $_SESSION['results']['q3'] == 'correct')
                        echo '<span class="text-success">✔️</span>'; ?>
                    <?php if (isset($_SESSION['results']['q3']) && $_SESSION['results']['q3'] == 'incorrect')
                        echo '<span class="text-danger">❌</span>'; ?></p>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q3" id="q3a" value="A">
                    <label class="form-check-label" for="q3a">Pour réduire la consommation de mémoire et améliorer les
                        performances</label>
                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q3" id="q3b" value="B">
                    <label class="form-check-label" for="q3b">Pour éviter l'installation de logiciels
                        malveillants</label>
                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q3" id="q3c" value="C">
                    <label class="form-check-label" for="q3c">Pour diminuer la surface d'attaque en évitant d'exposer
                        des services inutiles aux attaquants</label>
                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q3" id="q3d" value="D">
                    <label class="form-check-label" for="q3d">Pour empêcher l'accès à des données sensibles par les
                        administrateurs</label>
                </div>
            </div>
            <br>
            <div class="question">
                <p><strong>4. Pourquoi est-il risqué de laisser des fichiers de config sensibles, comme ceux
                        contenant des clés API ou des informations de base de données, dans le répertoire public d'un
                        serveur ?</strong>
                    <?php if (isset($_SESSION['results']['q4']) && $_SESSION['results']['q4'] == 'correct')
                        echo '<span class="text-success">✔️</span>'; ?>
                    <?php if (isset($_SESSION['results']['q4']) && $_SESSION['results']['q4'] == 'incorrect')
                        echo '<span class="text-danger">❌</span>'; ?></p>
                </p>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q4" id="q4a" value="A">
                    <label class="form-check-label" for="q4a">Les fichiers seront accessibles à tout utilisateur sur
                        Internet, ce qui peut permettre à un attaquant de voler des informations sensibles ou d'accéder
                        à la base de données</label>
                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q4" id="q4b" value="B">
                    <label class="form-check-label" for="q4b">Les fichiers seront automatiquement cryptés par le
                        serveur</label>
                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q4" id="q4c" value="C">
                    <label class="form-check-label" for="q4c">Les fichiers seront uniquement accessibles aux
                        administrateurs système</label>
                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q4" id="q4d" value="D">
                    <label class="form-check-label" for="q4d">Les fichiers seront utilisés uniquement pour des tests
                        internes et ne seront pas utilisés en production</label>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 mt-4">Submit</button>
        </form>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>