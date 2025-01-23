<?php

include('config.php');
session_start();
$conn = getDbConnection();


$_SESSION['challenge_success'] = false;

function containsForbiddenWords($input)
{
    $forbidden_words = ['UPDATE', 'INSERT', 'DELETE'];
    foreach ($forbidden_words as $word) {
        if (stripos($input, $word) !== false) {
            return true;
        }
    }
    return false;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = isset($_POST['login']) ? trim($_POST['login']) : null;
    $password = isset($_POST['password']) ? trim($_POST['password']) : null;

    if (!empty($login) && !empty($password)) {

        if (!containsForbiddenWords($login) || !containsForbiddenWords($password)) {
            $sql = "SELECT * FROM exo1_sql WHERE login = '$login' AND password = '$password'";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                $_SESSION['challenge_success'] = true;
                $message = "Authentification réussie ! FLAG : OWASP{basique_sql}";
            } else {
                $_SESSION['challenge_success'] = false;
                $message = "Échec de l'authentification. Essayez encore.";
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
header("Location: ../sql_exo1.html?message=" . urlencode(htmlspecialchars($message)));
exit;
