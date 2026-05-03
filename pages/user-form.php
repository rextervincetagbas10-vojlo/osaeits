<?php
session_start();
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/auth-check.php';

if (empty($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: dashboard.php');
    exit;
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$user = null;
if ($id > 0) {
    $stmt = $pdo->prepare("SELECT id, username, email, first_name, last_name, role FROM users WHERE id = ?");
    $stmt->execute([$id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$user) { header('Location: users.php'); exit; }
}

$page_title = $user ? 'Edit User' : 'Add User';
$current_page = 'users';
$base_url = '../';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? 'user';
    if (!in_array($role, ['admin', 'user'])) $role = 'user';
    if (!$first_name || !$last_name || !$username || !$email) {
        $error = 'Name, username and email are required.';
    } elseif (!$user && strlen($password) < 6) {
        $error = 'Password must be at least 6 characters for new user.';
    } else {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE (email = ? OR username = ?) AND id != ?");
        $stmt->execute([$email, $username, $id]);
        if ($stmt->fetch()) {
            $error = 'Email or username already in use.';
        } else {
            if ($user) {
                if ($password !== '') {
                    $hash = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $pdo->prepare("UPDATE users SET first_name=?, last_name=?, username=?, email=?, password=?, role=? WHERE id=?");
                    $stmt->execute([$first_name, $last_name, $username, $email, $hash, $role, $id]);
                } else {
                    $stmt = $pdo->prepare("UPDATE users SET first_name=?, last_name=?, username=?, email=?, role=? WHERE id=?");
                    $stmt->execute([$first_name, $last_name, $username, $email, $role, $id]);
                }
            } else {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("INSERT INTO users (first_name, last_name, username, email, password, role) VALUES (?,?,?,?,?,?)");
                $stmt->execute([$first_name, $last_name, $username, $email, $hash, $role]);
            }
            require_once __DIR__ . '/../includes/activity-log.php';
            $actor = (int)$_SESSION['user_id'];
            if ($user) {
                log_activity($pdo, $actor, 'user.update', 'user', $id, [
                    'username' => $username,
                    'email' => $email,
                    'role' => $role,
                ]);
            } else {
                log_activity($pdo, $actor, 'user.create', 'user', (int)$pdo->lastInsertId(), [
                    'username' => $username,
                    'email' => $email,
                    'role' => $role,
                ]);
            }
            $_SESSION['success_message'] = $user ? 'User updated.' : 'User added.';
            header('Location: users.php');
            exit;
        }
    }
}

if ($error && $_POST) {
    $user = array_merge($user ?? [], $_POST);
}
if (!$user) {
    $user = ['first_name'=>'','last_name'=>'','username'=>'','email'=>'','role'=>'user'];
}

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/sidebar.php';
require_once __DIR__ . '/../includes/topbar.php';
?>

<div class="card shadow mb-4">
    <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary"><?= $page_title ?></h6></div>
    <div class="card-body">
        <?php if ($error): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>
        <form method="post">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>First name *</label>
                    <input type="text" name="first_name" class="form-control" value="<?= htmlspecialchars($user['first_name']) ?>" required>
                </div>
                <div class="form-group col-md-6">
                    <label>Last name *</label>
                    <input type="text" name="last_name" class="form-control" value="<?= htmlspecialchars($user['last_name']) ?>" required>
                </div>
            </div>
            <div class="form-group">
                <label>Username *</label>
                <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($user['username']) ?>" required>
            </div>
            <div class="form-group">
                <label>Email *</label>
                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required>
            </div>
            <div class="form-group">
                <label>Password <?= $user && isset($user['id']) ? '(leave blank to keep)' : '*' ?></label>
                <input type="password" name="password" class="form-control" <?= ($user && isset($user['id'])) ? '' : 'required' ?>>
            </div>
            <div class="form-group">
                <label>Role</label>
                <select name="role" class="form-control">
                    <option value="user" <?= ($user['role'] ?? '') === 'user' ? 'selected' : '' ?>>User</option>
                    <option value="admin" <?= ($user['role'] ?? '') === 'admin' ? 'selected' : '' ?>>Admin</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="users.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
