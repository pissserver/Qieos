<?php

include '../../../sessions/session.php';

require '../../../vendor/phpoffice/phpexcel/Classes/PHPExcel.php';
require '../../../vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php';

$tab        = isset($_GET['tab']) ? $_GET['tab'] : 'all';
$first_date = isset($_GET['first_date']) ? $_GET['first_date'] : '';
$last_date  = isset($_GET['last_date']) ? $_GET['last_date'] : '';
$product_id = isset($_GET['product_id']) ? (int) $_GET['product_id'] : 0;
$category   = isset($_GET['category']) ? $_GET['category'] : '';
$cashier_id = isset($_GET['cashier_id']) ? (int) $_GET['cashier_id'] : 0;
$limit      = isset($_GET['limit']) ? (int) $_GET['limit'] : 10;

$escFirst = mysqli_real_escape_string($conn, $first_date);
$escLast  = mysqli_real_escape_string($conn, $last_date);

$tabLabels = [
    'summary'  => 'RINGKASAN KEUANGAN',
    'omzet'    => 'LAPORAN OMZET HARIAN',
    'expense'  => 'LAPORAN PENGELUARAN',
    'profit'   => 'LAPORAN LABA & RUGI',
    'margin'   => 'LAPORAN MARGIN PRODUK',
    'all'      => 'LAPORAN SEMUA TRANSAKSI',
    'product'  => 'LAPORAN PENJUALAN PER PRODUK',
    'category' => 'LAPORAN PENJUALAN PER KATEGORI',
    'cashier'  => 'LAPORAN PENJUALAN PER KASIR',
    'best'     => 'LAPORAN PRODUK TERLARIS'
];

$tabTitles = [
    'summary'  => 'Ringkasan Keuangan',
    'omzet'    => 'Laporan Omzet Harian',
    'expense'  => 'Laporan Pengeluaran',
    'profit'   => 'Laporan Laba & Rugi',
    'margin'   => 'Laporan Margin Produk',
    'all'      => 'Laporan Semua Transaksi',
    'product'  => 'Laporan Penjualan Per Produk',
    'category' => 'Laporan Penjualan Per Kategori',
    'cashier'  => 'Laporan Penjualan Per Kasir',
    'best'     => 'Laporan Produk Terlaris'
];

$title  = isset($tabLabels[$tab]) ? $tabLabels[$tab] : 'LAPORAN PENJUALAN';
$title2 = isset($tabTitles[$tab]) ? $tabTitles[$tab] : 'Laporan Penjualan';

$where = "DATE(tanggal) BETWEEN '$escFirst' AND '$escLast'";

$rows  = [];
$total = 0;
$extra = [];

