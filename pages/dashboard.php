<?php
include '../sessions/session.php';

date_default_timezone_set('Asia/Jakarta');
$today = date('Y-m-d');
$this_month = date('Y-m');

// ===== STATS =====
$total_customers = 0;
$total_revenue = 0;
$total_cashouts = 0;
$total_orders = 0;
$total_products = 0;
$net_profit = 0;
$today_revenue = 0;
$today_orders = 0;
$today_customers = 0;
$this_month_revenue = 0;
$this_month_orders = 0;
$pending_orders = 0;

$r = mysqli_query($conn, "SELECT COUNT(DISTINCT customer_name) as c, COALESCE(SUM(total),0) as r, COUNT(*) as o FROM orders WHERE status_payment='paid'");
if ($row = mysqli_fetch_assoc($r)) {
    $total_customers = $row['c'];
    $total_revenue = $row['r'];
    $total_orders = $row['o'];
}

$r = mysqli_query($conn, "SELECT COALESCE(SUM(amount),0) as c FROM cashouts");
if ($row = mysqli_fetch_assoc($r)) $total_cashouts = $row['c'];

$net_profit = $total_revenue - $total_cashouts;

$r = mysqli_query($conn, "SELECT COUNT(*) as c FROM products");
if ($row = mysqli_fetch_assoc($r)) $total_products = $row['c'];

$r = mysqli_query($conn, "SELECT COUNT(DISTINCT customer_name) as c, COALESCE(SUM(total),0) as r, COUNT(*) as o FROM orders WHERE DATE(tanggal)='$today' AND status_payment='paid'");
if ($row = mysqli_fetch_assoc($r)) {
    $today_revenue = $row['r'];
    $today_orders = $row['o'];
    $today_customers = $row['c'];
}

$r = mysqli_query($conn, "SELECT COALESCE(SUM(total),0) as r, COUNT(*) as o FROM orders WHERE DATE_FORMAT(tanggal,'%Y-%m')='$this_month' AND status_payment='paid'");
if ($row = mysqli_fetch_assoc($r)) {
    $this_month_revenue = $row['r'];
    $this_month_orders = $row['o'];
}

$r = mysqli_query($conn, "SELECT COUNT(*) as c FROM orders WHERE status_payment='waiting'");
if ($row = mysqli_fetch_assoc($r)) $pending_orders = $row['c'];

// ===== CHART: Monthly Revenue (last 6 months) =====
$chart_labels = [];
$chart_data = [];
$r = mysqli_query($conn, "SELECT DATE_FORMAT(tanggal,'%b') as label, DATE_FORMAT(tanggal,'%Y-%m') as key_month, COALESCE(SUM(total),0) as rev FROM orders WHERE status_payment='paid' AND tanggal >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH) GROUP BY key_month ORDER BY key_month ASC");
while ($row = mysqli_fetch_assoc($r)) {
    $chart_labels[] = $row['label'];
    $chart_data[] = (float)$row['rev'];
}

// ===== CHART: Order Status =====
$status_paid = 0;
$status_waiting = 0;
$status_cancelled = 0;
$r = mysqli_query($conn, "SELECT status_payment, COUNT(*) as c FROM orders GROUP BY status_payment");
while ($row = mysqli_fetch_assoc($r)) {
    if ($row['status_payment'] == 'paid') $status_paid = $row['c'];
    elseif ($row['status_payment'] == 'waiting') $status_waiting = $row['c'];
    elseif ($row['status_payment'] == 'cancelled') $status_cancelled = $row['c'];
}

// ===== RECENT ORDERS =====
$recent_orders = [];
$r = mysqli_query($conn, "SELECT o.code, o.customer_name, o.total, o.tanggal, o.status_payment, u.fullname as staff_name FROM orders o LEFT JOIN users u ON o.staff_id = u.id ORDER BY o.tanggal DESC LIMIT 6");
while ($row = mysqli_fetch_assoc($r)) $recent_orders[] = $row;

