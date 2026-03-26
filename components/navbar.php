<style>
    .cart-btn {
        background: #111827;
        color: white;
        border-radius: 50px;
        padding: 10px 15px;
        cursor: pointer;
    }

    .modal-body {
        max-height: 60vh;
        overflow-y: auto;
        padding-right: 10px;

        /* Smooth scroll */
        scroll-behavior: smooth;
    }

    /* Custom scrollbar */
    .modal-body::-webkit-scrollbar {
        width: 6px;
    }

    .modal-body::-webkit-scrollbar-thumb {
        background: #6366f1;
        border-radius: 10px;
    }

    .cart-container {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    /* CARD */
    .cart-card {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px;
        border-radius: 18px;
        background: #fff;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        transition: 0.3s;
    }

    .cart-card:hover {
        transform: translateY(-3px);
    }

    /* LEFT */
    .cart-left {
        display: flex;
        align-items: center;
        gap: 12px;
        flex: 1;
    }

    .cart-img {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        object-fit: cover;
    }

    /* TEXT */
    .cart-title {
        font-weight: 600;
        font-size: 15px;
    }

    .cart-meta {
        display: flex;
        gap: 6px;
        margin-top: 5px;
    }

    /* BADGES */
    .badge-price {
        background: #eef2ff;
        color: #4f46e5;
        padding: 3px 8px;
        border-radius: 8px;
        font-size: 12px;
    }

    .badge-qty {
        background: #ecfeff;
        color: #0891b2;
        padding: 3px 8px;
        border-radius: 8px;
        font-size: 12px;
    }

    /* QTY */
    .cart-qty {
        display: flex;
        align-items: center;
        gap: 8px;
        min-width: 110px; /* penting biar simetris */
        justify-content: center;
    }

    .cart-qty button {
        background: #6366f1;
        border: none;
        color: white;
        width: 30px;
        height: 30px;
        border-radius: 8px;
        font-weight: bold;
    }

    .cart-qty span {
        width: 30px;
        text-align: center;
        font-weight: bold;
    }

    /* RIGHT */
    .cart-right {
        text-align: right;
        min-width: 140px; /* biar harga panjang tetap rapi */
    }

    .cart-subtotal {
        font-weight: bold;
        font-size: 15px;
        margin-bottom: 5px;
    }

    .remove-btn {
        color: #ef4444;
        cursor: pointer;
    }

    .cart-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
    }

    /* TOTAL BOX */
    .cart-total-box {
        background: linear-gradient(45deg, #6366f1, #8b5cf6);
        color: white;
        padding: 10px 15px;
        border-radius: 12px;
        flex: 1;
    }

    .total-label {
        font-size: 12px;
        opacity: 0.8;
    }

    .total-value {
        font-size: 16px;
        font-weight: bold;
    }

    /* BUTTON */
    .btn-checkout {
        background: #111827;
        color: white;
        border-radius: 12px;
        padding: 10px 20px;
        border: none;
        transition: 0.3s;
        white-space: nowrap;
    }

    .btn-checkout:hover {
        background: #000;
        transform: translateY(-1px);
    }

    .empty-cart {
        text-align: center;
        padding: 40px 20px;
        color: #6b7280;
    }

    .empty-icon {
        font-size: 60px;
        color: #6366f1;
        margin-bottom: 15px;
    }

    .empty-cart h5 {
        font-weight: 600;
        color: #111827;
        margin-bottom: 5px;
    }

    .empty-cart p {
        font-size: 14px;
    }

    .empty-cart {
        animation: fadeIn 0.4s ease;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* MOBILE FIX */
    @media (max-width: 576px) {

        .cart-card {
            flex-direction: column;
            align-items: stretch;
            gap: 12px;
        }

        /* TOP: image + title */
        .cart-left {
            width: 100%;
        }

        /* MIDDLE: qty */
        .cart-qty {
            justify-content: center;
            width: 100%;
        }

        /* BOTTOM: subtotal + delete */
        .cart-right {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }

        .cart-subtotal {
            font-size: 16px;
        }

        .remove-btn {
            font-size: 20px;
        }
    }
</style>

<nav
    class="navbar navbar-top navbar-expand navbar-dashboard navbar-dark ps-0 pe-2 pb-0"
>
    <div class="container-fluid">
        <div
            class="d-flex justify-content-between w-100"
            id="navbarSupportedContent"
        >
            <!-- Cart button -->
            <div class="d-flex align-items-center">
                <div class="cart-btn" onclick="openCart()">
                    <i class="fas fa-shopping-cart"></i> (<span id="cart-count">0</span>)
                </div>
            </div>
            <!-- Navbar links -->
            <ul class="navbar-nav align-items-center">
                <li class="nav-item dropdown ms-lg-3">
                    <a class="nav-link dropdown-toggle pt-1 px-0" 
                    href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">

                        <!-- Card kecil untuk profile -->
                        <div class="card shadow-sm border-0 d-flex flex-row align-items-center px-2 py-1">
                            <!-- Avatar -->
                            <img class="avatar rounded-circle border border-2 border-white shadow-sm"
                                alt="Image placeholder"
                                src="<?php echo $user['photo'] ? $user['photo'] : '../assets/img/default-avatar.jpg'; ?>"
                                style="width:40px; height:40px; object-fit:cover;" />

                            <!-- Email + ikon dropdown -->
                            <div class="ms-2 d-none d-lg-block">
                                <span class="fw-bold text-gray-900"><?php echo $_SESSION['email']; ?></span>
                                <i class="fas fa-chevron-down ms-1 text-primary"></i>
                            </div>
                        </div>
                    </a>

                    <!-- Dropdown menu -->
                    <div class="dropdown-menu dashboard-dropdown dropdown-menu-end mt-2 py-1 shadow-lg rounded-1">
                        <a class="dropdown-item d-flex align-items-center" href="../pages/profile.php">
                            <i class="fas fa-user-circle text-gray-400 me-2"></i>
                            My Profile
                        </a>

                        <div role="separator" class="dropdown-divider my-1"></div>

                        <a class="dropdown-item d-flex align-items-center text-danger" href="../sessions/logout.php">
                            <i class="fas fa-sign-out-alt me-2"></i>
                            Sign out
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Modal Cart -->
<div class="modal fade" id="cartModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(45deg,#6366f1,#8b5cf6); color:white;">
                <h5 class="mb-0 text-white"><i class="fas fa-shopping-cart"></i>&nbsp; Keranjang</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div id="cart-items" class="cart-container"></div>
            </div>

            <div class="modal-footer cart-footer">
                <!-- TOTAL -->
                <div class="cart-total-box">
                    <div class="total-label">
                        <i class="fas fa-receipt me-1"></i> Total keseluruhan:
                    </div>

                    <div class="total-value">
                        <i class="fas fa-money-bill-wave"></i>&nbsp;
                        Rp <span id="cart-total">0</span>
                    </div>
                </div>

                <!-- BUTTON -->
                <button class="btn btn-checkout">
                    Pesan <i class="fas fa-arrow-right ms-1"></i>
                </button>

            </div>
        </div>
    </div>
</div>

<script>
    // Load cart from localStorage
    let cart = JSON.parse(localStorage.getItem('cart')) || [];

    function openCart() {
        let modal = new bootstrap.Modal(document.getElementById('cartModal'));
        modal.show();
    }

    function addToCart(id, name, price) {
        let qty = parseInt(document.getElementById('qty-' + id).value);
        if(qty == 0) return Swal.fire('Tambahkan qty produk terlebih dahulu!','','warning');

        let product = document.querySelector(`#product-${id}`);
        let img = product.querySelector('.product-img').src;

        let existing = cart.find(item => item.id == id);

        if(existing) {
            existing.qty += qty;
        } else {
            cart.push({
                id,
                name,
                price,
                qty,
                photo: img
            });
        }

        updateCart();
        document.getElementById('qty-' + id).value = 0;
    }

    function updateCart() {
        localStorage.setItem('cart', JSON.stringify(cart));

        let count = 0;
        let total = 0;
        let html = '';

        // 👉 JIKA KOSONG
        if(cart.length === 0) {
            html = `
            <div class="empty-cart">
                <div class="empty-icon">
                    <i class="fas fa-shopping-basket"></i>
                </div>

                <h5>Keranjang kosong</h5>
                <p>Yuk tambahkan produk ke keranjang kamu</p>
                <a href="../pages/catalog.php" class="btn btn-primary mt-2">
                    Mulai Belanja
                </a>
            </div>
            `;

            document.getElementById('cart-items').innerHTML = html;
            document.getElementById('cart-count').innerText = 0;

            // ❌ sembunyikan footer
            document.querySelector('.cart-footer').style.display = 'none';

            return;
        }

        // ✅ tampilkan lagi kalau ada isi
        document.querySelector('.cart-footer').style.display = 'flex';

        cart.forEach((item, index) => {
            let subtotal = item.qty * item.price;
            count += item.qty;
            total += subtotal;

            html += `
                <div class="cart-card">

                    <!-- LEFT -->
                    <div class="cart-left">
                        <img src="${item.photo}" class="cart-img">

                        <div>
                            <div class="cart-title">${item.name}</div>

                            <div class="cart-meta">
                                <span class="badge-price">
                                    Rp ${item.price.toLocaleString()}
                                </span>

                                <span class="badge-qty">
                                    Qty: ${item.qty}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- CENTER (QTY CONTROL) -->
                    <div class="cart-qty">
                        <button onclick="changeQty(${index}, -1)">-</button>
                        <span>${item.qty}</span>
                        <button onclick="changeQty(${index}, 1)">+</button>
                    </div>

                    <!-- RIGHT -->
                    <div class="cart-right">
                        <div class="cart-subtotal">
                            Rp ${subtotal.toLocaleString()}
                        </div>

                        <div class="remove-btn" onclick="removeItem(${index})">
                            <i class="fas fa-trash"></i>
                        </div>
                    </div>

                </div>
                `;
        });

        document.getElementById('cart-count').innerText = count;
        document.getElementById('cart-items').innerHTML = html;
        document.getElementById('cart-total').innerText = total.toLocaleString();
    }

    function changeQty(index, change) {
        cart[index].qty += change;

        if (cart[index].qty <= 0) {
            cart.splice(index, 1);
        }

        updateCart();
    }

    function removeItem(index) {
        cart.splice(index, 1);
        updateCart();
    }

    // Load cart on page load
    window.onload = function() {
        updateCart();
    };
</script>