switch ($tab) {

    case 'summary':
        $omzet = (float) mysqli_fetch_assoc(mysqli_query($conn, "SELECT COALESCE(SUM(total),0) AS v FROM orders WHERE status_payment='paid' AND $where"))['v'];
        $expense = (float) mysqli_fetch_assoc(mysqli_query($conn, "SELECT COALESCE(SUM(lpi.price),0) AS v FROM list_purchase_items lpi JOIN list_purchases lp ON lpi.list_purchase_id=lp.id WHERE lp.deleted_at IS NULL AND DATE(lp.date_list) BETWEEN '$escFirst' AND '$escLast'"))['v'];
        $orderCount = (int) mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS v FROM orders WHERE status_payment='paid' AND $where"))['v'];
        $profit = $omzet - $expense;
        $total = $profit;
        $extra = compact('omzet', 'expense', 'orderCount', 'profit');
        break;

    case 'omzet':
        $q = mysqli_query($conn, "SELECT DATE(tanggal) AS dt, COUNT(*) AS total_order, SUM(CASE WHEN status_payment='paid' THEN 1 ELSE 0 END) AS paid_count, SUM(CASE WHEN status_payment='waiting' THEN 1 ELSE 0 END) AS waiting_count, SUM(CASE WHEN status_payment='paid' THEN total ELSE 0 END) AS omzet FROM orders WHERE $where GROUP BY DATE(tanggal) ORDER BY dt DESC");
        if ($q) while ($r = mysqli_fetch_assoc($q)) { $rows[] = $r; $total += (float) $r['omzet']; }
        break;

    case 'expense':
        $q = mysqli_query($conn, "SELECT lp.id, lp.date_list, COUNT(lpi.id) AS total_items, COALESCE(SUM(lpi.price),0) AS total_price FROM list_purchases lp LEFT JOIN list_purchase_items lpi ON lp.id=lpi.list_purchase_id WHERE lp.deleted_at IS NULL AND DATE(lp.date_list) BETWEEN '$escFirst' AND '$escLast' GROUP BY lp.id, lp.date_list ORDER BY lp.date_list DESC, lp.id DESC");
        if ($q) while ($r = mysqli_fetch_assoc($q)) { $rows[] = $r; $total += (float) $r['total_price']; }
        break;

    case 'profit':
        $q = mysqli_query($conn, "SELECT d.dt, COALESCE(o.omzet,0) AS omzet, COALESCE(e.expense,0) AS expense FROM (SELECT DATE(tanggal) AS dt FROM orders WHERE $where UNION SELECT DATE(date_list) AS dt FROM list_purchases WHERE deleted_at IS NULL AND DATE(date_list) BETWEEN '$escFirst' AND '$escLast') d LEFT JOIN (SELECT DATE(tanggal) AS dt, COALESCE(SUM(total),0) AS omzet FROM orders WHERE status_payment='paid' AND $where GROUP BY DATE(tanggal)) o ON o.dt=d.dt LEFT JOIN (SELECT DATE(lp.date_list) AS dt, COALESCE(SUM(lpi.price),0) AS expense FROM list_purchases lp JOIN list_purchase_items lpi ON lp.id=lpi.list_purchase_id WHERE lp.deleted_at IS NULL AND DATE(lp.date_list) BETWEEN '$escFirst' AND '$escLast' GROUP BY DATE(lp.date_list)) e ON e.dt=d.dt ORDER BY d.dt DESC");
        if ($q) while ($r = mysqli_fetch_assoc($q)) { $r['profit'] = (float)$r['omzet'] - (float)$r['expense']; $rows[] = $r; $total += $r['profit']; }
        break;

    case 'margin':
        $q = mysqli_query($conn, "SELECT p.name, COALESCE(SUM(od.qty),0) AS qty_sold, COALESCE(AVG(od.price),0) AS sell_price, COALESCE((SELECT AVG(pi.buy_price) FROM purchase_items pi WHERE pi.product_id=p.id AND pi.deleted_at IS NULL AND pi.buy_price>0),0) AS buy_price, COALESCE(SUM(od.subtotal),0) AS revenue FROM order_details od JOIN orders o ON od.order_id=o.id JOIN products p ON od.product_id=p.id WHERE o.status_payment='paid' AND $where GROUP BY p.id, p.name ORDER BY revenue DESC, p.name ASC");
        if ($q) while ($r = mysqli_fetch_assoc($q)) { $qty=(int)$r['qty_sold']; $sell=(float)$r['sell_price']; $buy=(float)$r['buy_price']; $r['margin_pct']=$sell>0?(($sell-$buy)/$sell)*100:0; $r['profit']=($sell-$buy)*$qty; $rows[]=$r; $total+=$r['profit']; }
        break;

    case 'all':
        $q = mysqli_query($conn, "SELECT o.code, o.tanggal, o.total, o.status_payment, COALESCE(NULLIF(u.fullname,''),u.username,'-') AS cashier_name FROM orders o LEFT JOIN users u ON o.staff_id=u.id WHERE $where ORDER BY o.tanggal DESC, o.id DESC");
        if ($q) while ($r = mysqli_fetch_assoc($q)) { if ($r['status_payment']==='paid') $total+=(float)$r['total']; $rows[]=$r; }
        break;

    case 'product':
        $q = mysqli_query($conn, "SELECT o.code, o.tanggal, od.qty, od.price, od.subtotal FROM order_details od JOIN orders o ON od.order_id=o.id WHERE od.product_id=$product_id AND o.status_payment!='cancelled' AND $where ORDER BY o.tanggal DESC, o.id DESC");
        if ($q) while ($r = mysqli_fetch_assoc($q)) { $total+=(float)$r['subtotal']; $rows[]=$r; }
        break;

    case 'category':
        $escCat = mysqli_real_escape_string($conn, $category);
        $q = mysqli_query($conn, "SELECT p.name, p.code, COALESCE(SUM(od.qty),0) AS qty_sold, COALESCE(SUM(od.subtotal),0) AS omzet FROM order_details od JOIN orders o ON od.order_id=o.id JOIN products p ON od.product_id=p.id WHERE p.category='$escCat' AND o.status_payment='paid' AND $where GROUP BY p.id, p.name, p.code ORDER BY omzet DESC, p.name ASC");
        if ($q) while ($r = mysqli_fetch_assoc($q)) { $total+=(float)$r['omzet']; $rows[]=$r; }
        break;

    case 'cashier':
        $q = mysqli_query($conn, "SELECT o.code, o.tanggal, o.total, o.status_payment FROM orders o WHERE o.staff_id=$cashier_id AND $where ORDER BY o.tanggal DESC, o.id DESC");
        if ($q) while ($r = mysqli_fetch_assoc($q)) { if ($r['status_payment']==='paid') $total+=(float)$r['total']; $rows[]=$r; }
        break;

    case 'best':
        if ($limit <= 0) $limit = 10;
        $q = mysqli_query($conn, "SELECT p.name, p.category, COALESCE(SUM(od.qty),0) AS qty_sold, COALESCE(SUM(od.subtotal),0) AS omzet FROM order_details od JOIN orders o ON od.order_id=o.id JOIN products p ON od.product_id=p.id WHERE o.status_payment='paid' AND $where GROUP BY p.id, p.name, p.category ORDER BY qty_sold DESC, omzet DESC LIMIT $limit");
        if ($q) while ($r = mysqli_fetch_assoc($q)) { $total+=(int)$r['qty_sold']; $rows[]=$r; }
        break;
}

