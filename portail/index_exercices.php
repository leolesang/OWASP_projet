<?php
require_once 'config.php'; // Inclusion du fichier config.php
session_start();

// Initialisation des variables
$validationMessage = '';
$showValidationImage = false;

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$id_user = $_SESSION['user_id'];

// Connexion à la base de données
$conn = getDbConnection();

// Récupérer les exercices validés par l'utilisateur
$stmt = $conn->prepare("SELECT id_exercice FROM validation WHERE id_user = ?");
$stmt->bind_param('i', $id_user);
$stmt->execute();
$validatedExosResult = $stmt->get_result();

// Créer un tableau des exercices validés
$validatedExos = [];
while ($row = $validatedExosResult->fetch_assoc()) {
    $validatedExos[] = $row['id_exercice'];
}

$stmt->close();
// Vérifiez si un flag est soumis et si l'exercice existe
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['flag']) && isset($_GET['id'])) {
    $submittedFlag = trim($_GET['flag']);
    $id_exo = intval($_GET['id']);

    // Récupérer l'exercice et son flag depuis la base de données
    $stmt = $conn->prepare("SELECT flag FROM exercices WHERE id_exercice = ?");
    $stmt->bind_param('i', $id_exo);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    // Vérifiez si le flag est correct
    if ($row && $submittedFlag === $row['flag']) {
        $validationMessage = "Félicitations ! Vous avez trouvé le bon flag.";

        // Vérifiez si l'exercice n'a pas encore été validé
        $stmt = $conn->prepare("SELECT 1 FROM validation WHERE id_user = ? AND id_exercice = ?");
        $stmt->bind_param('ii', $id_user, $id_exo);
        $stmt->execute();
        $validationResult = $stmt->get_result();

        if ($validationResult->num_rows === 0) {
            // Insérer l'exercice validé dans la table validation
            $stmt = $conn->prepare("INSERT INTO validation (id_user, id_exercice) VALUES (?, ?)");
            $stmt->bind_param('ii', $id_user, $id_exo);
            if ($stmt->execute()) {
                $validationMessage .= " Votre réussite a été enregistrée.";
                header("Location: " . $_SERVER['PHP_SELF']);
                exit;
            } else {
                $validationMessage .= " Une erreur s'est produite lors de l'enregistrement.";
            }
        } else {
            $validationMessage .= " Vous avez déjà validé cet exercice.";
        }
    } else {
        // Le flag est incorrect
        $validationMessage = "Désolé, le flag est incorrect. Réessayez.";
    }

    $stmt->close();
    $conn->close();
} else {
    $validationMessage = "Veuillez soumettre un flag.";
}
?>




<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/docs/4.0/assets/../img/favicons/favicon.ico">
    <title>Page exercices</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/product/">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/product.css" rel="stylesheet">
    <link href="../css/button_valider.css" rel="stylesheet">
    <link href="../css/flag_input.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">
</head>

