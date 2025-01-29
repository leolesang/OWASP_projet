<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$flag = "OWASP{upload_filters}";

$uploadDir = '../uploads/';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['imageUpload']) && $_FILES['imageUpload']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['imageUpload']['tmp_name'];
        $fileName = $_FILES['imageUpload']['name']; // Nom du fichier original
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // Extensions autorisées pour les images
        $allowedImageExtensions = ['jpg', 'jpeg', 'png', 'gif'];

        // Vérification si le fichier contient .php mais n'est pas un fichier image valide suivi de .php
        if (strpos($fileName, '.php') !== false) {
            // Si l'extension principale est une image et que le fichier contient aussi .php
            $baseExtension = pathinfo($fileName, PATHINFO_EXTENSION);
            $baseName = basename($fileName, '.' . $baseExtension); // Nom sans l'extension principale
            $secondExtension = strtolower(pathinfo($baseName, PATHINFO_EXTENSION)); // Seconde extension

            // Si la seconde extension est .php et la première est une image valide
            if (in_array($secondExtension, $allowedImageExtensions)) {
                $destPath = $uploadDir . $fileName;

                // Déplacement du fichier
                if (move_uploaded_file($fileTmpPath, $destPath)) {
                    header("Location: $destPath");
                    exit;
                } else {
                    $_SESSION['error'] = "Erreur lors du déplacement du fichier.";
                }
            } else {
                $_SESSION['error'] = "Les fichiers PHP seuls ne sont pas autorisés.";
                header('Location: ../attack.html');
                exit;
            }
        } else {
            // Si le fichier n'est pas un fichier PHP ou ne contient pas .php
            if (in_array($fileExtension, $allowedImageExtensions)) {
                $destPath = $uploadDir . $fileName;

                // Déplacement du fichier
                if (move_uploaded_file($fileTmpPath, $destPath)) {
                    header("Location: $destPath");
                    exit;
                } else {
                    $_SESSION['error'] = "Erreur lors du déplacement du fichier.";
                }
            } else {
                $_SESSION['error'] = "Extension de fichier non autorisée.";
                header('Location: ../attack.html');
                exit;
            }
        }
    } else {
        $_SESSION['error'] = "Veuillez sélectionner un fichier.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Image</title>
    <link rel="stylesheet" href="../css/modal.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
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
        <img id="hintImage" src="../img/indice.png" alt="Indice" title="Cliquez pour un indice" onclick="showModal_hint()">
    </div>
    <div class="container mt-5">
        <div class="form-container">
            <h1 class="text-center mb-4">Upload Your File</h1>
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger">
                    <?= htmlspecialchars($_SESSION['error']); ?>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>
            <form id="uploadForm" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="imageUpload" class="form-label">Upload File</label>
                    <input type="file" class="form-control" id="imageUpload" name="imageUpload" required>
                </div>
                <button type="submit" class="btn btn-primary">Upload</button>
            </form>
        </div>
    </div>
    <div id="resultModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <p id="resultMessage"></p>
        </div>
    </div>

    <script>
        function showModal_hint() {
            document.getElementById('resultMessage').innerText = "Il existe plusieurs manière d'écrire une extension php.";
            document.getElementById('resultModal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('resultModal').style.display = 'none';
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>