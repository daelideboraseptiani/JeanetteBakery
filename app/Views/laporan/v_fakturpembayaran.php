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

<div class="card-header card-header-pengguna p-0">

    <!-- Judul -->
    <div class="header-title">
        <h2 class="mb-1">Data Pesanan</h2>
        <p class="mb-0 text-muted">
    </div>

    <!-- Area Tombol -->
    <div class="header-action">

        <div class="row g-4">

            <!-- LAPORAN HARIAN -->
            <div class="col-lg-12">

                <div class="card shadow-sm border-0 h-100">

                    <div class="card-body">

                        <form action="<?= base_url('fakturpembayaran/cetak') ?>" method="post" target="_blank">

                            <label class="form-label">
                                Silahkan Masukkan ID Pesanan
                            </label>

                            <select name="idpesanan" class="form-select" required>

                                <option value="">Pilih ID Pesanan</option>

                                <?php foreach ($pesanan as $p) : ?>

                                    <option value="<?= $p['IdPesanan'] ?>">
                                        <?= $p['IdPesanan'] ?>
                                    </option>

                                <?php endforeach; ?>

                            </select>

                            <button class="btn btn-primary w-100 mt-3">
                                <i class="ti ti-printer me-2"></i>
                                Cetak Faktur Pembayaran
                            </button>

                        </form>

                    </div>

                </div>

            </div>
        </div>

    </div>

</div>
<?= $this->endSection() ?>