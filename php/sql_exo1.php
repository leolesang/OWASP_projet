<?php

include('config.php');
$conn = getDbConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = isset($_POST['email']) ? trim($_POST['email']) : null;
    $password = isset($_POST['password']) ? trim($_POST['password']) : null;

    if (!empty($email) && !empty($password)) {
        echo "Email: " . htmlspecialchars($email) . "<br>";
        echo "Password: " . htmlspecialchars($password) . "<br>";

        $sql = "SELECT * FROM exo1_sql";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "ID: " . $row["id"] . " - Name: " . $row["name"] . "<br>";
            }
        } else {
            echo "0 results";
        }
    } else {
        echo "Veuillez remplir tous les champs.";
    }
} else {
    echo "Méthode non autorisée.";
}
