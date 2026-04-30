<?php include '../../sessions/session.php'; ?>

<!doctype html>
<html>
<head>
<title>Stok Penjualan</title>
<?php include '../../script/headscript.php'; ?>

<style>
:root {
    --primary:#4f46e5;
    --soft:#eef2ff;
    --border:#e2e8f0;
    --text:#0f172a;
    --muted:#64748b;
}
.card-modern{
    border:none;
    border-radius:16px;
    box-shadow:0 8px 24px rgba(0,0,0,0.05);
}
.form-control{
    border-radius:10px;
}
.badge-soft{
    background:var(--soft);
    color:var(--primary);
}
</style>
</head>

<body>
<?php include '../../components/sidebar.php'; ?>
<main class="content">
<?php include '../../components/navbar.php'; ?>

<div class="container-fluid mt-4">

<h5 class="mb-3">Stok Penjualan</h5>

<!-- REQUEST -->
<div class="card card-modern p-4 mb-4">
<form id="form-request">

<div class="row g-3">
<div class="col-md-6">
<label>Produk</label>
<select name="product_id" class="form-control" required>
<option value="">Pilih</option>
<?php
$q = mysqli_query($conn,"SELECT id,name,code FROM products");
while($p=mysqli_fetch_assoc($q)):
?>
<option value="<?= $p['id'] ?>">
<?= $p['name'] ?> (<?= $p['code'] ?>)
</option>
<?php endwhile; ?>
</select>
</div>

<div class="col-md-3">
<label>Qty</label>
<input type="number" name="qty" placeholder="0" class="form-control" required>
</div>

<div class="col-md-3 d-flex align-items-end">
<button class="btn btn-primary w-100">
Request Stok
</button>
</div>

</div>

</form>
</div>

<!-- STOK -->
<div class="card card-modern p-3 mb-4">
<h6>Stok Penjualan</h6>
<div id="sales-table"></div>
</div>

<!-- REQUEST HISTORY -->
<div class="card card-modern p-3">
<h6>Riwayat Request</h6>
<div id="request-table"></div>
</div>

</div>
</main>

<?php include '../../script/footscript.php'; ?>

<script>
const form = document.getElementById("form-request");

form.addEventListener("submit", async function(e){
    e.preventDefault();

    let btn = form.querySelector("button");
    btn.disabled = true;
    btn.innerText = "Loading...";

    try{
        let res = await fetch('sales-action.php',{
            method:'POST',
            body:new FormData(form)
        });

        let data = await res.json();

        Swal.fire(data.status, data.msg, data.status);

        form.reset();
        loadTable();
        loadRequest();

    }catch(err){
        Swal.fire("error","Server error","error");
    }

    btn.disabled = false;
    btn.innerText = "Request Stok";
});

function loadTable(){
fetch('sales-table.php')
.then(res=>res.text())
.then(html=>{
document.getElementById("sales-table").innerHTML = html;
});
}

function loadRequest(){
fetch('request-table.php')
.then(res=>res.text())
.then(html=>{
document.getElementById("request-table").innerHTML = html;
});
}

loadTable();
loadRequest();
</script>

</body>
</html>