$count = ($tab === 'summary') ? 3 : count($rows);
$endCol = chr(ord('A') + 5);

// ============================
// CREATE EXCEL
// ============================
$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("Qieos")->setTitle($title2);

$sheet = $objPHPExcel->setActiveSheetIndex(0);
$sheet->setTitle("Laporan");

// HEADER
$sheet->mergeCells('A1:F1');
$sheet->setCellValue('A1', 'PT. SELARASGRIYA SARANA UTAMA');

$sheet->mergeCells('A2:F2');
$sheet->setCellValue('A2', 'Pasar Induk Surabaya Sidotopo');

$sheet->mergeCells('A4:F4');
$sheet->setCellValue('A4', $title);

$periode = '';
if (!empty($first_date) && !empty($last_date)) {
    $periode = 'Periode : ' . date('d M Y', strtotime($first_date)) . ' s/d ' . date('d M Y', strtotime($last_date));
}
$sheet->mergeCells('A5:F5');
$sheet->setCellValue('A5', $periode);

// TABLE HEADER
$row = 7;
$headers = [
    'summary'  => ['No', 'Komponen', 'Keterangan', 'Jumlah', '', ''],
    'omzet'    => ['No', 'Tanggal', 'Pesanan', 'Terbayar', 'Waiting', 'Omzet'],
    'expense'  => ['No', 'Tanggal', 'Form Belanja', 'Total Item', 'Total Belanja', ''],
    'profit'   => ['No', 'Tanggal', 'Omzet', 'Pengeluaran', 'Laba / Rugi', 'Status'],
    'margin'   => ['No', 'Produk', 'Qty Terjual', 'Harga Beli', 'Harga Jual', 'Keuntungan'],
    'all'      => ['No', 'Kode Pesanan', 'Tanggal', 'Kasir', 'Total', 'Status'],
    'product'  => ['No', 'Tanggal', 'Kode Pesanan', 'Qty', 'Harga', 'Subtotal'],
    'category' => ['No', 'Produk', 'Kode', 'Qty Terjual', 'Omzet', ''],
    'cashier'  => ['No', 'Kode Pesanan', 'Tanggal', 'Total', 'Status', ''],
    'best'     => ['Peringkat', 'Produk', 'Kategori', 'Qty Terjual', 'Omzet', '']
];

$hdrs = isset($headers[$tab]) ? $headers[$tab] : $headers['all'];
$lastCol = chr(ord('A') + count($hdrs) - 1);
$colLetter = 'A';
foreach ($hdrs as $header) {
    if (!empty($header)) {
        $sheet->setCellValue($colLetter . $row, $header);
    }
    $colLetter++;
}

