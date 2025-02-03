<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$correctAnswers = [
    "q1" => "A",
    "q2" => "C",
    "q3" => "B",
    "q4" => "B",
    "q5" => "A"
];

if (isset($_POST['reset'])) {
    unset($_SESSION['results']);
    header("Location: qcm_upload.php");
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
        <h1 class="text-center mb-4">Quiz: Upload</h1>
        <br>
        <form method="POST" action="" class="mt-3">
            <button type="submit" name="reset" class="btn btn-danger">Reset Questions</button>
        </form>
        <br>
        <form id="quizForm" method="POST">
            <div class="question">
                <p><strong>1. Quel est le principal risque d'une vulnérabilité d'upload de fichier mal protégée
                        ?</strong>
                    <?php if (isset($_SESSION['results']['q1']) && $_SESSION['results']['q1'] == 'correct')
                        echo '<span class="text-success">✔️</span>'; ?>
                    <?php if (isset($_SESSION['results']['q1']) && $_SESSION['results']['q1'] == 'incorrect')
                        echo '<span class="text-danger">❌</span>'; ?>
                </p>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q1" id="q1a" value="A">
                    <label class="form-check-label" for="q1a">Permettre l'exécution de scripts malveillants sur le
                        serveur</label>
                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q1" id="q1b" value="B">
                    <label class="form-check-label" for="q1b">Permettre à l'attaquant d'afficher des messages
                        d'erreur</label>
                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q1" id="q1c" value="C">
                    <label class="form-check-label" for="q1c">Permettre à l'attaquant de voler des mots de passe</label>
                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q1" id="q1d" value="D">
                    <label class="form-check-label" for="q1d">Permettre à l'attaquant de contourner le pare-feu</label>
                </div>
            </div>
            <br>
            <div class="question">
                <p><strong>2. Quel type de fichier est souvent utilisé pour injecter des scripts malveillants via une
                        faille d'upload ?</strong>
                    <?php if (isset($_SESSION['results']['q2']) && $_SESSION['results']['q2'] == 'correct')
                        echo '<span class="text-success">✔️</span>'; ?>
                    <?php if (isset($_SESSION['results']['q1']) && $_SESSION['results']['q2'] == 'incorrect')
                        echo '<span class="text-danger">❌</span>'; ?>
                </p>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q2" id="q2a" value="A">
                    <label class="form-check-label" for="q2a">Fichier image (ex: .jpg, .png)</label>
                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q2" id="q2b" value="B">
                    <label class="form-check-label" for="q2b">Fichier texte (ex: .txt)</label>
                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q2" id="q2c" value="C">
                    <label class="form-check-label" for="q2c">Fichier PHP ou un autre fichier exécutable (ex: .php,
                        .exe)M</label>
                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q2" id="q2d" value="D">
                    <label class="form-check-label" for="q2d">Fichier audio (ex: .mp3)</label>
                </div>
            </div>
            <br>
            <div class="question">
                <p><strong>3. Pourquoi est-il crucial de vérifier le type MIME d'un fichier téléchargé dans une
                        application vulnérable à une faille d'upload ?</strong>
                    <?php if (isset($_SESSION['results']['q3']) && $_SESSION['results']['q3'] == 'correct')
                        echo '<span class="text-success">✔️</span>'; ?>
                    <?php if (isset($_SESSION['results']['q3']) && $_SESSION['results']['q3'] == 'incorrect')
                        echo '<span class="text-danger">❌</span>'; ?></p>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q3" id="q3a" value="A">
                    <label class="form-check-label" for="q3a">Pour empêcher le fichier d'être trop volumineux</label>
                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q3" id="q3b" value="B">
                    <label class="form-check-label" for="q3b">Pour s'assurer que le fichier est réellement une image ou un fichier attendu</label>
                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q3" id="q3c" value="C">
                    <label class="form-check-label" for="q3c">Pour éviter que l'utilisateur n'ait à télécharger un fichier trop ancien</label>
                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q3" id="q3d" value="D">
                    <label class="form-check-label" for="q3d">Pour déterminer le nom du fichier téléchargé</label>
                </div>
            </div>
            <br>
            <div class="question">
                <p><strong>4. Quelle est la meilleure pratique pour limiter les risques d'une attaque via une faille d'upload de fichier ?</strong>
                    <?php if (isset($_SESSION['results']['q4']) && $_SESSION['results']['q4'] == 'correct')
                        echo '<span class="text-success">✔️</span>'; ?>
                    <?php if (isset($_SESSION['results']['q4']) && $_SESSION['results']['q4'] == 'incorrect')
                        echo '<span class="text-danger">❌</span>'; ?></p>
                </p>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q4" id="q4a" value="A">
                    <label class="form-check-label" for="q4a">Ne pas permettre l'upload de fichiers sous aucun prétexte</label>
                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q4" id="q4b" value="B">
                    <label class="form-check-label" for="q4b">Filtrer et valider les extensions de fichiers et scanner chaque fichier téléchargé avec un antivirus</label>
                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q4" id="q4c" value="C">
                    <label class="form-check-label" for="q4c">Accepter uniquement des fichiers compressés (.zip) pour éviter les scripts malveillants</label>
                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q4" id="q4d" value="D">
                    <label class="form-check-label" for="q4d">Toujours enregistrer les fichiers téléchargés avec des extensions aléatoires</label>
                </div>
            </div>
            <br>
            <div class="question">
                <p><strong>5. Si un attaquant parvient à télécharger un fichier PHP malveillant sur un serveur via une vulnérabilité d'upload, quelle est la principale méthode d'exploitation ?</strong>
                    <?php if (isset($_SESSION['results']['q5']) && $_SESSION['results']['q5'] == 'correct')
                        echo '<span class="text-success">✔️</span>'; ?>
                    <?php if (isset($_SESSION['results']['q5']) && $_SESSION['results']['q5'] == 'incorrect')
                        echo '<span class="text-danger">❌</span>'; ?></p>
                </p>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q5" id="q5a" value="A">
                    <label class="form-check-label" for="q5a">Le fichier PHP est exécuté lorsqu'un utilisateur accède à l'URL où il a été téléchargé</label>
                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q5" id="q5b" value="B">
                    <label class="form-check-label" for="q5b">Le fichier PHP est analysé et supprimé automatiquement par le serveur</label>
                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q5" id="q5c" value="C">
                    <label class="form-check-label" for="q5c">Le fichier PHP est utilisé pour crypter les données sensibles sur le serveur</label>
                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q5" id="q5d" value="D">
                    <label class="form-check-label" for="q5d">Le fichier PHP est exécuté uniquement lorsqu'un administrateur se connecte à l'interface d'administration</label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary w-100 mt-4">Submit</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>