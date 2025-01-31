<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$correctAnswers = [
    "q1" => "A",
    "q2" => "D",
    "q3" => "C",
    "q4" => "D",
    "q5" => "A"
];

if (isset($_POST['reset'])) {
    unset($_SESSION['results']);
    header("Location: qcm_deserialization.php");
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
        <h1 class="text-center mb-4">Quiz: Insecure Deserialization</h1>
        <br>
        <form method="POST" action="" class="mt-3">
            <button type="submit" name="reset" class="btn btn-danger">Reset Questions</button>
        </form>
        <br>
        <form id="quizForm" method="POST">
            <div class="question">
                <p><strong>1. Qu'est-ce que l'Insecure Deserialization ?</strong>
                    <?php if (isset($_SESSION['results']['q1']) && $_SESSION['results']['q1'] == 'correct') echo '<span class="text-success">✔️</span>'; ?>
                    <?php if (isset($_SESSION['results']['q1']) && $_SESSION['results']['q1'] == 'incorrect') echo '<span class="text-danger">❌</span>'; ?>
                </p>

                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q1" id="q1a" value="A">
                    <label class="form-check-label" for="q1a">Une faille permettant d’exécuter du code arbitraire en
                        manipulant des objets sérialisés</label>

                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q1" id="q1b" value="B">
                    <label class="form-check-label" for="q1b">Une méthode de protection des données contre les attaques
                        XSS</label>
                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q1" id="q1c" value="C">
                    <label class="form-check-label" for="q1c">Une technique de chiffrement des données sensibles</label>

                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q1" id="q1d" value="D">
                    <label class="form-check-label" for="q1d">Un type d'attaque visant uniquement les bases de
                        données</label>

                </div>
            </div>
            <br>
            <div class="question">
                <p><strong>2. Quel format de sérialisation peut être exploité pour une attaque ?</strong>
                    <?php if (isset($_SESSION['results']['q2']) && $_SESSION['results']['q2'] == 'correct') echo '<span class="text-success">✔️</span>'; ?>
                    <?php if (isset($_SESSION['results']['q2']) && $_SESSION['results']['q2'] == 'incorrect') echo '<span class="text-danger">❌</span>'; ?>
                </p>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q2" id="q2a" value="A">
                    <label class="form-check-label" for="q2a">JSON</label>
                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q2" id="q2b" value="B">
                    <label class="form-check-label" for="q2b">XML</label>
                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q2" id="q2c" value="C">
                    <label class="form-check-label" for="q2c">PHP Serialized Objects</label>
                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q2" id="q2d" value="D">
                    <label class="form-check-label" for="q2d">Tous les formats de sérialisation peuvent être
                        vulnérables</label>
                </div>
            </div>
            <br>
            <div class="question">
                <p><strong>3. Quel est le principal risque d'une désérialisation non sécurisée ?</strong>
                    <?php if (isset($_SESSION['results']['q3']) && $_SESSION['results']['q3'] == 'correct') echo '<span class="text-success">✔️</span>'; ?>
                    <?php if (isset($_SESSION['results']['q3']) && $_SESSION['results']['q3'] == 'incorrect') echo '<span class="text-danger">❌</span>'; ?>
                </p>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q3" id="q3a" value="A">
                    <label class="form-check-label" for="q3a">Une augmentation de la vitesse d’exécution du
                        programme</label>
                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q3" id="q3b" value="B">
                    <label class="form-check-label" for="q3b">Un accès non autorisé aux fichiers système</label>
                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q3" id="q3c" value="C">
                    <label class="form-check-label" for="q3c">Une exécution de code arbitraire sur le serveur</label>
                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q3" id="q3d" value="D">
                    <label class="form-check-label" for="q3d">Une simple perte de données sans autre conséquence</label>
                </div>
            </div>
            <br>
            <div class="question">
                <p><strong>4. Quelle bonne pratique permet d’atténuer ce type de vulnérabilité ?</strong>
                    <?php if (isset($_SESSION['results']['q4']) && $_SESSION['results']['q4'] == 'correct') echo '<span class="text-success">✔️</span>'; ?>
                    <?php if (isset($_SESSION['results']['q4']) && $_SESSION['results']['q4'] == 'incorrect') echo '<span class="text-danger">❌</span>'; ?>
                </p>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q4" id="q4a" value="A">
                    <label class="form-check-label" for="q4a">Ne jamais désérialiser des données non fiables</label>
                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q4" id="q4b" value="B">
                    <label class="form-check-label" for="q4b">Accepter uniquement des objets provenant d'une source
                        authentifiée</label>
                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q4" id="q4c" value="C">
                    <label class="form-check-label" for="q4c">Utiliser des formats de sérialisation sécurisés comme JSON
                        au lieu de PHP serialization</label>
                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q4" id="q4d" value="D">
                    <label class="form-check-label" for="q4d">Toutes les réponses sont correctes</label>
                </div>
            </div>
            <br>
            <div class="question">
                <p><strong>5. 6. Une attaque par Insecure Deserialization peut-elle être utilisée pour une élévation de
                        privilèges ?</strong>
                    <?php if (isset($_SESSION['results']['q5']) && $_SESSION['results']['q5'] == 'correct') echo '<span class="text-success">✔️</span>'; ?>
                    <?php if (isset($_SESSION['results']['q5']) && $_SESSION['results']['q5'] == 'incorrect') echo '<span class="text-danger">❌</span>'; ?>
                </p>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q5" id="q5a" value="A">
                    <label class="form-check-label" for="q5a">Oui, en modifiant les propriétés d'un objet sérialisé pour
                        devenir administrateur</label>
                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q5" id="q5b" value="B">
                    <label class="form-check-label" for="q5b">Non, elle ne permet que d'afficher des données mais pas de
                        modifier des privilèges</label>
                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q5" id="q5c" value="C">
                    <label class="form-check-label" for="q5c">Oui, mais uniquement si l'attaquant a un accès root au
                        serveur</label>
                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q5" id="q5d" value="D">
                    <label class="form-check-label" for="q5d">Non, cette faille ne concerne que les bases de
                        données</label>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 mt-4">Submit</button>
        </form>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>