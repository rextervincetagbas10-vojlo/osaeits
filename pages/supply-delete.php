<?php
session_start();
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/auth-check.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id > 0) {
    $stmt = $pdo->prepare('SELECT id, name FROM supplies WHERE id = ?');
    $stmt->execute([$id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        require_once __DIR__ . '/../includes/activity-log.php';
        log_activity($pdo, (int)$_SESSION['user_id'], 'supply.delete', 'supply', $id, ['name' => $row['name']]);
        $pdo->prepare('DELETE FROM supplies WHERE id = ?')->execute([$id]);
    }
}
$_SESSION['success_message'] = 'Supply deleted.';
header('Location: supplies.php');
exit;
