<?= $this->extend('layout/dashboard') ?>

<?= $this->section('content') ?>

<!-- ===================================================== -->

<!-- STATISTIK -->

<!-- ===================================================== -->

<div class="row mb-4">


<div class="col-md-3 mb-3">

    <div class="stat-card">
        <p>Total Pesanan</p>
        <h4><?= count($pesanan) ?></h4>
    </div>

</div>

<div class="col-md-3 mb-3">

    <div class="stat-card">
        <p>Menunggu</p>
        <h4>
            <?= count(array_filter($pesanan, fn($p) => $p['StatusPesanan'] == 'Menunggu')) ?>
        </h4>
    </div>

</div>

<div class="col-md-3 mb-3">

    <div class="stat-card">
        <p>Diproses</p>
        <h4>
            <?= count(array_filter($pesanan, fn($p) => $p['StatusPesanan'] == 'Diproses')) ?>
        </h4>
    </div>

</div>

<div class="col-md-3 mb-3">

    <div class="stat-card">
        <p>Selesai</p>
        <h4>
            <?= count(array_filter($pesanan, fn($p) => $p['StatusPesanan'] == 'Selesai')) ?>
        </h4>
    </div>

</div>


</div>

<!-- ===================================================== -->

<!-- CARD UTAMA -->

<!-- ===================================================== -->

<div class="card card-pengguna">


<div class="card-header card-header-pengguna">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

        <div>
            <h3>Data Pesanan</h3>
            <small>Kelola seluruh transaksi pesanan pelanggan</small>
        </div>

        <div class="d-flex align-items-center gap-3 header-tools">

            <!-- SEARCH -->
            <div class="search-wrapper">

                <i class="ti ti-search search-icon"></i>

                <input
                    type="text"
                    id="search-input"
                    class="form-control search-pengguna"
                    placeholder="Cari pelanggan atau ID pesanan">

            </div>

            <!-- TAMBAH -->
            <button
                type="button"
                class="btn btn-tambah"
                onclick="window.location.href='<?= base_url('datapesanan/tambah') ?>'">

                <i class="ti ti-shopping-cart-plus me-1"></i>
                Tambah Pesanan

            </button>

        </div>

    </div>

</div>

<div class="card-body">

    <div class="table-responsive">

        <table class="table table-bordered table-hover align-middle" id="datapesanan">

            <thead>

                <tr>
                    <th width="60">No</th>
                    <th>ID Pesanan</th>
                    <th>Pelanggan</th>
                    <th>Tanggal</th>
                    <th>Estimasi</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th width="140">Aksi</th>
                </tr>

            </thead>

            <tbody>

                <?php if (!empty($pesanan)) : ?>

                    <?php $no = 1; ?>

                    <?php foreach ($pesanan as $row) : ?>

                        <tr>

                            <!-- NO -->
                            <td class="text-center">
                                <?= $no++ ?>
                            </td>

                            <!-- ID -->
                            <td>

                                <span class="badge bg-primary">
                                    <?= $row['IdPesanan'] ?>
                                </span>

                            </td>

                            <!-- PELANGGAN -->
                            <td>
                                <strong><?= $row['NamaPelanggan'] ?></strong>
                            </td>

                            <!-- TANGGAL -->
                            <td>
                                <?= date('d/m/Y', strtotime($row['TglPesanan'])) ?>
                            </td>

                            <!-- ESTIMASI -->
                            <td>

                                <?php if (!empty($row['EstimasiSelesai'])) : ?>

                                    <?= date('d/m/Y', strtotime($row['EstimasiSelesai'])) ?>

                                <?php else : ?>

                                    <span class="text-muted">-</span>

                                <?php endif; ?>

                            </td>

                            <!-- TOTAL -->
                            <td>
                                <strong>
                                    Rp <?= number_format($row['Total'], 0, ',', '.') ?>
                                </strong>
                            </td>

                            <!-- STATUS -->
                            <td>

                                <?php if ($row['StatusPesanan'] == 'Menunggu') : ?>

                                    <span class="badge bg-warning text-dark">
                                        Menunggu
                                    </span>

                                <?php elseif ($row['StatusPesanan'] == 'Diproses') : ?>

                                    <span class="badge bg-info">
                                        Diproses
                                    </span>

                                <?php elseif ($row['StatusPesanan'] == 'Selesai') : ?>

                                    <span class="badge bg-success">
                                        Selesai
                                    </span>

                                <?php else : ?>

                                    <span class="badge bg-danger">
                                        Dibatalkan
                                    </span>

                                <?php endif; ?>

                            </td>

                            <!-- AKSI -->
                            <td class="text-center">

                                <!-- EDIT -->
                                <a href="<?= base_url('datapesanan/edit/' . $row['IdPesanan']) ?>"
                                   class="btn btn-warning btn-sm"
                                   title="Edit Pesanan">

                                    <i class="ti ti-edit"></i>

                                </a>

                                <!-- HAPUS -->
                                <a href="<?= base_url('datapesanan/hapus/' . $row['IdPesanan']) ?>"
                                   class="btn btn-danger btn-sm btn-hapus"
                                   title="Hapus Pesanan">

                                    <i class="ti ti-trash"></i>

                                </a>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                <?php else : ?>

                    <tr>

                        <td colspan="8" class="text-center text-muted py-4">
                            Data pesanan belum tersedia
                        </td>

                    </tr>

                <?php endif; ?>

                <!-- NO RESULT -->
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

<!-- ===================================================== -->

<!-- SCRIPT SEARCH -->

<!-- ===================================================== -->

<script>

    const searchInput = document.getElementById('search-input');

    searchInput.addEventListener('keyup', function() {

        let keyword = this.value.toLowerCase();

        let rows = document.querySelectorAll('#datapesanan tbody tr');

        let found = false;

        rows.forEach(row => {

            // skip row no-result
            if (row.id === 'no-result') return;

            let idPesanan = row.cells[1]?.innerText.toLowerCase() || '';
            let pelanggan = row.cells[2]?.innerText.toLowerCase() || '';

            if (
                idPesanan.includes(keyword) ||
                pelanggan.includes(keyword)
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


    // =====================================================
    // SWEETALERT HAPUS
    // =====================================================
    document.querySelectorAll('.btn-hapus').forEach(button => {

        button.addEventListener('click', function(e) {

            e.preventDefault();

            const url = this.getAttribute('href');

            Swal.fire({
                title: 'Hapus Pesanan?',
                text: 'Stok kemasan akan dikembalikan secara otomatis.',
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
