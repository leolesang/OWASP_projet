<?php
require_once 'config.php'; 
session_start(); 

$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);

    if (!empty($username)) {
        $conn = getDbConnection();

        $stmt = $conn->prepare("SELECT id_user FROM user WHERE login = ?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user) {
            $_SESSION['user_id'] = $user['id_user'];
            header('Location: index_exercices.php'); 
            exit;
        } else {
            $stmt = $conn->prepare("INSERT INTO user (login) VALUES (?)");
            $stmt->bind_param('s', $username);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                $_SESSION['user_id'] = $conn->insert_id; 
                header('Location: index_exercices.php'); 
                exit;
            } else {
                $errorMessage = "Une erreur est survenue lors de l'inscription.";
            }

            $stmt->close();
        }

        $stmt->close();
        $conn->close();
    } else {
        $errorMessage = "Veuillez remplir tous les champs.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa; /* Light background color */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Full viewport height */
            margin: 0;
        }
        .login-container {
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 300px; /* Fixed width for the form */
        }

    </style>
</head>
<body>
    <div class="login-container">
        
        <h2 class="text-center mb-4">Création compte</h2>
        <form method="POST">
            <div class="mb-3">

                <input type="text" class="form-control" name="username" id="username" placeholder="Entrez votre pseudo" required>
                <p style="color : red; margin-top: 5px;">
                    <strong><?php echo $errorMessage ?></strong>
                </p>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
    </div>


    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

