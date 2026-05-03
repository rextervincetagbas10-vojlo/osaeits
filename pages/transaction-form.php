<?php
session_start();
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/auth-check.php';

function transactionStockDelta(string $type, int $qty): int
{
    if ($type === 'purchase' || $type === 'return') {
        return $qty;
    }
    if ($type === 'issue') {
        return -$qty;
    }
    return 0;
}

function applyTransactionEffects(PDO $pdo, array $tx, int $direction = 1): void
{
    $delta = transactionStockDelta((string)$tx['transaction_type'], (int)$tx['quantity']) * $direction;
    $itemType = (string)$tx['item_type'];
    $itemId = (int)$tx['item_id'];

    if ($itemType === 'supply') {
        if ($delta !== 0) {
            $stmt = $pdo->prepare("UPDATE supplies SET current_stock = GREATEST(current_stock + ?, 0) WHERE id = ?");
            $stmt->execute([$delta, $itemId]);
        }
        return;
    }

    if ($itemType === 'equipment') {
        if ((string)$tx['transaction_type'] === 'issue') {
            $status = $direction === 1 ? 'unservicable' : 'servicable';
            $stmt = $pdo->prepare("UPDATE equipment SET status = ? WHERE id = ?");
            $stmt->execute([$status, $itemId]);
        } elseif ((string)$tx['transaction_type'] === 'return') {
            $status = $direction === 1 ? 'servicable' : 'unservicable';
            $stmt = $pdo->prepare("UPDATE equipment SET status = ? WHERE id = ?");
            $stmt->execute([$status, $itemId]);
        }
    }
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$prefill_item_type = $_GET['item_type'] ?? '';
$prefill_item_type = in_array($prefill_item_type, ['supply', 'equipment'], true) ? $prefill_item_type : '';
$prefill_item_id = isset($_GET['item_id']) ? (int)$_GET['item_id'] : 0;

$tx = null;
if ($id > 0) {
    $stmt = $pdo->prepare("SELECT * FROM transactions WHERE id = ?");
    $stmt->execute([$id]);
    $tx = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$tx) {
        $_SESSION['success_message'] = 'Movement not found.';
        header('Location: inventory.php');
        exit;
    }
}

$page_title = $tx ? 'Edit stock movement' : 'Add stock movement';
$current_page = 'inventory';
$base_url = '../';

