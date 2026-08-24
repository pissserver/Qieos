<?php

include '../../../sessions/session.php';
include 'report-helper.php';

list($first, $last) = report_dates($conn);

$query = mysqli_query($conn, "
    SELECT
        lp.id,
        lp.date_list,
        COUNT(lpi.id) AS total_items,
        COALESCE(SUM(lpi.price), 0) AS total_price
    FROM list_purchases lp
    LEFT JOIN list_purchase_items lpi ON lp.id = lpi.list_purchase_id
    WHERE lp.deleted_at IS NULL
      AND DATE(lp.date_list) BETWEEN '$first' AND '$last'
    GROUP BY lp.id, lp.date_list
    ORDER BY lp.date_list DESC, lp.id DESC
");

$no = 1;
$total = 0;
$hasData = $query && mysqli_num_rows($query) > 0;

if ($hasData) {
    while ($row = mysqli_fetch_assoc($query)) {
        $total += (float) $row['total_price'];
        $form = 'BELANJA-' . str_pad($row['id'], 7, '0', STR_PAD_LEFT);
        ?>
        <tr>
            <td class="text-center"><?= $no++ ?></td>
            <td class="text-center"><?= report_date_id($row['date_list']) ?></td>
            <td class="text-center fw-bold"><?= htmlspecialchars($form) ?></td>
            <td class="text-center"><?= (int) $row['total_items'] ?></td>
            <td class="text-center fw-semibold"><?= report_rp($row['total_price']) ?></td>
        </tr>
        <?php
    }
} else {
    report_empty(5, 'Tidak ada pengeluaran belanja pada periode ini.');
}

report_foot($total);
