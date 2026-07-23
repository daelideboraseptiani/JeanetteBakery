<?= $this->extend('layout/dashboard') ?>

<?= $this->section('content') ?>

<!-- Statistik -->

<div class="row mb-4">


<div class="col-md-4 mb-3">
    <div class="stat-card">
        <p>Total Produk</p>
        <h4><?= count($produk) ?></h4>
    </div>
</div>

<div class="col-md-4 mb-3">
    <div class="stat-card">
        <p>Produk Aktif</p>
        <h4>
            <?= count(array_filter($produk, fn($p) => $p['StatusProduk'] == 'Aktif')) ?>
        </h4>
    </div>
</div>

<div class="col-md-4 mb-3">
    <div class="stat-card">
        <p>Produk Nonaktif</p>
        <h4>
            <?= count(array_filter($produk, fn($p) => $p['StatusProduk'] == 'Nonaktif')) ?>
        </h4>
    </div>
</div>


</div>

<!-- Card Utama -->

<div class="card card-pengguna">


<div class="card-header card-header-pengguna">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

        <div>
            <h3>Data Produk</h3>
            <!-- <small>Kelola seluruh data produk kue kering</small> -->
        </div>

        <div class="d-flex align-items-center gap-3 header-tools">

            <!-- Search -->
            <div class="search-wrapper">

                <i class="ti ti-search search-icon"></i>

                <input
                    type="text"
                    id="search-input"
                    class="form-control search-pengguna"
                    placeholder="Cari nama produk">

            </div>

            <!-- Tombol Tambah -->
            <button
                type="button"
                class="btn btn-tambah"
                onclick="window.location.href='<?= base_url('dataproduk/tambah') ?>'">

                <i class="ti ti-plus me-1"></i>
                Tambah Produk

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

        <table class="table table-bordered table-hover align-middle" id="dataproduk">

            <thead>

                <tr>
                    <th width="60">No</th>
                    <th>ID Produk</th>
                    <th>Nama Produk</th>
                    <th>Deskripsi</th>
                    <th>Status</th>
                    <th width="130">Aksi</th>
                </tr>

            </thead>

            <tbody>

                <?php if (!empty($produk)) : ?>

                    <?php $no = 1; ?>

                    <?php foreach ($produk as $row) : ?>

                        <tr>

                            <td class="text-center">
                                <?= $no++ ?>
                            </td>

                            <td>
                                <span class="badge bg-primary">
                                    <?= $row['IdProduk'] ?>
                                </span>
                            </td>

                            <td>
                                <strong><?= $row['NamaProduk'] ?></strong>
                            </td>

                            <td>

                                <?php if (!empty($row['Deskripsi'])) : ?>

                                    <?= $row['Deskripsi'] ?>

                                <?php else : ?>

                                    <span class="text-muted">
                                        Tidak ada deskripsi
                                    </span>

                                <?php endif; ?>

                            </td>

                            <td>

                                <?php if ($row['StatusProduk'] == 'Aktif') : ?>

                                    <span class="badge bg-success">
                                        Aktif
                                    </span>

                                <?php else : ?>

                                    <span class="badge bg-danger">
                                        Nonaktif
                                    </span>

                                <?php endif; ?>

                            </td>

                            <td class="text-center">

                                <!-- Edit -->
                                <a href="<?= base_url('dataproduk/edit/' . $row['IdProduk']) ?>"
                                   class="btn btn-warning btn-sm">

                                    <i class="ti ti-edit"></i>

                                </a>

                                <!-- Hapus -->
                                <a href="<?= base_url('dataproduk/hapus/' . $row['IdProduk']) ?>"
                                   class="btn btn-danger btn-sm btn-hapus">

                                    <i class="ti ti-trash"></i>

                                </a>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                <?php else : ?>

                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            Data produk belum tersedia
                        </td>
                    </tr>

                <?php endif; ?>

                <!-- Pesan jika pencarian tidak ditemukan -->
                <tr id="no-result" style="display:none;">
                    <td colspan="6" class="text-center text-danger">
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
        let rows = document.querySelectorAll('#dataproduk tbody tr');
        let found = false;

        rows.forEach(row => {

            // skip row no-result
            if (row.id === 'no-result') return;

            let nama = row.cells[2]?.innerText.toLowerCase() || '';

            if (nama.includes(keyword)) {

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
    // KONFIRMASI HAPUS
    // =========================
    document.querySelectorAll('.btn-hapus').forEach(button => {

        button.addEventListener('click', function(e) {

            e.preventDefault();

            const url = this.getAttribute('href');

            Swal.fire({
                title: 'Hapus Produk?',
                text: 'Data produk yang dihapus tidak dapat dikembalikan.',
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
