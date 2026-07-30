<?php
include '../../sessions/session.php';
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Input Pembelian - Qieos</title>
<?php include '../../script/headscript.php'; ?>

<style>
    :root{
        --primary:#1e293b;
        --primary-dark:#0f172a;
        --accent:#334155;
        --soft:#f8fafc;
        --border:#cbd5e1;
        --text:#0f172a;
        --muted:#64748b;
        --badge:#e2e8f0;
    }

    /* SECTION */

    .section-card{
        background:#fff;
        border-radius:24px;
        padding:24px;
        box-shadow:0 8px 24px rgba(15,23,42,.05);
    }

    /* PANEL */
            
    .panel-header{
        display:flex;
        justify-content:space-between;
        align-items:center;
        padding:18px 22px;
        border-radius:18px;
    }

    .panel-left{
        display:flex;
        align-items:center;
        gap:16px;
    }

    .panel-icon{
        width:58px;
        height:58px;
        border-radius:16px;
        background:rgba(255,255,255,.12);
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:22px;
    }

    .panel-title{
        font-size:17px;
        font-weight:700;
    }

    .panel-subtitle{
        font-size:13px;
        opacity:.85;
    }

    .panel-primary{
        background:linear-gradient(
            135deg,
            #4f46e5,
            #4338ca
        );
        color:#fff;
    }


    .panel-dark{
        background:linear-gradient(
            135deg,
            #334155,
            #0f172a
        );
        color:#fff;
    }

    .panel-toggle-wrap{
        display:flex;
        align-items:center;
        gap:10px;
    }

    .toggle-label{
        font-size:13px;
        color:#cbd5e1;
        font-weight:500;
        transition:.25s;
    }

    .toggle-label.active{
        color:#fff;
        font-weight:700;
    }

    .switch-toggle{
        position:relative;
        display:inline-block;
        width:54px;
        height:28px;
    }

    .switch-toggle input{
        opacity:0;
        width:0;
        height:0;
    }

    .slider-toggle{
        position:absolute;
        cursor:pointer;
        inset:0;
        background:#475569;
        border-radius:50px;
        transition:.3s;
    }

    .slider-toggle:before{
        content:"";
        position:absolute;
        width:22px;
        height:22px;
        left:3px;
        top:3px;
        background:#fff;
        border-radius:50%;
        transition:.3s;
    }

    .switch-toggle input:checked + .slider-toggle{
        background:#22c55e;
    }

    .switch-toggle input:checked + .slider-toggle:before{
        transform:translateX(26px);
    }

    .panel-mode{
        display:none;
        animation:fadeSlide .3s ease;
    }

    .panel-mode.active{
        display:block;
    }

    @keyframes fadeSlide{
        from{
            opacity:0;
            transform:translateY(8px);
        }
        to{
            opacity:1;
            transform:translateY(0);
        }
    }

    /* SECTION */
    .section-title{
        display:inline-block;
        background:#edf4ff;
        color:var(--primary-dark);
        padding:5px 12px;
        border-radius:7px;
        font-size:12px;
        font-weight:600;
        margin-bottom:14px;
    }

    /* FORM */
    .input-group-modern{
        display:flex;
        align-items:center;
        margin-bottom:14px;
    }

    .input-icon{
        width:42px;
        height:42px;
        border-radius:10px;
        background:linear-gradient(135deg,#334155,#1e293b);
        display:flex;
        align-items:center;
        justify-content:center;
        color:#fff;
        margin-right:10px;
        box-shadow:0 4px 10px rgba(15,23,42,.18);
    }

    .form-control{
        height:42px;
        border-radius:8px;
        border:1px solid var(--border);
        font-size:14px;
    }

    textarea.form-control{
        height:65px;
    }

    .form-control:focus{
        border-color:var(--primary);
        box-shadow:0 0 0 3px rgba(63,130,196,.15);
    }

    /* BUTTON */
    .btn-save{
        background:linear-gradient(90deg,#1e293b,#334155);
        border:none;
        border-radius:8px;
        color:#fff;
        padding:10px 24px;
        font-weight:600;
    }

    .btn-prev-form{
        background:#334155;
        color:#fff;
        border:none;
        padding:11px 18px;
        border-radius:10px;
        font-weight:600;
    }

    .btn-change-form{
        background:#0f172a;
        color:#fff;
        border:none;
        padding:11px 18px;
        border-radius:10px;
        font-weight:600;
    }

    .btn-prev-form:hover,
    .btn-change-form:hover{
        opacity:.9;
    }

    /* DATATABLE */
    .dataTables_filter input{
        border-radius:8px !important;
        border:1px solid #cbd5e1 !important;
        padding:8px 14px !important;
        width:180px !important;
    }

    .dataTables_length select{
        min-width:75px !important;
        height:38px !important;
        padding:0 30px 0 12px !important;
        border-radius:8px !important;
        border:1px solid #cbd5e1 !important;
    }

    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter{
        margin-bottom:18px;
    }

    .empty-search{
        padding:50px 20px;
        text-align:center;
    }

    .empty-img{
        width:370px;
        opacity:.9;
        margin-bottom:18px;
    }

    .empty-title{
        font-size:18px;
        font-weight:700;
        color:#0f172a;
        margin-bottom:6px;
    }

    .empty-sub{
        font-size:14px;
        color:#64748b;
    }

    .modal-backdrop.show{
        opacity:.55 !important;
    }

    #editAdditionalModal .modal-content{
        background:#fff !important;
        border-radius:16px !important;
        overflow:hidden;
        box-shadow:0 20px 40px rgba(15,23,42,.25);
    }

    #editAdditionalModal .stock-body{
        background:#fff !important;
    }

    #editAdditionalModal .modal-dialog{
        max-width:1200px;
    }

    #editAdditionalModal .btn-close{
        filter:brightness(0) invert(1);
        opacity:.85;
    }

    #editAdditionalModal .modal-content *{
        opacity:1 !important;
    }
