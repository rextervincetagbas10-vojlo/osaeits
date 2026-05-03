<?php
session_start();
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/auth-check.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id > 0) {
    $stmt = $pdo->prepare('SELECT id, name, serial_number FROM equipment WHERE id = ?');
    $stmt->execute([$id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        require_once __DIR__ . '/../includes/activity-log.php';
        log_activity($pdo, (int)$_SESSION['user_id'], 'equipment.delete', 'equipment', $id, [
            'name' => $row['name'],
            'serial_number' => $row['serial_number'],
        ]);
        $pdo->prepare('DELETE FROM equipment WHERE id = ?')->execute([$id]);
    }
}
$_SESSION['success_message'] = 'Equipment deleted.';
header('Location: equipment.php');
exit;
