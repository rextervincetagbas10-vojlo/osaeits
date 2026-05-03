<?php
/**
 * Shared navigation among Supplies, Equipment, and stock movements (inventory.php).
 * Expects $current_page to be one of: supplies, equipment, inventory.
 */
$hubPage = $current_page ?? '';
?>
<div class="card border-left-info shadow-sm mb-4 inventory-hub-nav">
    <div class="card-body py-3">
        <div class="d-flex flex-wrap align-items-center mb-2">
            <span class="font-weight-bold text-secondary small text-uppercase mr-2">Items &amp; stock</span>
            <ul class="nav nav-pills small inventory-hub-pills flex-grow-1 flex-nowrap overflow-auto mb-0 pl-0">
                <li class="nav-item">
                    <a class="nav-link py-1 px-2 <?= $hubPage === 'supplies' ? 'active' : '' ?>" href="supplies.php">
                        <i class="fas fa-boxes fa-fw"></i> Supplies
                        <span class="d-none d-xl-inline text-muted font-weight-normal"> — list &amp; quantities</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link py-1 px-2" href="equipment.php">
                        <i class="fas fa-laptop fa-fw"></i> Equipment
                        <span class="d-none d-xl-inline text-muted font-weight-normal"> — assets &amp; status</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link py-1 px-2 <?= $hubPage === 'inventory' ? 'active' : '' ?>" href="inventory.php">
                        <i class="fas fa-exchange-alt fa-fw"></i> Stock movements
                        <span class="d-none d-xl-inline text-muted font-weight-normal"> — in, out, returns</span>
                    </a>
                </li>
            </ul>
        </div>
        <p class="small text-muted mb-0 pl-0">
            <strong>How this fits:</strong> Maintain the <strong>Supplies</strong> and <strong>Equipment</strong> lists first (what you own).
            Record every change under <strong>Stock movements</strong> — purchases, issues, returns, adjustments — so quantities and equipment status stay correct.
        </p>
    </div>
</div>
