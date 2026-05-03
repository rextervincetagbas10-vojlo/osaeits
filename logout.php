<?php
session_start();
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/activity-log.php';

$uid = !empty($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : null;
if ($uid) {
    log_activity($pdo, $uid, 'auth.logout', null, null, null);
}

$_SESSION = [];
if (ini_get('session.use_cookies')) {
    $p = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
}
session_destroy();
header('Location: login.php');
exit;
