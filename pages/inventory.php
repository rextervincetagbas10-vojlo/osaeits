<?php
session_start();
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/auth-check.php';

$page_title = 'Stock movements';
$current_page = 'inventory';
$base_url = '../';

$item_type_filter = $_GET['item_type'] ?? '';
$item_type_filter = in_array($item_type_filter, ['supply', 'equipment'], true) ? $item_type_filter : '';
$item_id_filter = isset($_GET['item_id']) ? (int)$_GET['item_id'] : 0;

$filter_item_label = '';
if ($item_type_filter !== '' && $item_id_filter > 0) {
    if ($item_type_filter === 'supply') {
        $st = $pdo->prepare('SELECT name FROM supplies WHERE id = ? LIMIT 1');
        $st->execute([$item_id_filter]);
        $filter_item_label = (string)($st->fetchColumn() ?: '');
    } else {
        $st = $pdo->prepare('SELECT name FROM equipment WHERE id = ? LIMIT 1');
        $st->execute([$item_id_filter]);
        $filter_item_label = (string)($st->fetchColumn() ?: '');
    }
}

$sql = "SELECT t.*, u.first_name, u.last_name,
            s.name AS supply_name,
            e.name AS equipment_name,
            e.serial_number AS equipment_serial
     FROM transactions t
     LEFT JOIN users u ON t.user_id = u.id
     LEFT JOIN supplies s ON t.item_type = 'supply' AND t.item_id = s.id
     LEFT JOIN equipment e ON t.item_type = 'equipment' AND t.item_id = e.id";
$params = [];
if ($item_type_filter !== '' && $item_id_filter > 0) {
    $sql .= ' WHERE t.item_type = ? AND t.item_id = ?';
    $params[] = $item_type_filter;
    $params[] = $item_id_filter;
}
$sql .= ' ORDER BY t.created_at DESC LIMIT 200';

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);

$tx_form_href = 'transaction-form.php';
if ($item_type_filter !== '' && $item_id_filter > 0) {
    $tx_form_href .= '?' . http_build_query(['item_type' => $item_type_filter, 'item_id' => $item_id_filter]);
}

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/sidebar.php';
require_once __DIR__ . '/../includes/topbar.php';
require_once __DIR__ . '/../includes/inventory-hub-nav.php';
?>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-wrap justify-content-between align-items-center">
        <div>
            <h6 class="m-0 font-weight-bold text-primary">Stock movements</h6>
            <p class="small text-muted mb-0">History of purchases, issues, returns, and adjustments. These entries update supply quantities and equipment status.</p>
        </div>
        <a href="<?= htmlspecialchars($tx_form_href) ?>" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Add movement</a>
    </div>
    <div class="card-body">
        <?php if (!empty($_SESSION['success_message'])): ?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?= htmlspecialchars($_SESSION['success_message']); unset($_SESSION['success_message']); ?>
            </div>
        <?php endif; ?>
        <?php if ($item_type_filter !== '' && $item_id_filter > 0): ?>
            <div class="alert alert-info py-2 mb-3">
                Showing movements for
                <strong><?= htmlspecialchars($filter_item_label !== '' ? $filter_item_label : (($item_type_filter === 'supply' ? 'supply' : 'equipment') . ' #' . $item_id_filter)) ?></strong>
                (<?= $item_type_filter === 'supply' ? 'from Supplies' : 'from Equipment' ?>).
                <a href="inventory.php" class="alert-link">Show all movements</a>
                ·
                <?php if ($item_type_filter === 'supply'): ?>
                    <a href="supply-form.php?id=<?= (int)$item_id_filter ?>" class="alert-link">Edit this supply</a>
                <?php else: ?>
                    <a href="equipment-form.php?id=<?= (int)$item_id_filter ?>" class="alert-link">Edit this equipment</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <div class="table-responsive">
            <table class="table table-bordered table-sm">
                <thead class="thead-light">
                    <tr>
                        <th>Date</th>
                        <th>Movement</th>
                        <th>For</th>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Total (₱)</th>
                        <th>Recorded by</th>
                        <th>Notes</th>
                        <th width="120">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($transactions as $t): ?>
                        <tr>
                            <td><?= date('M j, Y H:i', strtotime($t['created_at'])) ?></td>
                            <td><?= htmlspecialchars(ucfirst($t['transaction_type'])) ?></td>
                            <td><?= $t['item_type'] === 'supply' ? 'Supply' : 'Equipment' ?></td>
                            <td>
                                <?php if ($t['item_type'] === 'supply'): ?>
                                    <a href="supply-form.php?id=<?= (int)$t['item_id'] ?>"><?= htmlspecialchars($t['supply_name'] ?? ('Supply #' . (int)$t['item_id'])) ?></a>
                                <?php else: ?>
                                    <a href="equipment-form.php?id=<?= (int)$t['item_id'] ?>"><?= htmlspecialchars($t['equipment_name'] ?? ('Equipment #' . (int)$t['item_id'])) ?></a>
                                    <?php if (!empty($t['equipment_serial'])): ?>
                                        <span class="text-muted">(<?= htmlspecialchars($t['equipment_serial']) ?>)</span>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </td>
                            <td><?= (int)$t['quantity'] ?></td>
                            <td>₱<?= number_format($t['total_amount'], 2) ?></td>
                            <td><?= htmlspecialchars(trim($t['first_name'] . ' ' . $t['last_name']) ?: '-') ?></td>
                            <td><?= htmlspecialchars($t['notes'] ?? '-') ?></td>
                            <td class="table-actions">
                                <a href="transaction-form.php?id=<?= (int)$t['id'] ?>" class="btn btn-sm btn-info btn-icon-action" title="Edit movement" aria-label="Edit movement">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <a href="transaction-delete.php?id=<?= (int)$t['id'] ?>" class="btn btn-sm btn-danger btn-icon-action" data-confirm="Delete this movement?" title="Delete" aria-label="Delete movement">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php if (empty($transactions)): ?>
            <p class="text-muted mb-0"><?= $item_type_filter !== '' && $item_id_filter > 0 ? 'No movements recorded for this item yet.' : 'No movements yet.' ?></p>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
