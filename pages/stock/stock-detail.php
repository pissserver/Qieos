<?php
include '../../sessions/session.php';

$id = $_GET['id'];

$q = mysqli_query($conn,"
    SELECT qty, remaining_qty, date, unit, buy_price
    FROM purchase_items
    WHERE product_id=$id
    ORDER BY date ASC
");
?>

<table class="table table-sm">
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Qty Awal</th>
            <th>Sisa</th>
            <th>Harga</th>
        </tr>
    </thead>
    <tbody>
    <?php while($d=mysqli_fetch_assoc($q)): ?>
        <tr>
            <td>
                <?php
                $bulan = [
                    1 => 'Januari','Februari','Maret','April','Mei','Juni',
                    'Juli','Agustus','September','Oktober','November','Desember'
                ];
                $tgl = strtotime($d['date']);
                echo date('d', $tgl) . ' ' . $bulan[(int)date('m', $tgl)] . ' ' . date('Y', $tgl);
                ?>
            </td>

            <td><?= $d['qty'] ?> <?= $d['unit'] ?></td>

            <td><?= $d['remaining_qty'] ?></td>

            <td>
                Rp <?= number_format($d['buy_price'], 0, ',', '.') ?>
            </td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>