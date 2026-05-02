<?php
    include '../../../sessions/session.php';

    $q = mysqli_query($conn,"
    SELECT r.*, p.name, p.code
    FROM stock_requests r
    JOIN products p ON p.id = r.product_id
    ORDER BY r.id DESC
    LIMIT 20
    ");
    ?>

    <?php if(mysqli_num_rows($q)==0): ?>

    <div class="empty-state">
        <i class="fas fa-clock fa-2x mb-2"></i><br>
        Belum ada history
    </div>

    <?php else: ?>

    <table id="requestHistory" class="table table-hover align-middle">

    <thead>
    <tr style="font-size:13px;color:#64748b;">
        <th>Produk</th>
        <th class="text-center">Qty</th>
        <th class="text-center">Status</th>
        <th class="text-center">Tanggal</th>
    </tr>
    </thead>

    <tbody>

    <?php while($d=mysqli_fetch_assoc($q)): ?>

    <tr>

    <td>
        <div class="product-name"><?= htmlspecialchars($d['name']) ?></div>
        <div class="product-code"><?= htmlspecialchars($d['code']) ?></div>
    </td>

    <td class="text-center">
        <span class="badge-soft">
            <i class="fas fa-cubes me-1"></i>
            <?= $d['qty'] ?>
        </span>
    </td>

    <td class="text-center">

    <?php if($d['status']=='approved'): ?>
        <span class="badge bg-success">
            <i class="fas fa-check me-1"></i> Approved
        </span>
    <?php elseif($d['status']=='rejected'): ?>
        <span class="badge bg-danger">
            <i class="fas fa-times me-1"></i> Rejected
        </span>
    <?php else: ?>
        <span class="badge bg-secondary">
            <i class="fas fa-clock me-1"></i> Pending
        </span>
    <?php endif; ?>

    </td>

    <td class="text-center">
        <i class="far fa-calendar-alt me-1"></i>
        <?= date('d M Y', strtotime($d['created_at'])) ?>
    </td>

    </tr>

    <?php endwhile; ?>

    </tbody>
    </table>

<?php endif; ?>