<?php
/**
 * Append one audit row. Safe to call anywhere; failures are ignored so core flows keep working.
 */
function log_activity(PDO $pdo, ?int $userId, string $action, ?string $entityType = null, ?int $entityId = null, ?array $details = null): void
{
    try {
        $ip = isset($_SERVER['REMOTE_ADDR']) ? (string)$_SERVER['REMOTE_ADDR'] : null;
        if (strlen($ip) > 45) {
            $ip = substr($ip, 0, 45);
        }
        $detailsJson = $details !== null ? json_encode($details, JSON_UNESCAPED_UNICODE) : null;
        $stmt = $pdo->prepare(
            'INSERT INTO activity_logs (user_id, action, entity_type, entity_id, details, ip_address)
             VALUES (?,?,?,?,?,?)'
        );
        $stmt->execute([$userId, $action, $entityType, $entityId, $detailsJson, $ip]);
    } catch (Throwable $e) {
        // Table missing or DB error — do not break the app
    }
}
