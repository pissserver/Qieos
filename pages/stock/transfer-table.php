<?php
include '../../sessions/session.php';

$q = mysqli_query($conn,"
SELECT
    r.*,
    p.name,
    p.code
FROM stock_requests r
JOIN products p
    ON p.id = r.product_id
WHERE r.status='pending'
ORDER BY r.id DESC
");
?>

<link rel="stylesheet" href="/qieos/css/pages/transfer-table.css">

<?php if(mysqli_num_rows($q)==0): ?>

<div class="empty-state">

    <i class="fas fa-inbox"></i>

    <h6 class="mb-1">
        Tidak Ada Request
    </h6>

    <small>
        Saat ini tidak ada permintaan transfer stok yang menunggu persetujuan.
    </small>

</div>

<?php else: ?>

<?php while($d=mysqli_fetch_assoc($q)): ?>

<div class="request-card">

    <div class="request-left">

        <div class="product-avatar">
            <i class="fas fa-box-open"></i>
        </div>

        <div>

            <div class="product-name">
                <?= htmlspecialchars($d['name']) ?>
            </div>

            <div class="product-code">
                <?= htmlspecialchars($d['code']) ?>
            </div>

            <div class="request-meta">

                <span class="qty-badge">
                    <i class="fas fa-cubes me-1"></i>
                    Qty Request :
                    <?= number_format($d['qty']) ?>
                </span>

                <span class="date-badge">
                    <i class="far fa-calendar-alt me-1"></i>
                    <?= date('d M Y H:i', strtotime($d['created_at'])) ?>
                </span>

            </div>

        </div>

    </div>

    <div class="request-action">

        <button
            onclick="approve(<?= $d['id'] ?>)"
            class="btn-approve">

            <i class="fas fa-check me-1"></i>
            Approve

        </button>

        <button
            onclick="reject(<?= $d['id'] ?>)"
            class="btn-reject-modern">

            <i class="fas fa-times me-1"></i>
            Reject

        </button>

    </div>

</div>

<?php endwhile; ?>

<?php endif; ?>