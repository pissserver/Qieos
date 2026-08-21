<?php
include '../../sessions/session.php';
?>

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
