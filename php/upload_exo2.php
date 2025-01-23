<?php
session_start();

// Solution fichier nom.PHP.jpg

$FLAG = "ATTENTIONAUBYPASS";

$uploadDir = '../uploads/';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['imageUpload']) && $_FILES['imageUpload']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['imageUpload']['tmp_name'];
        $fileName = $_FILES['imageUpload']['name']; // Nom du fichier original
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // Extensions autorisées (validation faible)
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

        // Vérification basée uniquement sur l'extension dans le nom
        if (strpos($fileName, '.php') === false && in_array($fileExtension, $allowedExtensions)) {
            $destPath = $uploadDir . $fileName;

            // Déplacement du fichier (sans vérification approfondie)
            if (move_uploaded_file($fileTmpPath, $destPath)) {
                header("Location: $destPath");
                exit;
            } else {
                $_SESSION['error'] = "Erreur lors du déplacement du fichier.";
            }
        } else {
            header('Location: ../attack.html');
            exit;
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
