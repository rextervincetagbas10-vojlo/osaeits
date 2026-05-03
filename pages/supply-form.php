<?php
session_start();
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/auth-check.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$supply = null;
if ($id > 0) {
    $stmt = $pdo->prepare("SELECT * FROM supplies WHERE id = ?");
    $stmt->execute([$id]);
    $supply = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$supply) { header('Location: supplies.php'); exit; }
}

$page_title = $supply ? 'Edit Supply' : 'Add Supply';
$current_page = 'supplies';
$base_url = '../';
$fixed_category = 'Supplies';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $category = $fixed_category;
    $unit = trim($_POST['unit'] ?? '');
    $current_stock = (int)($_POST['current_stock'] ?? 0);
    $minimum_stock = (int)($_POST['minimum_stock'] ?? 0);
    $unit_price = (float)($_POST['unit_price'] ?? 0);
    $supplier = trim($_POST['supplier'] ?? '');
    if (!$name || !$unit) {
        $error = 'Name and unit are required.';
    } else {
        if ($supply) {
            $stmt = $pdo->prepare("UPDATE supplies SET name=?, description=?, category=?, unit=?, current_stock=?, minimum_stock=?, unit_price=?, supplier=? WHERE id=?");
            $stmt->execute([$name, $description, $category, $unit, $current_stock, $minimum_stock, $unit_price, $supplier, $id]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO supplies (name, description, category, unit, current_stock, minimum_stock, unit_price, supplier) VALUES (?,?,?,?,?,?,?,?)");
            $stmt->execute([$name, $description, $category, $unit, $current_stock, $minimum_stock, $unit_price, $supplier]);
        }
        require_once __DIR__ . '/../includes/activity-log.php';
        $actor = (int)$_SESSION['user_id'];
        if ($supply) {
            log_activity($pdo, $actor, 'supply.update', 'supply', $id, ['name' => $name]);
        } else {
            log_activity($pdo, $actor, 'supply.create', 'supply', (int)$pdo->lastInsertId(), ['name' => $name]);
        }
        $_SESSION['success_message'] = $supply ? 'Supply updated.' : 'Supply added.';
        header('Location: supplies.php');
        exit;
    }
    $supply = array_merge(['name'=>'','description'=>'','category'=>$fixed_category,'unit'=>'','current_stock'=>0,'minimum_stock'=>0,'unit_price'=>0,'supplier'=>''], $_POST);
    $supply['category'] = $fixed_category;
} elseif (!$supply) {
    $supply = ['name'=>'','description'=>'','category'=>$fixed_category,'unit'=>'','current_stock'=>0,'minimum_stock'=>0,'unit_price'=>0,'supplier'=>''];
} else {
    $supply['category'] = $fixed_category;
}

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/sidebar.php';
require_once __DIR__ . '/../includes/topbar.php';
require_once __DIR__ . '/../includes/inventory-hub-nav.php';
?>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-wrap justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary"><?= htmlspecialchars($page_title) ?></h6>
        <?php if ($id > 0): ?>
            <a href="inventory.php?<?= http_build_query(['item_type' => 'supply', 'item_id' => $id]) ?>" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-exchange-alt"></i> Movements for this supply
            </a>
        <?php endif; ?>
    </div>
    <div class="card-body">
        <?php if ($error): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>
        <form method="post">
            <div class="form-group">
                <label>Name *</label>
                <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($supply['name']) ?>" required>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" class="form-control" rows="2"><?= htmlspecialchars($supply['description'] ?? '') ?></textarea>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label>Category</label>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($fixed_category) ?>" readonly>
                    <input type="hidden" name="category" value="<?= htmlspecialchars($fixed_category) ?>">
                </div>
                <div class="form-group col-md-4">
                    <label>Unit *</label>
                    <input type="text" name="unit" class="form-control" placeholder="e.g. piece, box" value="<?= htmlspecialchars($supply['unit']) ?>" required>
                </div>
                <div class="form-group col-md-4">
                    <label>Supplier</label>
                    <input type="text" name="supplier" class="form-control" value="<?= htmlspecialchars($supply['supplier'] ?? '') ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label>Current Stock</label>
                    <input type="number" name="current_stock" class="form-control" min="0" value="<?= (int)($supply['current_stock'] ?? 0) ?>">
                </div>
                <div class="form-group col-md-4">
                    <label>Minimum Stock</label>
                    <input type="number" name="minimum_stock" class="form-control" min="0" value="<?= (int)($supply['minimum_stock'] ?? 0) ?>">
                </div>
                <div class="form-group col-md-4">
                    <label>Unit Price (₱)</label>
                    <input type="number" name="unit_price" class="form-control" step="0.01" min="0" value="<?= htmlspecialchars($supply['unit_price'] ?? '0') ?>">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="supplies.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
