<?php
    $current_page = basename($_SERVER['PHP_SELF']);

    // Ambil versi update terbaru dari database jika koneksi $conn tersedia
    $latest_version = 'v1.0.0';
    if (isset($conn) && $conn) {
        $q_ver = mysqli_query($conn, "SELECT update_version FROM updates WHERE deleted_at IS NULL ORDER BY id DESC LIMIT 1");
        if ($q_ver && mysqli_num_rows($q_ver) > 0) {
            $row_ver = mysqli_fetch_assoc($q_ver);
            $latest_version = 'v' . ltrim($row_ver['update_version'], 'v');
        }
    }
?>

<style>
    :root {
        --sidebar-width: 270px;
        --sidebar-collapsed-width: 80px;
        --sidebar-bg: #0f172a;
        --sidebar-border: rgba(255, 255, 255, 0.08);
        --sidebar-shadow: 0 20px 40px rgba(0, 0, 0, 0.35);
        --accent-gradient: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
        --text-primary: #f8fafc;
        --text-secondary: #94a3b8;
        --hover-bg: rgba(255, 255, 255, 0.05);
        --active-shadow: 0 8px 20px rgba(99, 102, 241, 0.3);
    }

    /* ===== SIDEBAR CONTAINER ===== */
    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        height: 100dvh;
        width: var(--sidebar-width);
        background: var(--sidebar-bg);
        border-right: 1px solid var(--sidebar-border);
        box-shadow: var(--sidebar-shadow);
        transition: width 0.35s cubic-bezier(0.16, 1, 0.3, 1), transform 0.35s cubic-bezier(0.16, 1, 0.3, 1);
        z-index: 1040;
        display: flex;
        flex-direction: column;
        user-select: none;
        overflow: hidden;
    }

    .sidebar.collapsed {
        width: var(--sidebar-collapsed-width);
    }

    /* Collapsed Hide Elements with smooth fade */
    .sidebar.collapsed .sidebar-text,
    .sidebar.collapsed .sidebar-logo-text,
    .sidebar.collapsed .nav-title,
    .sidebar.collapsed .version-text {
        opacity: 0;
        visibility: hidden;
        width: 0;
        margin: 0;
        pointer-events: none;
        white-space: nowrap;
    }

    /* Show Version Icon on Collapse */
    .version-icon {
        display: none;
        font-size: 0.95rem;
        color: var(--text-primary);
        margin: 0;
        line-height: 1;
    }

    .sidebar.collapsed .version-icon {
        display: flex;
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        align-items: center;
        justify-content: center;
    }

    /* ===== SIDEBAR HEADER ===== */
    .sidebar-header {
        padding: 20px 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid var(--sidebar-border);
        min-height: 75px;
    }

    .sidebar-logo {
        display: flex;
        align-items: center;
        gap: 12px;
        text-decoration: none;
        overflow: hidden;
    }

    .sidebar-logo-icon {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.06);
        border: 1px solid rgba(255, 255, 255, 0.12);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        padding: 6px;
        transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .sidebar-logo:hover .sidebar-logo-icon {
        transform: scale(1.08) rotate(-3deg);
        border-color: rgba(99, 102, 241, 0.5);
    }

    .sidebar-logo-icon img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .sidebar-logo-text {
        display: flex;
        flex-direction: column;
        transition: opacity 0.25s ease, visibility 0.25s ease;
    }

    .sidebar-logo-text h4 {
        margin: 0;
        font-size: 1.15rem;
        font-weight: 800;
        color: var(--text-primary);
        letter-spacing: -0.02em;
    }

    .sidebar-logo-text span {
        font-size: 0.725rem;
        color: var(--text-secondary);
        font-weight: 500;
        letter-spacing: 0.02em;
    }

    .sidebar-toggle {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: var(--text-secondary);
        cursor: pointer;
        transition: all 0.25s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .sidebar-toggle:hover {
        background: rgba(255, 255, 255, 0.12);
        color: var(--text-primary);
    }

    .sidebar.collapsed .sidebar-toggle i {
        transform: rotate(180deg);
    }

    .sidebar-toggle i {
        transition: transform 0.35s ease;
        font-size: 0.875rem;
    }

    /* ===== SIDEBAR MENU ===== */
    .sidebar-menu {
        flex: 1;
        overflow-y: auto;
        overflow-x: hidden;
        padding: 16px 12px;
        scrollbar-width: thin;
        scrollbar-color: rgba(255, 255, 255, 0.15) transparent;
    }

    .sidebar-menu::-webkit-scrollbar {
        width: 5px;
    }

    .sidebar-menu::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.15);
        border-radius: 10px;
    }

    /* ===== NAV TITLE ===== */
    .nav-title {
        font-size: 0.65rem;
        font-weight: 700;
        color: #64748b;
        margin: 20px 0 8px 12px;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        transition: opacity 0.2s ease, visibility 0.2s ease;
        white-space: nowrap;
    }

    .nav-title:first-child {
        margin-top: 4px;
    }

    /* Collapsed Title Indicator Line */
    .sidebar.collapsed .nav-title {
        margin: 16px 0 8px 0;
        height: 1px;
        background: rgba(255, 255, 255, 0.08);
        overflow: hidden;
    }

    /* ===== NAV ITEMS ===== */
    .nav {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .nav-item {
        margin-bottom: 4px;
        position: relative;
    }

    .nav-link {
        display: flex;
        align-items: center;
        padding: 10px 14px;
        border-radius: 12px;
        color: var(--text-secondary);
        text-decoration: none;
        font-size: 0.885rem;
        font-weight: 400; /* NORMAL WEIGHT */
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        position: relative;
        white-space: nowrap;
        overflow: hidden;
    }

    .sidebar.collapsed .nav-link {
        padding: 10px 0;
        justify-content: center;
    }

    .nav-link:hover {
        background: var(--hover-bg);
        color: var(--text-primary);
        transform: translateX(3px);
    }

    .sidebar.collapsed .nav-link:hover {
        transform: none;
    }

    .nav-item.active .nav-link {
        background: var(--accent-gradient);
        color: #ffffff;
        font-weight: 500;
        box-shadow: var(--active-shadow);
    }

    .sidebar-icon {
        width: 22px;
        height: 22px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 12px;
        flex-shrink: 0;
        font-size: 1.05rem;
        transition: margin 0.3s ease;
    }

    .sidebar.collapsed .sidebar-icon {
        margin-right: 0;
    }

    .sidebar-text {
        transition: opacity 0.2s ease, visibility 0.2s ease;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        font-weight: 400; /* NORMAL WEIGHT */
    }

    /* ===== FLOATING TOOLTIP WHEN COLLAPSED ===== */
    .sidebar-tooltip {
        position: fixed;
        left: 92px;
        background: #1e293b;
        color: #f8fafc;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 500;
        white-space: nowrap;
        pointer-events: none;
        opacity: 0;
        visibility: hidden;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4);
        border: 1px solid rgba(255, 255, 255, 0.12);
        z-index: 1090;
        transition: opacity 0.15s ease, visibility 0.15s ease, transform 0.15s ease;
        transform: translateY(-50%) translateX(-6px);
    }

    .sidebar-tooltip.show {
        opacity: 1;
        visibility: visible;
        transform: translateY(-50%) translateX(0);
    }

    /* ===== SIDEBAR FOOTER ===== */
    .sidebar-footer {
        padding: 16px;
        border-top: 1px solid var(--sidebar-border);
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .version-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 8px 16px;
        border-radius: 99px;
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.08);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .version-text {
        display: flex;
        align-items: center;
        gap: 6px;
        transition: opacity 0.2s ease, visibility 0.2s ease;
    }

    .version-badge span {
        font-weight: 600;
        color: var(--text-primary);
        font-size: 0.8rem;
    }

    .version-badge small {
        color: var(--text-secondary);
        font-size: 0.725rem;
    }

    .sidebar.collapsed .version-badge {
        padding: 0;
        border-radius: 50%;
        width: 38px;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* ===== MOBILE OVERLAY & NAVBAR ===== */
    .sidebar-overlay {
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.65);
        backdrop-filter: blur(4px);
        z-index: 1035;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }

    .sidebar-overlay.show {
        opacity: 1;
        visibility: visible;
    }

    .navbar-theme-primary {
        background: var(--sidebar-bg);
        border-bottom: 1px solid var(--sidebar-border);
        padding: 0.75rem 1rem;
    }

    .mobile-user-card {
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 14px;
        padding: 12px;
        margin-bottom: 16px;
    }

    /* ===== RESPONSIVE BEHAVIOR ===== */
    @media (max-width: 991.98px) {
        .sidebar {
            transform: translateX(-100%);
            width: 270px !important;
        }

        .sidebar.show {
            transform: translateX(0);
        }

        .sidebar.collapsed {
            width: 270px !important;
        }

        .sidebar-toggle {
            display: none;
        }

        .sidebar.collapsed .sidebar-text,
        .sidebar.collapsed .sidebar-logo-text,
        .sidebar.collapsed .nav-title,
        .sidebar.collapsed .version-text {
            opacity: 1 !important;
            visibility: visible !important;
            width: auto !important;
            margin: inherit !important;
        }

        .sidebar.collapsed .nav-link {
            padding: 10px 14px !important;
            justify-content: flex-start !important;
        }

        .sidebar.collapsed .sidebar-icon {
            margin-right: 12px !important;
        }

        .sidebar.collapsed .version-badge {
            padding: 8px 16px !important;
            border-radius: 99px !important;
            width: auto !important;
            height: auto !important;
        }

        .sidebar.collapsed .version-icon {
            display: none !important;
            position: static !important;
        }
    }

    @media (min-width: 992px) {
        .navbar-theme-primary {
            display: none !important;
        }

        .mobile-user-card {
            display: none !important;
        }

        .sidebar-overlay {
            display: none !important;
        }

        .content {
            margin-left: var(--sidebar-width) !important;
            transition: none !important;
            will-change: margin-left;
        }

        .content.sidebar-transition {
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
        }

        .sidebar.collapsed ~ .content {
            margin-left: var(--sidebar-collapsed-width) !important;
        }
    }
