<?= $this->extend('layout/dashboard') ?>

<?= $this->section('content') ?>

<div class="card card-pengguna">


<div class="card-header card-header-pengguna">

    <div class="d-flex justify-content-between align-items-center">

        <div>
            <h3>Tambah Produksi</h3>
            <small>Catat proses produksi dan penggunaan bahan baku</small>
        </div>

        <a href="<?= base_url('dataproduksi') ?>" class="btn btn-secondary">

            <i class="ti ti-arrow-left me-1"></i>
            Kembali

        </a>

    </div>

</div>

<div class="card-body">

    <!-- Error Validasi -->
    <?php if (session()->getFlashdata('errors')) : ?>

        <div class="alert alert-danger">

            <ul class="mb-0">

                <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>

            </ul>

        </div>

    <?php endif; ?>

    <form action="<?= base_url('dataproduksi/simpan') ?>" method="post">

        <?= csrf_field(); ?>

        <!-- ===================================================== -->
        <!-- DATA PRODUKSI -->
        <!-- ===================================================== -->
        <div class="row">

            <!-- ID PRODUKSI -->
            <div class="col-md-6 mb-3">

                <label class="form-label">ID Produksi</label>

                <input
                    type="text"
                    name="IdProduksi"
                    class="form-control"
                    value="<?= $IdProduksi ?>"
                    readonly>

            </div>

            <!-- TANGGAL -->
            <div class="col-md-6 mb-3">

                <label class="form-label">Tanggal Produksi</label>

                <input
                    type="date"
                    name="TglProduksi"
                    class="form-control"
                    value="<?= old('TglProduksi', date('Y-m-d')) ?>"
                    required>

            </div>

            <!-- PRODUK -->
            <div class="col-md-6 mb-3">

                <label class="form-label">Produk</label>

                <select name="IdProduk" class="form-select" required>

                    <option value="">-- Pilih Produk --</option>

                    <?php foreach ($produk as $p) : ?>

                        <option value="<?= $p['IdProduk'] ?>"
                            <?= old('IdProduk') == $p['IdProduk'] ? 'selected' : '' ?>>

                            <?= $p['NamaProduk'] ?>

                        </option>

                    <?php endforeach; ?>

                </select>

            </div>

            <!-- STATUS PRODUKSI -->
            <div class="col-md-6 mb-3">

                <label class="form-label">Status Produksi</label>

                <select name="StatusProduksi" class="form-select" required>

                    <option value="Diproduksi"
                        <?= old('StatusProduksi', 'Diproduksi') == 'Diproduksi' ? 'selected' : '' ?>>

                        Diproduksi

                    </option>

                    <option value="Selesai"
                        <?= old('StatusProduksi') == 'Selesai' ? 'selected' : '' ?>>

                        Selesai

                    </option>

                </select>

            </div>

            <!-- JUMLAH PRODUKSI -->
            <div class="col-md-6 mb-3">

                <label class="form-label">Jumlah Produksi</label>

                <input
                    type="number"
                    step="0.01"
                    name="JumlahProduksi"
                    class="form-control"
                    value="<?= old('JumlahProduksi') ?>"
                    placeholder="Contoh: 5.00"
                    required>

                <small class="text-muted">
                    Contoh: 5 kg adonan.
                </small>

            </div>

            <!-- HASIL PRODUKSI -->
            <div class="col-md-6 mb-3">

                <label class="form-label">Hasil Produksi</label>

                <input
                    type="number"
                    step="0.01"
                    name="HasilProduksi"
                    class="form-control"
                    value="<?= old('HasilProduksi') ?>"
                    placeholder="Contoh: 20.00"
                    required>

                <small class="text-muted">
                    Contoh: 20 toples ukuran 250 gram.
                </small>

            </div>

        </div>

        <hr class="my-4">

        <!-- ===================================================== -->
        <!-- DETAIL BAHAN BAKU -->
        <!-- ===================================================== -->
        <div class="d-flex justify-content-between align-items-center mb-3">

            <div>
                <h5 class="mb-1">Bahan Baku yang Dipakai</h5>
                <small class="text-muted">
                    Tambahkan satu atau lebih bahan baku untuk produksi ini.
                </small>
            </div>

            <button
                type="button"
                class="btn btn-outline-primary btn-sm"
                id="btn-tambah-bahan">

                <i class="ti ti-plus me-1"></i>
                Tambah Bahan

            </button>

        </div>

        <!-- Container Bahan -->
        <div id="container-bahan">

            <!-- Baris Pertama -->
            <div class="row align-items-end bahan-row mb-3">

                <div class="col-md-6">

                    <label class="form-label">Bahan Baku</label>

                    <select name="IdBahanBaku[]" class="form-select">

                        <option value="">-- Pilih Bahan --</option>

                        <?php foreach ($bahan as $b) : ?>

                            <option value="<?= $b['IdBahanBaku'] ?>">

                                <?= $b['NamaBahan'] ?> (<?= number_format($b['Stok'], 2) ?> <?= $b['Satuan'] ?>)

                            </option>

                        <?php endforeach; ?>

                    </select>

                </div>

                <div class="col-md-4">

                    <label class="form-label">Qty Dipakai</label>

                    <input
                        type="number"
                        step="0.01"
                        name="QtyDipakai[]"
                        class="form-control"
                        placeholder="Contoh: 2.50">

                </div>

                <div class="col-md-2 d-grid">

                    <button type="button" class="btn btn-danger btn-hapus-bahan">

                        <i class="ti ti-trash"></i>

                    </button>

                </div>

            </div>

        </div>

        <hr>

        <!-- ACTION -->
        <div class="d-flex justify-content-end gap-2">

            <a href="<?= base_url('dataproduksi') ?>" class="btn btn-secondary">
                Batal
            </a>

            <button type="submit" class="btn btn-tambah">

                <i class="ti ti-device-floppy me-1"></i>
                Simpan Produksi

            </button>

        </div>

    </form>

