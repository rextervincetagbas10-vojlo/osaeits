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
            $stmt = $pdo->prepare("UPDATE supplies SET current_stock = current_stock + ? WHERE id = ?");
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
$redirect = 'inventory.php';

if ($id <= 0) {
    $_SESSION['success_message'] = 'Invalid movement.';
    header('Location: ' . $redirect);
    exit;
}

try {
    $pdo->beginTransaction();
    $stmt = $pdo->prepare("SELECT * FROM transactions WHERE id = ?");
    $stmt->execute([$id]);
    $tx = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$tx) {
        $pdo->rollBack();
        $_SESSION['success_message'] = 'Movement not found.';
        header('Location: ' . $redirect);
        exit;
    }

    // Reverse effects then delete the transaction row.
    applyTransactionEffects($pdo, $tx, -1);
    $stmt = $pdo->prepare("DELETE FROM transactions WHERE id = ?");
    $stmt->execute([$id]);
    $pdo->commit();

    require_once __DIR__ . '/../includes/activity-log.php';
    log_activity($pdo, (int)$_SESSION['user_id'], 'transaction.delete', 'transaction', $id, [
        'snapshot' => $tx,
    ]);

    $_SESSION['success_message'] = 'Movement deleted.';
    $it = (string)($tx['item_type'] ?? '');
    $iid = (int)($tx['item_id'] ?? 0);
    if (in_array($it, ['supply', 'equipment'], true) && $iid > 0) {
        $redirect .= '?' . http_build_query(['item_type' => $it, 'item_id' => $iid]);
    }
} catch (Throwable $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    $_SESSION['success_message'] = 'Unable to delete movement.';
}

header('Location: ' . $redirect);
exit;
