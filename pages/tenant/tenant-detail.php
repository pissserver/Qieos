<?php
    include '../../sessions/session.php';

    $id = $_GET['id'];
    $query = "SELECT * FROM tenants WHERE id = '$id' ORDER BY tenant_name ASC";
    $result = mysqli_query($conn, $query);
    $tenant = mysqli_fetch_assoc($result);

    $query2 = "SELECT * FROM tenants WHERE status = 'active' ORDER BY tenant_name ASC";
    $result2 = mysqli_query($conn, $query2);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Detail Tenant - Qieos</title>
    <?php include '../../script/headscript.php'; ?>

    <link rel="stylesheet" href="/qieos/css/pages/tenant-detail.css">
</head>

<body>
<?php include '../components/sidebar.php'; ?>
<main class="content">
<?php include '../components/navbar.php'; ?>

<div class="container-fluid px-0 mt-4">

    <!-- HEADER -->
    <!-- <div class="stock-header mt-5">
        <div>
            <h3>Stok Gudang</h3>
            <p>Monitoring stok produk dan FIFO layer secara realtime</p>
        </div>

        <div class="header-icon">
            <i class="fas fa-warehouse"></i>
        </div>
    </div> -->

    <div class="row">
        <div class="col-md-12">
            <!-- Main Table -->
            <div class="section-card mb-4 mt-4">
                <div class="panel-header panel-primary">
                    <div class="panel-left">
                        <div class="panel-icon">
                            <i class="fas fa-store"></i>
                        </div>

                        <div>
                            <div class="tenant-dropdown">
                                <button
                                    type="button"
                                    class="tenant-toggle"
                                    id="tenantToggle">
                                    <span><?= htmlspecialchars(strtoupper($tenant['tenant_name'])) ?></span>
                                    <i class="fas fa-chevron-down" id="tenantArrow"></i>
                                </button>

                                <div class="tenant-menu" id="tenantMenu">
                                    <div class="tenant-header">
                                        <small>Pilih Tenant</small>
                                        <h6>Daftar Tenant</h6>
                                    </div>

                                    <?php while($allTenant=mysqli_fetch_assoc($result2)): ?>
                                        <a
                                            href="?id=<?= $allTenant['id'] ?>"
                                            class="tenant-item <?= $allTenant['id']==$tenant['id'] ? 'active' : '' ?>">

                                            <span>
                                                <i class="fas fa-store"></i>
                                                <?= htmlspecialchars(strtoupper($allTenant['tenant_name'])) ?>
                                            </span>

                                            <?php if($allTenant['id']==$tenant['id']){ ?>
                                                <i class="fas fa-check"></i>
                                            <?php } ?>
                                        </a>
                                    <?php endwhile; ?>
                                </div>
                            </div>

                            <div class="panel-subtitle">
                                <?= $tenant['tenant_owner'] ?> | <?= ucwords(strtolower($tenant['status'])) ?> &nbsp;<i class="fas fa-check-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="detail-container mb-5">

                <!-- <div class="fifo-title">
                    <i class="fas fa-wallet text-primary"></i>
                    <h5 class="mb-0">Detail Pembayaran</h5>
                </div> -->

                <div class="payment-tabs">

                    <button
                        class="payment-tab active"
                        onclick="switchPaymentTab('tenant', this)">
                        <i class="fas fa-store"></i>
                        Pembayaran Tenant
                    </button>

                    <button
                        class="payment-tab"
                        onclick="switchPaymentTab('utility', this)">
                        <i class="fas fa-bolt"></i>
                        Air & Listrik
                    </button>

                </div>

                <div id="payment-content">

                    <div class="loading-box">
                        <i class="fas fa-spinner fa-spin"></i>
                        Memuat data...
                    </div>

                </div>

            </div>
        </div>
    </div>

    <!-- Add MODAL -->
    <div class="modal fade" id="addPaymentModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content stock-panel border-0">

                <div class="panel-header panel-dark my-3 mx-3">
                    <div class="panel-left">
                        <div class="panel-icon">
                            <i class="fas fas fa-user-plus"></i>
                        </div>

                        <div>
                            <div id="addPaymentTitle" class="panel-title">

                            </div>
                            <div class="panel-subtitle">
                                Tambah pembayaran baru untuk tenant ini
                            </div>
                        </div>
                    </div>

                    <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="mt-2 px-5" id="addPaymentContent"></div>
            </div>
        </div>
    </div>

    <!-- EDIT MODAL -->
    <div class="modal fade" id="editPaymentModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content stock-panel border-0">

                <div class="panel-header panel-dark my-3 mx-3">
                    <div class="panel-left">
                        <div class="panel-icon">
                            <i class="fas fas fa-money-bill-wave"></i>
                        </div>

                        <div>
                            <div id="editPaymentTitle" class="panel-title">
                                
                            </div>
                            <div class="panel-subtitle">
                                Edit nama tenant dan tanggal pembayaran
                            </div>
                        </div>
                    </div>

                    <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="mt-2 px-5" id="editPaymentContent"></div>
            </div>
        </div>
    </div>
