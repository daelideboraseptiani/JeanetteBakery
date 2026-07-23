<?= $this->extend('layout/dashboard') ?>

<?= $this->section('content') ?>

<!-- Statistik -->

<div class="row mb-4">


<div class="col-md-3 mb-3">
    <div class="stat-card">
        <p>Total Kemasan</p>
        <h4><?= count($kemasan) ?></h4>
    </div>
</div>

<div class="col-md-3 mb-3">
    <div class="stat-card">
        <p>Kemasan Aktif</p>
        <h4>
            <?= count(array_filter($kemasan, fn($k) => $k['StatusKemasan'] == 'Aktif')) ?>
        </h4>
    </div>
</div>

<div class="col-md-3 mb-3">
    <div class="stat-card">
        <p>Total Stok</p>
        <h4><?= array_sum(array_column($kemasan, 'Stok')) ?></h4>
    </div>
</div>

<div class="col-md-3 mb-3">
    <div class="stat-card">
        <p>Stok Habis</p>
        <h4>
            <?= count(array_filter($kemasan, fn($k) => $k['Stok'] <= 0)) ?>
        </h4>
    </div>
</div>


</div>

<!-- Card Utama -->

<div class="card card-pengguna">


<div class="card-header card-header-pengguna">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

        <div>
            <h3>Data Kemasan</h3>
        </div>

        <div class="d-flex align-items-center gap-3 header-tools">

            <!-- Search -->
            <div class="search-wrapper">

                <i class="ti ti-search search-icon"></i>

                <input
                    type="text"
                    id="search-input"
                    class="form-control search-pengguna"
                    placeholder="Cari produk atau kemasan">

            </div>

            <!-- Tombol Tambah -->
            <button
                type="button"
                class="btn btn-tambah"
                onclick="window.location.href='<?= base_url('datakemasan/tambah') ?>'">

                <i class="ti ti-plus me-1"></i>
                Tambah Kemasan

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

        <table class="table table-bordered table-hover align-middle" id="datakemasan">

            <thead>

                <tr>
                    <th width="60">No</th>
                    <th>Foto</th>
                    <th>ID Kemasan</th>
                    <th>Produk</th>
                    <th>Nama Kemasan</th>
                    <th>Berat</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Status</th>
                    <th width="130">Aksi</th>
                </tr>

            </thead>

            <tbody>

                <?php if (!empty($kemasan)) : ?>

                    <?php $no = 1; ?>

                    <?php foreach ($kemasan as $row) : ?>

                        <tr>

                            <!-- No -->
                            <td class="text-center">
                                <?= $no++ ?>
                            </td>

                            <!-- Foto -->
                            <td class="text-center">

                                <?php if (!empty($row['Foto'])) : ?>

                                    <img
                                        src="<?= base_url('storage/fotokemasan/' . $row['Foto']) ?>"
                                        alt="Foto Kemasan"
                                        width="60"
                                        height="60"
                                        class="rounded border"
                                        style="object-fit: cover;">

                                <?php else : ?>

                                    <div class="bg-light border rounded d-flex align-items-center justify-content-center"
                                         style="width:60px;height:60px;">

                                        <i class="ti ti-photo text-muted fs-4"></i>

                                    </div>

                                <?php endif; ?>

                            </td>

                            <!-- ID -->
                            <td>
                                <span class="badge bg-primary">
                                    <?= $row['IdKemasan'] ?>
                                </span>
                            </td>

                            <!-- Produk -->
                            <td>
                                <strong><?= $row['NamaProduk'] ?></strong>
                            </td>

                            <!-- Nama Kemasan -->
                            <td><?= $row['NamaKemasan'] ?></td>

                            <!-- Berat -->
                            <td>
                                <?= $row['Berat'] . ' ' . $row['SatuanBerat'] ?>
                            </td>

                            <!-- Harga -->
                            <td>
                                <strong class="text-success">
                                    Rp <?= number_format($row['Harga'], 0, ',', '.') ?>
                                </strong>
                            </td>

                            <!-- Stok -->
                            <td>

                                <?php if ($row['Stok'] <= 0) : ?>

                                    <span class="badge bg-danger">Habis</span>

                                <?php elseif ($row['Stok'] <= 10) : ?>

                                    <span class="badge bg-warning text-dark">
                                        <?= $row['Stok'] ?>
                                    </span>

                                <?php else : ?>

                                    <span class="badge bg-success">
                                        <?= $row['Stok'] ?>
                                    </span>

                                <?php endif; ?>

                            </td>

                            <!-- Status -->
                            <td>

                                <?php if ($row['StatusKemasan'] == 'Aktif') : ?>

                                    <span class="badge bg-success">Aktif</span>

                                <?php else : ?>

                                    <span class="badge bg-danger">Nonaktif</span>

                                <?php endif; ?>

                            </td>

                            <!-- Aksi -->
                            <td class="text-center">

                                <a href="<?= base_url('datakemasan/edit/' . $row['IdKemasan']) ?>"
                                   class="btn btn-warning btn-sm">

                                    <i class="ti ti-edit"></i>

                                </a>

                                <a href="<?= base_url('datakemasan/hapus/' . $row['IdKemasan']) ?>"
                                   class="btn btn-danger btn-sm btn-hapus">

                                    <i class="ti ti-trash"></i>

                                </a>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                <?php else : ?>

                    <tr>
                        <td colspan="10" class="text-center text-muted py-4">
                            Data kemasan belum tersedia
                        </td>
                    </tr>

                <?php endif; ?>

                <!-- No Result -->
                <tr id="no-result" style="display:none;">
                    <td colspan="10" class="text-center text-danger">
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
        let rows = document.querySelectorAll('#datakemasan tbody tr');
        let found = false;

        rows.forEach(row => {

            if (row.id === 'no-result') return;

            let produk = row.cells[3]?.innerText.toLowerCase() || '';
            let namaKemasan = row.cells[4]?.innerText.toLowerCase() || '';

            if (
                produk.includes(keyword) ||
                namaKemasan.includes(keyword)
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
                title: 'Hapus Kemasan?',
                text: 'Foto dan data kemasan akan dihapus permanen.',
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