$supplies = $pdo->query("SELECT id, name, unit_price FROM supplies ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);
$equipment = $pdo->query("SELECT id, name, serial_number, purchase_price FROM equipment ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item_type = $_POST['item_type'] ?? '';
    $item_id = (int)($_POST['item_id'] ?? 0);
    $transaction_type = $_POST['transaction_type'] ?? '';
    $quantity = (int)($_POST['quantity'] ?? 0);
    $unit_price = (float)($_POST['unit_price'] ?? 0);
    $reference_number = trim($_POST['reference_number'] ?? '');
    $notes = trim($_POST['notes'] ?? '');

    $validItemTypes = ['supply', 'equipment'];
    $validTxTypes = ['purchase', 'issue', 'return', 'adjustment'];

    if (!in_array($item_type, $validItemTypes, true) || !in_array($transaction_type, $validTxTypes, true)) {
        $error = 'Invalid item type or transaction type.';
    } elseif ($item_id <= 0 || $quantity <= 0) {
        $error = 'Item and quantity are required.';
    } else {
        // For supply issues, verify there is enough stock before proceeding.
        if ($item_type === 'supply' && $transaction_type === 'issue' && $error === '') {
            $stockStmt = $pdo->prepare("SELECT current_stock FROM supplies WHERE id = ?");
            $stockStmt->execute([$item_id]);
            $currentStock = (int)$stockStmt->fetchColumn();
            // In edit mode, the old issued qty was already deducted — add it back for comparison.
            $editedOldQty = ($tx && $tx['item_type'] === 'supply' && (int)$tx['item_id'] === $item_id && $tx['transaction_type'] === 'issue')
                ? (int)$tx['quantity']
                : 0;
            $availableForIssue = $currentStock + $editedOldQty;
            if ($quantity > $availableForIssue) {
                $error = "Insufficient stock to issue. Available: {$availableForIssue}";
            }
        }
    }
    if ($error === '') {
        try {
            $pdo->beginTransaction();

            if ($tx) {
                // Revert old effects then apply updated effects.
                applyTransactionEffects($pdo, $tx, -1);
            }

            $total_amount = $quantity * $unit_price;

            $newTxId = 0;
            if ($tx) {
                $stmt = $pdo->prepare("UPDATE transactions SET item_type=?, item_id=?, transaction_type=?, quantity=?, unit_price=?, total_amount=?, reference_number=?, notes=?, user_id=? WHERE id=?");
                $stmt->execute([
                    $item_type, $item_id, $transaction_type, $quantity, $unit_price, $total_amount,
                    $reference_number !== '' ? $reference_number : null,
                    $notes !== '' ? $notes : null,
                    (int)$_SESSION['user_id'],
                    $id
                ]);
            } else {
                $stmt = $pdo->prepare("INSERT INTO transactions (item_type, item_id, transaction_type, quantity, unit_price, total_amount, reference_number, notes, user_id) VALUES (?,?,?,?,?,?,?,?,?)");
                $stmt->execute([
                    $item_type, $item_id, $transaction_type, $quantity, $unit_price, $total_amount,
                    $reference_number !== '' ? $reference_number : null,
                    $notes !== '' ? $notes : null,
                    (int)$_SESSION['user_id']
                ]);
                $newTxId = (int)$pdo->lastInsertId();
            }

            $newTx = [
                'item_type' => $item_type,
                'item_id' => $item_id,
                'transaction_type' => $transaction_type,
                'quantity' => $quantity
            ];
            applyTransactionEffects($pdo, $newTx, 1);

            $pdo->commit();

            require_once __DIR__ . '/../includes/activity-log.php';
            $actor = (int)$_SESSION['user_id'];
            $logDetails = [
                'item_type' => $item_type,
                'item_id' => $item_id,
                'transaction_type' => $transaction_type,
                'quantity' => $quantity,
                'unit_price' => $unit_price,
                'total_amount' => $total_amount,
                'reference_number' => $reference_number !== '' ? $reference_number : null,
            ];
            if ($tx) {
                log_activity($pdo, $actor, 'transaction.update', 'transaction', $id, $logDetails);
            } else {
                log_activity($pdo, $actor, 'transaction.create', 'transaction', $newTxId, $logDetails);
            }

            $_SESSION['success_message'] = $tx ? 'Movement updated.' : 'Movement recorded.';
            $invLoc = 'inventory.php';
            if ($item_id > 0) {
                $invLoc .= '?' . http_build_query(['item_type' => $item_type, 'item_id' => $item_id]);
            }
            header('Location: ' . $invLoc);
            exit;
        } catch (Throwable $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            $error = 'Unable to save transaction. Please try again.';
        }
    }

    $tx = array_merge($tx ?? [], [
        'item_type' => $item_type,
        'item_id' => $item_id,
        'transaction_type' => $transaction_type,
        'quantity' => $quantity,
        'unit_price' => $unit_price,
        'reference_number' => $reference_number,
        'notes' => $notes
    ]);
}

if (!$tx) {
    $tx = [
        'item_type' => $prefill_item_type !== '' ? $prefill_item_type : 'supply',
        'item_id' => $prefill_item_id > 0 ? $prefill_item_id : 0,
        'transaction_type' => 'purchase',
        'quantity' => 1,
        'unit_price' => 0,
        'reference_number' => '',
        'notes' => ''
    ];
}

$cancel_inv_href = 'inventory.php';
if (!empty($tx['item_type']) && in_array($tx['item_type'], ['supply', 'equipment'], true) && (int)($tx['item_id'] ?? 0) > 0) {
    $cancel_inv_href .= '?' . http_build_query(['item_type' => $tx['item_type'], 'item_id' => (int)$tx['item_id']]);
}

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/sidebar.php';
require_once __DIR__ . '/../includes/topbar.php';
require_once __DIR__ . '/../includes/inventory-hub-nav.php';
?>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary"><?= htmlspecialchars($page_title) ?></h6>
    </div>
    <div class="card-body">
        <?php if ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label>This movement is for *</label>
                    <select name="item_type" id="item_type" class="form-control" required>
                        <option value="supply" <?= ($tx['item_type'] ?? '') === 'supply' ? 'selected' : '' ?>>Supply</option>
                        <option value="equipment" <?= ($tx['item_type'] ?? '') === 'equipment' ? 'selected' : '' ?>>Equipment</option>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label>Movement type *</label>
                    <select name="transaction_type" class="form-control" required>
                        <option value="purchase" <?= ($tx['transaction_type'] ?? '') === 'purchase' ? 'selected' : '' ?>>Purchase</option>
                        <option value="issue" <?= ($tx['transaction_type'] ?? '') === 'issue' ? 'selected' : '' ?>>Issue</option>
                        <option value="return" <?= ($tx['transaction_type'] ?? '') === 'return' ? 'selected' : '' ?>>Return</option>
                        <option value="adjustment" <?= ($tx['transaction_type'] ?? '') === 'adjustment' ? 'selected' : '' ?>>Adjustment</option>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label>Which item *</label>
                    <select name="item_id" id="item_id" class="form-control" required></select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label>Quantity *</label>
                    <input type="number" name="quantity" class="form-control" min="1" value="<?= (int)($tx['quantity'] ?? 1) ?>" required>
                </div>
                <div class="form-group col-md-3">
                    <label>Unit Price (PHP)</label>
                    <input type="number" name="unit_price" class="form-control" min="0" step="0.01" value="<?= htmlspecialchars((string)($tx['unit_price'] ?? '0')) ?>">
                </div>
                <div class="form-group col-md-6">
                    <label>Reference Number</label>
                    <input type="text" name="reference_number" class="form-control" value="<?= htmlspecialchars((string)($tx['reference_number'] ?? '')) ?>">
                </div>
            </div>

            <div class="form-group">
                <label>Notes</label>
                <textarea name="notes" class="form-control" rows="3"><?= htmlspecialchars((string)($tx['notes'] ?? '')) ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Save movement</button>
            <a href="<?= htmlspecialchars($cancel_inv_href) ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<script>
const supplyItems = <?= json_encode($supplies, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>;
const equipmentItems = <?= json_encode($equipment, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>;
const selectedItem = <?= (int)($tx['item_id'] ?? 0) ?>;
const selectedType = <?= json_encode((string)($tx['item_type'] ?? 'supply')) ?>;
const isEditMode = <?= $tx && isset($tx['id']) ? 'true' : 'false' ?>;

function renderItemOptions() {
    const typeSelect = document.getElementById('item_type');
    const itemSelect = document.getElementById('item_id');
    const source = typeSelect.value === 'equipment' ? equipmentItems : supplyItems;

    itemSelect.innerHTML = '';
    const defaultOption = document.createElement('option');
    defaultOption.value = '';
    defaultOption.textContent = '-- Select item --';
    itemSelect.appendChild(defaultOption);

    source.forEach(function (item) {
        const option = document.createElement('option');
        option.value = item.id;
        option.textContent = typeSelect.value === 'equipment' && item.serial_number
            ? item.name + ' (' + item.serial_number + ')'
            : item.name;
        if (parseInt(item.id, 10) === selectedItem) {
            option.selected = true;
        }
        itemSelect.appendChild(option);
    });
}

function getSelectedItemData() {
    const type = document.getElementById('item_type').value;
    const id = parseInt(document.getElementById('item_id').value || '0', 10);
    const source = type === 'equipment' ? equipmentItems : supplyItems;
    return source.find(function (i) { return parseInt(i.id, 10) === id; }) || null;
}

function autoFillPriceAndReference() {
    const type = document.getElementById('item_type').value;
    const txType = document.querySelector('select[name="transaction_type"]').value;
    const refInput = document.querySelector('input[name="reference_number"]');
    const priceInput = document.querySelector('input[name="unit_price"]');
    const item = getSelectedItemData();

    if (!item) return;

    const itemPrice = type === 'equipment'
        ? parseFloat(item.purchase_price || 0)
        : parseFloat(item.unit_price || 0);
    if (!Number.isNaN(itemPrice) && itemPrice > 0) {
        priceInput.value = itemPrice.toFixed(2);
    }

    if (!isEditMode || refInput.value.trim() === '') {
        const now = new Date();
        const y = now.getFullYear();
        const m = String(now.getMonth() + 1).padStart(2, '0');
        const d = String(now.getDate()).padStart(2, '0');
        const rand = String(Math.floor(Math.random() * 900) + 100);
        const prefix = (type === 'equipment' ? 'EQ' : 'SP') + '-' + txType.substring(0, 3).toUpperCase();
        refInput.value = prefix + '-' + y + m + d + '-' + rand;
    }
}

document.getElementById('item_type').addEventListener('change', function () {
    renderItemOptions();
    document.getElementById('item_id').value = '';
    autoFillPriceAndReference();
});
document.getElementById('item_id').addEventListener('change', autoFillPriceAndReference);
document.querySelector('select[name="transaction_type"]').addEventListener('change', autoFillPriceAndReference);
renderItemOptions();
document.getElementById('item_type').value = selectedType;
renderItemOptions();
if (selectedItem > 0) {
    document.getElementById('item_id').value = String(selectedItem);
}
autoFillPriceAndReference();
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
