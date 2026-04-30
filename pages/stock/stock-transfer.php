<?php include '../../sessions/session.php'; ?>

<!doctype html>
<html>
<head>
<title>Transfer ke Penjualan</title>
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
</style>
</head>

<body>
<?php include '../../components/sidebar.php'; ?>

<main class="content">
<?php include '../../components/navbar.php'; ?>

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
<div class="card card-modern p-3 mt-4">

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
    fetch('transfer-table.php')
    .then(res=>res.text())
    .then(html=>{
        document.getElementById("transfer-table").innerHTML = html;
    });
}

function loadHistory(){
    fetch('transfer-history.php')
    .then(res=>res.text())
    .then(html=>{
        document.getElementById("history-table").innerHTML = html;
    });
}

loadTable();
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

            fetch('approve-action.php',{
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

            fetch('reject-action.php',{
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
</script>

</body>
</html>