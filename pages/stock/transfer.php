<?php include '../../sessions/session.php'; ?>

<!doctype html>
<html>
    <head>
        <title>Transfer ke Penjualan - Qieos</title>
        <?php include '../../script/headscript.php'; ?>

        <link rel="stylesheet" href="/qieos/css/pages/transfer.css">
    </head>

    <body>
        <?php include '../components/sidebar.php'; ?>

        <main class="content">
            <?php include '../components/navbar.php'; ?>

            <div class="container-fluid px-0 mt-4">
                <!-- HEADER -->
                <!-- <div class="transfer-header mt-5">
                    <div>
                        <h3>Transfer ke Penjualan</h3>
                        <p class="mb-0">
                            Persetujuan request stok dari staff penjualan
                        </p>
                    </div>

                    <div class="transfer-icon">
                        <i class="fas fa-arrow-right-arrow-left"></i>
                    </div>
                </div> -->

                <!-- REQUEST PENDING -->
                <div class="section-card mb-4 mt-5">
                    <div class="panel-header panel-warning">
                        <div class="panel-left">
                            <div class="panel-icon">
                                <i class="fas fa-clock"></i>
                            </div>

                            <div>
                                <div class="panel-title">
                                    Request Pending
                                </div>
                                <div class="panel-subtitle">
                                    Menunggu approval transfer stok ke penjualan
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 px-4">
                        <div id="transfer-table"></div>
                    </div>
                </div>

                <!-- HISTORY -->
                <div class="section-card mb-5">
                    <div class="panel-header panel-dark">
                        <div class="panel-left">
                            <div class="panel-icon">
                                <i class="fas fa-history"></i>
                            </div>

                            <div>
                                <div class="panel-title">
                                    Riwayat Request
                                </div>
                                <div class="panel-subtitle">
                                    Histori seluruh permintaan stok gudang
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 px-4">
                        <div id="history-table"></div>
                    </div>
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

                        // ðŸ”¥ DESTROY DULU
                        if ($.fn.DataTable.isDataTable('#requestHistory')) {
                            $('#requestHistory').DataTable().destroy();
                        }

                        // ðŸ”¥ INIT ULANG
                        $('#requestHistory').DataTable({
                            pageLength: 5,
                            lengthMenu:[[5,10,25,50],[5,10,25,50]],
                            responsive: true,
                            autoWidth: false,
                            language:{
                                search:"",
                                searchPlaceholder:"Cari request...",

                                zeroRecords: `
                                    <div class="empty-search">
                                        <img src="../../assets/img/illustrations/empty-data.png" class="empty-img">
                                        <div class="empty-title">Request tidak ditemukan</div>
                                        <div class="empty-sub">
                                            Coba gunakan kata kunci lain
                                        </div>
                                    </div>
                                `,

                                emptyTable: `
                                    <div class="empty-search">
                                        <img src="../../assets/img/illustrations/empty-data.png" class="empty-img">
                                        <div class="empty-title">Belum ada data request</div>
                                        <div class="empty-sub">
                                            Silakan tambahkan stok terlebih dahulu
                                        </div>
                                    </div>
                                `
                            },

                            // ðŸ”¥ PENTING: IKUTIN SORT SQL
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


            // ðŸ”¥ APPROVE
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

                        fetch('transfer-action.php?action=approve',{
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

            // ðŸ”¥ REJECT
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

                        fetch('transfer-action.php?action=reject',{
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