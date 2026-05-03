    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard.php">
            <div class="sidebar-brand-text mx-3">OSAEITS</div>
        </a>
        <hr class="sidebar-divider my-0">
        <li class="nav-item <?= ($current_page ?? '') === 'dashboard' ? 'active' : '' ?>">
            <a class="nav-link" href="dashboard.php">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <?php
        $inv_hub_pages = ['supplies', 'equipment', 'inventory'];
        $inv_hub_open = in_array(($current_page ?? ''), $inv_hub_pages, true);
        ?>
        <li class="nav-item">
            <a class="nav-link <?= $inv_hub_open ? '' : 'collapsed' ?>" href="#" data-toggle="collapse" data-target="#collapseInvHub" aria-expanded="<?= $inv_hub_open ? 'true' : 'false' ?>">
                <i class="fas fa-fw fa-warehouse"></i>
                <span>Items &amp; stock</span>
            </a>
            <div id="collapseInvHub" class="collapse <?= $inv_hub_open ? 'show' : '' ?>" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item <?= ($current_page ?? '') === 'supplies' ? 'active' : '' ?>" href="supplies.php">Supplies</a>
                    <a class="collapse-item <?= ($current_page ?? '') === 'equipment' ? 'active' : '' ?>" href="equipment.php">Equipment</a>
                    <a class="collapse-item <?= ($current_page ?? '') === 'inventory' ? 'active' : '' ?>" href="inventory.php">Stock movements</a>
                </div>
            </div>
        </li>
        <li class="nav-item <?= ($current_page ?? '') === 'assign_items' ? 'active' : '' ?>">
            <a class="nav-link" href="assign-items.php">
                <i class="fas fa-fw fa-hand-holding"></i>
                <span>Assign Items</span>
            </a>
        </li>
        <li class="nav-item <?= ($current_page ?? '') === 'reports' ? 'active' : '' ?>">
            <a class="nav-link" href="reports.php">
                <i class="fas fa-fw fa-chart-bar"></i>
                <span>Reports</span>
            </a>
        </li>
        <?php if (!empty($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
        <hr class="sidebar-divider">
        <li class="nav-item <?= ($current_page ?? '') === 'users' ? 'active' : '' ?>">
            <a class="nav-link" href="users.php">
                <i class="fas fa-fw fa-users"></i>
                <span>Users</span>
            </a>
        </li>
        <li class="nav-item <?= ($current_page ?? '') === 'barangay_officials' ? 'active' : '' ?>">
            <a class="nav-link" href="barangay-officials.php">
                <i class="fas fa-fw fa-user-tie"></i>
                <span>Barangay Officials</span>
            </a>
        </li>
        <li class="nav-item <?= ($current_page ?? '') === 'activity_log' ? 'active' : '' ?>">
            <a class="nav-link" href="ActivityLog.php">
                <i class="fas fa-fw fa-history"></i>
                <span>Activity Log</span>
            </a>
        </li>
        <li class="nav-item <?= ($current_page ?? '') === 'database_backup' ? 'active' : '' ?>">
            <a class="nav-link" href="database-backup.php">
                <i class="fas fa-fw fa-database"></i>
                <span>Database Backup</span>
            </a>
        </li>
        <?php endif; ?>
        <hr class="sidebar-divider d-none d-md-block">
    </ul>
