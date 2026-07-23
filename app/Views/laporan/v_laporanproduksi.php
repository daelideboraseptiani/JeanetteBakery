<?= $this->extend('layout/dashboard') ?>

<?= $this->section('content') ?>

<!-- ===================================================== -->
<!-- STYLE KHUSUS LAPORAN -->
<!-- ===================================================== -->

<style>
    .laporan-header {
        background: linear-gradient(135deg, #fff7f8 0%, #ffeef1 100%);
        border: 1px solid #f3d6dc;
        border-radius: 18px;
        padding: 28px;
        margin-bottom: 24px;
        position: relative;
        overflow: hidden;
    }

    .laporan-header::before {
        content: '';
        position: absolute;
        top: -50px;
        right: -50px;
        width: 180px;
        height: 180px;
        background: rgba(212, 163, 115, .08);
        border-radius: 50%;
    }

    .laporan-title {
        color: #5C3D2E;
        font-weight: 700;
        font-size: 2rem;
        margin-bottom: 8px;
    }

    .laporan-subtitle {
        color: #8b6f6f;
        margin-bottom: 0;
        font-size: .95rem;
    }

    .brand-mini {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 16px;
    }

    .brand-mini img {
        width: 56px;
        height: 56px;
        object-fit: contain;
        border-radius: 14px;
        background: white;
        padding: 6px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, .08);
    }

    .brand-mini .brand-name {
        font-weight: 700;
        color: #5C3D2E;
        font-size: 1.05rem;
    }

    .stat-card-report {
        background: white;
        border: 1px solid #f3d6dc;
        border-radius: 16px;
        padding: 20px;
        transition: all .25s ease;
        height: 100%;
    }

    .stat-card-report:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 24px rgba(244, 182, 196, .18);
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 14px;
        font-size: 1.4rem;
    }

    .stat-icon.total {
        background: #fcecef;
        color: #c86b85;
    }

    .stat-icon.aktif {
        background: #eaf7ee;
        color: #2e7d32;
    }

    .stat-icon.nonaktif {
        background: #fdeaea;
        color: #c62828;
    }

    .stat-label {
        color: #8b6f6f;
        font-size: .9rem;
        margin-bottom: 6px;
    }

    .stat-value {
        color: #5C3D2E;
        font-size: 1.8rem;
        font-weight: 700;
    }

    .card-laporan {
        border: none;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 8px 28px rgba(92, 61, 46, .08);
    }

    .card-header-laporan {
        background: linear-gradient(135deg, #fff 0%, #fff7f8 100%);
        border-bottom: 1px solid #f3d6dc;
        padding: 24px;
    }

    .section-title {
        color: #5C3D2E;
        font-weight: 700;
        margin-bottom: 4px;
    }

    .section-subtitle {
        color: #8b6f6f;
        font-size: .9rem;
        margin-bottom: 0;
    }

    .btn-cetak {
        border-radius: 12px;
        padding: 11px 18px;
        font-weight: 600;
    }

    .btn-pink {
        background: linear-gradient(135deg, #e48aa3 0%, #d96c8a 100%);
        color: white;
        border: none;
    }

    .btn-pink:hover {
        background: linear-gradient(135deg, #d96c8a 0%, #c95a7b 100%);
        color: white;
    }

    .table-laporan thead th {
        background: linear-gradient(135deg, #f8d7da 0%, #f6c8d0 100%);
        color: #5C3D2E;
        border: none;
        text-align: center;
    }

    .table-laporan tbody td {
        vertical-align: middle;
        border-color: #f3e4e7;
    }

    .table-laporan tbody tr:hover {
        background: #fff7f8;
    }

    .badge-status-aktif {
        background: #e8f5e9;
        color: #2e7d32;
        border: 1px solid #c8e6c9;
        padding: 6px 12px;
        border-radius: 999px;
        font-size: .78rem;
        font-weight: 600;
    }

    .badge-status-nonaktif {
        background: #ffebee;
        color: #c62828;
        border: 1px solid #ffcdd2;
        padding: 6px 12px;
        border-radius: 999px;
        font-size: .78rem;
        font-weight: 600;
    }

    .search-box {
        position: relative;
    }

    .search-box .ti {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #c86b85;
    }

    .search-box input {
        padding-left: 42px;
        border-radius: 12px;
        border: 1px solid #f3d6dc;
    }

    .search-box input:focus {
        border-color: #d96c8a;
        box-shadow: 0 0 0 .2rem rgba(217, 108, 138, .15);
    }
</style>

<!-- ===================================================== -->
<!-- HEADER -->
<!-- ===================================================== -->

<div class="laporan-header">

    <div class="brand-mini">

        <img src="<?= base_url('assets/img/logo.jpeg') ?>">

        <div>

            <div class="brand-name">
                Kue Kering Jeanette
            </div>

            <small class="text-muted">
                Sistem Informasi Produksi & Penjualan
            </small>

        </div>

    </div>

    <h1 class="laporan-title">
        Laporan Data Produksi
    </h1>

    <p class="laporan-subtitle">
        Menampilkan seluruh data proses produksi Kue Kering Jeanette.
    </p>

</div>

<!-- ===================================================== -->
<!-- STATISTIK -->
<!-- ===================================================== -->

<div class="row g-3 mb-4">

    <div class="col-md-4">

        <div class="stat-card-report">

            <div class="stat-icon total">

                <i class="ti ti-tools-kitchen-2"></i>

            </div>

            <div class="stat-label">
                Total Produksi
            </div>

            <div class="stat-value">
                <?= count($produksi) ?>
            </div>

        </div>

    </div>

    <div class="col-md-4">

        <div class="stat-card-report">

            <div class="stat-icon aktif">

                <i class="ti ti-progress"></i>

            </div>

            <div class="stat-label">
                Sedang Diproduksi
            </div>

            <div class="stat-value">
                <?= count(array_filter($produksi, fn($p) => $p['StatusProduksi'] == 'Diproduksi')) ?>
            </div>

        </div>

    </div>

    <div class="col-md-4">

        <div class="stat-card-report">

            <div class="stat-icon nonaktif">

                <i class="ti ti-circle-check"></i>

            </div>

            <div class="stat-label">
                Produksi Selesai
            </div>

            <div class="stat-value">
                <?= count(array_filter($produksi, fn($p) => $p['StatusProduksi'] == 'Selesai')) ?>
            </div>

        </div>

    </div>

</div>
<!-- ===================================================== -->
<!-- CARD UTAMA -->
<!-- ===================================================== -->

<div class="card card-laporan">

    <div class="card-header card-header-laporan">

        <div class="d-flex flex-column gap-3">

            <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center">

                <div>

                    <h3 class="section-title">
                        Daftar Produksi
                    </h3>

                    <p class="section-subtitle">
                        Kelola dan cetak laporan data produksi berdasarkan status dan periode.
                    </p>

                </div>

            </div>

            <!-- FILTER -->

            <div class="row g-2 align-items-end">

                <div class="col-md-3">

                    <label class="form-label">Tanggal Awal</label>

                    <input type="date"
                        class="form-control"
                        id="tgl_awal">

                </div>

                <div class="col-md-3">

                    <label class="form-label">Tanggal Akhir</label>

                    <input type="date"
                        class="form-control"
                        id="tgl_akhir">

                </div>

                <div class="col-md-6">

                    <div class="d-flex flex-wrap gap-2">

                        

                        <button
                            type="button"
                            class="btn btn-pink btn-cetak"
                            onclick="cetakProduksi('')">

                            <i class="ti ti-printer me-2"></i>

                            Cetak

                        </button>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="card-body">

        <!-- SEARCH -->

        <div class="row mb-3">

            <div class="col-md-5">

                <div class="search-box">

                    <i class="ti ti-search"></i>

                    <input
                        type="text"
                        id="search-input"
                        class="form-control"
                        placeholder="Cari ID produksi, produk, atau tanggal...">

                </div>

            </div>

        </div>

        <!-- TABLE -->

        <div class="table-responsive">

            <table class="table table-laporan align-middle" id="dataproduksi">

                <thead>

                    <tr>

                        <th width="60">No</th>
                        <th>ID Produksi</th>
                        <th>Nama Produk</th>
                        <th>Tanggal Produksi</th>
                        <th>Jumlah Produksi</th>
                        <th>Hasil Produksi</th>
                        <th>Status Produksi</th>

                    </tr>

                </thead>

                <tbody>

                    <?php if (!empty($produksi)) : ?>

                        <?php $no = 1; ?>

                        <?php foreach ($produksi as $row) : ?>

                            <tr>

                                <td class="text-center fw-semibold">

                                    <?= $no++ ?>

                                </td>

                                <td>

                                    <span class="fw-semibold text-primary">

                                        <?= esc($row['IdProduksi']) ?>

                                    </span>

                                </td>

                                <td>

                                    <strong>

                                        <?= esc($row['NamaProduk']) ?>

                                    </strong>

                                </td>

                                <td class="text-center">

                                    <?= date('d-m-Y', strtotime($row['TglProduksi'])) ?>

                                </td>

                                <td class="text-center">

                                    <?= number_format($row['JumlahProduksi'], 2, ',', '.') ?>

                                </td>

                                <td class="text-center">

                                    <?= number_format($row['HasilProduksi'], 2, ',', '.') ?>

                                </td>

                                <td class="text-center">

                                    <?php if ($row['StatusProduksi'] == 'Diproduksi') : ?>

                                        <span class="badge bg-warning text-dark">

                                            <?= esc($row['StatusProduksi']) ?>

                                        </span>

                                    <?php else : ?>

                                        <span class="badge bg-success">

                                            <?= esc($row['StatusProduksi']) ?>

                                        </span>

                                    <?php endif; ?>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    <?php else : ?>

                        <tr>

                            <td colspan="7" class="text-center py-5 text-muted">

                                <i class="ti ti-database-off fs-1 d-block mb-2"></i>

                                Data produksi belum tersedia

                            </td>

                        </tr>

                    <?php endif; ?>

                    <!-- HASIL PENCARIAN -->

                    <tr id="no-result" style="display:none;">

                        <td colspan="7" class="text-center py-4 text-danger">

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
<!-- SEARCH SCRIPT -->
<!-- ===================================================== -->

<script>
    const searchInput = document.getElementById('search-input');

    searchInput.addEventListener('keyup', function() {

        let keyword = this.value.toLowerCase();

        let rows = document.querySelectorAll('#dataproduksi tbody tr');

        let found = false;

        rows.forEach(row => {

            if (row.id === 'no-result') return;

            let id = row.cells[1]?.innerText.toLowerCase() || '';
            let produk = row.cells[2]?.innerText.toLowerCase() || '';
            let tanggal = row.cells[3]?.innerText.toLowerCase() || '';
            let jumlah = row.cells[4]?.innerText.toLowerCase() || '';
            let hasil = row.cells[5]?.innerText.toLowerCase() || '';
            let status = row.cells[6]?.innerText.toLowerCase() || '';

            if (
                id.includes(keyword) ||
                produk.includes(keyword) ||
                tanggal.includes(keyword) ||
                jumlah.includes(keyword) ||
                hasil.includes(keyword) ||
                status.includes(keyword)
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
</script>
<script>

function cetakProduksi(status)
{

    let tglAwal = document.getElementById('tgl_awal').value;
    let tglAkhir = document.getElementById('tgl_akhir').value;

    let url = "<?= base_url('laporanproduksi/cetak') ?>?";

    if(status !== '')
    {
        url += "status=" + encodeURIComponent(status);
    }

    if(tglAwal !== '')
    {

        url += (url.slice(-1) != '?' ? '&' : '') +
            "tgl_awal=" + encodeURIComponent(tglAwal);

    }

    if(tglAkhir !== '')
    {

        url += (url.slice(-1) != '?' ? '&' : '') +
            "tgl_akhir=" + encodeURIComponent(tglAkhir);

    }

    window.open(url, "_blank");

}

</script>

<?= $this->endSection() ?>