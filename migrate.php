<?php
/**
 * Run once to create database and tables.
 * Uses same DB as original OSAEITS (osaeits_db) - run from XAMPP or create DB first.
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);

$db_host = 'localhost';
$db_name = 'osaeits_db';
$db_user = 'root';
$db_pass = '';

try {
    $pdo = new PDO("mysql:host=$db_host;charset=utf8mb4", $db_user, $db_pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$db_name`");
    $pdo->exec("USE `$db_name`");
} catch (PDOException $e) {
    die('Connection failed: ' . $e->getMessage());
}

$pdo->exec("CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    role ENUM('admin', 'user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)");

$pdo->exec("CREATE TABLE IF NOT EXISTS supplies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    category VARCHAR(50) NOT NULL,
    unit VARCHAR(20) NOT NULL,
    current_stock INT DEFAULT 0,
    minimum_stock INT DEFAULT 0,
    unit_price DECIMAL(10,2) DEFAULT 0.00,
    supplier VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)");

$pdo->exec("CREATE TABLE IF NOT EXISTS equipment (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    category VARCHAR(50) NOT NULL,
    serial_number VARCHAR(100) UNIQUE,
    model VARCHAR(100),
    brand VARCHAR(100),
    status ENUM('servicable', 'unservicable') DEFAULT 'servicable',
    location VARCHAR(100),
    purok_area VARCHAR(120) NULL,
    appropriation VARCHAR(180) NULL,
    person_incharge VARCHAR(120) NULL,
    assigned_to INT,
    purchase_date DATE,
    warranty_expiry DATE,
    purchase_price DECIMAL(10,2) DEFAULT 0.00,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)");

// Ensure new reporting columns exist on old databases.
try { $pdo->exec("ALTER TABLE equipment ADD COLUMN purok_area VARCHAR(120) NULL AFTER location"); } catch (Throwable $e) {}
try { $pdo->exec("ALTER TABLE equipment ADD COLUMN appropriation VARCHAR(180) NULL AFTER purok_area"); } catch (Throwable $e) {}
try { $pdo->exec("ALTER TABLE equipment ADD COLUMN person_incharge VARCHAR(120) NULL AFTER appropriation"); } catch (Throwable $e) {}

// Normalize legacy status values, then enforce current enum.
try {
    $pdo->exec("UPDATE equipment SET status = 'servicable' WHERE status IN ('available','in_use','maintenance')");
    $pdo->exec("UPDATE equipment SET status = 'unservicable' WHERE status IN ('retired')");
    $pdo->exec("ALTER TABLE equipment MODIFY status ENUM('servicable', 'unservicable') DEFAULT 'servicable'");
} catch (Throwable $e) {
    // Ignore on fresh installs or DBs that already match this schema.
}

$pdo->exec("CREATE TABLE IF NOT EXISTS inventory (
    id INT AUTO_INCREMENT PRIMARY KEY,
    item_type ENUM('supply', 'equipment') NOT NULL,
    item_id INT NOT NULL,
    quantity INT DEFAULT 0,
    action ENUM('in', 'out', 'adjustment') NOT NULL,
    reference_number VARCHAR(100),
    notes TEXT,
    user_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

$pdo->exec("CREATE TABLE IF NOT EXISTS transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    item_type ENUM('supply', 'equipment') NOT NULL,
    item_id INT NOT NULL,
    transaction_type ENUM('purchase', 'issue', 'return', 'adjustment') NOT NULL,
    quantity INT NOT NULL,
    unit_price DECIMAL(10,2) DEFAULT 0.00,
    total_amount DECIMAL(10,2) DEFAULT 0.00,
    reference_number VARCHAR(100),
    notes TEXT,
    user_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

$pdo->exec("CREATE TABLE IF NOT EXISTS activity_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NULL,
    action VARCHAR(100) NOT NULL,
    entity_type VARCHAR(50) NULL,
    entity_id INT NULL,
    details TEXT NULL,
    ip_address VARCHAR(45) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_activity_created (created_at),
    INDEX idx_activity_user (user_id),
    INDEX idx_activity_entity (entity_type, entity_id)
)");

$pdo->exec("CREATE TABLE IF NOT EXISTS barangay_officials (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(60) NOT NULL,
    middle_name VARCHAR(60) NULL,
    last_name VARCHAR(60) NOT NULL,
    suffix VARCHAR(20) NULL,
    position_title VARCHAR(120) NOT NULL,
    committee VARCHAR(120) NULL,
    contact_number VARCHAR(30) NULL,
    email VARCHAR(120) NULL,
    term_start DATE NULL,
    term_end DATE NULL,
    status ENUM('active', 'inactive') DEFAULT 'active',
    notes TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_official_position (position_title),
    INDEX idx_official_status (status)
)");

$pdo->exec("CREATE TABLE IF NOT EXISTS assign_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    item_type ENUM('supply', 'equipment', 'inventory') NOT NULL,
    item_ref_id INT NOT NULL,
    quantity INT DEFAULT 1,
    assigned_to VARCHAR(120) NOT NULL,
    assigned_area VARCHAR(120) NULL,
    appropriation VARCHAR(180) NULL,
    assigned_date DATE NOT NULL,
    status ENUM('assigned', 'returned') DEFAULT 'assigned',
    notes TEXT NULL,
    user_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_assign_item (item_type, item_ref_id),
    INDEX idx_assign_status (status),
    INDEX idx_assign_date (assigned_date)
)");

// Ensure assignment appropriation column exists on old databases.
try { $pdo->exec("ALTER TABLE assign_items ADD COLUMN appropriation VARCHAR(180) NULL AFTER assigned_area"); } catch (Throwable $e) {}

$stmt = $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'admin'");
if ($stmt->fetchColumn() == 0) {
    $hash = password_hash('admin123', PASSWORD_DEFAULT);
    $pdo->prepare("INSERT INTO users (username, email, password, first_name, last_name, role) VALUES ('admin', 'admin@osaeits.com', ?, 'Admin', 'User', 'admin')")->execute([$hash]);
    echo "Default admin created: admin@osaeits.com / admin123<br>";
}

echo "<h2>Migration done.</h2>";
echo "<p><a href='login.php'>Go to Login</a></p>";