</main>

<?php include '../../script/footscript.php'; ?>

<!-- Tenant Dropdown -->
<script>
    const tenantToggle=document.getElementById("tenantToggle");
    const tenantMenu=document.getElementById("tenantMenu");
    const tenantArrow=document.getElementById("tenantArrow");

    tenantToggle.addEventListener("click",function(e){

        e.stopPropagation();

        tenantMenu.classList.toggle("show");

        tenantToggle.classList.toggle("active");

    });

    document.addEventListener("click",function(){

        tenantMenu.classList.remove("show");

        tenantToggle.classList.remove("active");

    });
</script>

<!-- Switch Payment Tab -->
<script>
    document.addEventListener("DOMContentLoaded", function(){
        loadPayment("tenant");
    });

    function switchPaymentTab(type, el){
        document.querySelectorAll(".payment-tab").forEach(btn=>{
            btn.classList.remove("active");
        });

        el.classList.add("active");

        loadPayment(type);
    }

    function loadPayment(type){
        document.getElementById("payment-content").innerHTML=`
            <div class="loading-box">
                <i class="fas fa-spinner fa-spin"></i>
                Memuat data...
            </div>
        `;

        fetch("tenant-detail-table.php?type="+type+"&tenant=<?= $tenant['id']; ?>")
        .then(res=>res.text())
        .then(html=>{

            document.getElementById("payment-content").innerHTML=html;

            if($.fn.DataTable.isDataTable("#tablePayment")){
                $("#tablePayment").DataTable().destroy();
            }

            $("#tablePayment").DataTable({
                pageLength:10,
                responsive:true,
                ordering:false,
                autoWidth:false,

                language:{
                    search:"",
                    searchPlaceholder:"Cari pembayaran..."
                }
            });
        });
    }
</script>

<!-- Script Add -->
<script>
    // OPEN ADD MODAL
    $(document).on('click','.addPaymentBtn',function(){

        let type = $(this).data('type');
        let tenant_id = $(this).data('tenant-id');

        $('#addPaymentModal').modal('show');

        const paymentType = type === 'tenant' ? 'Pembayaran Tenant' : 'Pembayaran Air & Listrik';
        $('#addPaymentTitle').text('Tambah ' + paymentType);

        document.getElementById('addPaymentContent').innerHTML = `
            <div class="text-center py-5">
                <i class="fas fa-spinner fa-spin fa-2x text-secondary"></i>
            </div>
        `;

        fetch('tenant-payment-add.php?type=' + type + '&tenant_id=' + tenant_id)
        .then(res => res.text())
        .then(html => {
            document.getElementById('addPaymentContent').innerHTML = html;
        });

    });

    // Add Action
    $(document).on('submit','#addPaymentForm',function(e){
        e.preventDefault();

        let formData = new FormData(this);
        let tenant_id = formData.get('tenant_id');
        let type = formData.get('type');

        fetch('tenant-payment-action.php?action=store',{
            method:'POST',
            body:formData
        })
        .then(res => res.json())
        .then(res => {

            if(res.status === 'success'){

                const receiptUrl = `../receipt-tenant.php?payment_id=${res.payment_id}&type=${res.type}`;
                    window.open(receiptUrl, '_blank');

                if (navigator.share) {
                    navigator.share({
                        title: 'Struk Pembayaran',
                        text: 'Berikut struk pembayaran' + type,
                        url: receiptUrl
                    });
                }

                QToast('Berhasil', 'Data berhasil ditambahkan', 'success');

                $('#addPaymentModal').modal('hide');

                setTimeout(() => {
                    loadPayment(type);
                }, 1000);

            }else{

                QToast('Gagal', res.message || 'Terjadi kesalahan', 'error');

            }

        })
        .catch(() => {
            QToast('Error', 'Gagal memproses update', 'error');
        });
    });
