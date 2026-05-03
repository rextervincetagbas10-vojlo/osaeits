<?php
session_start();
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/auth-check.php';

$page_title = 'Equipment';
$current_page = 'equipment';
$base_url = '../';

function normalizeEquipmentStatus(string $status): string
{
    $status = strtolower(trim($status));
    if (in_array($status, ['servicable', 'available', 'in_use', 'maintenance'], true)) {
        return 'servicable';
    }
    if (in_array($status, ['unservicable', 'retired'], true)) {
        return 'unservicable';
    }
    return $status;
}

$search = trim($_GET['search'] ?? '');
$status = trim($_GET['status'] ?? '');

// Pagination parameters
$limit = 10; // Items per page
$page = max(1, (int)($_GET['page'] ?? 1));
$offset = ($page - 1) * $limit;

$sql = "SELECT * FROM equipment";
$params = [];
$where = [];
if ($search !== '') {
    $where[] = "(name LIKE ? OR category LIKE ? OR serial_number LIKE ? OR brand LIKE ?)";
    $term = "%$search%";
    $params = [$term, $term, $term, $term];
}
if (in_array($status, ['servicable', 'unservicable'], true)) {
    $where[] = "status = ?";
    $params[] = $status;
}
if (!empty($where)) {
    $sql .= " WHERE " . implode(" AND ", $where);
}

// Get total count for pagination
$countSql = $sql;
$countStmt = $pdo->prepare($countSql);
$countStmt->execute($params);
$total_items = $countStmt->rowCount();
$total_pages = ceil($total_items / $limit);

$sql .= " ORDER BY name ASC LIMIT " . $limit . " OFFSET " . $offset;
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$equipment = $stmt->fetchAll(PDO::FETCH_ASSOC);

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/sidebar.php';
require_once __DIR__ . '/../includes/topbar.php';
require_once __DIR__ . '/../includes/inventory-hub-nav.php';
?>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-wrap align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Equipment List</h6>
        <a href="equipment-form.php" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Add Equipment</a>
    </div>
    <div class="card-body">
        <form method="get" class="form-inline mb-3">
            <input type="text" name="search" class="form-control form-control-sm mr-2" placeholder="Search..." value="<?= htmlspecialchars($search) ?>">
            <select name="status" class="form-control form-control-sm mr-2">
                <option value="">All Status</option>
                <option value="servicable" <?= $status === 'servicable' ? 'selected' : '' ?>>Servicable</option>
                <option value="unservicable" <?= $status === 'unservicable' ? 'selected' : '' ?>>Unservicable</option>
            </select>
            <button type="submit" class="btn btn-sm btn-secondary">Search</button>
            <a href="equipment.php" class="btn btn-sm btn-light ml-2">Reset</a>
        </form>
        <div class="table-responsive">
            <table class="table table-bordered table-sm">
                <thead class="thead-light">
                    <tr>
                        <th width="55">No.</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Serial</th>
                        <th>Brand / Model</th>
                        <th>Status</th>
                        <th>Location</th>
                        <th>Purok/Area</th>
                        <th>Appropriation</th>
                        <th>Person Incharge</th>
                        <th>Purchase Price</th>
                        <th width="170">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($equipment as $idx => $e): ?>
                        <?php $rowNumber = ($page - 1) * $limit + $idx + 1; ?>
                        <tr>
                            <td><?= $rowNumber ?></td>
                            <td><?= htmlspecialchars($e['name']) ?></td>
                            <td><?= htmlspecialchars($e['category']) ?></td>
                            <td><?= htmlspecialchars($e['serial_number'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($e['brand'] ?? '') ?> / <?= htmlspecialchars($e['model'] ?? '-') ?></td>
                            <?php $s = normalizeEquipmentStatus((string)$e['status']); ?>
                            <td><span class="badge badge-<?= $s === 'servicable' ? 'success' : 'secondary' ?>"><?= $s === 'servicable' ? 'Servicable' : 'Unservicable' ?></span></td>
                            <td><?= htmlspecialchars($e['location'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($e['purok_area'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($e['appropriation'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($e['person_incharge'] ?? '-') ?></td>
                            <td>₱<?= number_format($e['purchase_price'], 2) ?></td>
                            <td class="table-actions">
                                <a href="inventory.php?item_type=equipment&amp;item_id=<?= (int)$e['id'] ?>" class="btn btn-sm btn-outline-secondary btn-icon-action" title="Stock movements for this equipment" aria-label="Stock movements for this equipment">
                                    <i class="fas fa-exchange-alt"></i>
                                </a>
                                <a href="equipment-form.php?id=<?= (int)$e['id'] ?>" class="btn btn-sm btn-info btn-icon-action" title="Edit" aria-label="Edit equipment">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <a href="equipment-delete.php?id=<?= (int)$e['id'] ?>" class="btn btn-sm btn-danger btn-icon-action" data-confirm="Delete this equipment?" title="Delete" aria-label="Delete equipment">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php if ($total_items > 0): ?>
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div class="small text-muted">
                Showing <?= ($offset + 1) ?> to <?= min($offset + count($equipment), $total_items) ?> of <?= $total_items ?> equipment
            </div>
            <nav aria-label="Equipment pagination">
                <ul class="pagination pagination-sm mb-0">
                    <?php
                    // Build base query params, preserving search and filter
                    $baseParams = [];
                    if (!empty($search)) {
                        $baseParams['search'] = $search;
                    }
                    if (!empty($status)) {
                        $baseParams['status'] = $status;
                    }

                    // Helper function to build pagination URL
                    $buildPaginationUrl = function($pageNum, $params) {
                        $params['page'] = $pageNum;
                        return 'equipment.php?' . http_build_query($params);
                    };

                    // Previous button
                    if ($page > 1):
                    ?>
                        <li class="page-item">
                            <a class="page-link" href="<?= $buildPaginationUrl($page - 1, $baseParams) ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="page-item disabled">
                            <span class="page-link" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </span>
                        </li>
                    <?php endif; ?>

                    <?php
                    $startPage = max(1, $page - 2);
                    $endPage = min($total_pages, $page + 2);

                    // First page if not in range
                    if ($startPage > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="<?= $buildPaginationUrl(1, $baseParams) ?>">1</a>
                        </li>
                        <?php if ($startPage > 2): ?>
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                        <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                            <a class="page-link" href="<?= $buildPaginationUrl($i, $baseParams) ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>

                    <?php
                    // Last page if not in range
                    if ($endPage < $total_pages): ?>
                        <?php if ($endPage < $total_pages - 1): ?>
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        <?php endif; ?>
                        <li class="page-item">
                            <a class="page-link" href="<?= $buildPaginationUrl($total_pages, $baseParams) ?>"><?= $total_pages ?></a>
                        </li>
                    <?php endif; ?>

                    <?php
                    // Next button
                    if ($page < $total_pages):
                    ?>
                        <li class="page-item">
                            <a class="page-link" href="<?= $buildPaginationUrl($page + 1, $baseParams) ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="page-item disabled">
                            <span class="page-link" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </span>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