</style>

<!-- Mobile Overlay Backdrop -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- Floating Tooltip Container for Collapsed State -->
<div class="sidebar-tooltip" id="sidebarTooltip"></div>

<!-- Mobile Top Navbar -->
<nav class="navbar navbar-dark navbar-theme-primary px-3 d-lg-none">
    <a class="navbar-brand d-flex align-items-center gap-2" href="/qieos/pages/dashboard.php">
        <img src="/qieos/assets/img/brand/qieos.png" alt="Qieos Logo" style="height: 40px; width: auto;" />
    </a>
    <button
        class="navbar-toggler"
        type="button"
        id="mobileSidebarToggle"
        aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
</nav>

<!-- Main Collapsible Sidebar -->
<div class="sidebar" id="sidebarMenu">
    <!-- Header -->
    <div class="sidebar-header">
        <a href="/qieos/pages/dashboard.php" class="sidebar-logo">
            <div class="sidebar-logo-icon">
                <img src="/qieos/assets/img/brand/qieos2.png" alt="Qieos Logo" />
            </div>
            <div class="sidebar-logo-text">
                <h4>Qieos</h4>
                <span>POS Management</span>
            </div>
        </a>
        <button class="sidebar-toggle" id="sidebarToggle" aria-label="Toggle Sidebar">
            <i class="fas fa-chevron-left"></i>
        </button>
    </div>

    <!-- Mobile User Profile Block -->
    <div class="mobile-user-card d-lg-none mx-3 mt-3">
        <div class="d-flex align-items-center gap-3">
            <img
                src="<?php echo $user['photo'] ? '/qieos/assets/img/uploads/' . $user['photo'] : '/qieos/assets/img/default-avatar.jpg'; ?>"
                class="rounded-circle"
                style="width: 38px; height: 38px; object-fit: cover;"
                alt="User" />
            <div class="overflow-hidden">
                <h6 class="mb-0 text-white text-truncate" style="font-size: 13px; font-weight: 700;">
                    <?php echo $user['fullname'] != '' ? $user['fullname'] : $_SESSION['username']; ?>
                </h6>
                <small class="text-secondary" style="font-size: 11px;">
                    <?php echo ucwords(strtolower($user['role'])); ?>
                </small>
            </div>
        </div>
        <a href="/qieos/sessions/logout.php" class="btn btn-sm btn-danger w-100 mt-2 py-1" style="background: #ef4444; border: none; font-size: 12px; font-weight: 600;">
            <i class="fas fa-sign-out-alt me-1"></i> Logout
        </a>
    </div>

    <!-- Menu Items -->
    <div class="sidebar-menu" id="sidebarMenuContainer">
        <ul class="nav flex-column">
            <li class="nav-item <?php echo ($current_page == 'dashboard.php') ? 'active' : ''; ?>">
                <a href="/qieos/pages/dashboard.php" class="nav-link" data-tooltip="Dashboard">
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
                    <a href="/qieos/pages/coming-soon.php" class="nav-link" data-tooltip="Daftar Belanja">
                        <span class="sidebar-icon"><i class="fas fa-file-alt"></i></span>
                        <span class="sidebar-text">Daftar Belanja</span>
                    </a>
                </li>

                <li class="nav-item <?= ($current_page == 'purchase.php') ? 'active' : ''; ?>">
                    <a href="/qieos/pages/coming-soon.php" class="nav-link" data-tooltip="Input Pembelian">
                        <span class="sidebar-icon"><i class="fas fa-cart-plus"></i></span>
                        <span class="sidebar-text">Input Pembelian</span>
                    </a>
                </li>

                <li class="nav-item <?= ($current_page == 'additional.php') ? 'active' : ''; ?>">
                    <a href="/qieos/pages/coming-soon.php" class="nav-link" data-tooltip="Produk Tambahan">
                        <span class="sidebar-icon"><i class="fas fa-box-open"></i></span>
                        <span class="sidebar-text">Produk Tambahan</span>
                    </a>
                </li>

                <!-- GUDANG STOK (SUMBER BARANG / FIFO) -->
                <li class="nav-title">GUDANG STOK</li>

                <li class="nav-item <?= ($current_page == 'stock.php') ? 'active' : ''; ?>">
                    <a href="/qieos/pages/coming-soon.php" class="nav-link" data-tooltip="Stok Gudang">
                        <span class="sidebar-icon"><i class="fas fa-warehouse"></i></span>
                        <span class="sidebar-text">Stok Gudang</span>
                    </a>
                </li>

                <li class="nav-item <?= ($current_page == 'mutation.php') ? 'active' : ''; ?>">
                    <a href="/qieos/pages/coming-soon.php" class="nav-link" data-tooltip="Mutasi Stok">
                        <span class="sidebar-icon"><i class="fas fa-truck-ramp-box"></i></span>
                        <span class="sidebar-text">Mutasi Stok</span>
                    </a>
                </li>

                <li class="nav-item <?= ($current_page == 'transfer.php') ? 'active' : ''; ?>">
                    <a href="/qieos/pages/coming-soon.php" class="nav-link" data-tooltip="Transfer ke Penjualan">
                        <span class="sidebar-icon"><i class="fas fa-exchange-alt"></i></span>
                        <span class="sidebar-text">Transfer ke Penjualan</span>
                    </a>
                </li>

                <!-- TENANT -->
                <li class="nav-title">TENANT</li>

                <li class="nav-item <?= ($current_page == 'registration.php') ? 'active' : ''; ?>">
                    <a href="/qieos/pages/tenant/registration.php" class="nav-link" data-tooltip="Pendaftaran Tenant">
                        <span class="sidebar-icon"><i class="fas fa-pen-to-square"></i></span>
                        <span class="sidebar-text">Pendaftaran Tenant</span>
                    </a>
                </li>

                <li class="nav-item <?= ($current_page == 'tenant.php' || $current_page == 'tenant-detail.php') ? 'active' : ''; ?>">
                    <a href="/qieos/pages/tenant/tenant.php" class="nav-link" data-tooltip="Tenant">
                        <span class="sidebar-icon"><i class="fas fa-store"></i></span>
                        <span class="sidebar-text">Tenant</span>
                    </a>
                </li>

                <!-- LAPORAN -->
                <li class="nav-title">LAPORAN</li>

                <li class="nav-item <?= ($current_page == 'report.php') ? 'active' : ''; ?>">
                    <a href="/qieos/pages/coming-soon.php" class="nav-link" data-tooltip="Laporan Penjualan">
                        <span class="sidebar-icon"><i class="fas fa-chart-line"></i></span>
                        <span class="sidebar-text">Laporan Penjualan</span>
                    </a>
                </li>

                <li class="nav-item <?= ($current_page == 'report-tenant.php') ? 'active' : ''; ?>">
                    <a href="/qieos/pages/report/report-tenant.php" class="nav-link" data-tooltip="Laporan Tenant">
                        <span class="sidebar-icon"><i class="fas fa-chart-line"></i></span>
                        <span class="sidebar-text">Laporan Tenant</span>
                    </a>
                </li>

                <!-- MANAJEMEN STAFF -->
                <li class="nav-title">MANAJEMEN USER</li>

                <li class="nav-item <?= ($current_page == 'administrator.php') ? 'active' : ''; ?>">
                    <a href="/qieos/pages/coming-soon.php" class="nav-link" data-tooltip="Administrator">
                        <span class="sidebar-icon"><i class="fas fa-users"></i></span>
                        <span class="sidebar-text">Administrator</span>
                    </a>
                </li>

                <li class="nav-item <?= ($current_page == 'cashier.php') ? 'active' : ''; ?>">
                    <a href="/qieos/pages/coming-soon.php" class="nav-link" data-tooltip="Staff Kasir">
                        <span class="sidebar-icon"><i class="fas fa-users"></i></span>
                        <span class="sidebar-text">Staff Kasir</span>
                    </a>
                </li>

                <!-- LAINNYA -->
                <li class="nav-title">LAINNYA</li>

                <li class="nav-item <?= ($current_page == 'update.php') ? 'active' : ''; ?>">
                    <a href="/qieos/pages/other/update.php" class="nav-link" data-tooltip="Update">
                        <span class="sidebar-icon"><i class="fas fa-rocket"></i></span>
                        <span class="sidebar-text">Update</span>
                    </a>
                </li>
            <?php } ?>

            <?php if ($user['role'] == 'staff kasir') { ?>
                <!-- GUDANG PENJUALAN -->
                <li class="nav-title">PENJUALAN</li>

                <li class="nav-item <?= ($current_page == 'sales-stock.php') ? 'active' : ''; ?>">
                    <a href="/qieos/pages/coming-soon.php" class="nav-link" data-tooltip="Stok Penjualan">
                        <span class="sidebar-icon"><i class="fas fa-store"></i></span>
                        <span class="sidebar-text">Stok Penjualan</span>
                    </a>
                </li>

                <li class="nav-item <?= ($current_page == 'catalog.php') ? 'active' : ''; ?>">
                    <a href="/qieos/pages/coming-soon.php" class="nav-link" data-tooltip="Katalog Produk">
                        <span class="sidebar-icon"><i class="fas fa-book-open"></i></span>
                        <span class="sidebar-text">Katalog Produk</span>
                    </a>
                </li>

                <li class="nav-item <?= ($current_page == 'order.php') ? 'active' : ''; ?>">
                    <a href="/qieos/pages/coming-soon.php" class="nav-link" data-tooltip="Pesanan">
                        <span class="sidebar-icon"><i class="fas fa-receipt"></i></span>
                        <span class="sidebar-text">Pesanan</span>
                    </a>
                </li>

                <!-- TENANT -->
                <li class="nav-title">TENANT</li>

                <li class="nav-item <?= ($current_page == 'tenant.php' || $current_page == 'tenant-detail.php') ? 'active' : ''; ?>">
                    <a href="/qieos/pages/tenant/tenant.php" class="nav-link" data-tooltip="Daftar Tenant">
                        <span class="sidebar-icon"><i class="fas fa-store"></i></span>
                        <span class="sidebar-text">Daftar Tenant</span>
                    </a>
                </li>

                <!-- REKAP -->
                <li class="nav-title">REKAP</li>

                <li class="nav-item <?= ($current_page == 'recap.php') ? 'active' : ''; ?>">
                    <a href="/qieos/pages/recap/recap.php" class="nav-link" data-tooltip="Penjualan & Tenant">
                        <span class="sidebar-icon"><i class="fas fa-chart-bar"></i></span>
                        <span class="sidebar-text">Penjualan & Tenant</span>
                    </a>
                </li>

                <!-- LAINNYA -->
                <li class="nav-title">LAINNYA</li>

                <li class="nav-item <?= ($current_page == 'update.php') ? 'active' : ''; ?>">
                    <a href="/qieos/pages/other/update.php" class="nav-link" data-tooltip="Update">
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
            <i class="fas fa-code-branch version-icon"></i>
            <div class="version-text">
                <span>Qieos</span>
                <small><?php echo htmlspecialchars($latest_version); ?></small>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebarMenu');
        const overlay = document.getElementById('sidebarOverlay');
        const desktopToggle = document.getElementById('sidebarToggle');
        const mobileToggle = document.getElementById('mobileSidebarToggle');
        const tooltip = document.getElementById('sidebarTooltip');
        const menuContainer = document.getElementById('sidebarMenuContainer');

        // Restore collapsed state on desktop from localStorage
        if (window.innerWidth >= 992) {
            const isCollapsed = localStorage.getItem('sidebar_collapsed') === 'true';
            if (isCollapsed) {
                sidebar.classList.add('collapsed');
            }
        }

        // Auto Scroll to Active Menu Item
        const activeItem = sidebar.querySelector('.nav-item.active');
        if (activeItem && menuContainer) {
            setTimeout(function() {
                activeItem.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }, 100);
        }

        // Desktop Toggle Action
        if (desktopToggle) {
            desktopToggle.addEventListener('click', function() {
                const content = document.querySelector('.content');
                if (content) content.classList.add('sidebar-transition');
                sidebar.classList.toggle('collapsed');
                localStorage.setItem('sidebar_collapsed', sidebar.classList.contains('collapsed'));
                if (tooltip) tooltip.classList.remove('show');
                setTimeout(function() {
                    if (content) content.classList.remove('sidebar-transition');
                }, 320);
            });
        }

        // Mobile Toggle Action
        if (mobileToggle) {
            mobileToggle.addEventListener('click', function() {
                sidebar.classList.toggle('show');
                overlay.classList.toggle('show');
            });
        }

        // Mobile Overlay Click Close
        if (overlay) {
            overlay.addEventListener('click', function() {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
            });
        }

        // Floating Tooltip for Collapsed Sidebar
        const navLinks = sidebar.querySelectorAll('.nav-link');
        navLinks.forEach(function(link) {
            link.addEventListener('mouseenter', function() {
                if (sidebar.classList.contains('collapsed') && window.innerWidth >= 992) {
                    const text = this.getAttribute('data-tooltip') || this.querySelector('.sidebar-text')?.textContent;
                    if (text && tooltip) {
                        const rect = this.getBoundingClientRect();
                        tooltip.textContent = text.trim();
                        tooltip.style.top = (rect.top + rect.height / 2) + 'px';
                        tooltip.classList.add('show');
                    }
                }
            });

            link.addEventListener('mouseleave', function() {
                if (tooltip) tooltip.classList.remove('show');
            });
        });

        if (menuContainer) {
            menuContainer.addEventListener('scroll', function() {
                if (tooltip) tooltip.classList.remove('show');
            });
        }
    });
</script>
