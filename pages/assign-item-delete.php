<?php
session_start();
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/auth-check.php';

/**
 * Revert the stock effect of an assignment being deleted.
 * Mirrors applyAssignmentEffects in assign-item-form.php with direction = -1.
 */
function revertAssignmentEffects(PDO $pdo, string $itemType, int $itemRefId, string $status, int $qty): void
{
    if ($itemType === 'supply') {
        $delta = ($status === 'assigned' ? -$qty : $qty) * -1;
        if ($delta !== 0) {
            $pdo->prepare("UPDATE supplies SET current_stock = current_stock + ? WHERE id = ?")
                ->execute([$delta, $itemRefId]);
        }
    } elseif ($itemType === 'equipment') {
        $newStatus = $status === 'assigned' ? 'servicable' : 'unservicable';
        $pdo->prepare("UPDATE equipment SET status = ? WHERE id = ?")
            ->execute([$newStatus, $itemRefId]);
    }
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id > 0) {
    $stmt = $pdo->prepare("SELECT * FROM assign_items WHERE id = ?");
    $stmt->execute([$id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        try {
            $pdo->beginTransaction();

            revertAssignmentEffects($pdo, (string)$row['item_type'], (int)$row['item_ref_id'], (string)$row['status'], (int)$row['quantity']);
            $pdo->prepare("DELETE FROM assign_items WHERE id = ?")->execute([$id]);

            $pdo->commit();
        } catch (Throwable $e) {
            if ($pdo->inTransaction()) $pdo->rollBack();
        }

        require_once __DIR__ . '/../includes/activity-log.php';
        log_activity($pdo, (int)$_SESSION['user_id'], 'assign_item.delete', 'assign_item', $id, [
            'item_type' => $row['item_type'],
            'item_ref_id' => (int)$row['item_ref_id'],
            'assigned_to' => $row['assigned_to'],
        ]);
    }
}

$_SESSION['success_message'] = 'Assigned item deleted.';
header('Location: assign-items.php');
exit;