<body>
    <nav class="site-header sticky-top py-1">
        <div class="container d-flex flex-column flex-md-row justify-content-between">
            <a class="py-2" href="">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="d-block mx-auto">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="14.31" y1="8" x2="20.05" y2="17.94"></line>
                    <line x1="9.69" y1="8" x2="21.17" y2="8"></line>
                    <line x1="7.38" y1="12" x2="13.12" y2="2.06"></line>
                    <line x1="9.69" y1="16" x2="3.95" y2="6.06"></line>
                    <line x1="14.31" y1="16" x2="2.83" y2="16"></line>
                    <line x1="16.62" y1="12" x2="10.88" y2="21.94"></line>
                </svg>
            </a>
            <a class="py-2 d-none d-md-inline-block" href="index_exercices.php"></a>
            <a class="py-2 d-none d-md-inline-block" href="index_exercices.php">Exercices</a>
            <a class="py-2 d-none d-md-inline-block" href="index_exercices.php"></a>
            <a class="py-2 d-none d-md-inline-block" href="logout.php">Déconnexion</a>
        </div>
    </nav>

    <div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center bg-light">
        <div class="col-md-5 p-lg-5 mx-auto my-5">
            <h1 class="display-4 font-weight-normal">Exercices
            </h1>
            <p class="lead font-weight-normal">Sur cette page, vous trouverez différents types d'exercices concernant le
                top 10 OWASP.
                Dans chaque exercice le FLAG est de type OWASP{...}.
            </p>
        </div>
        <div class="product-device box-shadow d-none d-md-block"></div>
        <div class="product-device product-device-2 box-shadow d-none d-md-block"></div>
    </div>

        <div class="d-flex justify-content-center w-100 my-md-3 pl-md-3 mx-auto">
        <div class="mr-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center text-white overflow-hidden"
            style="border-radius: 15px; box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px; width: 45%; height: auto;">
            <div class="my-3 py-3 position-relative">

                <?php if (in_array("1", $validatedExos)): ?>
                    <img src="../img/valide.png" alt="Validation"
                        style="position: absolute; top: 10px; left: 10px; width: 40px; height: 40px;">
                <?php else: ?>
                    <img src="../img/croix.png" alt="Non validé"
                        style="position: absolute; top: 0px; left: 10px; width: 60px; height: 60px;">
                <?php endif; ?>

                <a href="../sql_exo1.html">
                    <img src="../img/demarrer2.png" alt="Démarrer l'exercice"
                        style="position: absolute; top: 10px; right: 10px; width: 60px; height: 60px;">
                </a>
                <div class="d-flex justify-content-center align-items-center">
                    <h2 class="display-5" style="color: black; margin-right: 10px;">SQL 1</h2>
                    <img src="../img/lvl1.png" alt="level 1" style="width: 30px; height: 30px;">
                    <span style="color: rgb(69, 251, 14);"> &nbspeasy</span>
                </div>
                <p class="lead" style="color: black; font-size:17px;">Essayez d'arriver à vous authentifier.</p>
            </div>
            <div class="d-flex justify-content-between mt-4">
                <div class="text-center">
                    <a href="../explications/sql_explication.html">
                        <img src="../img/explication.png" alt="Explication"
                            style="width: 60px; height: 60px; border-radius: 8px;">
                    </a>
                </div>
                <div class="text-center">
                    <img src="../img/monde.png" alt="Explication"
                        style="width: 60px; height: 60px; border-radius: 8px;">
                    <form method="GET">
                        <div class="mb-3">
                            <input type="hidden" name="id" value="1">
                            <input type="text" style="margin-top: 10px;" class="form-control" id="flag" name="flag"
                                placeholder="Entrer votre flag">
                        </div>
                        <button type="submit">Valider</button>
                    </form>
                </div>
                <div class="text-center">
                    <a href="solution_video.php?id=1">
                        <img src="../img/solution.png" alt="Solution"
                            style="width: 60px; height: 60px; border-radius: 8px; margin-bottom: 20px;">
                    </a>
                </div>
            </div>
        </div>


        <div class="mr-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center text-white overflow-hidden"
            style="border-radius: 15px; box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px; width: 45%;">
            <div class="my-3 py-3 position-relative">
                <?php if (in_array("2", $validatedExos)): ?>
                    <img src="../img/valide.png" alt="Validation"
                        style="position: absolute; top: 10px; left: 10px; width: 40px; height: 40px;">
                <?php else: ?>
                    <img src="../img/croix.png" alt="Non validé"
                        style="position: absolute; top: 0px; left: 10px; width: 60px; height: 60px;">
                <?php endif; ?>

                <a href="../sql_exo2.html">
                    <img src="../img/demarrer2.png" alt="Démarrer l'exercice"
                        style="position: absolute; top: 10px; right: 10px; width: 60px; height: 60px;">
                </a>
                <div class="d-flex justify-content-center align-items-center">
                    <h2 class="display-5" style="color: black; margin-right: 10px;">SQL 2</h2>
                    <img src="../img/lvl3.png" alt="level 3" style="width: 30px; height: 30px;">
                    <span style="color: rgb(255, 128, 0);"> &nbsp medium</span>
                </div>
                <p class="lead" style="color: black; font-size:17px;">Trouver dans quelle ville le superhéro Jean se
                    trouve.</p>
            </div>
            <div class="d-flex justify-content-between mt-4">
                <div class="text-center">
                    <a href="../explications/sql_explication.html">
                        <img src="../img/explication.png" alt="Explication"
                            style="width: 60px; height: 60px; border-radius: 8px;">
                    </a>
                </div>
                <div class="text-center">
                    <img src="../img/monde.png" alt="Explication"
                        style="width: 60px; height: 60px; border-radius: 8px;">
                    <form method="GET">
                        <div class="mb-3">
                            <input type="hidden" name="id" value="2">
                            <input type="text" style="margin-top: 10px;" class="form-control" id="flag" name="flag"
                                placeholder="Entrer votre flag">
                        </div>
                        <button type="submit">Valider</button>
                    </form>
                </div>
                <div class="text-center">
                    <a href="solution_video.php?id=2">
                        <img src="../img/solution.png" alt="Solution"
                            style="width: 60px; height: 60px; border-radius: 8px; margin-bottom: 20px;">
                    </a>
                </div>
            </div>
        </div>
    </div>
    <br>
    <br>


    <div class="d-flex justify-content-center w-100 my-md-3 pl-md-3 mx-auto">
        <div class="mr-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center text-white overflow-hidden"
            style="border-radius: 15px; box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px; width: 45%;">
            <div class="my-3 py-3 position-relative">
                <?php if (in_array("3", $validatedExos)): ?>
                    <img src="../img/valide.png" alt="Validation"
                        style="position: absolute; top: 10px; left: 10px; width: 40px; height: 40px;">
                <?php else: ?>
                    <img src="../img/croix.png" alt="Non validé"
                        style="position: absolute; top: 0px; left: 10px; width: 60px; height: 60px;">
                <?php endif; ?>
                <a href="/exo3/lfi_exo1.php">
                    <img src="../img/demarrer2.png" alt="Démarrer l'exercice"
                        style="position: absolute; top: 10px; right: 10px; width: 60px; height: 60px;">
                </a>
                <div class="d-flex justify-content-center align-items-center">
                    <h2 class="display-5" style="color: black; margin-right: 10px;">LFI 1</h2>
                    <img src="../img/lvl1.png" alt="level 1" style="width: 30px; height: 30px;">
                    <span style="color: rgb(69, 251, 14);"> &nbspeasy</span>
                </div>
                <p class="lead" style="color: black;">Retrouvez le flag dans le dossier lfi/flag_lfi1</p>
            </div>
            <div class="d-flex justify-content-between mt-4">
                <div class="text-center">
                    <a href="explications/lfi_explication.php">
                        <img src="../img/explication.png" alt="Explication"
                            style="width: 60px; height: 60px; border-radius: 8px;">
                    </a>
                </div>
                <div class="text-center">
                    <img src="../img/monde.png" alt="Explication"
                        style="width: 60px; height: 60px; border-radius: 8px;">
                    <form method="GET">
                        <div class="mb-3">
                            <input type="hidden" name="id" value="3">
                            <input type="text" style="margin-top: 10px;" class="form-control" id="flag" name="flag"
                                placeholder="Entrer votre flag">
                        </div>
                        <button type="submit">Valider</button>
                    </form>
                </div>
                <div class="text-center">
                    <a href="solution_video.php?id=3">
                        <img src="../img/solution.png" alt="Solution"
                            style="width: 60px; height: 60px; border-radius: 8px; margin-bottom: 20px;">
                    </a>
                </div>
            </div>
        </div>

        <div class="mr-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center text-white overflow-hidden"
            style="border-radius: 15px; box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px; width: 45%;">
            <div class="my-3 py-3 position-relative">
                <?php if (in_array("4", $validatedExos)): ?>
                    <img src="../img/valide.png" alt="Validation"
                        style="position: absolute; top: 10px; left: 10px; width: 40px; height: 40px;">
                <?php else: ?>
                    <img src="../img/croix.png" alt="Non validé"
                        style="position: absolute; top: 0px; left: 10px; width: 60px; height: 60px;">
                <?php endif; ?>
                <a href="/exo4/lfi_exo2.php">
                    <img src="../img/demarrer2.png" alt="Démarrer l'exercice"
                        style="position: absolute; top: 10px; right: 10px; width: 60px; height: 60px;">
                </a>
                <div class="d-flex justify-content-center align-items-center">
                    <h2 class="display-5" style="color: black; margin-right: 10px;">LFI 2</h2>
                    <img src="../img/lvl3.png" alt="level 3" style="width: 30px; height: 30px;">
                    <span style="color: rgb(255, 128, 0);"> &nbsp medium</span>
                </div>
                <p class="lead" style="color: black;">Retrouvez le flag dans le dossier lfi/flag_lfi2</p>
            </div>
            <div class="d-flex justify-content-between mt-4">
                <div class="text-center">
                    <a href="explications/lfi_explication.php">
                        <img src="../img/explication.png" alt="Explication"
                            style="width: 60px; height: 60px; border-radius: 8px;">
                    </a>
                </div>
                <div class="text-center">
                    <img src="../img/monde.png" alt="Explication"
                        style="width: 60px; height: 60px; border-radius: 8px;">
                    <form method="GET">
                        <div class="mb-3">
                            <input type="hidden" name="id" value="4">
                            <input type="text" style="margin-top: 10px;" class="form-control" id="flag" name="flag"
                                placeholder="Entrer votre flag">
                        </div>
                        <button type="submit">Valider</button>
                    </form>
                </div>
                <div class="text-center">
                    <a href="solution_video.php?id=4">
                        <img src="../img/solution.png" alt="Solution"
                            style="width: 60px; height: 60px; border-radius: 8px; margin-bottom: 20px;">
                    </a>
                </div>
            </div>
        </div>
    </div>

    <br>
    <br>

    <div class="d-flex justify-content-center w-100 my-md-3 pl-md-3 mx-auto">
        <div class="mr-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center text-white overflow-hidden"
            style="border-radius: 15px; box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px; width: 45%;">
            <div class="my-3 py-3 position-relative">
                <?php if (in_array("5", $validatedExos)): ?>
                    <img src="../img/valide.png" alt="Validation"
                        style="position: absolute; top: 10px; left: 10px; width: 40px; height: 40px;">
                <?php else: ?>
                    <img src="../img/croix.png" alt="Non validé"
                        style="position: absolute; top: 0px; left: 10px; width: 60px; height: 60px;">
                <?php endif; ?>
                <a href="/exo5/xss_exo1.php">
                    <img src="../img/demarrer2.png" alt="Démarrer l'exercice"
                        style="position: absolute; top: 10px; right: 10px; width: 60px; height: 60px;">
                </a>
                <div class="d-flex justify-content-center align-items-center">
                    <h2 class="display-5" style="color: black; margin-right: 10px;">XSS Stored</h2>
                    <img src="../img/lvl1.png" alt="level 1" style="width: 30px; height: 30px;">
                    <span style="color: rgb(69, 251, 14);"> &nbspeasy</span>
                </div>
                <p class="lead" style="color: black;">Simuler la récupèration des cookies</p>
            </div>
            <div class="d-flex justify-content-between mt-4">
                <div class="text-center">
                    <a href="../explications/xss_explication.html">
                        <img src="../img/explication.png" alt="Explication"
                            style="width: 60px; height: 60px; border-radius: 8px;">
                    </a>
                </div>
                <div class="text-center">
                    <img src="../img/monde.png" alt="Explication"
                        style="width: 60px; height: 60px; border-radius: 8px;">
                    <form method="GET">
                        <div class="mb-3">
                            <input type="hidden" name="id" value="5">
                            <input type="text" style="margin-top: 10px;" class="form-control" id="flag" name="flag"
                                placeholder="Entrer votre flag">
                        </div>
                        <button type="submit">Valider</button>
                    </form>
                </div>
                <div class="text-center">
                    <a href="solution_video.php?id=5">
                        <img src="../img/solution.png" alt="Solution"
                            style="width: 60px; height: 60px; border-radius: 8px; margin-bottom: 20px;">
                    </a>
                </div>
            </div>
        </div>

        <div class="mr-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center text-white overflow-hidden"
            style="border-radius: 15px; box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px; width: 45%;">
            <div class="my-3 py-3 position-relative">
                <?php if (in_array("6", $validatedExos)): ?>
                    <img src="../img/valide.png" alt="Validation"
                        style="position: absolute; top: 10px; left: 10px; width: 40px; height: 40px;">
                <?php else: ?>
                    <img src="../img/croix.png" alt="Non validé"
                        style="position: absolute; top: 0px; left: 10px; width: 60px; height: 60px;">
                <?php endif; ?>
                <a href="/exo6/crack_exo1.php">
                    <img src="../img/demarrer2.png" alt="Démarrer l'exercice"
                        style="position: absolute; top: 10px; right: 10px; width: 60px; height: 60px;">
                </a>
                <div class="d-flex justify-content-center align-items-center">
                    <h2 class="display-5" style="color: black; margin-right: 10px;">Crack</h2>
                    <img src="../img/lvl1.png" alt="level 3" style="width: 30px; height: 30px;">
                    <span style="color: rgb(69, 251, 14);"> &nbsp easy</span>
                </div>
                <p class="lead" style="color: black;">Décoder tous les codes pour avoir le flag</p>
            </div>
            <div class="d-flex justify-content-between mt-4">
                <div class="text-center">
                    <a href="../explications/crack_explication.html">
                        <img src="../img/explication.png" alt="Explication"
                            style="width: 60px; height: 60px; border-radius: 8px;">
                    </a>
                </div>
                <div class="text-center">
                    <img src="../img/monde.png" alt="Explication"
                        style="width: 60px; height: 60px; border-radius: 8px;">
                    <form method="GET">
                        <div class="mb-3">
                            <input type="hidden" name="id" value="6">
                            <input type="text" style="margin-top: 10px;" class="form-control" id="flag" name="flag"
                                placeholder="Entrer votre flag">
                        </div>
                        <button type="submit">Valider</button>
                    </form>
                </div>
                <div class="text-center">
                    <a href="solution_video.php?id=6">
                        <img src="../img/solution.png" alt="Solution"
                            style="width: 60px; height: 60px; border-radius: 8px; margin-bottom: 20px;">
                    </a>
                </div>
            </div>
        </div>
    </div>
    <br>
    <br>

    <div class="d-flex justify-content-center w-100 my-md-3 pl-md-3 mx-auto">
        <div class="mr-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center text-white overflow-hidden"
            style="border-radius: 15px; box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px; width: 45%;">
            <div class="my-3 py-3 position-relative">
                <?php if (in_array("7", $validatedExos)): ?>
                    <img src="../img/valide.png" alt="Validation"
                        style="position: absolute; top: 10px; left: 10px; width: 40px; height: 40px;">
                <?php else: ?>
                    <img src="../img/croix.png" alt="Non validé"
                        style="position: absolute; top: 0px; left: 10px; width: 60px; height: 60px;">
                <?php endif; ?>
                <a href="/exo7/upload_exo1.php">
                    <img src="../img/demarrer2.png" alt="Démarrer l'exercice"
                        style="position: absolute; top: 10px; right: 10px; width: 60px; height: 60px;">
                </a>
                <div class="d-flex justify-content-center align-items-center">
                    <h2 class="display-5" style="color: black; margin-right: 10px;">Upload 1</h2>
                    <img src="../img/lvl1.png" alt="level 1" style="width: 30px; height: 30px;">
                    <span style="color: rgb(69, 251, 14);"> &nbspeasy</span>
                </div>
                <p class="lead" style="color: black;">Trouvez le flag dans le fichier upload_exo1.php</p>
            </div>
            <div class="d-flex justify-content-between mt-4">
                <div class="text-center">
                    <a href="../explications/upload_explication.html">
                        <img src="../img/explication.png" alt="Explication"
                            style="width: 60px; height: 60px; border-radius: 8px;">
                    </a>
                </div>
                <div class="text-center">
                    <img src="../img/monde.png" alt="Explication"
                        style="width: 60px; height: 60px; border-radius: 8px;">
                    <form method="GET">
                        <div class="mb-3">
                            <input type="hidden" name="id" value="7">
                            <input type="text" style="margin-top: 10px;" class="form-control" id="flag" name="flag"
                                placeholder="Entrer votre flag">
                        </div>
                        <button type="submit">Valider</button>
                    </form>
                </div>
                <div class="text-center">
                    <a href="solution_video.php?id=7">
                        <img src="../img/solution.png" alt="Solution"
                            style="width: 60px; height: 60px; border-radius: 8px; margin-bottom: 20px;">
                    </a>
                </div>
            </div>
        </div>

        <div class="mr-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center text-white overflow-hidden"
            style="border-radius: 15px; box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px; width: 45%;">
            <div class="my-3 py-3 position-relative">
                <?php if (in_array("8", $validatedExos)): ?>
                    <img src="../img/valide.png" alt="Validation"
                        style="position: absolute; top: 10px; left: 10px; width: 40px; height: 40px;">
                <?php else: ?>
                    <img src="../img/croix.png" alt="Non validé"
                        style="position: absolute; top: 0px; left: 10px; width: 60px; height: 60px;">
                <?php endif; ?>
                <a href="/exo8/upload_exo2.php">
                    <img src="../img/demarrer2.png" alt="Démarrer l'exercice"
                        style="position: absolute; top: 10px; right: 10px; width: 60px; height: 60px;">
                </a>
                <div class="d-flex justify-content-center align-items-center">
                    <h2 class="display-5" style="color: black; margin-right: 10px;">Upload 2</h2>
                    <img src="../img/lvl3.png" alt="level 3" style="width: 30px; height: 30px;">
                    <span style="color: rgb(255, 128, 0);"> &nbsp medium</span>
                </div>
                <p class="lead" style="color: black;">Trouvez le flag dans le fichier upload_exo2.php</p>
            </div>
            <div class="d-flex justify-content-between mt-4">
                <div class="text-center">
                    <a href="../explications/upload_explication.html">
                        <img src="../img/explication.png" alt="Explication"
                            style="width: 60px; height: 60px; border-radius: 8px;">
                    </a>
                </div>
                <div class="text-center">
                    <img src="../img/monde.png" alt="Explication"
                        style="width: 60px; height: 60px; border-radius: 8px;">
                    <form method="GET">
                        <div class="mb-3">
                            <input type="hidden" name="id" value="8">
                            <input type="text" style="margin-top: 10px;" class="form-control" id="flag" name="flag"
                                placeholder="Entrer votre flag">
                        </div>
                        <button type="submit">Valider</button>
                    </form>
                </div>
                <div class="text-center">
                    <a href="solution_video.php?id=8">
                        <img src="../img/solution.png" alt="Solution"
                            style="width: 60px; height: 60px; border-radius: 8px; margin-bottom: 20px;">
                    </a>
                </div>
            </div>
        </div>
    </div>

    <br>
    <div class="d-flex justify-content-center w-100 my-md-3 pl-md-3 mx-auto">
        <div class="mr-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center text-white overflow-hidden"
            style="border-radius: 15px; box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px; width: 45%;">
            <div class="my-3 py-3 position-relative">
                <?php if (in_array("9", $validatedExos)): ?>
                    <img src="../img/valide.png" alt="Validation"
                        style="position: absolute; top: 10px; left: 10px; width: 40px; height: 40px;">
                <?php else: ?>
                    <img src="../img/croix.png" alt="Non validé"
                        style="position: absolute; top: 0px; left: 10px; width: 60px; height: 60px;">
                <?php endif; ?>
                <a href="/exo9/misconfig_exo1.html">
                    <img src="../img/demarrer2.png" alt="Démarrer l'exercice"
                        style="position: absolute; top: 10px; right: 10px; width: 60px; height: 60px;">
                </a>
                <div class="d-flex justify-content-center align-items-center">
                    <h2 class="display-5" style="color: black; margin-right: 10px;">Misconfiguration 1</h2>
                    <img src="../img/lvl1.png" alt="level 1" style="width: 30px; height: 30px;">
                    <span style="color: rgb(69, 251, 14);"> &nbspeasy</span>
                </div>
                <p class="lead" style="color: black;">Trouvez le flag</p>
            </div>
            <div class="d-flex justify-content-between mt-4">
                <div class="text-center">
                    <a href="../explications/misconfig_explication.html">
                        <img src="../img/explication.png" alt="Explication"
                            style="width: 60px; height: 60px; border-radius: 8px;">
                    </a>
                </div>
                <div class="text-center">
                    <img src="../img/monde.png" alt="Explication"
                        style="width: 60px; height: 60px; border-radius: 8px;">
                    <form method="GET">
                        <div class="mb-3">
                            <input type="hidden" name="id" value="9">
                            <input type="text" style="margin-top: 10px;" class="form-control" id="flag" name="flag"
                                placeholder="Entrer votre flag">
                        </div>
                        <button type="submit">Valider</button>
                    </form>
                </div>
                <div class="text-center">
                    <a href="solution_video.php?id=9">
                        <img src="../img/solution.png" alt="Solution"
                            style="width: 60px; height: 60px; border-radius: 8px; margin-bottom: 20px;">
                    </a>
                </div>
            </div>
        </div>

        <div class="mr-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center text-white overflow-hidden"
            style="border-radius: 15px; box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px; width: 45%;">
            <div class="my-3 py-3 position-relative">
                <?php if (in_array("10", $validatedExos)): ?>
                    <img src="../img/valide.png" alt="Validation"
                        style="position: absolute; top: 10px; left: 10px; width: 40px; height: 40px;">
                <?php else: ?>
                    <img src="../img/croix.png" alt="Non validé"
                        style="position: absolute; top: 0px; left: 10px; width: 60px; height: 60px;">
                <?php endif; ?>
                <a href="/exo10/csrf_exo1.php">
                    <img src="../img/demarrer2.png" alt="Démarrer l'exercice"
                        style="position: absolute; top: 10px; right: 10px; width: 60px; height: 60px;">
                </a>
                <div class="d-flex justify-content-center align-items-center">
                    <h2 class="display-5" style="color: black; margin-right: 10px;">CSRF 1</h2>
                    <img src="../img/lvl5.png" alt="level 3" style="width: 30px; height: 30px;">
                    <span style="color: rgb(255, 0, 0);"> &nbsp hard</span>
                </div>
                <p class="lead" style="color: black;">Essayer de faire un virement au compte "987654321"</p>
            </div>
            <div class="d-flex justify-content-between mt-4">
                <div class="text-center">
                    <a href="../explications/csrf_explication.html">
                        <img src="../img/explication.png" alt="Explication"
                            style="width: 60px; height: 60px; border-radius: 8px;">
                    </a>
                </div>
                <div class="text-center">
                    <img src="../img/monde.png" alt="Explication"
                        style="width: 60px; height: 60px; border-radius: 8px;">
                    <form method="GET">
                        <div class="mb-3">
                            <input type="hidden" name="id" value="10">
                            <input type="text" style="margin-top: 10px;" class="form-control" id="flag" name="flag"
                                placeholder="Entrer votre flag">
                        </div>
                        <button type="submit">Valider</button>
                    </form>
                </div>
                <div class="text-center">
                    <a href="solution_video.php?id=10">
                        <img src="../img/solution.png" alt="Solution"
                            style="width: 60px; height: 60px; border-radius: 8px; margin-bottom: 20px;">
                    </a>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="d-flex justify-content-center w-100 my-md-3 pl-md-3 mx-auto">
        <div class="mr-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center text-white overflow-hidden"
            style="border-radius: 15px; box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px; width: 45%;">
            <div class="my-3 py-3 position-relative">
                <?php if (in_array("11", $validatedExos)): ?>
                    <img src="../img/valide.png" alt="Validation"
                        style="position: absolute; top: 10px; left: 10px; width: 40px; height: 40px;">
                <?php else: ?>
                    <img src="../img/croix.png" alt="Non validé"
                        style="position: absolute; top: 0px; left: 10px; width: 60px; height: 60px;">
                <?php endif; ?>
                <a href="/exo11/insecure_deserialization.php">
                    <img src="../img/demarrer2.png" alt="Démarrer l'exercice"
                        style="position: absolute; top: 10px; right: 10px; width: 60px; height: 60px;">
                </a>
                <div class="d-flex justify-content-center align-items-center" style="margin-left : 30px;">
                    <h2 class="display-5" style="color: black;">Insecure Deserialization </h2>
                    <img src="../img/lvl1.png" alt="level 1" style="width: 30px; height: 30px; margin-left : 10px;">
                    <span style="color: rgb(69, 251, 14);"> &nbspeasy</span>
                </div>
                <p class="lead" style="color: black;">De Jean à Admin trouvez le flag.</p>
            </div>
            <div class="d-flex justify-content-between mt-4">
                <div class="text-center">
                    <a href="../explications/insecure_deserialization.html">
                        <img src="../img/explication.png" alt="Explication"
                            style="width: 60px; height: 60px; border-radius: 8px;">
                    </a>
                </div>
                <div class="text-center">
                    <img src="../img/monde.png" alt="Explication"
                        style="width: 60px; height: 60px; border-radius: 8px;">
                    <form method="GET">
                        <div class="mb-3">
                            <input type="hidden" name="id" value="11">
                            <input type="text" style="margin-top: 10px;" class="form-control" id="flag" name="flag"
                                placeholder="Entrer votre flag">
                        </div>
                        <button type="submit">Valider</button>
                    </form>
                </div>
                <div class="text-center">
                    <a href="solution_video.php?id=11">
                        <img src="../img/solution.png" alt="Solution"
                            style="width: 60px; height: 60px; border-radius: 8px; margin-bottom: 20px;">
                    </a>
                </div>
            </div>
        </div>

        <div class="mr-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center text-white overflow-hidden"
            style="border-radius: 15px; box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px; width: 45%;">
            <div class="my-3 py-3 position-relative">
                <?php if (in_array("12", $validatedExos)): ?>
                    <img src="../img/valide.png" alt="Validation"
                        style="position: absolute; top: 10px; left: 10px; width: 40px; height: 40px;">
                <?php else: ?>
                    <img src="../img/croix.png" alt="Non validé"
                        style="position: absolute; top: 0px; left: 10px; width: 60px; height: 60px;">
                <?php endif; ?>
                <a href="/exo12/jwt_exo1.php">
                    <img src="../img/demarrer2.png" alt="Démarrer l'exercice"
                        style="position: absolute; top: 10px; right: 10px; width: 60px; height: 60px;">
                </a>
                <div class="d-flex justify-content-center align-items-center">
                    <h2 class="display-5" style="color: black; margin-right: 10px;">JWT 1</h2>
                    <img src="../img/lvl1.png" alt="level 3" style="width: 30px; height: 30px;">
                    <span style="color: rgb(69, 251, 14);"> &nbsp easy</span>
                </div>
                <p class="lead" style="color: black;">Tu dois passer admin !</p>
            </div>
            <div class="d-flex justify-content-between mt-4">
                <div class="text-center">
                    <a href="../explications/jwt_explication.html">
                        <img src="../img/explication.png" alt="Explication"
                            style="width: 60px; height: 60px; border-radius: 8px;">
                    </a>
                </div>
                <div class="text-center">
                    <img src="../img/monde.png" alt="Explication"
                        style="width: 60px; height: 60px; border-radius: 8px;">
                    <form method="GET">
                        <div class="mb-3">
                            <input type="hidden" name="id" value="12">
                            <input type="text" style="margin-top: 10px;" class="form-control" id="flag" name="flag"
                                placeholder="Entrer votre flag">
                        </div>
                        <button type="submit">Valider</button>
                    </form>
                </div>
                <div class="text-center">
                    <a href="solution_video.php?id=12">
                        <img src="../img/solution.png" alt="Solution"
                            style="width: 60px; height: 60px; border-radius: 8px; margin-bottom: 20px;">
                    </a>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="d-flex justify-content-center w-100 my-md-3 pl-md-3 mx-auto">
        <div class="mr-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center text-white overflow-hidden"
            style="border-radius: 15px; box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px; width: 45%;">
            <div class="my-3 py-3 position-relative">
                <?php if (in_array("13", $validatedExos)): ?>
                    <img src="../img/valide.png" alt="Validation"
                        style="position: absolute; top: 10px; left: 10px; width: 40px; height: 40px;">
                <?php else: ?>
                    <img src="../img/croix.png" alt="Non validé"
                        style="position: absolute; top: 0px; left: 10px; width: 60px; height: 60px;">
                <?php endif; ?>
                <a href="/exo13/jwt_exo2.php">
                    <img src="../img/demarrer2.png" alt="Démarrer l'exercice"
                        style="position: absolute; top: 10px; right: 10px; width: 60px; height: 60px;">
                </a>
                <div class="d-flex justify-content-center align-items-center" style="margin-left : 30px;">
                    <h2 class="display-5" style="color: black;">JWT 2 </h2>
                    <img src="../img/lvl3.png" alt="level 1" style="width: 30px; height: 30px; margin-left : 10px;">
                    <span style="color: rgb(255, 128, 0);"> &nbspmedium</span>
                </div>
                <p class="lead" style="color: black;">Tu dois encore passer Admin !</p>
            </div>
            <div class="d-flex justify-content-between mt-4">
                <div class="text-center">
                    <a href="../explications/jwt_explication.html">
                        <img src="../img/explication.png" alt="Explication"
                            style="width: 60px; height: 60px; border-radius: 8px;">
                    </a>
                </div>
                <div class="text-center">
                    <img src="../img/monde.png" alt="Explication"
                        style="width: 60px; height: 60px; border-radius: 8px;">
                    <form method="GET">
                        <div class="mb-3">
                            <input type="hidden" name="id" value="13">
                            <input type="text" style="margin-top: 10px;" class="form-control" id="flag" name="flag"
                                placeholder="Entrer votre flag">
                        </div>
                        <button type="submit">Valider</button>
                    </form>
                </div>
                <div class="text-center">
                    <a href="solution_video.php?id=13">
                        <img src="../img/solution.png" alt="Solution"
                            style="width: 60px; height: 60px; border-radius: 8px; margin-bottom: 20px;">
                    </a>
                </div>
            </div>
        </div>

        <div class="mr-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center text-white overflow-hidden"
            style="border-radius: 15px; box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px; width: 45%;">
            <div class="my-3 py-3 position-relative">
                <?php if (in_array("14", $validatedExos)): ?>
                    <img src="../img/valide.png" alt="Validation"
                        style="position: absolute; top: 10px; left: 10px; width: 40px; height: 40px;">
                <?php else: ?>
                    <img src="../img/croix.png" alt="Non validé"
                        style="position: absolute; top: 0px; left: 10px; width: 60px; height: 60px;">
                <?php endif; ?>
                <a href="/exo14/injection_command.php">
                    <img src="../img/demarrer2.png" alt="Démarrer l'exercice"
                        style="position: absolute; top: 10px; right: 10px; width: 60px; height: 60px;">
                </a>
                <div class="d-flex justify-content-center align-items-center">
                    <h2 class="display-5" style="color: black; margin-right: 10px;">Injection command</h2>
                    <img src="../img/lvl5.png" alt="level 3" style="width: 30px; height: 30px;">
                    <span style="color: rgb(255, 0, 0);"> &nbsp hard</span>
                </div>
                <p class="lead" style="color: black;">Trouve le flag dans le fichier injection_command.php</p>
            </div>
            <div class="d-flex justify-content-between mt-4">
                <div class="text-center">
                    <a href="../explications/command_explication.html">
                        <img src="../img/explication.png" alt="Explication"
                            style="width: 60px; height: 60px; border-radius: 8px;">
                    </a>
                </div>
                <div class="text-center">
                    <img src="../img/monde.png" alt="Explication"
                        style="width: 60px; height: 60px; border-radius: 8px;">
                    <form method="GET">
                        <div class="mb-3">
                            <input type="hidden" name="id" value="14">
                            <input type="text" style="margin-top: 10px;" class="form-control" id="flag" name="flag"
                                placeholder="Entrer votre flag">
                        </div>
                        <button type="submit">Valider</button>
                    </form>
                </div>
                <div class="text-center">
                    <a href="solution_video.php?id=14">
                        <img src="../img/solution.png" alt="Solution"
                            style="width: 60px; height: 60px; border-radius: 8px; margin-bottom: 20px;">
                    </a>
                </div>
            </div>
        </div>
    </div>
    <br>
	<div class="d-flex justify-content-center w-100 my-md-3 pl-md-3 mx-auto">
        <div class="mr-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center text-white overflow-hidden"
            style="border-radius: 15px; box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px; width: 45%;">
            <div class="my-3 py-3 position-relative">
                <?php if (in_array("15", $validatedExos)): ?>
                    <img src="../img/valide.png" alt="Validation"
                        style="position: absolute; top: 10px; left: 10px; width: 40px; height: 40px;">
                <?php else: ?>
                    <img src="../img/croix.png" alt="Non validé"
                        style="position: absolute; top: 0px; left: 10px; width: 60px; height: 60px;">
                <?php endif; ?>
                <a href="/exo15/outdated_module.php">
                    <img src="../img/demarrer2.png" alt="Démarrer l'exercice"
                        style="position: absolute; top: 10px; right: 10px; width: 60px; height: 60px;">
                </a>
                <div class="d-flex justify-content-center align-items-center" style="margin-left : 30px;">
                    <h2 class="display-5" style="color: black;">Outdated module</h2>
                    <img src="../img/lvl3.png" alt="level 1" style="width: 30px; height: 30px; margin-left : 10px;">
                    <span style="color: rgb(255, 128, 0);"> &nbspmedium</span>
                </div>
                <p class="lead" style="color: black;">Essaie de lire le fichier flag.txt</p>
            </div>
            <div class="d-flex justify-content-between mt-4">
                <div class="text-center">
                    <a href="../explications/module_explication.html">
                        <img src="../img/explication.png" alt="Explication"
                            style="width: 60px; height: 60px; border-radius: 8px;">
                    </a>
                </div>
                <div class="text-center">
                    <img src="../img/monde.png" alt="Explication"
                        style="width: 60px; height: 60px; border-radius: 8px;">
                    <form method="GET">
                        <div class="mb-3">
                            <input type="hidden" name="id" value="15">
                            <input type="text" style="margin-top: 10px;" class="form-control" id="flag" name="flag"
                                placeholder="Entrer votre flag">
                        </div>
                        <button type="submit">Valider</button>
                    </form>
                </div>
                <div class="text-center">
                    <a href="solution_video.php?id=15">
                        <img src="../img/solution.png" alt="Solution"
                            style="width: 60px; height: 60px; border-radius: 8px; margin-bottom: 20px;">
                    </a>
                </div>
            </div>
        </div>

        <div class="mr-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center text-white overflow-hidden"
            style="border-radius: 15px; box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px; width: 45%;">
            <div class="my-3 py-3 position-relative">
                <?php if (in_array("16", $validatedExos)): ?>
                    <img src="../img/valide.png" alt="Validation"
                        style="position: absolute; top: 10px; left: 10px; width: 40px; height: 40px;">
                <?php else: ?>
                    <img src="../img/croix.png" alt="Non validé"
                        style="position: absolute; top: 0px; left: 10px; width: 60px; height: 60px;">
                <?php endif; ?>
                <a href="/exo16/reverse_shell.php">
                    <img src="../img/demarrer2.png" alt="Démarrer l'exercice"
                        style="position: absolute; top: 10px; right: 10px; width: 60px; height: 60px;">
                </a>
                <div class="d-flex justify-content-center align-items-center">
                    <h2 class="display-5" style="color: black; margin-right: 10px;">Reverse Shell</h2>
                    <img src="../img/lvl1.png" alt="level 3" style="width: 30px; height: 30px;">
                    <span style="color: rgb(69, 251, 14);"> &nbsp easy</span>
                </div>
                <p class="lead" style="color: black;">Exploiter un reverse shell</p>
            </div>
            <div class="d-flex justify-content-between mt-4">
                <div class="text-center">
                    <a href="https://sysdig.com/learn-cloud-native/what-is-a-reverse-shell/">
                        <img src="../img/explication.png" alt="Explication"
                            style="width: 60px; height: 60px; border-radius: 8px;">
                    </a>
                </div>
                <div class="text-center">
                    <img src="../img/monde.png" alt="Explication"
                        style="width: 60px; height: 60px; border-radius: 8px;">
                    <form method="GET">
                        <div class="mb-3">
                            <input type="hidden" name="id" value="16">
                            <input type="text" style="margin-top: 10px;" class="form-control" id="flag" name="flag"
                                placeholder="Entrer votre flag">
                        </div>
                        <button type="submit">Valider</button>
                    </form>
                </div>
                <div class="text-center">
                    <a href="solution_video.php?id=16">
                        <img src="../img/solution.png" alt="Solution"
                            style="width: 60px; height: 60px; border-radius: 8px; margin-bottom: 20px;">
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>