// ===== TOP PRODUCTS =====
$top_products = [];
$r = mysqli_query($conn, "SELECT p.name, p.category, COUNT(od.product_id) as times_sold, COALESCE(SUM(od.qty),0) as total_qty, COALESCE(SUM(od.subtotal),0) as total_rev FROM order_details od JOIN products p ON od.product_id = p.id JOIN orders o ON od.order_id = o.id WHERE o.status_payment='paid' GROUP BY od.product_id ORDER BY total_rev DESC LIMIT 5");
while ($row = mysqli_fetch_assoc($r)) $top_products[] = $row;

// ===== TOP CUSTOMERS =====
$top_customers = [];
$r = mysqli_query($conn, "SELECT customer_name, COUNT(*) as total_orders, COALESCE(SUM(total),0) as total_spent FROM orders WHERE status_payment='paid' GROUP BY customer_name ORDER BY total_spent DESC LIMIT 5");
while ($row = mysqli_fetch_assoc($r)) $top_customers[] = $row;

// ===== DAILY REVENUE (last 7 days) =====
$week_labels = [];
$week_data = [];
$r = mysqli_query($conn, "SELECT DATE(tanggal) as d, DAYNAME(tanggal) as day_name, COALESCE(SUM(total),0) as rev FROM orders WHERE status_payment='paid' AND tanggal >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) GROUP BY d ORDER BY d ASC");
while ($row = mysqli_fetch_assoc($r)) {
    $week_labels[] = substr($row['day_name'], 0, 3);
    $week_data[] = (float)$row['rev'];
}

// ===== CASHOUT CATEGORIES =====
$recent_cashouts = [];
$r = mysqli_query($conn, "SELECT note, amount, created_at FROM cashouts ORDER BY created_at DESC LIMIT 5");
if ($r) while ($row = mysqli_fetch_assoc($r)) $recent_cashouts[] = $row;
?>

