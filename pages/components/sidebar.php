<?php
    $current_page = basename($_SERVER['PHP_SELF']);
?>

<style>
    :root {
        --sidebar-width: 280px;
        --sidebar-collapsed-width: 80px;
        --sidebar-bg: linear-gradient(180deg, #0a0e27 0%, #1a1f3a 50%, #0a0e27 100%);
        --sidebar-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
        --accent-blue: #4f7cff;
        --accent-purple: #7c3aed;
        --text-primary: #ffffff;
        --text-secondary: #94a3b8;
        --hover-bg: rgba(255, 255, 255, 0.06);
        --active-bg: linear-gradient(135deg, #4f7cff, #7c3aed);
    }

    body {
        --content-margin-left: var(--sidebar-width);
    }

    /* ===== SIDEBAR CONTAINER ===== */
    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        width: var(--sidebar-width);
        background: var(--sidebar-bg);
        box-shadow: var(--sidebar-shadow);
        transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        z-index: 1000;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }

    .sidebar.collapsed {
        width: var(--sidebar-collapsed-width);
    }

    .sidebar.collapsed .sidebar-text,
    .sidebar.collapsed .sidebar-logo-text,
    .sidebar.collapsed .nav-title {
        opacity: 0;
        visibility: hidden;
    }

    .sidebar.collapsed .version-badge span,
    .sidebar.collapsed .version-badge small {
        display: none;
    }

    /* ===== SIDEBAR HEADER ===== */
    .sidebar-header {
        padding: 24px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        min-height: 80px;
    }

    .sidebar-logo {
        display: flex;
        align-items: center;
        gap: 12px;
        text-decoration: none;
        overflow: hidden;
    }

    .sidebar-logo-icon {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        background: var(--active-bg);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 20px;
        flex-shrink: 0;
        box-shadow: 0 4px 12px rgba(79, 124, 255, 0.3);
    }

    .sidebar-logo-text {
        display: flex;
        flex-direction: column;
        transition: opacity 0.2s, visibility 0.2s;
    }

    .sidebar-logo-text h4 {
        margin: 0;
        font-size: 18px;
        font-weight: 700;
        color: var(--text-primary);
        letter-spacing: -0.5px;
    }

    .sidebar-logo-text span {
        font-size: 11px;
        color: var(--text-secondary);
        font-weight: 500;
    }

    .sidebar-toggle {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: white;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .sidebar-toggle:hover {
        background: rgba(255, 255, 255, 0.1);
        transform: rotate(180deg);
    }

    /* ===== SIDEBAR MENU ===== */
    .sidebar-menu {
        flex: 1;
        overflow-y: auto;
        overflow-x: hidden;
        padding: 16px 12px;
        scrollbar-width: thin;
        scrollbar-color: rgba(255, 255, 255, 0.2) transparent;
    }

    .sidebar-menu::-webkit-scrollbar {
        width: 6px;
    }

    .sidebar-menu::-webkit-scrollbar-track {
        background: transparent;
    }

    .sidebar-menu::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.2);
        border-radius: 10px;
    }

    .sidebar-menu::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.3);
    }

    /* ===== NAV TITLE ===== */
    .nav-title {
        font-size: 10px;
        font-weight: 700;
        color: var(--text-secondary);
        margin: 20px 0 8px 12px;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        transition: opacity 0.2s, visibility 0.2s;
        white-space: nowrap;
    }

    .nav-title:first-child {
        margin-top: 0;
    }

    /* ===== NAV ITEMS ===== */
    .nav {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .nav-item {
        margin-bottom: 4px;
    }

    .nav-link {
        display: flex;
        align-items: center;
        padding: 12px 16px;
        border-radius: 12px;
        color: var(--text-secondary);
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        white-space: nowrap;
    }

    .nav-link::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 3px;
        height: 0;
        background: var(--active-bg);
        border-radius: 0 3px 3px 0;
        transition: height 0.3s;
    }

    .nav-link:hover {
        background: var(--hover-bg);
        color: var(--text-primary);
        transform: translateX(4px);
    }

    .nav-item.active .nav-link {
        background: var(--active-bg);
        color: var(--text-primary);
        box-shadow: 0 4px 12px rgba(79, 124, 255, 0.25);
    }

    .nav-item.active .nav-link::before {
        height: 60%;
    }

    .sidebar-icon {
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 12px;
        flex-shrink: 0;
        font-size: 18px;
    }

    .sidebar-text {
        transition: opacity 0.2s, visibility 0.2s;
        white-space: nowrap;
    }

    /* ===== SIDEBAR FOOTER ===== */
    .sidebar-footer {
        padding: 20px;
        border-top: 1px solid rgba(255, 255, 255, 0.08);
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .version-badge {
        position: relative;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 18px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        overflow: hidden;
        transition: all 0.3s;
    }

    .version-badge::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(120deg, transparent, rgba(255, 255, 255, 0.1), transparent);
        transform: translateX(-100%);
        animation: shimmer 3s infinite;
    }

    @keyframes shimmer {
        100% {
            transform: translateX(100%);
        }
    }

    .version-badge span {
        font-weight: 600;
        color: var(--text-primary);
        font-size: 13px;
        transition: all 0.2s;
    }

    .version-badge small {
        color: var(--text-secondary);
        font-weight: 500;
        font-size: 11px;
        transition: all 0.2s;
    }

    .sidebar.collapsed .version-badge {
        padding: 10px;
        width: 40px;
        height: 40px;
        border-radius: 50%;
    }

    .version-badge:hover {
        background: rgba(255, 255, 255, 0.1);
        transform: translateY(-2px);
    }

    /* ===== MOBILE NAVBAR ===== */
    .navbar-theme-primary {
        background: var(--sidebar-bg);
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    }

    .mobile-user-card {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 16px;
        padding: 16px;
        margin-bottom: 16px;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 991.98px) {
        .sidebar {
            transform: translateX(-100%);
            width: var(--sidebar-width);
        }

        .sidebar.show {
            transform: translateX(0);
        }

        .sidebar-toggle {
            display: none;
        }

        body {
            --content-margin-left: 0;
        }
    }

    @media (min-width: 992px) {
        .navbar-theme-primary {
            display: none;
        }

        .collapse-close {
            display: none;
        }

        .user-card {
            display: none !important;
        }
    }

    /* ===== CONTENT OFFSET ===== */
    .content {
        margin-left: var(--content-margin-left);
        transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        min-height: 100vh;
        padding: 20px;
    }

    .sidebar.collapsed ~ .content {
        margin-left: var(--sidebar-collapsed-width);
    }

    @media (max-width: 991.98px) {
        .content {
            margin-left: 0 !important;
        }
    }
