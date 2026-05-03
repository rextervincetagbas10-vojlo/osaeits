<?php
/**
 * Database connection - simple PDO
 */
$db_host = 'localhost';
$db_name = 'osaeits_db';
$db_user = 'root';
$db_pass = '';

try {
    $pdo = new PDO(
        "mysql:host=$db_host;dbname=$db_name;charset=utf8mb4",
        $db_user,
        $db_pass,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    die('<h1>Database error</h1><p>' . htmlspecialchars($e->getMessage()) . '</p><p>Run migrate.php first.</p>');
}
