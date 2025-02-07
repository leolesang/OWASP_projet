<?php

include('config.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$conn = getDbConnection();


$_SESSION['challenge_success'] = false;

function containsForbiddenWords($input)
{
    $forbidden_words = ['UPDATE', 'INSERT', 'DELETE', 'exercices', 'user', 'exo1_sql', 'validation'];
    foreach ($forbidden_words as $word) {
        if (stripos($input, $word) !== false) {
            return true;
        }
    }
    return false;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ville = isset($_POST['ville']) ? trim($_POST['ville']) : null;

    if (!empty($ville)) {
        if (!containsForbiddenWords($ville)) {
            $sql = "SELECT ville, superheros FROM exo2_sql WHERE ville = '$ville'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                if ($row['ville'] == 'Zigma_B') {
                    $_SESSION['challenge_success'] = true;
                    $message = "Bien joué FLAG : OWASP{SQL_UNION_trop_bien}";
                } else {
                    $_SESSION['challenge_success'] = false;
                    $message = "Ville : " . $row['ville'] . " - Superhéros : " . $row['superheros'];
                }
            } else {
                $error_code = mysqli_errno($conn);
                $error_message = mysqli_error($conn);
                $_SESSION['challenge_success'] = false;
                $message = "Erreur SQL : Code $error_code - $error_message";
            }
        } else {
            $_SESSION['challenge_success'] = false;
            $message = "Mot interdit !!!";
        }
    } else {
        $_SESSION['challenge_success'] = false;
        $message = "Veuillez remplir tous les champs.";
    }
} else {
    echo "Méthode non autorisée.";
}


mysqli_close($conn);
header("Location: ../sql_exo2.html?message=" . urlencode(htmlspecialchars($message)));
exit;
