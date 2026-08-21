<?php
include '../../sessions/session.php';
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Pendaftaran Tenant - Qieos</title>
    <?php include '../../script/headscript.php'; ?>

    <link rel="stylesheet" href="/qieos/css/pages/registration.css">
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
                            <i class="fas fa-users"></i>
                        </div>

                        <div>
                            <div class="panel-title">
                                Pendaftaran Tenant
                            </div>
                            <div class="panel-subtitle">
                                Kelola pendaftaran dan informasi tenant yang terdaftar di sistem
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 px-4">
                    <!-- Button Add -->
                    <div id="btnContainer" style="display:none;">
                        <button
                            type="button"
                            class="btn btn-primary"
                            id="btnAddRegistration">
                            <i class="fas fa-user-plus me-2"></i>
                            Tambah Tenant
                        </button>
                    </div>
                    
                    <!-- TABLE -->
                    <div class="table-responsive-wrap">
                        <table class="table table-hover align-middle" id="stockTable">
                            <thead>
                                <tr style="font-size:13px;color:#64748b;">
                                    <th>Nama Tenant</th>
                                    <th class="text-center">Pemilik</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Tanggal Pendaftaran</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>

                            <?php
                            $q = mysqli_query($conn,"
                            SELECT
                                *
                            FROM tenants
                            WHERE deleted_at IS NULL
                            ORDER BY tenant_name ASC
                            ");
                            while($d=mysqli_fetch_assoc($q)): ?>

                            <tr class="stock-row">

                                <td>
                                    <div class="product-wrap">

                                        <div class="avatar">
                                            <i class="fas fa-store"></i>
                                        </div>

                                        <div>
                                            <div class="fw-bold">
                                                <?= htmlspecialchars($d['tenant_name']) ?>
                                            </div>

                                            <small class="text-muted">
                                                Tenant PISS
                                            </small>
                                        </div>

                                    </div>
                                </td>

                                <td class="text-center">

                                    <span class="stock-badge unit-badge text-capitalize">
                                        <i class="fas fa-user me-1"></i>
                                        <?= htmlspecialchars($d['tenant_owner']) ?>
                                    </span>

                                </td>
                                

                                <td class="text-center">

                                    <span class="stock-badge status-badge text-capitalize">
                                        <i class="fas fa-check me-1"></i>
                                        <?= htmlspecialchars($d['status']) ?>
                                    </span>

                                </td>

                                <td class="text-center">
                                    <span class="unit-badge">
                                        <i class="fas fa-calendar-alt me-1"></i>
                                        <?php
                                        $bulan = [
                                            1 => 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
                                            'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'
                                        ];

                                        $tgl = strtotime($d['registration_date']);
                                        echo date('d', $tgl) . ' ' . $bulan[(int)date('n', $tgl)] . ' ' . date('Y', $tgl);
                                        ?>
                                    </span>
                                </td>

                                <td class="text-center">
                                    <button class="action-btn btn-edit editRegistrationBtn" data-id="<?= $d['id'] ?>">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <button class="action-btn btn-delete deleteRegistrationBtn"
                                        data-id="<?= $d['id'] ?>"
                                        data-name="<?= $d['tenant_name'] ?>">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>

                            <?php endwhile; ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add MODAL -->
    <div class="modal fade" id="addRegistrationModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content stock-panel border-0">

                <div class="panel-header panel-dark my-3 mx-3">
                    <div class="panel-left">
                        <div class="panel-icon">
                            <i class="fas fas fa-user-plus"></i>
                        </div>

                        <div>
                            <div class="panel-title">
                                Tambah Tenant 
                            </div>
                            <div class="panel-subtitle">
                                Masukkan nama tenant dan pemilik tenant
                            </div>
                        </div>
                    </div>

                    <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="mt-2 px-5" id="addRegistrationContent"></div>
            </div>
        </div>
    </div>

    <!-- EDIT MODAL -->
    <div class="modal fade" id="editRegistrationModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content stock-panel border-0">

                <div class="panel-header panel-dark my-3 mx-3">
                    <div class="panel-left">
                        <div class="panel-icon">
                            <i class="fas fas fa-store"></i>
                        </div>

                        <div>
                            <div class="panel-title">
                                Edit Tenant 
                            </div>
                            <div class="panel-subtitle">
                                Edit nama tenant dan pemilik tenant
                            </div>
                        </div>
                    </div>

                    <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="mt-2 px-5" id="editRegistrationContent"></div>
            </div>
        </div>
    </div>
</div>
</main>

<?php include '../../script/footscript.php'; ?>

<script>
    $(document).ready(function(){
        $('#stockTable').DataTable({
            pageLength: 5,
            lengthMenu:[[5,10,25,50],[5,10,25,50]],
            responsive: true,
            autoWidth: false,
            language:{
                search:"",
                searchPlaceholder:"Cari tenant...",

                zeroRecords: `
                    <div class="empty-search">
                        <img src="../../assets/img/illustrations/empty-data.png" class="empty-img">
                        <div class="empty-title">Tenant tidak ditemukan</div>
                        <div class="empty-sub">
                            Coba gunakan kata kunci lain
                        </div>
                    </div>
                `,

                emptyTable: `
                    <div class="empty-search">
                        <img src="../../assets/img/illustrations/empty-data.png" class="empty-img">
                        <div class="empty-title">Belum ada data Tenant</div>
                        <div class="empty-sub">
                            Silakan tambahkan tenant terlebih dahulu
                        </div>
                    </div>
                `
            }
        });

        // Buat wrapper untuk search + button
        $('#stockTable_filter')
            .wrap('<div class="table-action-wrapper"></div>');

        // Pindahkan tombol ke wrapper
        $('#btnContainer')
            .show()
            .appendTo('.table-action-wrapper');
    });
</script>

<!-- Script Add -->
<script>
    // Add Modal
    $(document).on('click','#btnAddRegistration',function(){

        $('#addRegistrationModal').modal('show');

        document.getElementById('addRegistrationContent').innerHTML = `
            <div class="text-center py-5">
                <i class="fas fa-spinner fa-spin fa-2x text-secondary"></i>
            </div>
        `;

        fetch('registration-add.php')
        .then(res => res.text())
        .then(html => {
            document.getElementById('addRegistrationContent').innerHTML = html;
        });

    });

    // Add Action
    $(document).on('submit','#addRegistrationForm',function(e){
        e.preventDefault();

        let formData = new FormData(this);

        fetch('registration-action.php?action=store',{
            method:'POST',
            body:formData
        })
        .then(res => res.json())
        .then(res => {

            if(res.status === 'success'){

                QToast('Berhasil', 'Data berhasil ditambahkan', 'success');

                $('#addRegistrationModal').modal('hide');

                setTimeout(() => {
                    location.reload();
                }, 1000);

            }else{

                QToast('Gagal', res.message || 'Terjadi kesalahan', 'error');

            }

        })
        .catch(() => {
            QToast('Error', 'Gagal memproses tambah data', 'error');
        });
    });
</script>

<!-- Script Edit -->
<script>
    // OPEN EDIT MODAL
    $(document).on('click','.editRegistrationBtn',function(){

        let id = $(this).data('id');

        $('#editRegistrationModal').modal('show');

        document.getElementById('editRegistrationContent').innerHTML = `
            <div class="text-center py-5">
                <i class="fas fa-spinner fa-spin fa-2x text-secondary"></i>
            </div>
        `;

        fetch('registration-edit.php?id=' + id)
        .then(res => res.text())
        .then(html => {
            document.getElementById('editRegistrationContent').innerHTML = html;
        });

    });

    // Edit Action
    $(document).on('submit','#editRegistrationForm',function(e){
        e.preventDefault();

        let formData = new FormData(this);
        let id = formData.get('id');

        fetch('registration-action.php?action=update&id='+id,{
            method:'POST',
            body:formData
        })
        .then(res => res.json())
        .then(res => {

            if(res.status === 'success'){

                QToast('Berhasil', 'Data berhasil diperbarui', 'success');

                $('#editRegistrationModal').modal('hide');

                setTimeout(() => {
                    location.reload();
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
    $(document).on('click','.deleteRegistrationBtn',function(){

        let id = $(this).data('id');
        let name = $(this).data('name');

        fetch('registration-action.php?action=destroy', {
            method: 'POST',
            body: new URLSearchParams({ id: id })
        })
        .then(res=>res.json())
        .then(res=>{

            if(res.status==='success'){

                QToast('Terhapus', 'Data berhasil dihapus', 'success');

                setTimeout(() => {
                    location.reload();
                }, 1000);
            }
        });
    });
</script>

</body>
</html>