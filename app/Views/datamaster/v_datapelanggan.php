<?= $this->extend('layout/dashboard') ?>

<?= $this->section('content') ?>

<!-- Statistik -->

<div class="row mb-4">


<div class="col-md-4 mb-3">
    <div class="stat-card">
        <p>Total Pelanggan</p>
        <h4><?= count($pelanggan) ?></h4>
    </div>
</div>

<div class="col-md-4 mb-3">
    <div class="stat-card">
        <p>Pelanggan Terdaftar</p>
        <h4>
            <?= count(array_filter($pelanggan, fn($p) => !empty($p['IdUser']))) ?>
        </h4>
    </div>
</div>

<div class="col-md-4 mb-3">
    <div class="stat-card">
        <p>Tanpa Akun</p>
        <h4>
            <?= count(array_filter($pelanggan, fn($p) => empty($p['IdUser']))) ?>
        </h4>
    </div>
</div>


</div>

<!-- Card Utama -->

<div class="card card-pengguna">


<div class="card-header card-header-pengguna">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

        <div>
            <h3>Data Pelanggan</h3>
            <!-- <small>Kelola seluruh data pelanggan sistem</small> -->
        </div>

        <div class="d-flex align-items-center gap-3 header-tools">

            <!-- Search -->
            <div class="search-wrapper">

                <i class="ti ti-search search-icon"></i>

                <input
                    type="text"
                    id="search-input"
                    class="form-control search-pengguna"
                    placeholder="Cari nama pelanggan atau nomor HP">

            </div>

            <!-- Tombol Tambah -->
            <button
                type="button"
                class="btn btn-tambah"
                onclick="window.location.href='<?= base_url('datapelanggan/tambah') ?>'">

                <i class="ti ti-user-plus me-1"></i>
                Tambah Pelanggan

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

        <table class="table table-bordered table-hover align-middle" id="datapelanggan">

            <thead>

                <tr>
                    <th width="60">No</th>
                    <th>ID Pelanggan</th>
                    <th>ID User</th>
                    <th>Nama Pelanggan</th>
                    <th>Alamat</th>
                    <th>No HP</th>
                    <th width="130">Aksi</th>
                </tr>

            </thead>

            <tbody>

                <?php if (!empty($pelanggan)) : ?>

                    <?php $no = 1; ?>

                    <?php foreach ($pelanggan as $row) : ?>

                        <tr>

                            <td class="text-center">
                                <?= $no++ ?>
                            </td>

                            <td>
                                <?= $row['IdPelanggan'] ?>
                            </td>

                            <td>

                                <?php if (!empty($row['IdUser'])) : ?>

                                    <span class="badge bg-primary">
                                        <?= $row['IdUser'] ?>
                                    </span>

                                <?php else : ?>

                                    <span class="text-muted">
                                        -
                                    </span>

                                <?php endif; ?>

                            </td>

                            <td>
                                <?= $row['NamaPelanggan'] ?>
                            </td>

                            <td>
                                <?= $row['Alamat'] ?: '-' ?>
                            </td>

                            <td>
                                <?= $row['NoHp'] ?>
                            </td>

                            <td class="text-center">

                                <!-- Edit -->
                                <a href="<?= base_url('datapelanggan/edit/' . $row['IdPelanggan']) ?>"
                                   class="btn btn-warning btn-sm">

                                    <i class="ti ti-edit"></i>

                                </a>

                                <!-- Hapus -->
                                <a href="<?= base_url('datapelanggan/hapus/' . $row['IdPelanggan']) ?>"
                                   class="btn btn-danger btn-sm btn-hapus">

                                    <i class="ti ti-trash"></i>

                                </a>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                <?php else : ?>

                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            Data pelanggan belum tersedia
                        </td>
                    </tr>

                <?php endif; ?>

                <!-- Pesan jika pencarian tidak ditemukan -->
                <tr id="no-result" style="display:none;">
                    <td colspan="7" class="text-center text-danger">
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
        let rows = document.querySelectorAll('#datapelanggan tbody tr');
        let found = false;

        rows.forEach(row => {

            // skip row no-result
            if (row.id === 'no-result') return;

            let nama = row.cells[3]?.innerText.toLowerCase() || '';
            let nohp = row.cells[5]?.innerText.toLowerCase() || '';

            if (
                nama.includes(keyword) ||
                nohp.includes(keyword)
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
    // KONFIRMASI HAPUS
    // =========================
    document.querySelectorAll('.btn-hapus').forEach(button => {

        button.addEventListener('click', function(e) {

            e.preventDefault();

            const url = this.getAttribute('href');

            Swal.fire({
                title: 'Hapus Pelanggan?',
                text: 'Data yang dihapus tidak dapat dikembalikan.',
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
