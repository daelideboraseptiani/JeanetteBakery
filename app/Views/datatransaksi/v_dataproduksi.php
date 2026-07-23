<?= $this->extend('layout/dashboard') ?>

<?= $this->section('content') ?>

<!-- Statistik -->

<div class="row mb-4">


    <div class="col-md-3 mb-3">
        <div class="stat-card">
            <p>Total Produksi</p>
            <h4><?= count($produksi) ?></h4>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="stat-card">
            <p>Diproduksi</p>
            <h4>
                <?= count(array_filter($produksi, fn($p) => $p['StatusProduksi'] == 'Diproduksi')) ?>
            </h4>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="stat-card">
            <p>Selesai</p>
            <h4>
                <?= count(array_filter($produksi, fn($p) => $p['StatusProduksi'] == 'Selesai')) ?>
            </h4>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="stat-card">
            <p>Stok Belum Update</p>
            <h4>
                <?= count(array_filter($produksi, fn($p) => $p['StatusUpdateStok'] == 'Belum')) ?>
            </h4>
        </div>
    </div>


</div>

<!-- Card Utama -->

<div class="card card-pengguna">


    <div class="card-header card-header-pengguna">

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

            <div>
                <h3>Data Produksi</h3>
            </div>

            <div class="d-flex align-items-center gap-3 header-tools">

                <!-- Search -->
                <div class="search-wrapper">

                    <i class="ti ti-search search-icon"></i>

                    <input
                        type="text"
                        id="search-input"
                        class="form-control search-pengguna"
                        placeholder="Cari produk atau tanggal produksi">

                </div>

                <!-- Tombol Tambah -->
                <button
                    type="button"
                    class="btn btn-tambah"
                    onclick="window.location.href='<?= base_url('dataproduksi/tambah') ?>'">

                    <i class="ti ti-plus me-1"></i>
                    Tambah Produksi

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

            <table class="table table-bordered table-hover align-middle" id="dataproduksi">

                <thead>

                    <tr>
                        <th width="60">No</th>
                        <th>ID Produksi</th>
                        <th>Produk</th>
                        <th>Tanggal Produksi</th>
                        <th>Jumlah Produksi</th>
                        <th>Hasil Produksi</th>
                        <th>Status Produksi</th>
                        <th>Status Update Stok</th>
                        <th width="130">Aksi</th>
                    </tr>

                </thead>

                <tbody>

                    <?php if (!empty($produksi)) : ?>

                        <?php $no = 1; ?>

                        <?php foreach ($produksi as $row) : ?>

                            <tr>

                                <!-- No -->
                                <td class="text-center">
                                    <?= $no++ ?>
                                </td>

                                <!-- ID -->
                                <td>
                                    <span class="badge bg-primary">
                                        <?= $row['IdProduksi'] ?>
                                    </span>
                                </td>

                                <!-- Produk -->
                                <td>
                                    <strong><?= $row['NamaProduk'] ?></strong>
                                </td>

                                <!-- Tanggal -->
                                <td>
                                    <?= date('d-m-Y', strtotime($row['TglProduksi'])) ?>
                                </td>

                                <!-- Jumlah Produksi -->
                                <td>
                                    <?= number_format($row['JumlahProduksi'], 2) ?>
                                </td>

                                <!-- Hasil Produksi -->
                                <td>
                                    <strong class="text-success">
                                        <?= number_format($row['HasilProduksi'], 2) ?>
                                    </strong>
                                </td>

                                <!-- Status Produksi -->
                                <td>

                                    <?php if ($row['StatusProduksi'] == 'Selesai') : ?>

                                        <span class="badge bg-success">
                                            Selesai
                                        </span>

                                    <?php else : ?>

                                        <span class="badge bg-warning text-dark">
                                            Diproduksi
                                        </span>

                                    <?php endif; ?>

                                </td>

                                <!-- Status Update Stok -->
                                <td>

                                    <?php if ($row['StatusUpdateStok'] == 'Sudah') : ?>

                                        <span class="badge bg-success">
                                            Sudah
                                        </span>

                                    <?php else : ?>

                                        <span class="badge bg-danger">
                                            Belum
                                        </span>

                                    <?php endif; ?>

                                </td>

                                <!-- Aksi -->
                                <td class="text-center">

                                    <?php if ($row['StatusUpdateStok'] == 'Belum') : ?>

                                        <!-- UPDATE STOK KEMASAN -->
                                        <a href="<?= base_url('dataproduksi/updatestok/' . $row['IdProduksi']) ?>"
                                            class="btn btn-success btn-sm"
                                            title="Update Stok Kemasan">

                                            <i class="ti ti-package"></i>

                                        </a>

                                        <!-- EDIT -->
                                        <a href="<?= base_url('dataproduksi/edit/' . $row['IdProduksi']) ?>"
                                            class="btn btn-warning btn-sm"
                                            title="Edit Produksi">

                                            <i class="ti ti-edit"></i>

                                        </a>

                                        <!-- HAPUS -->
                                        <a href="<?= base_url('dataproduksi/hapus/' . $row['IdProduksi']) ?>"
                                            class="btn btn-danger btn-sm btn-hapus"
                                            title="Hapus Produksi">

                                            <i class="ti ti-trash"></i>

                                        </a>

                                    <?php else : ?>

                                        <!-- SUDAH FINAL -->
                                        <span class="badge bg-success px-3 py-2">
                                            <i class="ti ti-check me-1"></i> Produksi Final
                                        </span>

                                    <?php endif; ?>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    <?php else : ?>

                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">
                                Data produksi belum tersedia
                            </td>
                        </tr>

                    <?php endif; ?>

                    <!-- No Result -->
                    <tr id="no-result" style="display:none;">
                        <td colspan="9" class="text-center text-danger">
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
        let rows = document.querySelectorAll('#dataproduksi tbody tr');
        let found = false;

        rows.forEach(row => {

            if (row.id === 'no-result') return;

            let produk = row.cells[2]?.innerText.toLowerCase() || '';
            let tanggal = row.cells[3]?.innerText.toLowerCase() || '';

            if (
                produk.includes(keyword) ||
                tanggal.includes(keyword)
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
                title: 'Hapus Produksi?',
                text: 'Data produksi dan detail bahan baku akan dihapus.',
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