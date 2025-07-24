<!-- Menu -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="index.php" class="app-brand-link">
            <span class="app-brand-text demo menu-text fw-bolder ms-2">Dr. CRUD</span>
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item <?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : '' ?>">
            <a href="index.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>

        <!-- Drugs Management -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Inventory</span>
        </li>
        <li class="menu-item">
            <a href="pages/drugs.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-capsule"></i>
                <div data-i18n="Basic">Drugs</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="pages/suppliers.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-store"></i>
                <div data-i18n="Basic">Suppliers</div>
            </a>
        </li>

        <!-- Sales Management -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Sales</span>
        </li>
        <li class="menu-item">
            <a href="pages/sales.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-receipt"></i>
                <div data-i18n="Basic">Sales</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="pages/customers.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div data-i18n="Basic">Customers</div>
            </a>
        </li>

        <!-- Purchase Management -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Purchase</span>
        </li>
        <li class="menu-item">
            <a href="pages/purchases.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-shopping-bag"></i>
                <div data-i18n="Basic">Purchases</div>
            </a>
        </li>

        <!-- Reports -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Reports</span>
        </li>
        <li class="menu-item">
            <a href="pages/reports.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-chart"></i>
                <div data-i18n="Basic">Reports</div>
            </a>
        </li>

        <!-- User Management (Admin only) -->
        <?php if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'admin'): ?>
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Administration</span>
        </li>
        <li class="menu-item">
            <a href="pages/users.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user-check"></i>
                <div data-i18n="Basic">Users</div>
            </a>
        </li>
        <?php endif; ?>

        <!-- Logout -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Account</span>
        </li>
        <li class="menu-item">
            <a href="auth/logout.php" class="menu-link" onclick="return confirm('Are you sure you want to logout?')">
                <i class="menu-icon tf-icons bx bx-log-out"></i>
                <div data-i18n="Basic">Logout</div>
            </a>
        </li>
    </ul>
</aside>
<!-- / Menu -->