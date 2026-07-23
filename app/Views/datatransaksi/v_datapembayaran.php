<?= $this->extend('layout/dashboard') ?>

<?= $this->section('content') ?>

<!-- ===================================================== -->

<!-- STATISTIK -->

<!-- ===================================================== -->

<div class="row mb-4">


    <div class="col-md-3 mb-3">

        <div class="stat-card">
            <p>Total Pembayaran</p>
            <h4><?= count($pembayaran) ?></h4>
        </div>

    </div>

    <div class="col-md-3 mb-3">

        <div class="stat-card">
            <p>Menunggu Verifikasi</p>
            <h4>
                <?= count(array_filter($pembayaran, fn($p) => $p['StatusPembayaran'] == 'Menunggu Verifikasi')) ?>
            </h4>
        </div>

    </div>

    <div class="col-md-3 mb-3">

        <div class="stat-card">
            <p>Terverifikasi</p>
            <h4>
                <?= count(array_filter($pembayaran, fn($p) => $p['StatusPembayaran'] == 'Terverifikasi')) ?>
            </h4>
        </div>

    </div>

    <div class="col-md-3 mb-3">

        <div class="stat-card">
            <p>Ditolak</p>
            <h4>
                <?= count(array_filter($pembayaran, fn($p) => $p['StatusPembayaran'] == 'Ditolak')) ?>
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
                <h3>Data Pembayaran</h3>
                <small>Kelola seluruh transaksi pembayaran pelanggan</small>
            </div>

            <div class="d-flex align-items-center gap-3 header-tools">

                <!-- SEARCH -->
                <div class="search-wrapper">

                    <i class="ti ti-search search-icon"></i>

                    <input
                        type="text"
                        id="search-input"
                        class="form-control search-pengguna"
                        placeholder="Cari pelanggan atau ID pembayaran">

                </div>

                <!-- TAMBAH -->
                <button
                    type="button"
                    class="btn btn-tambah"
                    onclick="window.location.href='<?= base_url('datapembayaran/tambah') ?>'">

                    <i class="ti ti-cash me-1"></i>
                    Tambah Pembayaran

                </button>

            </div>

        </div>

    </div>

    <div class="card-body">

        <div class="table-responsive">


            <table class="table table-bordered table-hover align-middle" id="datapembayaran">

                <thead>

                    <tr>
                        <th width="60">No</th>
                        <th>ID Pembayaran</th>
                        <th>Pelanggan</th>
                        <th>Tanggal</th>
                        <th>Jenis</th>
                        <th>Metode</th>
                        <th>Jumlah</th>
                        <th>Status Pembayaran</th>
                        <th>Status Pelunasan</th>
                        <th>Bukti</th>
                        <th width="140">Aksi</th>
                    </tr>

                </thead>

                <tbody>

                    <?php if (!empty($pembayaran)) : ?>

                        <?php $no = 1; ?>

                        <?php foreach ($pembayaran as $row) : ?>

                            <tr>

                                <!-- NO -->
                                <td class="text-center">
                                    <?= $no++ ?>
                                </td>

                                <!-- ID PEMBAYARAN -->
                                <td>
                                    <span class="badge bg-primary">
                                        <?= $row['IdPembayaran'] ?>
                                    </span>
                                </td>

                                <!-- PELANGGAN -->
                                <td>
                                    <strong><?= esc($row['NamaPelanggan']) ?></strong>
                                    <br>
                                    <small class="text-muted">
                                        <?= $row['IdPesanan'] ?>
                                    </small>
                                </td>

                                <!-- TANGGAL -->
                                <td>
                                    <?= date('d/m/Y', strtotime($row['TglBayar'])) ?>
                                </td>

                                <!-- JENIS PEMBAYARAN -->
                                <td class="text-center">

                                    <?php if ($row['JenisPembayaran'] == 'DP') : ?>

                                        <span class="badge bg-warning text-dark">
                                            DP
                                        </span>

                                    <?php elseif ($row['JenisPembayaran'] == 'Pelunasan') : ?>

                                        <span class="badge bg-info text-dark">
                                            Pelunasan
                                        </span>

                                    <?php else : ?>

                                        <span class="badge bg-success">
                                            Full Payment
                                        </span>

                                    <?php endif; ?>

                                </td>

                                <!-- METODE -->
                                <td class="text-center">
                                    <?= esc($row['MetodePembayaran']) ?>
                                </td>

                                <!-- JUMLAH -->
                                <td class="text-end fw-bold text-success">
                                    Rp <?= number_format($row['JumlahBayar'], 0, ',', '.') ?>
                                </td>

                                <!-- STATUS PEMBAYARAN -->
                                <td class="text-center">

                                    <?php if ($row['StatusPembayaran'] == 'Terverifikasi') : ?>

                                        <span class="badge bg-success">
                                            <i class="ti ti-check me-1"></i>
                                            Terverifikasi
                                        </span>

                                    <?php elseif ($row['StatusPembayaran'] == 'Menunggu Verifikasi') : ?>

                                        <span class="badge bg-warning text-dark">
                                            <i class="ti ti-clock me-1"></i>
                                            Menunggu
                                        </span>

                                    <?php elseif ($row['StatusPembayaran'] == 'Ditolak') : ?>

                                        <span class="badge bg-danger">
                                            <i class="ti ti-x me-1"></i>
                                            Ditolak
                                        </span>

                                    <?php else : ?>

                                        <span class="badge bg-secondary">
                                            Belum Bayar
                                        </span>

                                    <?php endif; ?>

                                </td>

                                <!-- STATUS PELUNASAN -->
                                <td class="text-center">

                                    <?php if ($row['StatusPelunasan'] == 'Lunas') : ?>

                                        <span class="badge bg-success">
                                            <i class="ti ti-circle-check me-1"></i>
                                            Lunas
                                        </span>

                                    <?php else : ?>

                                        <span class="badge bg-warning text-dark">
                                            <i class="ti ti-alert-circle me-1"></i>
                                            Belum Lunas
                                        </span>

                                    <?php endif; ?>

                                </td>

                                <!-- BUKTI -->
                                <td class="text-center">

                                    <?php if (!empty($row['BuktiPembayaran'])) : ?>

                                        <a href="<?= base_url('storage/fotobuktipem/' . $row['BuktiPembayaran']) ?>"
                                            target="_blank"
                                            class="btn btn-info btn-sm">

                                            <i class="ti ti-eye"></i>

                                        </a>

                                    <?php else : ?>

                                        <span class="text-muted">-</span>

                                    <?php endif; ?>

                                </td>

                                <!-- AKSI -->
                                <td class="text-center">

                                    <a href="<?= base_url('datapembayaran/edit/' . $row['IdPembayaran']) ?>"
                                        class="btn btn-warning btn-sm">

                                        <i class="ti ti-edit"></i>

                                    </a>

                                    <a href="<?= base_url('datapembayaran/hapus/' . $row['IdPembayaran']) ?>"
                                        class="btn btn-danger btn-sm btn-hapus">

                                        <i class="ti ti-trash"></i>

                                    </a>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    <?php else : ?>

                        <tr>

                            <td colspan="11" class="text-center text-muted py-4">

                                <i class="ti ti-receipt-off fs-1 d-block mb-2"></i>
                                Data pembayaran belum tersedia

                            </td>

                        </tr>

                    <?php endif; ?>

                    <!-- ROW PENCARIAN KOSONG -->
                    <tr id="no-result" style="display:none;">

                        <td colspan="11" class="text-center text-danger py-3">

                            <i class="ti ti-search-off me-1"></i>
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

        let rows = document.querySelectorAll('#datapembayaran tbody tr');

        let found = false;

        rows.forEach(row => {

            // skip row no-result
            if (row.id === 'no-result') return;

            let idPembayaran = row.cells[1]?.innerText.toLowerCase() || '';
            let pelanggan = row.cells[2]?.innerText.toLowerCase() || '';

            if (
                idPembayaran.includes(keyword) ||
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
                title: 'Hapus Pembayaran?',
                text: 'Status pesanan akan dikembalikan ke Menunggu.',
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