</div>


</div>

<!-- ===================================================== -->

<!-- TEMPLATE BAHAN -->

<!-- ===================================================== -->

<template id="template-bahan">


<div class="row align-items-end bahan-row mb-3">

    <div class="col-md-6">

        <label class="form-label">Bahan Baku</label>

        <select name="IdBahanBaku[]" class="form-select">

            <option value="">-- Pilih Bahan --</option>

            <?php foreach ($bahan as $b) : ?>

                <option value="<?= $b['IdBahanBaku'] ?>">

                    <?= $b['NamaBahan'] ?> (<?= number_format($b['Stok'], 2) ?> <?= $b['Satuan'] ?>)

                </option>

            <?php endforeach; ?>

        </select>

    </div>

    <div class="col-md-4">

        <label class="form-label">Qty Dipakai</label>

        <input
            type="number"
            step="0.01"
            name="QtyDipakai[]"
            class="form-control"
            placeholder="Contoh: 1.25">

    </div>

    <div class="col-md-2 d-grid">

        <button type="button" class="btn btn-danger btn-hapus-bahan">

            <i class="ti ti-trash"></i>

        </button>

    </div>

</div>


</template>

<script>

    // =====================================================
    // TAMBAH BAHAN DINAMIS
    // =====================================================
    const containerBahan = document.getElementById('container-bahan');
    const templateBahan = document.getElementById('template-bahan');
    const btnTambahBahan = document.getElementById('btn-tambah-bahan');

    btnTambahBahan.addEventListener('click', function() {

        const clone = templateBahan.content.cloneNode(true);

        containerBahan.appendChild(clone);

    });


    // =====================================================
    // HAPUS BARIS BAHAN
    // =====================================================
    document.addEventListener('click', function(e) {

        if (e.target.closest('.btn-hapus-bahan')) {

            const rows = document.querySelectorAll('.bahan-row');

            // Minimal 1 baris
            if (rows.length > 1) {

                e.target.closest('.bahan-row').remove();

            } else {

                Swal.fire({
                    icon: 'warning',
                    title: 'Minimal 1 Bahan',
                    text: 'Produksi harus memiliki minimal satu bahan baku.'
                });

            }

        }

    });


    // =====================================================
    // VALIDASI ANGKA POSITIF
    // =====================================================
    document.addEventListener('input', function(e) {

        if (e.target.type === 'number') {

            if (e.target.value < 0) {
                e.target.value = 0;
            }

        }

    });

</script>

<?= $this->endSection() ?>
