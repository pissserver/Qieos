<?php
include '../../sessions/session.php';

$q = mysqli_query($conn,"
SELECT r.*, p.name, p.code
FROM stock_requests r
JOIN products p ON p.id = r.product_id
WHERE r.status='pending'
ORDER BY r.id DESC
");
?>

<?php if(mysqli_num_rows($q)==0): ?>

<div class="empty-state">
    <i class="fas fa-inbox fa-2x mb-2"></i><br>
    Tidak ada request saat ini
</div>

<?php else: ?>

<table class="table table-hover align-middle">

<thead>
<tr style="font-size:13px;color:#64748b;">
    <th>Produk</th>
    <th class="text-center">Qty</th>
    <th class="text-center">Tanggal</th>
    <th class="text-center">Aksi</th>
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
    <i class="far fa-calendar-alt me-1"></i>
    <?= date('d M Y', strtotime($d['created_at'])) ?>
</td>

<td class="text-center">

    <button onclick="approve(<?= $d['id'] ?>)" 
        class="btn btn-sm btn-action btn-acc me-1">
        <i class="fas fa-check"></i>
    </button>

    <button onclick="reject(<?= $d['id'] ?>)" 
        class="btn btn-sm btn-action btn-reject">
        <i class="fas fa-times"></i>
    </button>

</td>

</tr>
<?php endwhile; ?>

</tbody>
</table>

<?php endif; ?>