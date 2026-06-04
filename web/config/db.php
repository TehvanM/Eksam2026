<?php
define('DB_HOST', '10.0.16.5');
define('DB_USER', 'ktadmin');
define('DB_PASS', 'Passw0rd');
define('DB_NAME', 'kasutajatugi_db');


try {
    $pdo = new PDO(
        'mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8mb4',
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
         PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
    );
} catch (PDOException $e) {
    die('Andmebaasi viga: ' . $e->getMessage());
}
?>
