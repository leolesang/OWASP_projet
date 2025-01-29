<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}


// Initialiser les données si elles n'existent pas déjà
if (!isset($_SESSION['balances'])) {
    $_SESSION['balances'] = [
        '123456789' => 5000,
        '987654321' => 2000,
    ];
}

// Générer un jeton CSRF si nécessaire
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = "369b7c69fc661ec54bd2c5025975b9b78568a3914b09c0cbbdaa2ad05f0c71c0";
}

$user_account = '123456789';
$current_balance = $_SESSION['balances'][$user_account];

// Traiter le formulaire de transfert
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Vérification du jeton CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        echo $_SESSION['csrf_token'] . " - " . $_POST['csrf_token'];
        die("Erreur CSRF : La requête n'est pas autorisée.");
    }

    if (isset($_POST['reset'])) {
        $_SESSION['balances'] = [
            '123456789' => 5000,
            '987654321' => 2000,
        ];
        $_SESSION['flag'] = null;
        $_SESSION['csrf_token'] = "369b7c69fc661ec54bd2c5025975b9b78568a3914b09c0cbbdaa2ad05f0c71c0";
        $message = "Compte réinitialisé avec succès !";
        $current_balance = $_SESSION['balances'][$user_account];
    } else {
        $to_account = $_POST['to_account'];
        $amount = (int)$_POST['amount'];

        if ($_SESSION['balances'][$user_account] >= $amount) {
            $_SESSION['balances'][$user_account] -= $amount;
            $_SESSION['balances'][$to_account] += $amount;
            $_SESSION['flag'] = "Bien joué voici le flag : OWASP{CSRF_token}";
            header("Location: " . $_SERVER['PHP_SELF']);
        } else {
            $message = "Solde insuffisant pour effectuer ce transfert.";
        }
    }
}

if (isset($_GET['action']) && $_GET['action'] === 'get_balance') {
    echo json_encode(['balance' => $_SESSION['balances'][$user_account]]);
    exit;
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Compte</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            max-width: 600px;
            margin-top: 50px;
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        h2,
        h1 {
            text-align: center;
        }

        .balance {
            font-size: 1.2rem;
            text-align: center;
            /* Center the balance text */
        }

        .message {
            color: green;
        }

        .error {
            color: red;
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
    <div class="container">
        <form method="POST" class="text-center">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <button type="submit" name="reset" class="btn btn-danger w-50">Réinitialiser</button>
        </form>

        <h1 class="mt-4">Bienvenue sur votre compte</h1>
        <p class="balance">Votre solde actuel : <span id="balance"><strong><?php echo htmlspecialchars($current_balance); ?> €</strong></span></p>

        <h2>Effectuer un transfert <span style="color : red;"><strong>(bloqué)</strong></span></h2>
        <br>
        <div class="mb-3">
            <label for="to_account" class="form-label">Numéro du compte destinataire :</label>
            <input type="text" name="to_account" id="to_account" class="form-control" value="987654321" required>
        </div>
        <div class="mb-3">
            <label for="amount" class="form-label">Montant à transférer :</label>
            <input type="number" name="amount" id="amount" class="form-control" min="1" max="<?php echo $current_balance; ?>" required>
        </div>
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        <button disabled type="submit" class="btn btn-primary w-100" <?php echo ($current_balance <= 0) ? 'disabled' : ''; ?>>Transférer</button>

        <?php if (isset($message)) { ?>
            <p class="message text-center mt-3"><?php echo $message; ?></p>
        <?php } ?>

        <?php if ($_SESSION['flag']) { ?>
            <p class="error text-center mt-3"><?php echo $_SESSION['flag']; ?></p>
        <?php } ?>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>