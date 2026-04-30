<?php
include '../../sessions/session.php';

$q = mysqli_query($conn, "
    SELECT 
        p.name,
        COALESCE(SUM(pi.remaining_qty),0) as stock,
        GROUP_CONCAT(DISTINCT pi.unit) as units
    FROM products p
    LEFT JOIN purchase_items pi ON pi.product_id=p.id
    GROUP BY p.id
");


?>

<table id="stockTable" class="table align-middle">
    <thead>
        <tr style="font-size:13px;color:#64748b;">
            <th>Produk</th>
            <th class="text-center">Stok</th>
            <th class="text-center">Satuan</th>
        </tr>
    </thead>
    <tbody>
    <?php while($d=mysqli_fetch_assoc($q)): ?>
        <tr>
            <td>
                <div class="fw-semibold"><?= $d['name'] ?></div>
                <small class="text-muted">Gudang Stok</small>
            </td>

            <td class="text-center">
                <span class="badge-soft"><?= $d['stock'] ?></span>
            </td>

            <td class="text-center">
                <span><?= $d['units'] ?></span>
            </td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>