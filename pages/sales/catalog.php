<?php
include '../../sessions/session.php';
$query = mysqli_query($conn, 
            "SELECT p.*, COALESCE(SUM(ss.qty), 0) as stock FROM products p LEFT JOIN sales_stock ss ON p.id = ss.product_id
            WHERE p.catalog = 'active'
            GROUP BY p.id ORDER BY p.starred DESC, p.name ASC"
        );
?>

<link rel="stylesheet" href="/qieos/css/pages/catalog.css">

<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- Primary Meta Tags -->
    <title>Katalog Produk - Qieos</title>

    <?php include '../../script/headscript.php'; ?>
</head>

<body>
    <?php include '../components/sidebar.php'; ?>

    <main class="content">
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
                        placeholder="Cari produk..."
                        onkeyup="applyFilters()">

                </div>

                <div class="toolbar-actions">

                    <!-- FILTER KATEGORI -->
                    <div class="premium-filter">

                        <button class="toolbar-btn">
                            <i class="fas fa-layer-group"></i>
                        </button>

                        <select
                            id="category-filter"
                            class="hidden-select"
                            onchange="applyFilters()">

                            <option value="all">ðŸ“¦ Semua Kategori</option>
                            <option value="makanan">ðŸ” Makanan</option>
                            <option value="minuman">ðŸ¥¤ Minuman</option>
                            <option value="jajanan">ðŸª Jajanan</option>
                            <option value="pelengkap">ðŸ½ï¸ Pelengkap</option>
                            <option value="additional">âž• Tambahan</option>

                        </select>

                    </div>

                    <!-- SORT HARGA -->
                    <div class="premium-filter">

                        <button class="toolbar-btn">
                            <i class="fas fa-arrow-up-wide-short"></i>
                        </button>

                        <select
                            id="sort-filter"
                            class="hidden-select"
                            onchange="sortProduct(this.value)">

                            <option value="name">ðŸ”¤ Nama</option>
                            <option value="latest">âœ¨ Terbaru</option>
                            <option value="low">â¬‡ Harga Terendah</option>
                            <option value="high">â¬† Harga Tertinggi</option>

                        </select>

                    </div>

                </div>

            </div>

            <div id="product-list" class="product-grid">

                <?php $index = 0; ?>
                <?php while ($row = mysqli_fetch_assoc($query)): ?>

                <div class="product-item"
                    data-index="<?php echo $index++; ?>"
                    data-name="<?php echo strtolower($row['name']); ?>"
                    data-id="<?php echo $row['id']; ?>"
                    data-category="<?php echo $row['category']; ?>"
                    data-price="<?php echo $row['sell_price']; ?>"
                    data-star="<?php echo $row['starred']; ?>">

                    <div class="product-card">

                        <div class="product-image-wrap">

                            <img src="../../assets/img/products/<?php echo $row['photo']; ?>"
                                class="product-img">

                            <div class="stock-badge" id="stock-<?php echo $row['id']; ?>">
                                <i class="fas fa-cube"></i>
                                <?php echo $row['category'] !== 'additional' ? $row['stock'] : 'Tanpa' ; ?> Stok
                            </div>

                            <div class="price-floating">
                                Rp <?php echo number_format($row['sell_price'],0,',','.'); ?>
                            </div>

                        </div>

                        <div class="product-content">

                            <div class="product-meta">
                                <div class="category-pill">
                                    <i class="fas fa-tag"></i>
                                    <?php echo ucfirst($row['category']); ?>
                                </div>

                                <button
                                    class="star-btn <?= $row['starred'] ? 'active' : '' ?>"
                                    onclick="toggleStar(<?= $row['id'] ?>,this)">
                                    <i class="<?= $row['starred'] ? 'fas' : 'far' ?> fa-star"></i>
                                </button>
                            </div>

                            <h4 class="product-title">
                                <?php echo ucwords(strtolower($row['name'])); ?>
                            </h4>

                            <?php if($row['category'] !== 'additional'): ?>
                            <p class="product-desc">
                                <?php if($row['stock'] > 0): ?>
                                    <i class="fas fa-circle text-success"></i>
                                    Stok tersedia
                                <?php else: ?>
                                    <i class="fas fa-circle text-danger"></i>
                                    Stok habis
                                <?php endif; ?>
                            </p>

                            <div class="qty-box">

                                <?php if($row['stock'] > 0): ?>

                                    <div class="qty-control">

                                        <button class="qty-btn"
                                            onclick="decreaseQty('<?php echo $row['id']; ?>')">
                                            -
                                        </button>

                                        <input
                                            type="text"
                                            id="qty-<?php echo $row['id']; ?>"
                                            value="0"
                                            class="qty-input"
                                            data-stock="<?php echo $row['stock']; ?>"
                                            readonly>

                                        <button class="qty-btn qty-plus"
                                            onclick="increaseQty('<?php echo $row['id']; ?>')">
                                            +
                                        </button>

                                    </div>

                                <?php else: ?>

                                    <div class="out-stock-box">

                                        <i class="fas fa-box-open"></i>

                                        Tidak Ada Stok

                                    </div>

                                <?php endif; ?>

                            </div>
                            <?php endif; ?>

                            <?php if($row['stock'] > 0 || $row['category'] === 'additional'): ?>

                            <button
                                class="btn-checkout"
                                onclick="addToCart(
                                    this,
                                    '<?php echo $row['id']; ?>',
                                    '<?php echo addslashes($row['name']); ?>',
                                    '<?php echo $row['sell_price']; ?>',
                                    '<?php echo $row['category']; ?>'
                                )">

                                <i class="fas fa-cart-plus"></i>
                                Tambah
                                <i class="fas fa-arrow-right"></i>

                            </button>

                            <?php else: ?>

                            <button
                                class="btn-checkout btn-disabled"
                                disabled>

                                <i class="fas fa-ban"></i>
                                Stok Habis

                            </button>

                            <?php endif; ?>

                        </div>

                    </div>

                </div>

                <?php endwhile; ?>

                <div id="empty-search" class="empty-search" style="display:none;">
                    <div class="empty-icon">
                        <i class="fas fa-search"></i>
                    </div>

                    <h5>Produk Tidak Ditemukan</h5>

                    <p>
                        Tidak ada produk yang cocok dengan pencarian Anda.
                        Coba gunakan kata kunci lain atau ubah filter.
                    </p>
                </div>
            </div>
        </div>
    </main>

    <?php include '../../script/footscript.php'; ?>

    <script>
        function toggleStar(id,btn){

            fetch(
                'catalog-star.php',
                {
                    method:'POST',
                    headers:{
                        'Content-Type':'application/x-www-form-urlencoded'
                    },
                    body:'id='+id
                }
            )
            .then(res=>res.json())
            .then(data=>{

                let icon = btn.querySelector('i');

                let card = btn.closest('.product-item');

                if(data.starred){

                    btn.classList.add('active');

                    icon.classList.remove('far');
                    icon.classList.add('fas');

                    card.dataset.star = 1;

                }else{

                    btn.classList.remove('active');

                    icon.classList.remove('fas');
                    icon.classList.add('far');

                    card.dataset.star = 0;

                }

                // LANGSUNG PINDAH KE POSISI BARU
                reorderProducts();

            });

        }
        
        function increaseQty(id) {
            let input = document.getElementById('qty-' + id);
            let stock = parseInt(input.dataset.stock || 0);
            let currentVal = parseInt(input.value || 0);

            if (currentVal < stock) {
                input.value = currentVal + 1;
            }
        }

        function decreaseQty(id) {
            let input = document.getElementById('qty-' + id);
            let val = parseInt(input.value);
            if (val > 0) input.value = val - 1;
        }

        function applyFilters() {
            let keyword = document.getElementById('search').value.toLowerCase();
            let category = document.getElementById('category-filter').value.toLowerCase();
            let items = document.querySelectorAll('.product-item');
            let found = false;

            items.forEach(item => {

                let name = item.dataset.name.toLowerCase();
                let itemCategory = item.dataset.category.toLowerCase();

                let matchKeyword = name.includes(keyword);

                let matchCategory =
                    category === 'all' ||
                    itemCategory === category;

                if (matchKeyword && matchCategory) {

                    item.style.display = 'block';
                    found = true;

                } else {

                    item.style.display = 'none';

                }

            });

            let empty = document.getElementById('empty-search');
            let productList = document.getElementById('product-list');

            if (found) {

                empty.style.display = 'none';
                productList.classList.remove('empty-mode');

            } else {

                empty.style.display = 'flex';
                productList.classList.add('empty-mode');

            }

        }

        function reorderProducts(){

            let container = document.getElementById('product-list');
            let items = Array.from(document.querySelectorAll('.product-item'));

            items.sort((a,b)=>{

                let starA = parseInt(a.dataset.star || 0);
                let starB = parseInt(b.dataset.star || 0);

                // STAR always on top
                if(starA !== starB){
                    return starB - starA;
                }

                // fallback ke urutan asli
                return parseInt(a.dataset.index) - parseInt(b.dataset.index);
            });

            items.forEach(item=>{
                container.appendChild(item);
            });
        }

        function setInitialIndex() {
            document.querySelectorAll('.product-item').forEach((item, index) => {
                item.dataset.index = index;
            });
        }

        setInitialIndex();

        function sortProduct(type) {

            let container = document.getElementById('product-list');
            let items = Array.from(document.querySelectorAll('.product-item'));

            items.sort((a, b) => {

                let starA = parseInt(a.dataset.star || 0);
                let starB = parseInt(b.dataset.star || 0);

                if (starA !== starB) {
                    return starB - starA;
                }

                if (type === 'name') {
                    return a.dataset.name.localeCompare(b.dataset.name);
                }

                if (type === 'latest') {
                    return parseInt(b.dataset.index) - parseInt(a.dataset.index);
                }

                if (type === 'low') {
                    return parseInt(a.dataset.price) - parseInt(b.dataset.price);
                }

                if (type === 'high') {
                    return parseInt(b.dataset.price) - parseInt(a.dataset.price);
                }

                return a.dataset.name.localeCompare(b.dataset.name);
            });

            items.forEach(item => container.appendChild(item));
        }

        function syncStock() {

            fetch('../components/data/get-stock.php')
                .then(res => res.json())
                .then(data => {

                    Object.keys(data).forEach(id => {

                        let stock = parseInt(data[id]);

                        // STOCK BADGE
                        let el = document.getElementById('stock-' + id);

                        if (el) {
                            el.innerHTML = `
                                <i class="fas fa-cube"></i>
                                ${stock} Stok
                            `;
                        }

                        // PRODUCT CARD
                        let card = document.querySelector(`.product-item[data-id="${id}"]`);

                        if (card) {

                            // CLASS STOCK
                            if (stock <= 0) {
                                card.classList.add('out-of-stock');
                            } else {
                                card.classList.remove('out-of-stock');
                            }

                            // STATUS TEXT
                            let desc = card.querySelector('.product-desc');

                            if (desc) {

                                if (stock <= 0) {

                                    desc.innerHTML = `
                                        <i class="fas fa-circle text-danger"></i>
                                        Stok habis
                                    `;

                                } else {

                                    desc.innerHTML = `
                                        <i class="fas fa-circle text-success"></i>
                                        Stok tersedia
                                    `;

                                }

                            }

                            // UPDATE DATA STOCK INPUT
                            let input = document.getElementById('qty-' + id);

                            if (input) {

                                input.dataset.stock = stock;

                                // jika stok habis reset qty
                                if (stock <= 0) {
                                    input.value = 0;
                                }

                            }

                        }

                    });

                })
                .catch(err => {
                    console.error('Gagal sync stock:', err);
                });

        }

        // pertama kali load
        syncStock();

        // refresh tiap 3 detik
        setInterval(syncStock, 3000);

        // === HIGHLIGHT FROM GLOBAL SEARCH ===
        (function(){
            var params = new URLSearchParams(window.location.search);
            var highlightId = params.get('highlight');
            if(!highlightId) return;

            var target = document.querySelector('.product-item[data-id="'+highlightId+'"]');
            if(!target) return;

            setTimeout(function(){
                target.scrollIntoView({behavior:'smooth',block:'center'});
                target.classList.add('highlight-target');
                var nameEl = target.querySelector('.product-title');
                var productName = nameEl ? nameEl.textContent.trim() : 'Produk';
                QToast('Produk Ditemukan', 'Anda diarahkan ke "'+productName+'" dari pencarian.', 'info');
                setTimeout(function(){ target.classList.remove('highlight-target'); },4000);
                history.replaceState(null,'',window.location.pathname);
            },400);
        })();

    </script>

</body>

</html>