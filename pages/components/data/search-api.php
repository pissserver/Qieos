<?php
include '../../../script/connection.php';
header('Content-Type: application/json');

$q = isset($_GET['q']) ? trim($_GET['q']) : '';
$role = isset($_GET['role']) ? trim($_GET['role']) : '';

if ($q === '') {
    echo json_encode(['status' => 'success', 'results' => ['pages' => [], 'products' => [], 'tenants' => []]]);
    exit;
}

$like = '%' . $conn->real_escape_string($q) . '%';

$pages = [
    ['name' => 'Dashboard', 'url' => '/qieos/pages/dashboard.php', 'icon' => 'fas fa-chart-pie', 'category' => 'Halaman'],
    ['name' => 'Katalog Produk', 'url' => '/qieos/pages/coming-soon.php', 'icon' => 'fas fa-th-large', 'category' => 'Penjualan'],
    ['name' => 'Pesanan', 'url' => '/qieos/pages/coming-soon.php', 'icon' => 'fas fa-receipt', 'category' => 'Penjualan'],
    ['name' => 'Stok Penjualan', 'url' => '/qieos/pages/coming-soon.php', 'icon' => 'fas fa-boxes-stacked', 'category' => 'Penjualan'],
    ['name' => 'Tenant', 'url' => '/qieos/pages/tenant/tenant.php', 'icon' => 'fas fa-store', 'category' => 'Tenant'],
    ['name' => 'Pendaftaran Tenant', 'url' => '/qieos/pages/tenant/registration.php', 'icon' => 'fas fa-file-signature', 'category' => 'Tenant'],
    ['name' => 'Laporan Penjualan', 'url' => '/qieos/pages/coming-soon.php', 'icon' => 'fas fa-chart-bar', 'category' => 'Laporan'],
    ['name' => 'Laporan Tenant', 'url' => '/qieos/pages/report/report-tenant.php', 'icon' => 'fas fa-file-invoice-dollar', 'category' => 'Laporan'],
    ['name' => 'Rekap', 'url' => '/qieos/pages/recap/recap.php', 'icon' => 'fas fa-clipboard-list', 'category' => 'Laporan'],
    ['name' => 'Stok Gudang', 'url' => '/qieos/pages/coming-soon.php', 'icon' => 'fas fa-warehouse', 'category' => 'Persediaan'],
    ['name' => 'Mutasi Stok', 'url' => '/qieos/pages/coming-soon.php', 'icon' => 'fas fa-exchange-alt', 'category' => 'Persediaan'],
    ['name' => 'Transfer ke Penjualan', 'url' => '/qieos/pages/coming-soon.php', 'icon' => 'fas fa-truck-loading', 'category' => 'Persediaan'],
    ['name' => 'Daftar Belanja', 'url' => '/qieos/pages/coming-soon.php', 'icon' => 'fas fa-cart-plus', 'category' => 'Purchasing'],
    ['name' => 'Input Pembelian', 'url' => '/qieos/pages/coming-soon.php', 'icon' => 'fas fa-dolly', 'category' => 'Purchasing'],
    ['name' => 'Administrator', 'url' => '/qieos/pages/coming-soon.php', 'icon' => 'fas fa-user-shield', 'category' => 'Management'],
    ['name' => 'Staff Kasir', 'url' => '/qieos/pages/coming-soon.php', 'icon' => 'fas fa-cash-register', 'category' => 'Management'],
    ['name' => 'Profil', 'url' => '/qieos/pages/profile/profile.php', 'icon' => 'fas fa-user-circle', 'category' => 'Akun'],
    ['name' => 'Update', 'url' => '/qieos/pages/other/update.php', 'icon' => 'fas fa-rocket', 'category' => 'Sistem'],
];

if ($role === 'developer' || $role === 'staff kasir') {
    $pages[] = ['name' => 'Checkout', 'url' => '/qieos/pages/checkout.php', 'icon' => 'fas fa-credit-card', 'category' => 'Penjualan'];
    $pages[] = ['name' => 'Riwayat Pesanan', 'url' => '/qieos/pages/sales/order.php', 'icon' => 'fas fa-history', 'category' => 'Penjualan'];
}

$matched_pages = [];
foreach ($pages as $p) {
    if (stripos($p['name'], $q) !== false) {
        $matched_pages[] = $p;
    }
}

$matched_products = [];
$prod_q = $conn->query("SELECT id, product_name, product_code, category, price, stock, photo FROM products WHERE deleted_at IS NULL AND (product_name LIKE '$like' OR product_code LIKE '$like' OR category LIKE '$like') ORDER BY product_name ASC LIMIT 8");
if ($prod_q) {
    while ($row = $prod_q->fetch_assoc()) {
        $matched_products[] = [
            'id' => $row['id'],
            'name' => $row['product_name'],
            'code' => $row['product_code'],
            'category' => $row['category'],
            'price' => 'Rp ' . number_format($row['price'], 0, ',', '.'),
            'stock' => (int)$row['stock'],
            'photo' => $row['photo'] ? '/qieos/assets/img/uploads/' . $row['photo'] : '/qieos/assets/img/default-avatar.jpg',
            'url' => '/qieos/pages/coming-soon.php',
            'icon' => 'fas fa-box',
            'category_label' => 'Produk'
        ];
    }
}

$matched_tenants = [];
$tnt_q = $conn->query("SELECT id, tenant_name, tenant_code, tenant_type FROM tenants WHERE deleted_at IS NULL AND (tenant_name LIKE '$like' OR tenant_code LIKE '$like' OR tenant_type LIKE '$like') ORDER BY tenant_name ASC LIMIT 5");
if ($tnt_q) {
    while ($row = $tnt_q->fetch_assoc()) {
        $matched_tenants[] = [
            'id' => $row['id'],
            'name' => $row['tenant_name'],
            'code' => $row['tenant_code'],
            'type' => $row['tenant_type'],
            'url' => '/qieos/pages/tenant/tenant-detail.php?id=' . $row['id'],
            'icon' => 'fas fa-store',
            'category_label' => 'Tenant'
        ];
    }
}

echo json_encode([
    'status' => 'success',
    'results' => [
        'pages' => $matched_pages,
        'products' => $matched_products,
        'tenants' => $matched_tenants
    ]
]);
