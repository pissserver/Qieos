<?php
include '../../sessions/session.php';
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Administrator - Qieos</title>
    <?php include '../../script/headscript.php'; ?>

    <link rel="stylesheet" href="/qieos/css/pages/administrator.css">
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
                                Administrator
                            </div>
                            <div class="panel-subtitle">
                                Ubah informasi administrator atau hapus dari daftar administrator
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
                            id="btnAddAdministrator">
                            <i class="fas fa-user-plus me-2"></i>
                            Tambah Administrator
                        </button>
                    </div>
                    
                    <!-- TABLE -->
                    <div class="table-responsive-wrap">
                        <table class="table table-hover align-middle" id="stockTable">
                            <thead>
                                <tr style="font-size:13px;color:#64748b;">
                                    <th>Nama</th>
                                    <th class="text-center">Role</th>
                                    <th class="text-center">Terbuat</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>

                            <?php
                            $q = mysqli_query($conn,"
                            SELECT
                                *
                            FROM users
                            WHERE role IN ('administrator', 'developer') 
                            ORDER BY fullname ASC
                            ");
                            while($d=mysqli_fetch_assoc($q)): ?>

                            <tr class="stock-row">

                                <td>
                                    <div class="product-wrap">

                                        <?php if(!empty($d['photo'])): ?>
                                            <img class="avatar-photo"
                                                src="/qieos/assets/img/uploads/<?= htmlspecialchars($d['photo']) ?>"
                                                alt="<?= htmlspecialchars($d['fullname']) ?>">
                                        <?php else: ?>
                                            <div class="avatar">
                                                <i class="fas fa-user"></i>
                                            </div>
                                        <?php endif; ?>

                                        <div>
                                            <div class="fw-bold">
                                                <?= htmlspecialchars($d['fullname']) ?>
                                            </div>

                                            <small class="text-muted text-capitalize">
                                                <?= htmlspecialchars($d['username']) ?>
                                            </small>
                                        </div>

                                    </div>
                                </td>

                                <td class="text-center">

                                    <span class="stock-badge <?php echo $d['role'] === 'developer' ? 'dev-badge' : 'unit-badge'; ?> text-capitalize">
                                        <?php if($d['role'] === 'developer'): ?>
                                            <i class="fas fa-crown me-1"></i>
                                        <?php else: ?>
                                            <i class="fas fa-user-shield me-1"></i>
                                        <?php endif; ?>
                                        <?= htmlspecialchars($d['role']) ?>
                                    </span>

                                </td>

                                <td class="text-center">

                                    <span class="unit-badge">
                                        <i class="fas fa-cubes me-1"></i>
                                        <?php
                                        $bulan = [
                                            1 => 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
                                            'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'
                                        ];

                                        $tgl = strtotime($d['created_at']);
                                        echo date('d', $tgl) . ' ' . $bulan[(int)date('n', $tgl)] . ' ' . date('Y', $tgl);
                                        ?>
                                    </span>

                                </td>

                                <td class="text-center">
                                    <?php if($d['role'] === 'developer'): ?>
                                        <span class="text-muted" style="font-size:13px;">
                                            <i class="fas fa-lock me-1"></i>
                                            Tidak dapat diubah
                                        </span>
                                    <?php elseif($d['username'] === $_SESSION['username']): ?>
                                        <span class="text-muted" style="font-size:13px;">
                                            <i class="fas fa-lock me-1"></i>
                                            Anda
                                        </span>
                                    <?php else: ?>
                                        <button class="action-btn btn-edit editAdministratorBtn" data-id="<?= $d['id'] ?>">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        <button class="action-btn btn-delete deleteAdministratorBtn"
                                            data-id="<?= $d['id'] ?>"
                                            data-fullname="<?= $d['fullname'] ?>">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    <?php endif; ?>
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
    <div class="modal fade" id="addAdministratorModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content stock-panel border-0">

                <div class="panel-header panel-dark my-3 mx-3">
                    <div class="panel-left">
                        <div class="panel-icon">
                            <i class="fas fas fa-user-plus"></i>
                        </div>

                        <div>
                            <div class="panel-title">
                                Tambah Administrator 
                            </div>
                            <div class="panel-subtitle">
                                Tambah nama, username, dan password
                            </div>
                        </div>
                    </div>

                    <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="mt-2 px-5" id="addAdministratorContent"></div>
            </div>
        </div>
    </div>

    <!-- EDIT MODAL -->
    <div class="modal fade" id="editAdministratorModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content stock-panel border-0">

                <div class="panel-header panel-dark my-3 mx-3">
                    <div class="panel-left">
                        <div class="panel-icon">
                            <i class="fas fas fa-user"></i>
                        </div>

                        <div>
                            <div class="panel-title">
                                Edit Administrator 
                            </div>
                            <div class="panel-subtitle">
                                Edit nama, username, dan password
                            </div>
                        </div>
                    </div>

                    <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="mt-2 px-5" id="editAdministratorContent"></div>
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
                searchPlaceholder:"Cari administrator...",

                zeroRecords: `
                    <div class="empty-search">
                        <img src="../../assets/img/illustrations/empty-data.png" class="empty-img">
                        <div class="empty-title">Administrator tidak ditemukan</div>
                        <div class="empty-sub">
                            Coba gunakan kata kunci lain
                        </div>
                    </div>
                `,

                emptyTable: `
                    <div class="empty-search">
                        <img src="../../assets/img/illustrations/empty-data.png" class="empty-img">
                        <div class="empty-title">Belum ada data administrator</div>
                        <div class="empty-sub">
                            Silakan tambahkan administrator terlebih dahulu
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
    $(document).on('click','#btnAddAdministrator',function(){

        $('#addAdministratorModal').modal('show');

        document.getElementById('addAdministratorContent').innerHTML = `
            <div class="text-center py-5">
                <i class="fas fa-spinner fa-spin fa-2x text-secondary"></i>
            </div>
        `;

        fetch('administrator-add.php')
        .then(res => res.text())
        .then(html => {
            document.getElementById('addAdministratorContent').innerHTML = html;
        });

    });

    // Add Action
    $(document).on('submit','#addAdministratorForm',function(e){
        e.preventDefault();

        let formData = new FormData(this);

        fetch('administrator-action.php?action=store',{
            method:'POST',
            body:formData
        })
        .then(res => res.json())
        .then(res => {

            if(res.status === 'success'){

                Swal.fire({
                    icon:'success',
                    title:'Berhasil',
                    text:'Data berhasil ditambahkan',
                    showConfirmButton:false
                });

                $('#addAdministratorModal').modal('hide');

                setTimeout(() => {
                    location.reload();
                }, 1000);

            }else{

                Swal.fire({
                    icon:'error',
                    title:'Gagal',
                    text:res.message || 'Terjadi kesalahan'
                });

            }

        })
        .catch(() => {
            Swal.fire(
                'Error',
                'Gagal memproses tambah data',
                'error'
            );
        });
    });
</script>

<!-- Script Edit -->
<script>
    // OPEN EDIT MODAL
    $(document).on('click','.editAdministratorBtn',function(){

        let id = $(this).data('id');

        $('#editAdministratorModal').modal('show');

        document.getElementById('editAdministratorContent').innerHTML = `
            <div class="text-center py-5">
                <i class="fas fa-spinner fa-spin fa-2x text-secondary"></i>
            </div>
        `;

        fetch('administrator-edit.php?id=' + id)
        .then(res => res.text())
        .then(html => {
            document.getElementById('editAdministratorContent').innerHTML = html;
        });

    });

    // Edit Action
    $(document).on('submit','#editAdministratorForm',function(e){
        e.preventDefault();

        let formData = new FormData(this);
        let id = formData.get('id');

        fetch('administrator-action.php?action=update&id='+id,{
            method:'POST',
            body:formData
        })
        .then(res => res.json())
        .then(res => {

            if(res.status === 'success'){

                Swal.fire({
                    icon:'success',
                    title:'Berhasil',
                    text:'Data berhasil diperbarui',
                    showConfirmButton:false
                });

                $('#editAdministratorModal').modal('hide');

                setTimeout(() => {
                    location.reload();
                }, 1000);

            }else{

                Swal.fire({
                    icon:'error',
                    title:'Gagal',
                    text:res.message || 'Terjadi kesalahan'
                });

            }

        })
        .catch(() => {
            Swal.fire(
                'Error',
                'Gagal memproses update',
                'error'
            );
        });
    });
</script>

<!-- Script Delete -->
<script>
    // Delete Action
    $(document).on('click','.deleteAdministratorBtn',function(){

        let id = $(this).data('id');
        let fullname = $(this).data('fullname');

        Swal.fire({
            title:'Hapus Administrator?',
            html:`
                <div style="text-align:center">
                    <small style="color:#94a3b8">Nama administrator:</small><br>
                    ${fullname}
                </div>
            `,
            icon:'warning',
            showCancelButton:true,
            confirmButtonText:'Ya, Hapus',
            cancelButtonText:'Batal',
            confirmButtonColor:'#dc2626'
        }).then((result)=>{

            if(result.isConfirmed){

                fetch('administrator-action.php?action=destroy', {
                    method: 'POST',
                    body: new URLSearchParams({ id: id })
                })
                .then(res=>res.json())
                .then(res=>{

                    if(res.status==='success'){

                        Swal.fire({
                            icon:'success',
                            title:'Terhapus',
                            text:'Data berhasil dihapus',
                            timer:1500,
                            showConfirmButton:false
                        });

                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    }
                });
            }
        });
    });
</script>

</body>
</html>