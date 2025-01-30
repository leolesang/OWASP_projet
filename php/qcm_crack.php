<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$correctAnswers = [
    "q1" => "B",
    "q2" => "C",
    "q3" => "C",
    "q4" => "B",
    "q5" => "A"
];

if (isset($_POST['reset'])) {
    unset($_SESSION['results']);
    header(header: "Location: qcm_crack.php");
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
        <h1 class="text-center mb-4">Quiz: Crack</h1>
        <br>
        <form method="POST" action="" class="mt-3">
            <button type="submit" name="reset" class="btn btn-danger">Reset Questions</button>
        </form>
        <br>
        <form id="quizForm" method="POST">
            <div class="question">
                <p><strong>1. Qu'est-ce qu'un algorithme de hachage (hashing) et comment est-il utilisé en sécurité informatique ?</strong>
                    <?php if (isset($_SESSION['results']['q1']) && $_SESSION['results']['q1'] == 'correct')
                        echo '<span class="text-success">✔️</span>'; ?>
                    <?php if (isset($_SESSION['results']['q1']) && $_SESSION['results']['q1'] == 'incorrect')
                        echo '<span class="text-danger">❌</span>'; ?>
                </p>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q1" id="q1a" value="A">
                    <label class="form-check-label" for="q1a">Un algorithme de hachage permet de crypter les données pour les rendre illisibles sans clé secrète</label>
                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q1" id="q1b" value="B">
                    <label class="form-check-label" for="q1b">Un algorithme de hachage génère une valeur unique à partir de données d'entrée, utilisée pour vérifier l'intégrité des données sans révéler leur contenu</label>
                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q1" id="q1c" value="C">
                    <label class="form-check-label" for="q1c">Un algorithme de hachage est utilisé pour déchiffrer des données chiffrées</label>
                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q1" id="q1d" value="D">
                    <label class="form-check-label" for="q1d">Un algorithme de hachage est utilisé pour compresser des données volumineuses</label>
                </div>
            </div>
            <br>
            <div class="question">
                <p><strong>2.Pourquoi les algorithmes de hachage tels que MD5 et SHA-1 sont considérés comme vulnérables ? 
                        </strong>
                    <?php if (isset($_SESSION['results']['q2']) && $_SESSION['results']['q2'] == 'correct')
                        echo '<span class="text-success">✔️</span>'; ?>
                    <?php if (isset($_SESSION['results']['q1']) && $_SESSION['results']['q2'] == 'incorrect')
                        echo '<span class="text-danger">❌</span>'; ?>
                </p>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q2" id="q2a" value="A">
                    <label class="form-check-label" for="q2a">Parce qu'ils génèrent des valeurs de hachage trop longues et donc consomment trop de mémoire</label>
                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q2" id="q2b" value="B">
                    <label class="form-check-label" for="q2b">Parce qu'ils sont lents à calculer et ne peuvent pas être utilisés en production</label>
                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q2" id="q2c" value="C">
                    <label class="form-check-label" for="q2c">Parce qu'ils peuvent produire des collisions, c'est-à-dire deux ensembles de données différents qui génèrent le même hachage</label>
                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q2" id="q2d" value="D">
                    <label class="form-check-label" for="q2d">Parce qu'ils nécessitent une clé secrète pour fonctionner, ce qui les rend peu pratiques</label>
                </div>
            </div>
            <br>
            <div class="question">
                <p><strong>3. Comment les mots de passe sont-ils généralement protégés dans une base de données ?</strong>
                    <?php if (isset($_SESSION['results']['q3']) && $_SESSION['results']['q3'] == 'correct')
                        echo '<span class="text-success">✔️</span>'; ?>
                    <?php if (isset($_SESSION['results']['q3']) && $_SESSION['results']['q3'] == 'incorrect')
                        echo '<span class="text-danger">❌</span>'; ?></p>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q3" id="q3a" value="A">
                    <label class="form-check-label" for="q3a">Les mots de passe sont stockés sous forme de texte brut, car ils ne peuvent pas être récupérés par un attaquant</label>
                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q3" id="q3b" value="B">
                    <label class="form-check-label" for="q3b">Les mots de passe sont stockés après avoir été chiffrés avec un algorithme symétrique</label>
                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q3" id="q3c" value="C">
                    <label class="form-check-label" for="q3c">Les mots de passe sont stockés sous forme de hachages, souvent accompagnés d'un sel pour augmenter la sécurité</label>
                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q3" id="q3d" value="D">
                    <label class="form-check-label" for="q3d">Les mots de passe sont envoyés en clair sur Internet et validés sur le serveur</label>
                </div>
            </div>
            <br>
            <div class="question">
                <p><strong>4. Qu'est-ce qu'un "sel" (salt) dans le contexte du hachage des mots de passe et pourquoi est-il important ?</strong>
                    <?php if (isset($_SESSION['results']['q4']) && $_SESSION['results']['q4'] == 'correct')
                        echo '<span class="text-success">✔️</span>'; ?>
                    <?php if (isset($_SESSION['results']['q4']) && $_SESSION['results']['q4'] == 'incorrect')
                        echo '<span class="text-danger">❌</span>'; ?></p>
                </p>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q4" id="q4a" value="A">
                    <label class="form-check-label" for="q4a">Un sel est une clé utilisée pour chiffrer les mots de passe et la protéger des attaques par force brute</label>
                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q4" id="q4b" value="B">
                    <label class="form-check-label" for="q4b">Un sel est une valeur aléatoire ajoutée au mot de passe avant le hachage pour rendre les attaques par dictionnaire ou par force brute plus difficiles</label>
                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q4" id="q4c" value="C">
                    <label class="form-check-label" for="q4c">Un sel est un algorithme qui compresse le mot de passe pour le rendre plus difficile à deviner</label>
                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q4" id="q4d" value="D">
                    <label class="form-check-label" for="q4d">Un sel est une méthode de stockage des mots de passe en clair dans la base de données</label>
                </div>
            </div>
            <br>
            <div class="question">
                <p><strong>5. Quelle est la principale différence entre un algorithme de hachage et un algorithme de chiffrement ?</strong>
                    <?php if (isset($_SESSION['results']['q5']) && $_SESSION['results']['q5'] == 'correct')
                        echo '<span class="text-success">✔️</span>'; ?>
                    <?php if (isset($_SESSION['results']['q5']) && $_SESSION['results']['q5'] == 'incorrect')
                        echo '<span class="text-danger">❌</span>'; ?></p>
                </p>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q5" id="q5a" value="A">
                    <label class="form-check-label" for="q5a">Le chiffrement est réversible et nécessite une clé secrète, tandis que le hachage est irréversible</label>
                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q5" id="q5b" value="B">
                    <label class="form-check-label" for="q5b">Le chiffrement est utilisé pour vérifier l'intégrité des données, tandis que le hachage est utilisé pour les crypter</label>
                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q5" id="q5c" value="C">
                    <label class="form-check-label" for="q5c">Le chiffrement est plus rapide que le hachage</label>
                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q5" id="q5d" value="D">
                    <label class="form-check-label" for="q5d">Le hachage est asynchrone</label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary w-100 mt-4">Submit</button>
        </form>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>