$sheet->getStyle("A7:{$lastCol}7")->applyFromArray([
    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
    'fill' => ['type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => ['rgb' => '1E1B4B']],
    'alignment' => ['horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER],
    'borders' => ['allborders' => ['style' => PHPExcel_Style_Border::BORDER_THIN]]
]);

// DATA
$row = 8;
$no = 1;

for ($idx = 0; $idx < $count; $idx++) {

    $r = isset($rows[$idx]) ? $rows[$idx] : null;

    switch ($tab) {

        case 'summary':
            $summaryData = [
                ['Omzet Penjualan', $extra['orderCount'] . ' pesanan terbayar', $extra['omzet']],
                ['Pengeluaran Belanja', 'Dari daftar belanja stok', $extra['expense']],
                ['Laba Bersih', 'Omzet dikurangi pengeluaran', $extra['profit']]
            ];
            if (isset($summaryData[$no - 1])) {
                $sheet->setCellValue("A$row", $no);
                $sheet->setCellValue("B$row", $summaryData[$no - 1][0]);
                $sheet->setCellValue("C$row", $summaryData[$no - 1][1]);
                $sheet->setCellValue("D$row", $summaryData[$no - 1][2]);
            }
            break;

        case 'omzet':
            $sheet->setCellValue("A$row", $no);
            $sheet->setCellValue("B$row", date('d M Y', strtotime($r['dt'])));
            $sheet->setCellValue("C$row", (int) $r['total_order']);
            $sheet->setCellValue("D$row", (int) $r['paid_count']);
            $sheet->setCellValue("E$row", (int) $r['waiting_count']);
            $sheet->setCellValue("F$row", (float) $r['omzet']);
            break;

        case 'expense':
            $sheet->setCellValue("A$row", $no);
            $sheet->setCellValue("B$row", date('d M Y', strtotime($r['date_list'])));
            $sheet->setCellValue("C$row", 'BELANJA-' . str_pad($r['id'], 7, '0', STR_PAD_LEFT));
            $sheet->setCellValue("D$row", (int) $r['total_items']);
            $sheet->setCellValue("E$row", (float) $r['total_price']);
            break;

        case 'profit':
            $sheet->setCellValue("A$row", $no);
            $sheet->setCellValue("B$row", date('d M Y', strtotime($r['dt'])));
            $sheet->setCellValue("C$row", (float) $r['omzet']);
            $sheet->setCellValue("D$row", (float) $r['expense']);
            $sheet->setCellValue("E$row", (float) $r['profit']);
            $sheet->setCellValue("F$row", $r['profit'] >= 0 ? 'Untung' : 'Rugi');
            break;

        case 'margin':
            $qty = (int) $r['qty_sold'];
            $sell = (float) $r['sell_price'];
            $buy = (float) $r['buy_price'];
            $profit = ($sell - $buy) * $qty;
            $sheet->setCellValue("A$row", $no);
            $sheet->setCellValue("B$row", $r['name']);
            $sheet->setCellValue("C$row", $qty);
            $sheet->setCellValue("D$row", $buy);
            $sheet->setCellValue("E$row", $sell);
            $sheet->setCellValue("F$row", $profit);
            break;

        case 'all':
            $sheet->setCellValue("A$row", $no);
            $sheet->setCellValue("B$row", $r['code']);
            $sheet->setCellValue("C$row", date('d M Y', strtotime($r['tanggal'])));
            $sheet->setCellValue("D$row", $r['cashier_name']);
            $sheet->setCellValue("E$row", (float) $r['total']);
            $sheet->setCellValue("F$row", $r['status_payment'] === 'paid' ? 'Terbayar' : ucfirst($r['status_payment']));
            break;

        case 'product':
            $sheet->setCellValue("A$row", $no);
            $sheet->setCellValue("B$row", date('d M Y', strtotime($r['tanggal'])));
            $sheet->setCellValue("C$row", $r['code']);
            $sheet->setCellValue("D$row", (int) $r['qty']);
            $sheet->setCellValue("E$row", (float) $r['price']);
            $sheet->setCellValue("F$row", (float) $r['subtotal']);
            break;

        case 'category':
            $sheet->setCellValue("A$row", $no);
            $sheet->setCellValue("B$row", $r['name']);
            $sheet->setCellValue("C$row", $r['code']);
            $sheet->setCellValue("D$row", (int) $r['qty_sold']);
            $sheet->setCellValue("E$row", (float) $r['omzet']);
            break;

        case 'cashier':
            $sheet->setCellValue("A$row", $no);
            $sheet->setCellValue("B$row", $r['code']);
            $sheet->setCellValue("C$row", date('d M Y', strtotime($r['tanggal'])));
            $sheet->setCellValue("D$row", (float) $r['total']);
            $sheet->setCellValue("E$row", $r['status_payment'] === 'paid' ? 'Terbayar' : ucfirst($r['status_payment']));
            break;

        case 'best':
            $sheet->setCellValue("A$row", $no);
            $sheet->setCellValue("B$row", $r['name']);
            $sheet->setCellValue("C$row", ucfirst($r['category']));
            $sheet->setCellValue("D$row", (int) $r['qty_sold']);
            $sheet->setCellValue("E$row", (float) $r['omzet']);
            break;
    }

    $row++;
    $no++;
}

// TOTAL
$totalLabels = [
    'summary'  => 'LABA BERSIH',
    'omzet'    => 'TOTAL OMZET',
    'expense'  => 'TOTAL PENGELUARAN',
    'profit'   => 'TOTAL LABA / RUGI',
    'margin'   => 'TOTAL KEUNTUNGAN',
    'all'      => 'TOTAL OMZET',
    'product'  => 'TOTAL PENJUALAN',
    'category' => 'TOTAL OMZET',
    'cashier'  => 'TOTAL OMZET',
    'best'     => 'TOTAL QTY TERJUAL'
];
$totalLabel = isset($totalLabels[$tab]) ? $totalLabels[$tab] : 'TOTAL';

$totalColMap = [
    'summary'  => 'D',
    'omzet'    => 'F',
    'expense'  => 'E',
    'profit'   => 'E',
    'margin'   => 'F',
    'all'      => 'E',
    'product'  => 'F',
    'category' => 'E',
    'cashier'  => 'E',
    'best'     => 'E'
];
$totalCol = isset($totalColMap[$tab]) ? $totalColMap[$tab] : 'D';
$totalColIdx = ord($totalCol) - ord('A');
$mergeEndCol = chr(ord('A') + $totalColIdx - 1);

$sheet->mergeCells("A$row:{$mergeEndCol}{$row}");
$sheet->setCellValue("A$row", $totalLabel);
$sheet->getStyle("A$row")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

if ($tab !== 'best') {
    $firstDataRow = 8;
    $lastDataRow = $row - 1;
    $sheet->setCellValue($totalCol . $row, "=SUM($totalCol$firstDataRow:$totalCol$lastDataRow)");
} else {
    $sheet->setCellValue($totalCol . $row, $total);
}

$sheet->getStyle("A$row:{$mergeEndCol}{$row}")->applyFromArray([
    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
    'fill' => ['type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => ['rgb' => '1E1B4B']],
    'borders' => [
        'top' => ['style' => PHPExcel_Style_Border::BORDER_THIN],
        'bottom' => ['style' => PHPExcel_Style_Border::BORDER_THIN],
        'left' => ['style' => PHPExcel_Style_Border::BORDER_THIN],
        'right' => ['style' => PHPExcel_Style_Border::BORDER_THIN]
    ]
]);

$sheet->getStyle($totalCol . $row)->applyFromArray([
    'font' => ['bold' => true, 'color' => ['rgb' => 'C4A35A']],
    'fill' => ['type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => ['rgb' => '1E1B4B']],
    'numberFormat' => ['formatCode' => ($tab !== 'best') ? '"Rp " #,##0' : '#,##0'],
    'borders' => [
        'top' => ['style' => PHPExcel_Style_Border::BORDER_THIN],
        'bottom' => ['style' => PHPExcel_Style_Border::BORDER_THIN],
        'left' => ['style' => PHPExcel_Style_Border::BORDER_THIN],
        'right' => ['style' => PHPExcel_Style_Border::BORDER_THIN]
    ]
]);

// Format rupiah hanya pada kolom nominal uang
$rpColMap = [
    'summary'  => ['D'],
    'omzet'    => ['F'],
    'expense'  => ['E'],
    'profit'   => ['C', 'D', 'E'],
    'margin'   => ['D', 'E', 'F'],
    'all'      => ['D'],
    'product'  => ['E', 'F'],
    'category' => ['E'],
    'cashier'  => ['D'],
    'best'     => ['E']
];
$rpCols = isset($rpColMap[$tab]) ? $rpColMap[$tab] : ['D'];
foreach ($rpCols as $c) {
    $sheet->getStyle("{$c}8:{$c}" . ($row - 1))->getNumberFormat()->setFormatCode('"Rp " #,##0');
}

// Border semua tabel
$sheet->getStyle("A7:{$lastCol}" . ($row - 1))->applyFromArray([
    'borders' => ['allborders' => ['style' => PHPExcel_Style_Border::BORDER_THIN]]
]);

// Alignment
$sheet->getStyle("A7:{$lastCol}" . $row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$sheet->getStyle("A7:A$row")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

// Auto width
foreach (range('A', $lastCol) as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

// DOWNLOAD
if (ob_get_length()) {
    ob_end_clean();
}

$filename = $title2 . ' - ' . date('d M Y', strtotime($first_date)) . ' s.d. ' . date('d M Y', strtotime($last_date)) . '.xlsx';

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: max-age=0');
header('Pragma: public');

try {
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');
} catch (Exception $e) {
    error_log('[QIEOS Excel Error] ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine());
    header('Content-Type: text/html; charset=utf-8');
    echo '<h3>Error Generating Excel</h3>';
    echo '<pre>' . htmlspecialchars($e->getMessage()) . '</pre>';
    echo '<pre>' . htmlspecialchars($e->getTraceAsString()) . '</pre>';
    exit;
}

exit;
