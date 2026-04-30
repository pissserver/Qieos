<?php
include '../../sessions/session.php';
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Stok Gudang - Qieos</title>
    <?php include '../../script/headscript.php'; ?>

    <style>
        :root {
            --primary: #4f46e5;
            --soft: #eef2ff;
            --border: #e2e8f0;
            --muted: #64748b;
        }

        .card-modern {
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        }

        .badge-soft {
            background: var(--soft);
            color: var(--primary);
            padding: 6px 10px;
            border-radius: 8px;
        }

        .status-low {
            background: #fee2e2;
            color: #dc2626;
            padding: 5px 8px;
            border-radius: 6px;
        }

        .status-ok {
            background: #dcfce7;
            color: #16a34a;
            padding: 5px 8px;
            border-radius: 6px;
        }

        .table-hover tbody tr:hover {
            background: #f8fafc;
            cursor: pointer;
        }
    </style>
</head>

<body>
<?php include '../../components/sidebar.php'; ?>
<main class="content">
<?php include '../../components/navbar.php'; ?>

<div class="container-fluid mt-4">

    <!-- HEADER -->
    <h4 class="mb-3">
        <i class="fas fa-warehouse text-primary me-2"></i>
        Stok Gudang
    </h4>

    <!-- SUMMARY -->
    <div class="row mb-4">

        <?php
        $total_produk = mysqli_num_rows(mysqli_query($conn,"SELECT id FROM products"));
        $total_stok = mysqli_fetch_assoc(mysqli_query($conn,"SELECT SUM(remaining_qty) as t FROM purchase_items"))['t'];
        $low_stock = mysqli_fetch_assoc(mysqli_query($conn,"
            SELECT COUNT(*) as c FROM (
                SELECT SUM(remaining_qty) as s FROM purchase_items GROUP BY product_id HAVING s < 10
            ) x
        "))['c'];
        ?>

        <div class="col-md-4">
            <div class="card card-modern p-3">
                <small class="text-muted">Total Produk</small>
                <h5><?= $total_produk ?></h5>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-modern p-3">
                <small class="text-muted">Total Stok</small>
                <h5><?= $total_stok !== null ? $total_stok : 0 ?></h5>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-modern p-3">
                <small class="text-muted">Stok Menipis</small>
                <h5 class="text-danger"><?= $low_stock !== null ? $low_stock : 0 ?></h5>
            </div>
        </div>

    </div>

    <!-- TABLE -->
    <div class="card card-modern p-3">
        <table class="table table-hover align-middle" id="stockTable">
            <thead>
                <tr style="font-size:13px;color:#64748b;">
                    <th>Produk</th>
                    <th class="text-center">Stok</th>
                    <th class="text-center">Satuan</th>
                    <th class="text-center">Status</th>
                </tr>
            </thead>
            <tbody>

            <?php
            $q = mysqli_query($conn,"
                SELECT 
                    p.id,
                    p.name,
                    p.code,
                    SUM(pi.remaining_qty) as stock,
                    GROUP_CONCAT(DISTINCT pi.unit) as unit
                FROM products p
                LEFT JOIN purchase_items pi ON pi.product_id = p.id
                GROUP BY p.id
                ORDER BY p.name ASC
            ");

            while($d = mysqli_fetch_assoc($q)):
                $stock = (int)$d['stock'];
                $status = ($stock < 10) ? "Low" : "Aman";
            ?>

            <tr onclick="loadDetail(<?= $d['id'] ?>)">
                <td>
                    <div class="fw-semibold"><?= htmlspecialchars($d['name']) ?></div>
                    <small class="text-muted">
                        Kode: <?= htmlspecialchars($d['code']) ?> • Klik untuk FIFO
                    </small>
                </td>

                <td class="text-center">
                    <span class="badge-soft"><?= $stock ?></span>
                </td>

                <td class="text-center">
                    <?= htmlspecialchars($d['unit']) ?>
                </td>

                <td class="text-center">
                    <span class="<?= ($status=='Low') ? 'status-low':'status-ok' ?>">
                        <?= $status ?>
                    </span>
                </td>
            </tr>

            <?php endwhile; ?>

            </tbody>
        </table>
    </div>

    <!-- DETAIL FIFO -->
    <div class="card card-modern p-3 mt-4 mb-5">
        <h6>Detail FIFO</h6>
        <div id="fifo-detail">
            <small class="text-muted">Klik produk untuk melihat layer FIFO</small>
        </div>
    </div>

</div>
</main>

<?php include '../../script/footscript.php'; ?>

<script>
function loadDetail(id){
    fetch('stock-detail.php?id='+id)
    .then(res=>res.text())
    .then(html=>{
        document.getElementById("fifo-detail").innerHTML = html;
    });
}

$(document).ready(function(){
    $('#stockTable').DataTable({
        pageLength: 5,
        responsive: true
    });
});
</script>

</body>
</html>