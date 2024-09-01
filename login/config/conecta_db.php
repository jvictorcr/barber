<?php

// Define as constantes para conexão com o banco de dados
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'Melancia@13?');
define('DB_NAME', 'barber');

// Realiza a conexão com o banco de dados
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USERNAME, DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Falha na conexão: " . $e->getMessage();
    exit();
}

// Verifica se a conexão foi realizada com sucesso
if (!$pdo) {
    echo "Falha na conexão: conexão nula";
    exit();
}

?>