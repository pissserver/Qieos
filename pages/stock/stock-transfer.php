<?php include '../../sessions/session.php'; ?>

<!doctype html>
<html>
<head>
<title>Transfer ke Penjualan | Qieos</title>
<?php include '../../script/headscript.php'; ?>

<style>
    :root {
        --primary:#4f46e5;
        --soft:#eef2ff;
        --border:#e2e8f0;
        --text:#0f172a;
        --muted:#64748b;
    }

    /* CARD */
    .card-modern{
        border:none;
        border-radius:18px;
        box-shadow:0 10px 30px rgba(0,0,0,0.06);
    }

    /* HEADER */
    .page-title{
        font-weight:600;
        color:var(--text);
        font-size:20px;
    }

    /* TABLE */
    .table td{
        vertical-align:middle;
        padding:14px;
    }

    .table-hover tbody tr:hover{
        background:#f8fafc;
    }

    /* PRODUCT */
    .product-name{
        font-weight:600;
        font-size:14px;
    }
    .product-code{
        font-size:12px;
        color:var(--muted);
    }

    /* BADGE */
    .badge-soft{
        background:var(--soft);
        color:var(--primary);
        padding:6px 12px;
        border-radius:10px;
        font-weight:500;
    }

    /* BUTTON GROUP */
    .btn-action{
        border-radius:10px;
        font-size:12px;
        padding:6px 10px;
    }

    /* APPROVE */
    .btn-acc{
        background:#16a34a;
        color:#fff;
    }
    .btn-acc:hover{
        background:#15803d;
    }

    /* REJECT */
    .btn-reject{
        background:#ef4444;
        color:#fff;
    }
    .btn-reject:hover{
        background:#dc2626;
    }

    /* EMPTY */
    .empty-state{
        text-align:center;
        padding:40px;
        color:var(--muted);
    }

    .new-row {
        animation: fadeIn 0.5s ease;
        background: #ecfeff;
    }

    @keyframes fadeIn {
        from {opacity:0; transform: translateY(-5px);}
        to {opacity:1; transform: translateY(0);}
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
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <div class="page-title">
            <i class="fas fa-exchange-alt me-2 text-primary"></i>
            Transfer ke Penjualan
        </div>
        <small class="text-muted">Approve request stok dari staff</small>
    </div>
</div>

<!-- TABLE -->
<div class="card card-modern p-3">

    <div class="d-flex justify-content-between mb-3">
        <h6 class="mb-0">
            <i class="fas fa-clock me-1 text-warning"></i>
            Request Pending
        </h6>
    </div>

    <div id="transfer-table"></div>

</div>

<!-- 🔥 HISTORY -->
<div class="card card-modern p-3 mt-4 mb-5">

    <div class="d-flex justify-content-between mb-3">
        <h6 class="mb-0">
            <i class="fas fa-history me-1 text-secondary"></i>
            Riwayat Request
        </h6>
    </div>

    <div id="history-table"></div>

</div>

</div>
</main>

<?php include '../../script/footscript.php'; ?>

<script>
    function loadTable(){
        fetch('stock-transfer-table.php')
        .then(res=>res.text())
        .then(html=>{
            document.getElementById("transfer-table").innerHTML = html;
        })
        .catch(err=>{
            console.error("Load table error:", err);
        });
    }

    function loadHistory(){
        fetch('../components/tables/history-request-table.php')
        .then(res=>res.text())
        .then(html=>{
            document.getElementById("history-table").innerHTML = html;

            setTimeout(() => {

                // 🔥 DESTROY DULU
                if ($.fn.DataTable.isDataTable('#requestHistory')) {
                    $('#requestHistory').DataTable().destroy();
                }

                // 🔥 INIT ULANG
                $('#requestHistory').DataTable({
                    pageLength: 5,
                    lengthMenu: [5, 10, 25, 50],
                    responsive: true,
                    autoWidth: false,

                    // 🔥 PENTING: IKUTIN SORT SQL
                    order: [] 
                });

            }, 100);
        });
    }

    // First init
    loadTable();
    // Auto refresh setiap 1 detik
    setInterval(() => {
        loadTable();
    }, 3000);

    loadHistory();


    // 🔥 APPROVE
    function approve(id){
        Swal.fire({
            title: 'Approve Request?',
            text: "Stok akan dipindahkan dari gudang (FIFO)",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'ACC',
            confirmButtonColor: '#16a34a'
        }).then((result)=>{
            if(result.isConfirmed){

                fetch('stock-transfer-action.php?action=approve',{
                    method:'POST',
                    headers:{'Content-Type':'application/x-www-form-urlencoded'},
                    body:'id='+id
                })
                .then(res=>res.json())
                .then(res=>{
                    Swal.fire(res.status,res.msg,res.status);
                    loadTable();
                    loadHistory();
                });

            }
        });
    }


    // 🔥 REJECT
    function reject(id){
        Swal.fire({
            title: 'Tolak Request?',
            text:'Request tidak akan diproses',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Tolak',
            confirmButtonColor:'#ef4444'
        }).then((result)=>{
            if(result.isConfirmed){

                fetch('stock-transfer-action.php?action=reject',{
                    method:'POST',
                    headers:{'Content-Type':'application/x-www-form-urlencoded'},
                    body:'id='+id
                })
                .then(res=>res.json())
                .then(res=>{
                     console.log(res);
                     console.log(id);
                    Swal.fire(res.status,res.msg,res.status);
                    loadTable();
                    loadHistory();
                });

            }
        });
    }
</script>

</body>
</html>