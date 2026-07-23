<?= $this->extend('layout/dashboard') ?>

<?= $this->section('content') ?>

<!-- Statistik -->

<div class="row mb-4">


<div class="col-md-3 mb-3">
    <div class="stat-card">
        <p>Total Bahan</p>
        <h4><?= count($bahanbaku) ?></h4>
    </div>
</div>

<div class="col-md-3 mb-3">
    <div class="stat-card">
        <p>Total Stok</p>
        <h4><?= number_format(array_sum(array_column($bahanbaku, 'Stok')), 2) ?></h4>
    </div>
</div>

<div class="col-md-3 mb-3">
    <div class="stat-card">
        <p>Stok Menipis</p>
        <h4>
            <?= count(array_filter($bahanbaku, fn($b) => $b['Stok'] > 0 && $b['Stok'] <= 5)) ?>
        </h4>
    </div>
</div>

<div class="col-md-3 mb-3">
    <div class="stat-card">
        <p>Stok Habis</p>
        <h4>
            <?= count(array_filter($bahanbaku, fn($b) => $b['Stok'] <= 0)) ?>
        </h4>
    </div>
</div>


</div>

<!-- Card Utama -->

<div class="card card-pengguna">


<div class="card-header card-header-pengguna">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

        <div>
            <h3>Data Bahan Baku</h3>
        </div>

        <div class="d-flex align-items-center gap-3 header-tools">

            <!-- Search -->
            <div class="search-wrapper">

                <i class="ti ti-search search-icon"></i>

                <input
                    type="text"
                    id="search-input"
                    class="form-control search-pengguna"
                    placeholder="Cari nama bahan atau merk">

            </div>

            <!-- Tombol Tambah -->
            <button
                type="button"
                class="btn btn-tambah"
                onclick="window.location.href='<?= base_url('databahanbaku/tambah') ?>'">

                <i class="ti ti-plus me-1"></i>
                Tambah Bahan

            </button>

        </div>

    </div>

</div>

<div class="card-body">

    <!-- Flash Message -->
    <?php if (session()->getFlashdata('success')) : ?>

        <div class="alert alert-success alert-dismissible fade show" role="alert">

            <?= session()->getFlashdata('success') ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>

        </div>

    <?php endif; ?>

    <?php if (session()->getFlashdata('error')) : ?>

        <div class="alert alert-danger alert-dismissible fade show" role="alert">

            <?= session()->getFlashdata('error') ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>

        </div>

    <?php endif; ?>

    <div class="table-responsive">

        <table class="table table-bordered table-hover align-middle" id="databahanbaku">

            <thead>

                <tr>
                    <th width="60">No</th>
                    <th>ID Bahan</th>
                    <th>Nama Bahan</th>
                    <th>Satuan</th>
                    <th>Stok</th>
                    <th>Harga</th>
                    <th>Merk</th>
                    <th width="130">Aksi</th>
                </tr>

            </thead>

            <tbody>

                <?php if (!empty($bahanbaku)) : ?>

                    <?php $no = 1; ?>

                    <?php foreach ($bahanbaku as $row) : ?>

                        <tr>

                            <!-- No -->
                            <td class="text-center">
                                <?= $no++ ?>
                            </td>

                            <!-- ID -->
                            <td>
                                <span class="badge bg-primary">
                                    <?= $row['IdBahanBaku'] ?>
                                </span>
                            </td>

                            <!-- Nama -->
                            <td>
                                <strong><?= $row['NamaBahan'] ?></strong>
                            </td>

                            <!-- Satuan -->
                            <td>
                                <?= $row['Satuan'] ?>
                            </td>

                            <!-- Stok -->
                            <td>

                                <?php if ($row['Stok'] <= 0) : ?>

                                    <span class="badge bg-danger">
                                        Habis
                                    </span>

                                <?php elseif ($row['Stok'] <= 5) : ?>

                                    <span class="badge bg-warning text-dark">
                                        <?= number_format($row['Stok'], 2) ?>
                                    </span>

                                <?php else : ?>

                                    <span class="badge bg-success">
                                        <?= number_format($row['Stok'], 2) ?>
                                    </span>

                                <?php endif; ?>

                            </td>

                            <!-- Harga -->
                            <td>
                                <strong class="text-success">
                                    Rp <?= number_format($row['Harga'], 0, ',', '.') ?>
                                </strong>
                            </td>

                            <!-- Merk -->
                            <td>

                                <?php if (!empty($row['Merk'])) : ?>

                                    <?= $row['Merk'] ?>

                                <?php else : ?>

                                    <span class="text-muted">
                                        -
                                    </span>

                                <?php endif; ?>

                            </td>

                            <!-- Aksi -->
                            <td class="text-center">

                                <a href="<?= base_url('databahanbaku/edit/' . $row['IdBahanBaku']) ?>"
                                   class="btn btn-warning btn-sm">

                                    <i class="ti ti-edit"></i>

                                </a>

                                <a href="<?= base_url('databahanbaku/hapus/' . $row['IdBahanBaku']) ?>"
                                   class="btn btn-danger btn-sm btn-hapus">

                                    <i class="ti ti-trash"></i>

                                </a>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                <?php else : ?>

                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            Data bahan baku belum tersedia
                        </td>
                    </tr>

                <?php endif; ?>

                <!-- No Result -->
                <tr id="no-result" style="display:none;">
                    <td colspan="8" class="text-center text-danger">
                        Data tidak ditemukan
                    </td>
                </tr>

            </tbody>

        </table>

    </div>

</div>


</div>

<script>

    // =========================
    // SEARCH TABLE
    // =========================
    const searchInput = document.getElementById('search-input');

    searchInput.addEventListener('keyup', function() {

        let keyword = this.value.toLowerCase();
        let rows = document.querySelectorAll('#databahanbaku tbody tr');
        let found = false;

        rows.forEach(row => {

            if (row.id === 'no-result') return;

            let nama = row.cells[2]?.innerText.toLowerCase() || '';
            let merk = row.cells[6]?.innerText.toLowerCase() || '';

            if (
                nama.includes(keyword) ||
                merk.includes(keyword)
            ) {

                row.style.display = '';
                found = true;

            } else {

                row.style.display = 'none';

            }

        });

        document.getElementById('no-result').style.display =
            found ? 'none' : '';

    });


    // =========================
    // SWEETALERT HAPUS
    // =========================
    document.querySelectorAll('.btn-hapus').forEach(button => {

        button.addEventListener('click', function(e) {

            e.preventDefault();

            const url = this.getAttribute('href');

            Swal.fire({
                title: 'Hapus Bahan Baku?',
                text: 'Data bahan baku yang dihapus tidak dapat dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#4d4428',
                cancelButtonColor: '#dc3545',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {

                if (result.isConfirmed) {
                    window.location.href = url;
                }

            });

        });

    });

</script>

<?= $this->endSection() ?>
