<?php include '../../sessions/session.php'; ?>
<table class="table table-hover align-middle" id="stockTable">
    <thead>
        <tr style="font-size:13px;color:#64748b;">
            <th>Produk</th>
            <th class="text-center">Stok</th>
            <th class="text-center">Satuan</th>
            <th class="text-center">Status</th>
            <th class="text-center">Aksi</th>
        </tr>
    </thead>
    <tbody>

    <?php
    $q = mysqli_query($conn,"
    SELECT
        p.id,
        p.name,
        p.code,
        COALESCE(SUM(pi.remaining_qty),0) stock,
        GROUP_CONCAT(DISTINCT pi.unit) unit
    FROM products p
    LEFT JOIN purchase_items pi
        ON pi.product_id=p.id
        AND pi.deleted_at IS NULL
    WHERE p.category != 'additional'
    GROUP BY p.id
    ORDER BY p.name ASC
    ");
    while($d=mysqli_fetch_assoc($q)): ?>

    <?php
    $stock = (int)$d['stock'];

    $statusClass =
        $stock < 10
        ? 'stock-danger'
        : 'stock-success';
    ?>

    <tr class="stock-row"
        onclick="loadDetail(<?= $d['id'] ?>)">

        <td>
            <div class="product-wrap">

                <div class="product-icon">
                    <i class="fas fa-box-open"></i>
                </div>

                <div>
                    <div class="fw-bold">
                        <?= htmlspecialchars($d['name']) ?>
                    </div>

                    <small class="text-muted">
                        <?= htmlspecialchars($d['code']) ?>
                    </small>
                </div>

            </div>
        </td>

        <td class="text-center">

            <span class="stock-badge <?= $statusClass ?>">
                <i class="fas fa-cubes me-1"></i>
                <?= number_format($stock) ?>
            </span>

        </td>

        <td class="text-center">

            <span class="unit-badge">
                <i class="fas fa-balance-scale me-1"></i>
                <?= strtoupper($d['unit']) ?>
            </span>

        </td>

        <td class="text-center">
            <?php if($stock == 0): ?>

                <span class="stock-badge stock-empty">
                    <i class="fas fa-triangle-exclamation me-1"></i>
                    Habis
                </span>

            <?php elseif($stock <= 50): ?>

                <span class="stock-badge stock-danger">
                    <i class="fas fa-triangle-exclamation me-1"></i>
                    Menipis
                </span>

            <?php else: ?>

                <span class="stock-badge stock-success">
                    <i class="fas fa-check-circle me-1"></i>
                    Aman
                </span>

            <?php endif; ?>
        </td>

        <td class="text-center">
            <button class="action-btn btn-edit editStockBtn" data-id="<?= $d['id'] ?>">
                <i class="fas fa-edit"></i>
            </button>
        </td>
    </tr>

    <?php endwhile; ?>

    </tbody>
</table>
