<?php
include '../../sessions/session.php';
?>

<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Master Customer - Qieos</title>
    <?php include '../../script/headscript.php'; ?>
    <style>
        .master-card {
            background: #fff;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.04);
            padding: 24px;
        }
        .master-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 1px solid #e2e8f0;
        }
        .master-title {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .master-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: linear-gradient(135deg, #d97706, #f59e0b);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
        }
        .master-title h4 {
            font-size: 18px;
            font-weight: 700;
            margin: 0;
            color: #0f172a;
        }
        .master-title p {
            font-size: 12px;
            color: #64748b;
            margin: 0;
        }
    </style>
</head>
<body>

<?php include '../components/sidebar.php'; ?>

<main class="content">
    <?php include '../components/navbar.php'; ?>

    <div class="container-fluid px-0 mt-5">
        <div class="master-card">
            <div class="master-header">
                <div class="master-title">
                    <div class="master-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div>
                        <h4>Master Customer</h4>
                        <p>Kelola data master customer</p>
                    </div>
                </div>
            </div>
            <div class="p-4 text-center text-muted">
                <i class="fas fa-users fa-3x mb-3 text-secondary"></i>
                <p class="mb-0">Halaman Master Customer</p>
            </div>
        </div>
    </div>
</main>

</body>
</html>