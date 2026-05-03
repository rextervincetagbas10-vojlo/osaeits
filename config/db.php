<?php
/**
 * Database connection - simple PDO
 */
$db_host = 'tswkc0kg0wg4s0cc0g40woo8'; 
$db_name = 'osaeits_db';
$db_user = 'mysql'; // Note: Your connection string uses 'mysql' as the user
$db_pass = 'OziCKHrZSWAh5fXpv10n1r4ltO4xLGcsFoI7NEWs3KdLFtrFKZZKfV2FAjsOqZrO';

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
