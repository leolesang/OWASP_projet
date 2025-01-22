<?php
session_start();

$correctAnswers = [
    "NJSWC3RAMRSSA3DBEBTG63TUMFUW4ZI=" => "jean de la fontaine",
    "YmllbiBqb3XDqQ==" => "bien joué",
    "482c811da5d5b4bc6d497ffa98491e38" => "password123",
    "ayvw mhjpsl" => "trop facile",
    "ac9689e2272427085e35b9d3e3e8bed88cb3434828b43b86fc0596cad4c6e270" => "admin1234"
];

if (isset($_POST['reset'])) {
    session_destroy(); 
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $question = $_POST['question'] ?? '';
    $answer = trim($_POST['answer'] ?? '');

    if (isset($correctAnswers[$question]) && strtolower($correctAnswers[$question]) === strtolower($answer)) {
        $_SESSION['validated'][$question] = true; // Marque la question comme validée
    } else {
        $_SESSION['validated'][$question] = false; // Marque la question comme incorrecte
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercise 1 - Question 1</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            color: #333;
        }
        .exercise-container {
            max-width: 800px;
            margin: 50px auto;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }
        .validated-icon {
            color: green;
            margin-left: 10px;
        }
        .error-icon {
            color: red;
            margin-left: 10px;
        }
        .disabled {
            pointer-events: none;
            opacity: 0.6;
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
        <img id="homeImage" src="../img/accueil.png" alt="Accueil" onclick="window.location.href='../index_exercices.html'">
    </div>
    <div class="exercise-container">
        <h1 class="text-center mb-4">Crackage</h1>
        <form method="POST" action="" class="mt-3">
            <button type="submit" name="reset" class="btn btn-danger">Reset Questions</button>
        </form>
        <br>
        <?php foreach ($correctAnswers as $question => $correctAnswer): ?>
            <form method="POST" class="mb-4">
                <div class="question">
                    <p><?= htmlspecialchars($question) ?></p>
                </div>
                <div class="mb-3 answer-input">
                    <input 
                        type="text" 
                        class="form-control <?= isset($_SESSION['validated'][$question]) && $_SESSION['validated'][$question] ? 'disabled' : '' ?>" 
                        name="answer" 
                        placeholder="Type your answer here..." 
                        <?= isset($_SESSION['validated'][$question]) && $_SESSION['validated'][$question] ? 'disabled' : '' ?> 
                        required>
                </div>
                <input type="hidden" name="question" value="<?= htmlspecialchars($question) ?>">
                <button 
                    type="submit" 
                    class="btn btn-primary <?= isset($_SESSION['validated'][$question]) && $_SESSION['validated'][$question] ? 'disabled' : '' ?>" 
                    <?= isset($_SESSION['validated'][$question]) && $_SESSION['validated'][$question] ? 'disabled' : '' ?>>
                    Submit Answer
                </button>
                <?php if (isset($_SESSION['validated'][$question])): ?>
                    <?php if ($_SESSION['validated'][$question]): ?>
                        <span class="validated-icon">✔️</span>
                    <?php else: ?>
                        <span class="error-icon">❌</span>
                    <?php endif; ?>
                <?php endif; ?>
            </form>
        <?php endforeach; ?>
    </div>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>