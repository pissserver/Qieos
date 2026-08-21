<?php
include '../../sessions/session.php';
?>

<div class="table-mobile">
    <table class="table table-hover align-middle" id="stockTable">
        <thead>
            <tr style="font-size:13px;color:#64748b;">
                <th>Nama Update</th>
                <th class="text-center">Version</th>
                <th class="text-center">Type</th>
                <th class="text-center">Tanggal Update</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>

        <?php
        $q = mysqli_query($conn,"
        SELECT
            *
        FROM updates
        WHERE deleted_at IS NULL
        ORDER BY id DESC, update_date DESC
        ");
        while($d=mysqli_fetch_assoc($q)): ?>

        <tr class="stock-row">

            <td>
                <div class="product-wrap">

                    <div class="avatar">
                        <i class="fas fa-rocket"></i>
                    </div>

                    <div>
                        <div class="fw-bold">
                            <?= htmlspecialchars($d['update_name']) ?>
                        </div>

                        <small class="text-muted text-capitalize">
                            Update Log <?=htmlspecialchars($d['update_type']); ?>
                        </small>
                    </div>

                </div>
            </td>

            <td class="text-center">

                <span class="stock-badge
                    <?= $d['update_type'] === 'major' ? 'stock-danger' : ($d['update_type'] === 'minor' ? 'stock-success' : 'unit-badge'); ?>
                    text-capitalize">

                    <i class="fas fa-code-branch me-1"></i>
                    <?= htmlspecialchars($d['update_version']) ?>

                </span>

            </td>

            <td class="text-center">

                <span class="stock-badge
                    <?= $d['update_type'] === 'major' ? 'stock-danger' : ($d['update_type'] === 'minor' ? 'stock-success' : 'unit-badge'); ?>
                    text-capitalize">

                    <i class="fas fa-layer-group me-1"></i>
                    <?= htmlspecialchars($d['update_type']) ?>
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

                    $tgl = strtotime($d['update_date']);
                    echo date('d', $tgl) . ' ' . $bulan[(int)date('n', $tgl)] . ' ' . date('Y', $tgl) . ' | ' . date('h:i', $tgl);
                    ?>
                </span>

            </td>

            <td class="text-center">
                <button class="action-btn btn-show showUpdateBtn" data-id="<?= $d['id'] ?>">
                    <i class="fas fa-eye"></i>
                </button>

                <?php if($user['role'] == 'developer') : ?>
                <button class="action-btn btn-edit editUpdateBtn" data-id="<?= $d['id'] ?>">
                    <i class="fas fa-edit"></i>
                </button>

                <button class="action-btn btn-delete deleteUpdateBtn"
                    data-id="<?= $d['id'] ?>"
                    data-name="<?= $d['update_name'] ?>"
                    data-version="<?= $d['update_version'] ?>">
                    <i class="fas fa-trash"></i>
                </button>
                <?php endif; ?>
            </td>
        </tr>

        <?php endwhile; ?>

        </tbody>
    </table>
</div>