</style>

<!-- Mobile Navbar -->
<nav class="navbar navbar-dark navbar-theme-primary px-3 d-lg-none">
    <a class="navbar-brand me-lg-5" href="/qieos/pages/dashboard.php">
        <img class="navbar-brand-dark" src="/qieos/assets/img/brand/qieos.png" alt="Qieos Logo" />
    </a>
    <div class="d-flex align-items-center">
        <button
            class="navbar-toggler d-lg-none collapsed"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#sidebarMenu"
            aria-controls="sidebarMenu"
            aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
</nav>

<!-- Collapsible Sidebar Container -->
<div class="sidebar" id="sidebarMenu">
    <!-- Header -->
    <div class="sidebar-header">
        <a href="/qieos/pages/dashboard.php" class="sidebar-logo">
            <div class="sidebar-logo-icon">
                <i class="fas fa-layer-group"></i>
            </div>
            <div class="sidebar-logo-text">
                <h4>Qieos</h4>
                <span>POS Management</span>
            </div>
        </a>
        <button class="sidebar-toggle" id="sidebarToggle">
            <i class="fas fa-bars"></i>
        </button>
    </div>

    <!-- Mobile User Card -->
    <div class="mobile-user-card d-lg-none">
        <div class="d-flex align-items-center">
            <img
                src="<?php echo $user['photo'] ? '/qieos/assets/img/uploads/' . $user['photo'] : '/qieos/assets/img/default-avatar.jpg'; ?>"
                class="rounded-circle"
                style="width: 40px; height: 40px; object-fit: cover; margin-right: 12px;"
                alt="User" />
            <div>
                <h6 class="mb-0 text-white" style="font-size: 14px; font-weight: 600;">
                    <?php echo $user['fullname'] != '' ? $user['fullname'] : $_SESSION['username']; ?>
                </h6>
                <small class="text-secondary" style="font-size: 12px;">
                    <?php echo ucwords(strtolower($user['role'])); ?>
                </small>
            </div>
        </div>
        <a href="/qieos/sessions/logout.php" class="btn btn-sm btn-danger w-100 mt-2" style="background: #ef4444; border: none;">
            <i class="fas fa-sign-out-alt me-1"></i> Logout
        </a>
    </div>

    <!-- Menu -->
    <div class="sidebar-menu">
        <ul class="nav flex-column">
            <li class="nav-item <?php echo ($current_page == 'dashboard.php') ? 'active' : ''; ?>">
                <a href="/qieos/pages/coming-soon.php" class="nav-link">
                    <span class="sidebar-icon"><i class="fas fa-th-large"></i></span>
                    <span class="sidebar-text">Dashboard</span>
                </a>
            </li>

            <?php if ($user['role'] == 'developer') { ?>
                <?php include 'sidebar_developer.php' ?>
            <?php } ?>

            <?php if ($user['role'] == 'administrator') { ?>

                <!-- PEMBELIAN STOK -->
                <li class="nav-title">PURCHASING</li>

                <li class="nav-item <?= ($current_page == 'list.php') ? 'active' : ''; ?>">
                    <a href="/qieos/pages/coming-soon.php" class="nav-link">
                        <span class="sidebar-icon"><i class="fas fa-file-alt"></i></span>
                        <span class="sidebar-text">Daftar Belanja</span>
                    </a>
                </li>

                <li class="nav-item <?= ($current_page == 'purchase.php') ? 'active' : ''; ?>">
                    <a href="/qieos/pages/coming-soon.php" class="nav-link">
                        <span class="sidebar-icon"><i class="fas fa-cart-plus"></i></span>
                        <span class="sidebar-text">Input Pembelian</span>
                    </a>
                </li>

                <li class="nav-item <?= ($current_page == 'additional.php') ? 'active' : ''; ?>">
                    <a href="/qieos/pages/coming-soon.php" class="nav-link">
                        <span class="sidebar-icon"><i class="fas fa-box-open"></i></span>
                        <span class="sidebar-text">Produk Tambahan</span>
                    </a>
                </li>

                <!-- GUDANG STOK (SUMBER BARANG / FIFO) -->
                <li class="nav-title">GUDANG STOK</li>

                <li class="nav-item <?= ($current_page == 'stock.php') ? 'active' : ''; ?>">
                    <a href="/qieos/pages/coming-soon.php" class="nav-link">
                        <span class="sidebar-icon"><i class="fas fa-warehouse"></i></span>
                        <span class="sidebar-text">Stok Gudang</span>
                    </a>
                </li>

                <li class="nav-item <?= ($current_page == 'mutation.php') ? 'active' : ''; ?>">
                    <a href="/qieos/pages/coming-soon.php" class="nav-link">
                        <span class="sidebar-icon"><i class="fas fa-truck-ramp-box"></i></span>
                        <span class="sidebar-text">Mutasi Stok</span>
                    </a>
                </li>

                <li class="nav-item <?= ($current_page == 'transfer.php') ? 'active' : ''; ?>">
                    <a href="/qieos/pages/coming-soon.php" class="nav-link">
                        <span class="sidebar-icon"><i class="fas fa-exchange-alt"></i></span>
                        <span class="sidebar-text">Transfer ke Penjualan</span>
                    </a>
                </li>

                <!-- TENANT -->
                <li class="nav-title">TENANT</li>

                <li class="nav-item <?= ($current_page == 'registration.php') ? 'active' : ''; ?>">
                    <a href="/qieos/pages/tenant/registration.php" class="nav-link">
                        <span class="sidebar-icon"><i class="fas fa-pen-to-square"></i></span>
                        <span class="sidebar-text">Pendaftaran Tenant</span>
                    </a>
                </li>

                <li class="nav-item <?= ($current_page == 'tenant.php' || $current_page == 'tenant-detail.php') ? 'active' : ''; ?>">
                    <a href="/qieos/pages/tenant/tenant.php" class="nav-link">
                        <span class="sidebar-icon"><i class="fas fa-store"></i></span>
                        <span class="sidebar-text">Tenant</span>
                    </a>
                </li>

                <!-- LAPORAN -->
                <li class="nav-title">LAPORAN</li>

                <li class="nav-item <?= ($current_page == 'report.php') ? 'active' : ''; ?>">
                    <a href="/qieos/pages/coming-soon.php" class="nav-link">
                        <span class="sidebar-icon"><i class="fas fa-chart-line"></i></span>
                        <span class="sidebar-text">Laporan Penjualan</span>
                    </a>
                </li>

                <li class="nav-item <?= ($current_page == 'report-tenant.php') ? 'active' : ''; ?>">
                    <a href="/qieos/pages/report/report-tenant.php" class="nav-link">
                        <span class="sidebar-icon"><i class="fas fa-chart-line"></i></span>
                        <span class="sidebar-text">Laporan Tenant</span>
                    </a>
                </li>

                <!-- MANAJEMEN STAFF -->
                <li class="nav-title">MANAJEMEN USER</li>

                <li class="nav-item <?= ($current_page == 'administrator.php') ? 'active' : ''; ?>">
                    <a href="/qieos/pages/coming-soon.php" class="nav-link">
                        <span class="sidebar-icon"><i class="fas fa-users"></i></span>
                        <span class="sidebar-text">Administrator</span>
                    </a>
                </li>

                <li class="nav-item <?= ($current_page == 'cashier.php') ? 'active' : ''; ?>">
                    <a href="/qieos/pages/coming-soon.php" class="nav-link">
                        <span class="sidebar-icon"><i class="fas fa-users"></i></span>
                        <span class="sidebar-text">Staff Kasir</span>
                    </a>
                </li>

                <!-- LAINNYA -->
                <li class="nav-title">LAINNYA</li>

                <li class="nav-item <?= ($current_page == 'update.php') ? 'active' : ''; ?>">
                    <a href="/qieos/pages/other/update.php" class="nav-link">
                        <span class="sidebar-icon"><i class="fas fa-rocket"></i></span>
                        <span class="sidebar-text">Update</span>
                    </a>
                </li>
            <?php } ?>

            <?php if ($user['role'] == 'staff kasir') { ?>
                <!-- GUDANG PENJUALAN -->
                <li class="nav-title">PENJUALAN</li>

                <li class="nav-item <?= ($current_page == 'sales-stock.php') ? 'active' : ''; ?>">
                    <a href="/qieos/pages/coming-soon.php" class="nav-link">
                        <span class="sidebar-icon"><i class="fas fa-store"></i></span>
                        <span class="sidebar-text">Stok Penjualan</span>
                    </a>
                </li>

                <li class="nav-item <?= ($current_page == 'catalog.php') ? 'active' : ''; ?>">
                    <a href="/qieos/pages/coming-soon.php" class="nav-link">
                        <span class="sidebar-icon"><i class="fas fa-book-open"></i></span>
                        <span class="sidebar-text">Katalog Produk</span>
                    </a>
                </li>

                <li class="nav-item <?= ($current_page == 'order.php') ? 'active' : ''; ?>">
                    <a href="/qieos/pages/coming-soon.php" class="nav-link">
                        <span class="sidebar-icon"><i class="fas fa-receipt"></i></span>
                        <span class="sidebar-text">Pesanan</span>
                    </a>
                </li>

                <!-- TENANT -->
                <li class="nav-title">TENANT</li>

                <li class="nav-item <?= ($current_page == 'tenant.php' || $current_page == 'tenant-detail.php') ? 'active' : ''; ?>">
                    <a href="/qieos/pages/tenant/tenant.php" class="nav-link">
                        <span class="sidebar-icon"><i class="fas fa-store"></i></span>
                        <span class="sidebar-text">Daftar Tenant</span>
                    </a>
                </li>

                <!-- REKAP -->
                <li class="nav-title">REKAP</li>

                <li class="nav-item <?= ($current_page == 'recap.php') ? 'active' : ''; ?>">
                    <a href="/qieos/pages/recap/recap.php" class="nav-link">
                        <span class="sidebar-icon"><i class="fas fa-chart-bar"></i></span>
                        <span class="sidebar-text">Penjualan & Tenant</span>
                    </a>
                </li>

                <!-- LAINNYA -->
                <li class="nav-title">LAINNYA</li>

                <li class="nav-item <?= ($current_page == 'update.php') ? 'active' : ''; ?>">
                    <a href="/qieos/pages/other/update.php" class="nav-link">
                        <span class="sidebar-icon"><i class="fas fa-rocket"></i></span>
                        <span class="sidebar-text">Update</span>
                    </a>
                </li>
            <?php } ?>
        
        </ul>
    </div>

    <!-- Footer -->
    <div class="sidebar-footer">
        <div class="version-badge">
            <span>Qieos</span>
            <small>v1.0.0</small>
        </div>
    </div>
</div>

<script>
    // Toggle Sidebar
    document.getElementById('sidebarToggle').addEventListener('click', function() {
        document.getElementById('sidebarMenu').classList.toggle('collapsed');
    });

    // Mobile Sidebar Toggle
    document.querySelectorAll('.navbar-toggler').forEach(function(btn) {
        btn.addEventListener('click', function() {
            document.getElementById('sidebarMenu').classList.toggle('show');
        });
    });

    // Close sidebar on mobile when clicking outside
    document.addEventListener('click', function(e) {
        const sidebar = document.getElementById('sidebarMenu');
        const toggler = document.querySelector('.navbar-toggler');
        
        if (window.innerWidth < 992) {
            if (!sidebar.contains(e.target) && !toggler.contains(e.target)) {
                sidebar.classList.remove('show');
            }
        }
    });
</script>