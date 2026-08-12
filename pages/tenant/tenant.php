<?php
include '../../sessions/session.php';
$query = mysqli_query($conn, 
            "SELECT * FROM tenants WHERE deleted_at IS NULL ORDER BY tenant_name ASC"
        );
?>

<link rel="stylesheet" href="/qieos/css/pages/tenant.css">

<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- Primary Meta Tags -->
    <title>Daftar Tenant - Qieos</title>

    <?php include '../../script/headscript.php'; ?>
</head>

<body>
    <?php include '../components/sidebar.php'; ?>

    <main class="content" style="height:100vh;overflow:auto;">
        <?php include '../components/navbar.php'; ?>

        <div class="container-fluid px-0 mt-5 mb-5">

            <div class="catalog-toolbar mb-5">

                <div class="search-modern">

                    <div class="search-icon">
                        <i class="fas fa-search"></i>
                    </div>

                    <input
                        type="text"
                        id="search"
                        placeholder="Cari tenant...">
                </div>
            </div>

            <div id="product-list" class="product-grid">

                <?php $index = 0; ?>
                <?php while ($row = mysqli_fetch_assoc($query)):
                    $tgl = strtotime($row['registration_date']);

                    $tanggal = date('d', $tgl);
                    $bulan = [
                        1 => 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
                        'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'
                    ];
                    $bulanText = $bulan[(int)date('n', $tgl)];
                    $tahun = date('Y', $tgl);

                    
                    $search = strtolower(
                        $row['tenant_name'].' '.
                        $row['tenant_owner'].' '.
                        $tanggal.' '.
                        $bulanText.' '.
                        $tahun.' '.
                        date('Y-m-d', $tgl)
                    );
                ?>

                <div class="product-item" data-search="<?php echo htmlspecialchars($search); ?>">

                    <div class="product-card">

                        <div class="product-image-wrap">
                            <img src="../../assets/img/tenant-img.jpg"
                                class="product-img">
                        </div>

                        <div class="product-content">

                            <div class="product-meta">
                                <div class="category-pill">
                                    <i class="fas fa-user"></i>
                                    <?php echo ucfirst($row['tenant_owner']); ?>
                                </div>
                            </div>

                            <h4 class="product-title">
                                <?php echo ucwords(strtolower($row['tenant_name'])); ?>
                            </h4>

                            <p class="product-desc mb-4">
                                <i class="fas fa-calendar text-success"></i>&nbsp;
                                <?php
                                    echo $tanggal . ' ' . $bulanText . ' ' . $tahun;
                                ?>
                            </p>

                            <a href="tenant-detail.php?id=<?php echo $row['id']; ?>"
                                class="btn-detail">
                                <i></i>
                                <span>Detail Tenant &nbsp;&nbsp;<i class="fas fa-arrow-right"></i></span>
                                <i></i>
                            </a>
                        </div>
                    </div>
                </div>

                <?php endwhile; ?>

                <div id="empty-search" class="empty-search" style="display:none;">
                    <div class="empty-icon">
                        <i class="fas fa-search"></i>
                    </div>

                    <h5>Tenant Tidak Ditemukan</h5>

                    <p>
                        Tidak ada tenant yang cocok dengan pencarian Anda.
                        Coba gunakan kata kunci lain atau ubah filter.
                    </p>
                </div>
            </div>
        </div>
    </main>

    <?php include '../../script/footscript.php'; ?>

    <script>
        const searchInput = document.getElementById('search');
        const items = document.querySelectorAll('.product-item');
        const empty = document.getElementById('empty-search');
        const productList = document.getElementById('product-list');

        searchInput.addEventListener('input', function () {

            const keyword = this.value.trim().toLowerCase();
            let found = false;

            items.forEach(item => {

                const text = item.dataset.search;

                if (text.includes(keyword)) {
                    item.style.display = '';
                    found = true;
                } else {
                    item.style.display = 'none';
                }

            });

            if (found) {
                empty.style.display = 'none';
                productList.classList.remove('empty-mode');
            } else {
                empty.style.display = 'flex';
                productList.classList.add('empty-mode');
            }
        });
    </script>

</body>

</html>