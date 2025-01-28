<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$message = "";

$correctAnswers = [
    "q1" => "B",
    "q2" => "D",
    "q3" => "B"
];

if (isset($_POST['reset'])) {
    unset($_SESSION['results']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $results = [
        'q1' => '',
        'q2' => '',
        'q3' => ''
    ];
    foreach ($correctAnswers as $question => $correct_answer) {
        if (isset($_POST[$question])) {
            if ($_POST[$question] == $correct_answer) {
                $results[$question] = 'correct';
            } else {
                $results[$question] = 'incorrect';
            }
        } else {
            $results[$question] = 'incorrect';
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
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            /* Light background color */
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
        <h1 class="text-center mb-4">Quiz: Injection SQL</h1>
        <br>
        <form method="POST" action="" class="mt-3">
            <button type="submit" name="reset" class="btn btn-danger">Reset Questions</button>
        </form>
        <br>
        <form id="quizForm" method="POST">
            <div class="question">
                <p><strong>1. Qu'est-ce qu'une injection SQL ?</strong>
                    <?php if (isset($_SESSION['results']['q1']) && $_SESSION['results']['q1'] == 'correct') echo '<span class="text-success">✔️</span>'; ?>
                    <?php if (isset($_SESSION['results']['q1']) && $_SESSION['results']['q1'] == 'incorrect') echo '<span class="text-danger">❌</span>'; ?>
                </p>

                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q1" id="q1a" value="A">
                    <label class="form-check-label" for="q1a">Une technique pour améliorer la performance des requêtes SQL.</label>

                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q1" id="q1b" value="B">
                    <label class="form-check-label" for="q1b">Une méthode pour injecter du code malveillant dans une base de données via une entrée utilisateur non sécurisée.</label>
                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q1" id="q1c" value="C">
                    <label class="form-check-label" for="q1c">Une technique pour optimiser les index de la base de données.</label>

                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q1" id="q1d" value="D">
                    <label class="form-check-label" for="q1d">Une méthode pour chiffrer les données dans une base de données.</label>

                </div>
            </div>

            <div class="question">
                <p><strong>2. Quel type de requête SQL est le plus vulnérable aux injections SQL ?</strong>
                    <?php if (isset($_SESSION['results']['q2']) && $_SESSION['results']['q2'] == 'correct') echo '<span class="text-success">✔️</span>'; ?>
                    <?php if (isset($_SESSION['results']['q2']) && $_SESSION['results']['q2'] == 'incorrect') echo '<span class="text-danger">❌</span>'; ?>
                </p>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q2" id="q2a" value="A">
                    <label class="form-check-label" for="q2a">Requêtes SELECT.</label>
                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q2" id="q2b" value="B">
                    <label class="form-check-label" for="q2b">Requêtes INSERT.</label>
                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q2" id="q2c" value="C">
                    <label class="form-check-label" for="q2c">Requêtes UPDATE.</label>
                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q2" id="q2d" value="D">
                    <label class="form-check-label" for="q2d">Toutes les requêtes ci-dessus peuvent être vulnérables.</label>
                </div>
            </div>

            <div class="question">
                <p><strong>3. Quelle est la meilleure pratique pour prévenir les injections SQL ?</strong>
                    <?php if (isset($_SESSION['results']['q3']) && $_SESSION['results']['q3'] == 'correct') echo '<span class="text-success">✔️</span>'; ?>
                    <?php if (isset($_SESSION['results']['q3']) && $_SESSION['results']['q3'] == 'incorrect') echo '<span class="text-danger">❌</span>'; ?>
                </p>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q3" id="q3a" value="A">
                    <label class="form-check-label" for="q3a">Utiliser des requêtes dynamiques.</label>
                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q3" id="q3b" value="B">
                    <label class="form-check-label" for="q3b">Utiliser des requêtes préparées avec des paramètres liés.</label>
                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q3" id="q3c" value="C">
                    <label class="form-check-label" for="q3c">Utiliser des fonctions de hachage pour les entrées utilisateur.</label>
                </div>
                <div class="form-check answer-option">
                    <input class="form-check-input" type="radio" name="q3" id="q3d" value="D">
                    <label class="form-check-label" for="q3d">Utiliser des transactions SQL.</label>
                </div>
            </div>




            <button type="submit" class="btn btn-primary w-100 mt-4">Submit</button>
        </form>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>