<?= $this->extend('layout/dashboard') ?>

<?= $this->section('content') ?>

<div class="card card-pengguna">

```
<!-- ===================================================== -->
<!-- HEADER -->
<!-- ===================================================== -->
<div class="card-header card-header-pengguna">

    <div class="d-flex justify-content-between align-items-center">

        <div>
            <h3>Edit Pesanan</h3>
            <small>Perbarui transaksi pesanan pelanggan</small>
        </div>

        <a href="<?= base_url('datapesanan') ?>" class="btn btn-secondary">

            <i class="ti ti-arrow-left me-1"></i>
            Kembali

        </a>

    </div>

</div>

<div class="card-body">

    <!-- Flash Error -->
    <?php if (session()->getFlashdata('error')) : ?>

        <div class="alert alert-danger alert-dismissible fade show">

            <?= session()->getFlashdata('error') ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>

        </div>

    <?php endif; ?>

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

    <form action="<?= base_url('datapesanan/update') ?>" method="post" id="form-pesanan">

        <?= csrf_field(); ?>

        <input type="hidden" name="IdPesanan" value="<?= $pesanan['IdPesanan'] ?>">

        <!-- ===================================================== -->
        <!-- DATA PESANAN -->
        <!-- ===================================================== -->
        <div class="row">

            <!-- ID PESANAN -->
            <div class="col-md-6 mb-3">

                <label class="form-label">ID Pesanan</label>

                <input
                    type="text"
                    class="form-control"
                    value="<?= $pesanan['IdPesanan'] ?>"
                    readonly>

            </div>

            <!-- TANGGAL -->
            <div class="col-md-6 mb-3">

                <label class="form-label">Tanggal Pesanan</label>

                <input
                    type="date"
                    name="TglPesanan"
                    class="form-control"
                    value="<?= old('TglPesanan', $pesanan['TglPesanan']) ?>"
                    required>

            </div>

            <!-- PELANGGAN -->
            <div class="col-md-6 mb-3">

                <label class="form-label">Pelanggan</label>

                <select name="IdPelanggan" class="form-select" required>

                    <option value="">-- Pilih Pelanggan --</option>

                    <?php foreach ($pelanggan as $p) : ?>

                        <option value="<?= $p['IdPelanggan'] ?>"
                            <?= old('IdPelanggan', $pesanan['IdPelanggan']) == $p['IdPelanggan'] ? 'selected' : '' ?>>

                            <?= $p['NamaPelanggan'] ?>

                        </option>

                    <?php endforeach; ?>

                </select>

            </div>

            <!-- STATUS -->
            <div class="col-md-6 mb-3">

                <label class="form-label">Status Pesanan</label>

                <select name="StatusPesanan" class="form-select" required>

                    <option value="Menunggu"
                        <?= old('StatusPesanan', $pesanan['StatusPesanan']) == 'Menunggu' ? 'selected' : '' ?>>

                        Menunggu

                    </option>

                    <option value="Diproses"
                        <?= old('StatusPesanan', $pesanan['StatusPesanan']) == 'Diproses' ? 'selected' : '' ?>>

                        Diproses

                    </option>

                    <option value="Selesai"
                        <?= old('StatusPesanan', $pesanan['StatusPesanan']) == 'Selesai' ? 'selected' : '' ?>>

                        Selesai

                    </option>

                    <option value="Dibatalkan"
                        <?= old('StatusPesanan', $pesanan['StatusPesanan']) == 'Dibatalkan' ? 'selected' : '' ?>>

                        Dibatalkan

                    </option>

                </select>

            </div>

            <!-- ESTIMASI -->
            <div class="col-md-6 mb-3">

                <label class="form-label">Estimasi Selesai</label>

                <input
                    type="date"
                    name="EstimasiSelesai"
                    class="form-control"
                    value="<?= old('EstimasiSelesai', $pesanan['EstimasiSelesai']) ?>">

            </div>

        </div>

        <hr class="my-4">

        <!-- ===================================================== -->
        <!-- DETAIL PESANAN -->
        <!-- ===================================================== -->
        <div class="d-flex justify-content-between align-items-center mb-3">

            <div>
                <h5 class="mb-1">Detail Pesanan</h5>
                <small class="text-muted">
                    Ubah produk kemasan dan jumlah pesanan pelanggan
                </small>
            </div>

            <button
                type="button"
                class="btn btn-outline-primary btn-sm"
                id="btn-tambah-detail">

                <i class="ti ti-plus me-1"></i>
                Tambah Item

            </button>

        </div>

        <!-- ===================================================== -->
        <!-- CONTAINER DETAIL -->
        <!-- ===================================================== -->
        <div id="container-detail">

            <?php if (!empty($detail)) : ?>

                <?php foreach ($detail as $d) : ?>

                    <?php
                        $selectedKemasan = null;

                        foreach ($kemasan as $k) {
                            if ($k['IdKemasan'] == $d['IdKemasan']) {
                                $selectedKemasan = $k;
                                break;
                            }
                        }
                    ?>

                    <div class="row align-items-end detail-row mb-3">

                        <!-- KEMASAN -->
                        <div class="col-md-4">

                            <label class="form-label">Produk Kemasan</label>

                            <select name="IdKemasan[]" class="form-select select-kemasan" required>

                                <option value="">-- Pilih Kemasan --</option>

                                <?php foreach ($kemasan as $k) : ?>

                                    <option
                                        value="<?= $k['IdKemasan'] ?>"
                                        data-harga="<?= $k['Harga'] ?>"
                                        data-stok="<?= $k['Stok'] + ($k['IdKemasan'] == $d['IdKemasan'] ? $d['Qty'] : 0) ?>"
                                        <?= $d['IdKemasan'] == $k['IdKemasan'] ? 'selected' : '' ?>>

                                        <?= $k['NamaProduk'] ?> -
                                        <?= $k['NamaKemasan'] ?>
                                        (Stok: <?= $k['Stok'] + ($k['IdKemasan'] == $d['IdKemasan'] ? $d['Qty'] : 0) ?>)

                                    </option>

                                <?php endforeach; ?>

                            </select>

                        </div>

                        <!-- QTY -->
                        <div class="col-md-2">

                            <label class="form-label">Qty</label>

                            <input
                                type="number"
                                name="Qty[]"
                                class="form-control input-qty"
                                min="1"
                                value="<?= $d['Qty'] ?>"
                                required>

                        </div>

                        <!-- HARGA -->
                        <div class="col-md-2">

                            <label class="form-label">Harga</label>

                            <input
                                type="number"
                                name="Harga[]"
                                class="form-control input-harga"
                                value="<?= $d['Harga'] ?>"
                                readonly>

                        </div>

                        <!-- SUBTOTAL -->
                        <div class="col-md-3">

                            <label class="form-label">Sub Total</label>

                            <input
                                type="number"
                                name="SubTotal[]"
                                class="form-control input-subtotal"
                                value="<?= $d['SubTotal'] ?>"
                                readonly>

                        </div>

                        <!-- HAPUS -->
                        <div class="col-md-1 d-grid">

                            <button type="button" class="btn btn-danger btn-hapus-detail">

                                <i class="ti ti-trash"></i>

                            </button>

                        </div>

                    </div>

                <?php endforeach; ?>

            <?php else : ?>

                <!-- Jika belum ada detail -->
                <div class="row align-items-end detail-row mb-3">

                    <div class="col-md-4">

                        <label class="form-label">Produk Kemasan</label>

                        <select name="IdKemasan[]" class="form-select select-kemasan" required>

                            <option value="">-- Pilih Kemasan --</option>

                            <?php foreach ($kemasan as $k) : ?>

                                <option
                                    value="<?= $k['IdKemasan'] ?>"
                                    data-harga="<?= $k['Harga'] ?>"
                                    data-stok="<?= $k['Stok'] ?>">

                                    <?= $k['NamaProduk'] ?> -
                                    <?= $k['NamaKemasan'] ?>
                                    (Stok: <?= $k['Stok'] ?>)

                                </option>

                            <?php endforeach; ?>

                        </select>

                    </div>

                    <div class="col-md-2">

                        <label class="form-label">Qty</label>

                        <input
                            type="number"
                            name="Qty[]"
                            class="form-control input-qty"
                            min="1"
                            value="1"
                            required>

                    </div>

                    <div class="col-md-2">

                        <label class="form-label">Harga</label>

                        <input
                            type="number"
                            name="Harga[]"
                            class="form-control input-harga"
                            readonly>

                    </div>

                    <div class="col-md-3">

                        <label class="form-label">Sub Total</label>

                        <input
                            type="number"
                            name="SubTotal[]"
                            class="form-control input-subtotal"
                            readonly>

                    </div>

                    <div class="col-md-1 d-grid">

                        <button type="button" class="btn btn-danger btn-hapus-detail">

                            <i class="ti ti-trash"></i>

                        </button>

                    </div>

                </div>

            <?php endif; ?>

        </div>

        <hr>

        <!-- ===================================================== -->
        <!-- TOTAL -->
        <!-- ===================================================== -->
        <div class="row justify-content-end">

            <div class="col-md-4">

                <div class="card bg-light border-0">

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Total Item</span>
                            <strong id="total-item">0</strong>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold">Total Pesanan</span>
                            <h4 class="mb-0 text-success" id="total-display">
                                Rp 0
                            </h4>
                        </div>

                        <input
                            type="hidden"
                            name="Total"
                            id="total-hidden"
                            value="<?= $pesanan['Total'] ?>">

                    </div>

                </div>

            </div>

        </div>

        <hr>

        <!-- ACTION -->
        <div class="d-flex justify-content-end gap-2">

            <a href="<?= base_url('datapesanan') ?>" class="btn btn-secondary">
                Batal
            </a>

            <button type="submit" class="btn btn-tambah">

                <i class="ti ti-device-floppy me-1"></i>
                Update Pesanan

            </button>

        </div>

    </form>

</div>
```

