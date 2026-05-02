<?php
include '../../sessions/session.php';
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Pembelian Stok - Qieos</title>
    <?php include '../../script/headscript.php'; ?>

    <style>
        :root {
            --primary: #4f46e5;
            --primary-soft: #eef2ff;
            --dark: #0f172a;
            --muted: #64748b;
            --border: #e2e8f0;
        }

        .card-modern {
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        }

        .header-title {
            font-weight: 600;
            color: var(--dark);
        }

        .header-sub {
            font-size: 13px;
            color: var(--muted);
        }

        .form-control {
            border-radius: 10px;
            border: 1px solid var(--border);
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 2px var(--primary-soft);
        }

        .btn-primary {
            background: var(--primary);
            border: none;
            border-radius: 10px;
        }

        .badge-soft {
            background: var(--primary-soft);
            color: var(--primary);
            padding: 6px 10px;
            border-radius: 8px;
        }

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            margin-bottom: 10px;
        }

        .dataTables_length select {
            min-width: 70px;
            padding-right: 20px;
        }
    </style>
</head>

<body>
<?php include '../components/sidebar.php'; ?>

<main class="content">
<?php include '../components/navbar.php'; ?>

<div class="container-fluid mt-4">

    <!-- HEADER -->
    <div class="mb-4">
        <h4 class="header-title">
            <i class="fas fa-dolly-flatbed me-2 text-primary"></i>
            Pembelian Stok
        </h4>
        <div class="header-sub">
            Barang masuk ke Gudang Stok (FIFO System)
        </div>
    </div>

    <!-- FORM -->
    <div class="card card-modern p-4 mb-4">
        <form id="form-stock" action="stock-action.php?action=stock_in" method="POST" enctype="multipart/form-data">

            <div class="mb-3">
                <span class="badge-soft">Informasi Produk</span>
            </div>

            <div class="row">
                <div class="col-md-3 mb-3">
                    <input type="text" name="product_name" class="form-control" placeholder="Nama Produk" required>
                </div>

                <div class="col-md-3 mb-3">
                    <input type="text" name="code" class="form-control" placeholder="Kode Produk" required>
                </div>

                <div class="col-md-3 mb-3">
                    <select name="category" class="form-control" required>
                        <option value="">Kategori</option>
                        <option value="makanan">Makanan</option>
                        <option value="minuman">Minuman</option>
                        <option value="jajanan">Jajanan</option>
                    </select>
                </div>

                <div class="col-md-3 mb-3">
                    <input type="file" name="photo" class="form-control">
                </div>
            </div>

            <div class="mb-3 mt-4">
                <span class="badge-soft">Detail Stok</span>
            </div>

            <div class="row">
                <div class="col-md-3 mb-3">
                    <input type="number" name="qty" class="form-control" placeholder="Qty" required>
                </div>

                <div class="col-md-3 mb-3">
                    <input type="text" name="unit" class="form-control" placeholder="Satuan (pcs/karton)" required>
                </div>

                <div class="col-md-3 mb-3">
                    <input type="number" name="buy_price" class="form-control" placeholder="Harga Beli" required>
                </div>

                <div class="col-md-3 mb-3">
                    <input type="number" name="sell_price" class="form-control" placeholder="Harga Jual" required>
                </div>
            </div>

            <div class="mb-3">
                <textarea name="note" class="form-control" placeholder="Catatan"></textarea>
            </div>

            <div class="text-end">
                <button class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> Simpan
                </button>
            </div>

        </form>
    </div>

    <!-- TABLE -->
    <div class="card card-modern p-3 mb-5">
        <div id="table-stock"></div>
    </div>

</div>

</main>

    <?php include '../../script/footscript.php'; ?>

<script>
    document.getElementById("form-stock").addEventListener("submit", function(e) {
        e.preventDefault();

        let formData = new FormData(this);

        fetch(this.action, {
            method: "POST",
            body: formData
        })
        .then(res => res.json())
        .then(res => {
            if(res.status === "success"){
                Swal.fire("Berhasil", res.msg, "success");
                this.reset();
                loadTable();
            } else {
                Swal.fire("Error", res.msg, "error");
            }
        });
    });

    function loadTable() {
        fetch('stock-table.php')
        .then(res => res.text())
        .then(html => {
            document.getElementById("table-stock").innerHTML = html;

            setTimeout(() => {
                $('#stockTable').DataTable({
                    pageLength: 5,
                    lengthMenu: [5, 10, 25, 50],
                    responsive: true,
                    autoWidth: false
                });
            }, 100);
        });
    }

    loadTable();
</script>

</body>
</html>