<?php
define('DB_HOST', 'db');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'root');
define('DB_NAME', 'owasp');

function getDbConnection()
{
    $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
    if ($conn->connect_error) {
        die("La connexion a échoué : " . $conn->connect_error);
    }
    return $conn;
}