</div>

<!-- ===================================================== -->

<!-- TEMPLATE DETAIL BARU -->

<!-- ===================================================== -->

<template id="template-detail">

```
<div class="row align-items-end detail-row mb-3">

    <div class="col-md-4">

        <label class="form-label">Produk Kemasan</label>

        <select name="IdKemasan[]" class="form-select select-kemasan" required>

            <option value="">-- Pilih Kemasan --</option>

            <?php foreach ($kemasan as $k) : ?>

                <option
                    value="<?= $k['IdKemasan'] ?>"
                    data-harga="<?= $k['Harga'] ?>"
                    data-stok="<?= $k['Stok'] ?>">

                    <?= $k['NamaProduk'] ?> -
                    <?= $k['NamaKemasan'] ?>
                    (Stok: <?= $k['Stok'] ?>)

                </option>

            <?php endforeach; ?>

        </select>

    </div>

    <div class="col-md-2">

        <label class="form-label">Qty</label>

        <input
            type="number"
            name="Qty[]"
            class="form-control input-qty"
            min="1"
            value="1"
            required>

    </div>

    <div class="col-md-2">

        <label class="form-label">Harga</label>

        <input
            type="number"
            name="Harga[]"
            class="form-control input-harga"
            readonly>

    </div>

    <div class="col-md-3">

        <label class="form-label">Sub Total</label>

        <input
            type="number"
            name="SubTotal[]"
            class="form-control input-subtotal"
            readonly>

    </div>

    <div class="col-md-1 d-grid">

        <button type="button" class="btn btn-danger btn-hapus-detail">

            <i class="ti ti-trash"></i>

        </button>

    </div>

</div>
```

