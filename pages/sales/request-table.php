<?php
include '../../sessions/session.php';

$q = mysqli_query($conn,"
SELECT r.*, p.name, p.code
FROM stock_requests r
JOIN products p ON p.id=r.product_id
ORDER BY r.id DESC
");
?>

<table class="table">
<thead>
<tr>
<th>Produk</th>
<th>Qty</th>
<th>Status</th>
</tr>
</thead>

<tbody>

<?php while($d=mysqli_fetch_assoc($q)): ?>
<tr>

<td>
<b><?= $d['name'] ?></b><br>
<small><?= $d['code'] ?></small>
</td>

<td><?= $d['qty'] ?></td>

<td>
<?php if($d['status']=='pending'): ?>
<span class="badge bg-warning">Pending</span>
<?php elseif($d['status']=='approved'): ?>
<span class="badge bg-success">Approved</span>
<?php else: ?>
<span class="badge bg-danger">Rejected</span>
<?php endif; ?>
</td>

</tr>
<?php endwhile; ?>

</tbody>
</table>