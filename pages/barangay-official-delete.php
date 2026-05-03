<?php
session_start();
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/auth-check.php';

if (empty($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: dashboard.php');
    exit;
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id > 0) {
    $stmt = $pdo->prepare("SELECT id, first_name, last_name, position_title FROM barangay_officials WHERE id = ?");
    $stmt->execute([$id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        require_once __DIR__ . '/../includes/activity-log.php';
        log_activity($pdo, (int)$_SESSION['user_id'], 'official.delete', 'barangay_official', $id, [
            'name' => trim($row['first_name'] . ' ' . $row['last_name']),
            'position_title' => $row['position_title'],
        ]);
        $pdo->prepare("DELETE FROM barangay_officials WHERE id = ?")->execute([$id]);
    }
}

$_SESSION['success_message'] = 'Barangay official deleted.';
header('Location: barangay-officials.php');
exit;