</template>

<script>

    const containerDetail = document.getElementById('container-detail');
    const templateDetail = document.getElementById('template-detail');
    const btnTambahDetail = document.getElementById('btn-tambah-detail');

    // =====================================================
    // TAMBAH ITEM
    // =====================================================
    btnTambahDetail.addEventListener('click', function() {

        const clone = templateDetail.content.cloneNode(true);

        containerDetail.appendChild(clone);

        hitungSemua();

    });

    // =====================================================
    // HAPUS ITEM
    // =====================================================
    document.addEventListener('click', function(e) {

        if (e.target.closest('.btn-hapus-detail')) {

            const rows = document.querySelectorAll('.detail-row');

            if (rows.length > 1) {

                e.target.closest('.detail-row').remove();

                hitungSemua();

            } else {

                Swal.fire({
                    icon: 'warning',
                    title: 'Minimal 1 Item',
                    text: 'Pesanan harus memiliki minimal satu item.'
                });

            }

        }

    });

    // =====================================================
    // PILIH KEMASAN
    // =====================================================
    document.addEventListener('change', function(e) {

        if (e.target.classList.contains('select-kemasan')) {

            const row = e.target.closest('.detail-row');
            const selected = e.target.options[e.target.selectedIndex];

            const harga = parseInt(selected.dataset.harga || 0);

            row.querySelector('.input-harga').value = harga;

            hitungRow(row);
            hitungSemua();

        }

    });

    // =====================================================
    // INPUT QTY
    // =====================================================
    document.addEventListener('input', function(e) {

        if (e.target.classList.contains('input-qty')) {

            const row = e.target.closest('.detail-row');

            const select = row.querySelector('.select-kemasan');
            const selected = select.options[select.selectedIndex];

            const stok = parseInt(selected.dataset.stok || 0);
            const qty = parseInt(e.target.value || 0);

            if (qty > stok && stok > 0) {

                Swal.fire({
                    icon: 'error',
                    title: 'Stok Tidak Mencukupi',
                    text: `Stok tersedia hanya ${stok} item.`
                });

                e.target.value = stok;
            }

            hitungRow(row);
            hitungSemua();

        }

    });

    // =====================================================
    // HITUNG PER BARIS
    // =====================================================
    function hitungRow(row) {

        const qty = parseInt(row.querySelector('.input-qty').value || 0);
        const harga = parseInt(row.querySelector('.input-harga').value || 0);

        const subtotal = qty * harga;

        row.querySelector('.input-subtotal').value = subtotal;
    }

    // =====================================================
    // HITUNG TOTAL
    // =====================================================
    function hitungSemua() {

        let total = 0;
        let totalItem = 0;

        document.querySelectorAll('.detail-row').forEach(row => {

            total += parseInt(
                row.querySelector('.input-subtotal').value || 0
            );

            totalItem += parseInt(
                row.querySelector('.input-qty').value || 0
            );

        });

        document.getElementById('total-display').textContent =
            'Rp ' + total.toLocaleString('id-ID');

        document.getElementById('total-hidden').value = total;

        document.getElementById('total-item').textContent = totalItem;
    }

    // =====================================================
    // INISIALISASI
    // =====================================================
    window.addEventListener('load', function() {

        document.querySelectorAll('.detail-row').forEach(row => {
            hitungRow(row);
        });

        hitungSemua();

    });

</script>

<?= $this->endSection() ?>