</style>

</head>

<body>

<?php include '../components/sidebar.php'; ?>

<main class="content">
<?php include '../components/navbar.php'; ?>

<div class="container-fluid px-0 mt-5">
    <!-- FORM -->
    <div class="section-card mb-4">
        <div class="panel-header panel-dark">
            <div class="panel-left">
                <div class="panel-icon">
                    <i class="fas fas fa-file-alt"></i>
                </div>

                <div>
                    <div class="panel-title">
                        Produk Tambahan
                    </div>
                    <div class="panel-subtitle">
                        Tambahkan beberapa produk tambahan untuk penjualan
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4 px-4">
            <div class="stock-body">

                <div id="formMode" class="panel-mode active">
                    <form id="form-stock" action="additional-action.php?action=store" method="POST" enctype="multipart/form-data">

                        <!-- INFORMASI PRODUK -->
                        <div class="section-title">Informasi Produk</div>

                        <div class="row">

                            <!-- NAMA -->
                            <div class="col-md-3">
                                <div class="input-group-modern">
                                    <div class="input-icon">
                                        <i class="fas fa-box"></i>
                                    </div>

                                    <input type="text"
                                        name="product_name"
                                        id="productName"
                                        class="form-control"
                                        placeholder="Nama Produk"
                                        required>
                                </div>
                            </div>

                            <!-- KATEGORI -->
                            <div class="col-md-3">
                                <div class="input-group-modern">
                                    <div class="input-icon">
                                        <i class="fas fa-tags"></i>
                                    </div>

                                    <input type="text"
                                        name="category"
                                        id="category"
                                        class="form-control"
                                        placeholder="Kategori Additional"
                                        required
                                        readonly>
                                </div>
                            </div>

                            <!-- FOTO -->
                            <div class="col-md-3">
                                <div class="input-group-modern">
                                    <div class="input-icon">
                                        <i class="fas fa-image"></i>
                                    </div>

                                    <input type="file"
                                        name="photo"
                                        class="form-control">
                                </div>
                            </div>

                            <!-- HARGA JUAL -->
                            <div class="col-md-3">
                                <div class="input-group-modern">
                                    <div class="input-icon">
                                        <i class="fas fa-coins"></i>
                                    </div>

                                    <input type="number"
                                        name="sell_price"
                                        class="form-control"
                                        placeholder="Harga Jual"
                                        required>
                                </div>
                            </div>
                        </div>

                        <!-- ACTION -->
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <button type="submit" class="btn-save">
                                <i class="fas fa-save me-1"></i>
                                Simpan
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>    

    <!-- TABLE -->
    <div class="section-card mb-5">
        <div class="panel-header panel-primary">
            <div class="panel-left">
                <div class="panel-icon">
                    <i class="fas fa-boxes-stacked"></i>
                </div>

                <div>
                    <div class="panel-title">
                        Daftar Produk Tambahan 
                    </div>
                    <div class="panel-subtitle">
                        List produk tambahan yang akan ditampilkan pada katalog penjualan
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4 px-4">
            <div id="additional-table"></div>
        </div>
    </div>
