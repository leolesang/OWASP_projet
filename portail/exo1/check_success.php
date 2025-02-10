<?php
session_start();

header('Content-Type: application/json');
$response = ['success' => $_SESSION['challenge_success'] ?? false];
echo json_encode($response);