<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Qieos</title>
    <?php include '../script/headscript.php'; ?>
    <link rel="stylesheet" href="../assets/css/auth-premium.css">
    <style>
        .dash-stats-row { display:grid; grid-template-columns:repeat(4,1fr); gap:16px; margin-bottom:24px; }
        .dash-stat-card {
            background: #1f2235; border:1px solid rgba(255,255,255,0.06);
            border-radius:16px; padding:20px 22px; position:relative; overflow:hidden;
            transition: transform .25s ease, box-shadow .25s ease;
        }
        .dash-stat-card:hover { transform:translateY(-3px); box-shadow:0 12px 30px rgba(0,0,0,0.25); }
        .dash-stat-card .stat-icon {
            width:44px; height:44px; border-radius:12px; display:flex;
            align-items:center; justify-content:center; margin-bottom:14px;
        }
        .dash-stat-card .stat-icon svg { width:22px; height:22px; }
        .dash-stat-card .stat-label { font-size:.78rem; color:#9499b3; font-weight:600; text-transform:uppercase; letter-spacing:.04em; margin-bottom:4px; }
        .dash-stat-card .stat-value { font-size:1.35rem; font-weight:800; color:#f0f0f5; letter-spacing:-.02em; }
        .dash-stat-card .stat-sub { font-size:.72rem; color:#6e7191; margin-top:6px; }
        .dash-stat-card .stat-glow {
            position:absolute; width:120px; height:120px; border-radius:50%;
            filter:blur(50px); opacity:.15; top:-30px; right:-30px;
        }
        .icon-blue { background:rgba(99,102,241,0.12); color:#818cf8; }
        .icon-green { background:rgba(16,185,129,0.12); color:#34d399; }
        .icon-red { background:rgba(239,68,68,0.12); color:#f87171; }
        .icon-amber { background:rgba(245,158,11,0.12); color:#fbbf24; }
        .glow-blue { background:#6366f1; }
        .glow-green { background:#10b981; }
        .glow-red { background:#ef4444; }
        .glow-amber { background:#f59e0b; }

        .dash-chart-card {
            background:#1f2235; border:1px solid rgba(255,255,255,0.06);
            border-radius:16px; padding:22px; margin-bottom:24px;
        }
        .dash-chart-card .chart-title { font-size:1rem; font-weight:700; color:#f0f0f5; margin-bottom:4px; }
        .dash-chart-card .chart-sub { font-size:.78rem; color:#6e7191; margin-bottom:18px; }

        .dash-grid { display:grid; grid-template-columns:2fr 1fr; gap:20px; margin-bottom:24px; }
        .dash-grid-equal { display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:24px; }

        .order-row { display:flex; align-items:center; padding:12px 0; border-bottom:1px solid rgba(255,255,255,0.04); }
        .order-row:last-child { border-bottom:none; }
        .order-code { font-weight:700; font-size:.82rem; color:#c0c3d8; min-width:130px; }
        .order-customer { font-size:.82rem; color:#9499b3; flex:1; }
        .order-amount { font-weight:700; font-size:.85rem; color:#fbbf24; min-width:100px; text-align:right; }
        .order-status { font-size:.7rem; font-weight:700; padding:4px 10px; border-radius:20px; min-width:65px; text-align:center; }
        .status-paid { background:rgba(16,185,129,0.12); color:#34d399; }
        .status-waiting { background:rgba(245,158,11,0.12); color:#fbbf24; }
        .status-cancelled { background:rgba(239,68,68,0.12); color:#f87171; }

        .product-row { display:flex; align-items:center; padding:10px 0; border-bottom:1px solid rgba(255,255,255,0.04); }
        .product-row:last-child { border-bottom:none; }
        .product-rank { width:28px; height:28px; border-radius:8px; display:flex; align-items:center; justify-content:center; font-size:.72rem; font-weight:800; background:rgba(99,102,241,0.12); color:#818cf8; margin-right:12px; }
        .product-name { flex:1; font-size:.85rem; color:#c0c3d8; font-weight:600; }
        .product-cat { font-size:.7rem; color:#6e7191; margin-right:12px; }
        .product-rev { font-weight:700; font-size:.82rem; color:#fbbf24; }

        .customer-row { display:flex; align-items:center; padding:10px 0; border-bottom:1px solid rgba(255,255,255,0.04); }
        .customer-row:last-child { border-bottom:none; }
        .customer-avatar { width:36px; height:36px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-weight:800; font-size:.85rem; color:#fff; margin-right:12px; flex-shrink:0; }
        .customer-info { flex:1; }
        .customer-name { font-size:.85rem; color:#c0c3d8; font-weight:600; }
        .customer-orders { font-size:.7rem; color:#6e7191; }
        .customer-spent { font-weight:700; font-size:.82rem; color:#fbbf24; text-align:right; }

        .dash-empty { text-align:center; padding:40px 20px; color:#6e7191; font-size:.9rem; }
        .dash-empty svg { width:48px; height:48px; margin-bottom:12px; opacity:.4; }

        .stat-animate { opacity:0; transform:translateY(20px); }
        .stat-animate.revealed { animation:dashReveal .5s cubic-bezier(.16,1,.3,1) forwards; }
        @keyframes dashReveal { to { opacity:1; transform:translateY(0); } }

        @media(max-width:1199px) { .dash-stats-row { grid-template-columns:repeat(2,1fr); } .dash-grid, .dash-grid-equal { grid-template-columns:1fr; } }
        @media(max-width:575px) { .dash-stats-row { grid-template-columns:1fr; } }
    </style>
</head>

<body>
    <?php if (isset($_GET['login']) && $_GET['login'] == '1'): ?>
    <div class="dashboard-entry-overlay" id="dashboardEntryOverlay">
        <div class="dashboard-entry-logo">
            <img src="../assets/img/brand/qieos.png" alt="Qieos">
        </div>
        <div class="dashboard-welcome-text">Selamat Datang, <?php echo htmlspecialchars($user['fullname'] ? $user['fullname'] : $user['username']); ?>!</div>
        <div class="dashboard-welcome-sub">Memuat dashboard Anda...</div>
    </div>
    <?php endif; ?>

    <?php include 'components/sidebar.php'; ?>

    <main class="content" id="dashboardContent" <?php echo (isset($_GET['login']) && $_GET['login'] == '1') ? 'style="opacity:0"' : ''; ?>>
        <?php include 'components/navbar.php'; ?>

        <div class="mt-4" id="dashboardMain">

            <!-- STAT CARDS -->
            <div class="dash-stats-row">
                <div class="dash-stat-card stat-animate">
                    <div class="stat-glow glow-blue"></div>
                    <div class="stat-icon icon-blue">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div class="stat-label">Total Omzet</div>
                    <div class="stat-value" data-count="<?php echo $total_revenue; ?>">Rp 0</div>
                    <div class="stat-sub">Dari <?php echo number_format($total_orders); ?> transaksi</div>
                </div>

                <div class="dash-stat-card stat-animate">
                    <div class="stat-glow glow-green"></div>
                    <div class="stat-icon icon-green">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div class="stat-label">Omzet Hari Ini</div>
                    <div class="stat-value" data-count="<?php echo $today_revenue; ?>">Rp 0</div>
                    <div class="stat-sub"><?php echo number_format($today_orders); ?> pesanan hari ini</div>
                </div>

                <div class="dash-stat-card stat-animate">
                    <div class="stat-glow glow-red"></div>
                    <div class="stat-icon icon-red">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                    <div class="stat-label">Total Cashout</div>
                    <div class="stat-value" data-count="<?php echo $total_cashouts; ?>">Rp 0</div>
                    <div class="stat-sub">Laba bersih: Rp <?php echo number_format($net_profit); ?></div>
                </div>

                <div class="dash-stat-card stat-animate">
                    <div class="stat-glow glow-amber"></div>
                    <div class="stat-icon icon-amber">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    </div>
                    <div class="stat-label">Produk Aktif</div>
                    <div class="stat-value" data-count="<?php echo $total_products; ?>">0</div>
                    <div class="stat-sub"><?php echo number_format($pending_orders); ?> pesanan menunggu</div>
                </div>
            </div>

            <!-- SECONDARY STATS -->
            <div class="dash-stats-row" style="grid-template-columns:repeat(3,1fr); margin-bottom:24px;">
                <div class="dash-stat-card stat-animate" style="padding:16px 20px;">
                    <div class="stat-label" style="margin-bottom:2px;">Pelanggan Hari Ini</div>
                    <div class="stat-value" style="font-size:1.15rem;" data-count="<?php echo $today_customers; ?>">0</div>
                </div>
                <div class="dash-stat-card stat-animate" style="padding:16px 20px;">
                    <div class="stat-label" style="margin-bottom:2px;">Omzet Bulan Ini</div>
                    <div class="stat-value" style="font-size:1.15rem;" data-count="<?php echo $this_month_revenue; ?>">Rp 0</div>
                </div>
                <div class="dash-stat-card stat-animate" style="padding:16px 20px;">
                    <div class="stat-label" style="margin-bottom:2px;">Pesanan Bulan Ini</div>
                    <div class="stat-value" style="font-size:1.15rem;" data-count="<?php echo $this_month_orders; ?>">0</div>
                </div>
            </div>

            <!-- CHARTS ROW -->
            <div class="dash-grid stat-animate">
                <div class="dash-chart-card">
                    <div class="chart-title">Omzet 6 Bulan Terakhir</div>
                    <div class="chart-sub">Grafik total pendapatan per bulan</div>
                    <div id="revenueChart" style="height:260px;"></div>
                </div>
                <div class="dash-chart-card">
                    <div class="chart-title">Status Pesanan</div>
                    <div class="chart-sub">Distribusi seluruh status</div>
                    <div id="statusChart" style="height:260px;"></div>
                    <div style="display:flex; justify-content:center; gap:16px; margin-top:12px;">
                        <div style="display:flex; align-items:center; gap:6px; font-size:.75rem; color:#9499b3;">
                            <div style="width:10px;height:10px;border-radius:3px;background:#34d399;"></div> Dibayar (<?php echo $status_paid; ?>)
                        </div>
                        <div style="display:flex; align-items:center; gap:6px; font-size:.75rem; color:#9499b3;">
                            <div style="width:10px;height:10px;border-radius:3px;background:#fbbf24;"></div> Pending (<?php echo $status_waiting; ?>)
                        </div>
                        <div style="display:flex; align-items:center; gap:6px; font-size:.75rem; color:#9499b3;">
                            <div style="width:10px;height:10px;border-radius:3px;background:#f87171;"></div> Dibatal (<?php echo $status_cancelled; ?>)
                        </div>
                    </div>
                </div>
            </div>

            <!-- WEEKLY CHART + RECENT ORDERS -->
            <div class="dash-grid-equal stat-animate">
                <div class="dash-chart-card">
                    <div class="chart-title">Omzet 7 Hari Terakhir</div>
                    <div class="chart-sub">Pendapatan harian minggu ini</div>
                    <div id="weeklyChart" style="height:220px;"></div>
                </div>
                <div class="dash-chart-card">
                    <div class="chart-title">Pesanan Terbaru</div>
                    <div class="chart-sub">Transaksi terakhir yang masuk</div>
                    <?php if (empty($recent_orders)): ?>
                        <div class="dash-empty">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            <div>Belum ada pesanan</div>
                        </div>
                    <?php else: ?>
                        <?php foreach ($recent_orders as $o): ?>
                            <div class="order-row">
                                <div class="order-code"><?php echo htmlspecialchars($o['code']); ?></div>
                                <div class="order-customer"><?php echo htmlspecialchars($o['customer_name'] ?: '-'); ?></div>
                                <div class="order-amount">Rp <?php echo number_format($o['total'], 0, ',', '.'); ?></div>
                                <div class="order-status status-<?php echo $o['status_payment']; ?>"><?php echo ucfirst($o['status_payment']); ?></div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- TOP PRODUCTS + TOP CUSTOMERS -->
            <div class="dash-grid-equal stat-animate">
                <div class="dash-chart-card">
                    <div class="chart-title">Produk Terlaris</div>
                    <div class="chart-sub">Berdasarkan total pendapatan</div>
                    <?php if (empty($top_products)): ?>
                        <div class="dash-empty">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                            <div>Belum ada data produk</div>
                        </div>
                    <?php else: ?>
                        <?php $rank = 1; foreach ($top_products as $p): ?>
                            <div class="product-row">
                                <div class="product-rank"><?php echo $rank++; ?></div>
                                <div class="product-name"><?php echo htmlspecialchars($p['name']); ?></div>
                                <div class="product-cat"><?php echo ucfirst(htmlspecialchars($p['category'])); ?></div>
                                <div class="product-rev">Rp <?php echo number_format($p['total_rev'], 0, ',', '.'); ?></div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div class="dash-chart-card">
                    <div class="chart-title">Pelanggan Teratas</div>
                    <div class="chart-sub">Berdasarkan total pengeluaran</div>
                    <?php if (empty($top_customers)): ?>
                        <div class="dash-empty">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <div>Belum ada data pelanggan</div>
                        </div>
                    <?php else: ?>
                        <?php
                        $colors = ['#6366f1','#8b5cf6','#ec4899','#10b981','#f59e0b'];
                        $ci = 0;
                        foreach ($top_customers as $c):
                            $color = $colors[$ci % count($colors)];
                            $ci++;
                        ?>
                            <div class="customer-row">
                                <div class="customer-avatar" style="background:<?php echo $color; ?>;">
                                    <?php echo strtoupper(substr($c['customer_name'], 0, 1)); ?>
                                </div>
                                <div class="customer-info">
                                    <div class="customer-name"><?php echo htmlspecialchars($c['customer_name']); ?></div>
                                    <div class="customer-orders"><?php echo $c['total_orders']; ?> pesanan</div>
                                </div>
                                <div class="customer-spent">Rp <?php echo number_format($c['total_spent'], 0, ',', '.'); ?></div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </main>

    <?php include "../script/footscript.php"; ?>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Login overlay
        var overlay = document.getElementById('dashboardEntryOverlay');
        var content = document.getElementById('dashboardContent');
        if (overlay) {
            setTimeout(function() {
                overlay.classList.add('fade-out');
                if (content) { content.style.transition = 'opacity .5s ease'; content.style.opacity = '1'; }
                setTimeout(function() { overlay.remove(); if (window.history && window.history.replaceState) window.history.replaceState({}, '', window.location.pathname); }, 600);
            }, 1000);
        }

        // Staggered reveal
        var anims = document.querySelectorAll('.stat-animate');
        anims.forEach(function(el, i) {
            setTimeout(function() { el.classList.add('revealed'); }, 100 + i * 80);
        });

        // Animated counters
        document.querySelectorAll('.stat-value[data-count]').forEach(function(el) {
            var target = parseInt(el.getAttribute('data-count')) || 0;
            var prefix = el.textContent.startsWith('Rp') ? 'Rp ' : '';
            var duration = 1200;
            var start = 0;
            var startTime = null;
            function step(timestamp) {
                if (!startTime) startTime = timestamp;
                var progress = Math.min((timestamp - startTime) / duration, 1);
                var eased = 1 - Math.pow(1 - progress, 3);
                var current = Math.floor(eased * target);
                el.textContent = prefix + (prefix ? '' : '') + current.toLocaleString('id-ID');
                if (progress < 1) requestAnimationFrame(step);
                else el.textContent = prefix + target.toLocaleString('id-ID');
            }
            setTimeout(function() { requestAnimationFrame(step); }, 600);
        });

        // Revenue Bar Chart (Chartist)
        if (typeof Chartist !== 'undefined') {
            var labels = <?php echo json_encode($chart_labels); ?>;
            var data = <?php echo json_encode($chart_data); ?>;
            if (labels.length > 0) {
                new Chartist.Bar('#revenueChart', {
                    labels: labels,
                    series: [{ data: data }]
                }, {
                    distributeSeries: true,
                    plugins: [Chartist.plugins.tooltip()],
                    axisY: {
                        offset: 60,
                        labelInterpolationFnc: function(v) { return 'Rp ' + (v/1000000).toFixed(1) + 'jt'; }
                    },
                    axisX: { showGrid: false },
                    chartPadding: { top: 20, right: 15, bottom: 5, left: 10 }
                });
            }

            // Status Pie Chart
            var pieLabels = ['Dibayar', 'Pending', 'Dibatal'];
            var pieData = [<?php echo $status_paid; ?>, <?php echo $status_waiting; ?>, <?php echo $status_cancelled; ?>];
            if (pieData.some(function(v){return v>0;})) {
                new Chartist.Pie('#statusChart', {
                    labels: pieLabels,
                    series: pieData
                }, {
                    donut: true,
                    donutWidth: 50,
                    donutSolid: true,
                    showLabel: true,
                    labelOffset: 10,
                    labelDirection: 'explode',
                    plugins: [Chartist.plugins.tooltip()]
                });
            }

            // Weekly Line Chart
            var wLabels = <?php echo json_encode($week_labels); ?>;
            var wData = <?php echo json_encode($week_data); ?>;
            if (wLabels.length > 0) {
                new Chartist.Line('#weeklyChart', {
                    labels: wLabels,
                    series: [{ data: wData }]
                }, {
                    fullWidth: true,
                    chartPadding: { top: 20, right: 15, bottom: 5, left: 10 },
                    axisY: {
                        offset: 60,
                        labelInterpolationFnc: function(v) { return 'Rp ' + (v/1000).toFixed(0) + 'k'; }
                    },
                    axisX: { showGrid: false },
                    plugins: [Chartist.plugins.tooltip()]
                });
            }
        }
    });
    </script>
</body>
</html>