</div>
</main>

<!-- EDIT MODAL -->
<div class="modal fade" id="editAdditionalModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content stock-panel border-0">

            <div class="panel-header panel-dark my-3 mx-3">
                <div class="panel-left">
                    <div class="panel-icon">
                        <i class="fas fas fa-file-alt"></i>
                    </div>

                    <div>
                        <div class="panel-title">
                            Edit Produk Tambahan 
                        </div>
                        <div class="panel-subtitle">
                            Edit informasi produk tambahan
                        </div>
                    </div>
                </div>

                <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="mt-2 px-5" id="editAdditionalContent"></div>
        </div>
    </div>
</div>

<?php include '../../script/footscript.php'; ?>

<script>
    document.getElementById("form-stock").addEventListener("submit", function(e){
        e.preventDefault();

        let formData = new FormData(this);

        fetch(this.action,{
            method:"POST",
            body:formData
        })
        .then(res=>res.json())
        .then(res=>{
            if(res.status==="success"){
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: res.msg,
                    timer: 1500,
                    showConfirmButton: false
                });
                this.reset();
                loadTable();
            }else{
                Swal.fire("Error",res.msg,"error");
            }
        });
    });

    function loadTable(){
        fetch('additional-table.php')
        .then(res=>res.text())
        .then(html=>{
            document.getElementById("additional-table").innerHTML=html;

            setTimeout(()=>{
                $('#stockTable').DataTable({
                    pageLength:5,
                    lengthMenu:[[5,10,25,50],[5,10,25,50]],
                    responsive:true,
                    autoWidth:false,
                    language:{
                        search:"",
                        searchPlaceholder:"Cari produk...",

                        zeroRecords: `
                            <div class="empty-search">
                                <img src="../../assets/img/illustrations/empty-data.png" class="empty-img">
                                <div class="empty-title">Produk tidak ditemukan</div>
                                <div class="empty-sub">
                                    Coba gunakan kata kunci lain
                                </div>
                            </div>
                        `,

                        emptyTable: `
                            <div class="empty-search">
                                <img src="../../assets/img/illustrations/empty-data.png" class="empty-img">
                                <div class="empty-title">Belum ada data produk</div>
                                <div class="empty-sub">
                                    Silakan tambahkan stok terlebih dahulu
                                </div>
                            </div>
                        `
                    }
                });
            },100);
        });
    }

    loadTable();
</script>

<!-- Script Edit -->
<script>
    // OPEN EDIT MODAL
    $(document).on('click','.editAdditionalBtn',function(){

        let id = $(this).data('id');

        $('#editAdditionalModal').modal('show');

        document.getElementById('editAdditionalContent').innerHTML = `
            <div class="text-center py-5">
                <i class="fas fa-spinner fa-spin fa-2x text-secondary"></i>
            </div>
        `;

        fetch('additional-edit.php?id=' + id)
        .then(res => res.text())
        .then(html => {
            document.getElementById('editAdditionalContent').innerHTML = html;
        });

    });

    // Edit Action
    $(document).on('submit','#editAdditionalForm',function(e){
        e.preventDefault();

        let formData = new FormData(this);
        let id = formData.get('id');

        fetch('additional-action.php?action=update&id='+id,{
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

                $('#editAdditionalModal').modal('hide');

                loadTable();

            }else{

                Swal.fire({
                    icon:'error',
                    title:'Gagal',
                    text:res.msg || 'Terjadi kesalahan'
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
    $(document).on('click','.deleteAdditionalBtn',function(){

        let id = $(this).data('id');
        let name = $(this).data('name');

        Swal.fire({
            title:'Hapus Produk Tambahan?',
            html:`
                <div style="text-align:center">
                    ${name}
                </div>
            `,
            icon:'warning',
            showCancelButton:true,
            confirmButtonText:'Ya, Hapus',
            cancelButtonText:'Batal',
            confirmButtonColor:'#dc2626'
        }).then((result)=>{

            if(result.isConfirmed){

                fetch('additional-action.php?action=destroy', {
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