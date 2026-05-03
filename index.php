<?php
session_start();
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/auth-check.php';

// Redirect to dashboard in pages (no sidebar on index)
header('Location: pages/dashboard.php');
exit;