</script>

<!-- Script Edit -->
<script>
    // OPEN EDIT MODAL
    $(document).on('click','.editPaymentBtn',function(){

        let id = $(this).data('id');
        let type = $(this).data('type');

        $('#editPaymentModal').modal('show');

        const paymentType = type === 'tenant' ? 'Pembayaran Tenant' : 'Pembayaran Air & Listrik';
        $('#editPaymentTitle').text('Edit ' + paymentType);

        document.getElementById('editPaymentContent').innerHTML = `
            <div class="text-center py-5">
                <i class="fas fa-spinner fa-spin fa-2x text-secondary"></i>
            </div>
        `;

        fetch('tenant-payment-edit.php?id=' + id + '&type=' + type)
        .then(res => res.text())
        .then(html => {
            document.getElementById('editPaymentContent').innerHTML = html;
        });

    });

    // Edit Action
    $(document).on('submit','#editPaymentForm',function(e){
        e.preventDefault();

        let formData = new FormData(this);
        let id = formData.get('id');
        let type = formData.get('type');

        fetch('tenant-payment-action.php?action=update',{
            method:'POST',
            body:formData
        })
        .then(res => res.json())
        .then(res => {

            if(res.status === 'success'){

                QToast('Berhasil', 'Data berhasil diperbarui', 'success');

                $('#editPaymentModal').modal('hide');

                setTimeout(() => {
                    loadPayment(type);
                }, 1000);

            }else{

                QToast('Gagal', res.message || 'Terjadi kesalahan', 'error');

            }

        })
        .catch(() => {
            QToast('Error', 'Gagal memproses update', 'error');
        });
    });
</script>

<!-- Script Delete -->
<script>
    // Delete Action
    $(document).on('click','.deletePaymentBtn',function(){

        let id = $(this).data('id');
        let date = $(this).data('date');
        let type = $(this).data('type');

        if(type==="tenant"){
            typeName = "Pembayaran Tenant";
        }else if(type==="utility"){
            typeName = "Pembayaran Air & Listrik";
        }

        const formattedDate = new Date(date).toLocaleDateString('id-ID', {
            day: 'numeric',
            month: 'short',
            year: 'numeric'
        });

        QConfirm('Hapus Pembayaran?', 'Pembayaran "' + typeName + ' (' + formattedDate + ')" akan dihapus permanen.', {confirmText:'Hapus', icon:'fa-trash-can', confirmClass:'q-confirm-btn-danger', iconClass:'q-confirm-icon-danger'}).then(function(ok){
            if(ok){
                fetch('tenant-payment-action.php?action=destroy', {
                    method: 'POST',
                    body: new URLSearchParams({ id: id, type: type })
                })
                .then(res=>res.json())
                .then(res=>{

                    if(res.status==='success'){

                        QToast('Terhapus', 'Data berhasil dihapus', 'success');

                        setTimeout(() => {
                            loadPayment(type);
                        }, 1000);
                    }
                });
            }
        });
    });
</script>

<!-- Print Receipt -->
<script>
    function printReceipt(id, type) {
        const receiptUrl = `../receipt-tenant.php?payment_id=${id}&type=${type}`;

        // buka struk di tab baru
        const newWindow = window.open(receiptUrl, '_blank');

        // OPTIONAL: auto focus
        if (newWindow) {
            newWindow.focus();
        }

        if ($type == 'tenant') {
            $tittle = 'Pembayaran Tenant';
        } else {
            $tittle = 'Pembayaran Air & Listrik';
        }

        // SHARE (jika user klik manual)
        if (navigator.share) {
            navigator.share({
                title: 'Struk ' + $tittle,
                text: 'Berikut struk ' + $tittle,
                url: receiptUrl
            }).catch(err => console.log(err));
        }
    }
</script>

</body>
</html>