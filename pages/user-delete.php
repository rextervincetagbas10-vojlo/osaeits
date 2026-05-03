<?php
session_start();
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/auth-check.php';

if (empty($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: dashboard.php');
    exit;
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id > 0 && $id != $_SESSION['user_id']) {
    $stmt = $pdo->prepare('SELECT id, username, email FROM users WHERE id = ?');
    $stmt->execute([$id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        require_once __DIR__ . '/../includes/activity-log.php';
        log_activity($pdo, (int)$_SESSION['user_id'], 'user.delete', 'user', $id, [
            'deleted_username' => $row['username'],
            'deleted_email' => $row['email'],
        ]);
        $pdo->prepare('DELETE FROM users WHERE id = ?')->execute([$id]);
    }
}
$_SESSION['success_message'] = 'User deleted.';
header('Location: users.php');
exit;
