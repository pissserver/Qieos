<?php
include '../../sessions/session.php';

$q = mysqli_query($conn,"
SELECT 
    *
FROM products
WHERE category = 'additional'
ORDER BY name ASC;
");
?>

<style>
    /* DATATABLE TOP */

    #stockTable{
        border-collapse:separate;
        border-spacing:0 14px;
    }

    #stockTable thead th{
        font-size:12px;
        color:#64748b;
        font-weight:700;
        border:none !important;
        text-transform:uppercase;
    }

    /* ROW CARD */
    .stock-row{
        background:#fff;
        border-radius:16px;
        box-shadow:0 6px 18px rgba(15,23,42,.05);
        transition:.25s;
    }

    .stock-row:hover{
        transform:translateY(-3px);
        box-shadow:0 12px 24px rgba(15,23,42,.10);
    }

    .stock-row td:first-child{
        border-radius:14px 0 0 14px;
    }   

    .stock-row td:last-child{
        border-radius:0 14px 14px 0;
    }

    #stockTable tbody td{
        padding:20px 18px;
        border:none !important;
        vertical-align:middle;
    }

    /* PRODUCT */
    .stock-product{
        display:flex;
        align-items:center;
        gap:14px;
    }

    .product-icon{
        width:48px;
        height:48px;
        border-radius:14px;
        background:linear-gradient(135deg,#334155,#0f172a);
        display:flex;
        align-items:center;
        justify-content:center;
        color:#fff;
        font-size:18px;
    }

    /* BADGES */
    .category-badge{
        display:inline-flex;
        align-items:center;
        gap:8px;
        background:#eef2ff;
        color:#4338ca;
        padding:8px 14px;
        border-radius:10px;
        font-weight:600;
    }

    .stock-badge{
        display:inline-flex;
        align-items:center;
        gap:8px;
        background:#e2e8f0;
        color:#0f172a;
        padding:8px 14px;
        border-radius:10px;
        font-weight:700;
    }

    .stock-success{
        background:#dcfce7 !important;
        color:#166534 !important;
        border:1px solid #86efac;
    }

    /* ACTION */
    .action-btn{
        width:38px;
        height:38px;
        border:none;
        border-radius:10px;
        margin:0 4px;
        color:#fff;
        transition:.25s;
    }

    .btn-edit{
        background:#f59e0b;
    }

    .btn-delete{
        background:#ef4444;
    }
</style>

<table id="stockTable" class="table table-hover align-middle">
<thead>
<tr>
    <th>PRODUK</th>
    <th class="text-center">KATEGORI</th>
    <th class="text-center">HARGA JUAL</th>
    <th class="text-center">AKSI</th>
</tr>
</thead>

<tbody>
<?php while($d=mysqli_fetch_assoc($q)): ?>
<tr class="stock-row">

    <!-- PRODUK -->
    <td>
        <div class="stock-product">
            <div class="product-icon">
                <i class="fas fa-box-open"></i>
            </div>

            <div>
                <div class="fw-bold"><?= $d['name'] ?></div>
                <small class="text-muted">
                    <i class="fas fa-tags me-1"></i>Produk Tambahan
                </small>
            </div>
        </div>
    </td>

    <!-- KATEGORI -->
    <td class="text-center">
        <span class="category-badge">
            <i class="fas fa-tags"></i>
            <?= ucfirst($d['category']) ?>
        </span>
    </td>

    <td class="text-center">
        <span class="stock-badge stock-success">
            <i class="fas fa-money-bill-wave"></i>
            Rp <?= number_format($d['sell_price'],0,',','.') ?>
        </span>
    </td>

    <td class="text-center">
        <button class="action-btn btn-edit editAdditionalBtn" data-id="<?= $d['id'] ?>">
            <i class="fas fa-edit"></i>
        </button>

        <button class="action-btn btn-delete deleteAdditionalBtn"
            data-id="<?= $d['id'] ?>"
            data-name="<?= $d['name'] ?>">
                <i class="fas fa-trash"></i>
        </button>
    </td>
</tr>
<?php endwhile; ?>
</tbody>
</table>
