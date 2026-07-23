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
                <h3>Update Stok Kemasan</h3>
                <small>Bagi hasil produksi ke berbagai ukuran kemasan</small>
            </div>

            <a href="<?= base_url('dataproduksi') ?>" class="btn btn-secondary">

                <i class="ti ti-arrow-left me-1"></i>
                Kembali

            </a>

        </div>

    </div>

    <div class="card-body">

        <!-- ===================================================== -->
        <!-- INFORMASI PRODUKSI -->
        <!-- ===================================================== -->
        <div class="row mb-4">

            <div class="col-md-4">
                <div class="border rounded p-3 h-100">
                    <small class="text-muted d-block">ID Produksi</small>
                    <h5 class="mb-0"><?= $produksi['IdProduksi'] ?></h5>
                </div>
            </div>

            <div class="col-md-4">
                <div class="border rounded p-3 h-100">
                    <small class="text-muted d-block">Produk</small>
                    <h5 class="mb-0"><?= $produksi['NamaProduk'] ?></h5>
                </div>
            </div>

            <div class="col-md-4">
                <div class="border rounded p-3 h-100">
                    <small class="text-muted d-block">Hasil Produksi</small>
                    <h5 class="mb-0 text-success">
                        <?= number_format($produksi['HasilProduksi'], 2) ?> kg
                    </h5>
                </div>
            </div>

        </div>

        <!-- Penjelasan -->
        <div class="alert alert-info">

            <div class="d-flex align-items-start">

                <i class="ti ti-info-circle me-2 mt-1"></i>

                <div>

                    <strong>Petunjuk Pembagian Kemasan</strong>

                    <ul class="mb-0 mt-2">

                        <li>Masukkan jumlah kemasan yang ingin ditambahkan ke stok.</li>
                        <li>Sistem akan menghitung total berat seluruh kemasan.</li>
                        <li>Total berat tidak boleh melebihi hasil produksi (<?= number_format($produksi['HasilProduksi'], 2) ?> kg).</li>

                    </ul>

                </div>

            </div>

        </div>

        <!-- ===================================================== -->
        <!-- FORM -->
        <!-- ===================================================== -->
        <form action="<?= base_url('dataproduksi/simpanupdatestok') ?>" method="post" id="form-update-stok">

            <?= csrf_field(); ?>

            <input type="hidden" name="IdProduksi" value="<?= $produksi['IdProduksi'] ?>">

            <!-- ===================================================== -->
            <!-- TABEL KEMASAN -->
            <!-- ===================================================== -->
            <div class="table-responsive">

                <table class="table table-bordered align-middle" id="tabel-kemasan">

                    <thead class="table-light">

                        <tr>
                            <th>Kemasan</th>
                            <th width="120">Berat</th>
                            <th width="140">Stok Saat Ini</th>
                            <th width="180">Tambah Stok</th>
                            <th width="150">Total Berat</th>
                        </tr>

                    </thead>

                    <tbody>

                        <?php foreach ($kemasan as $k) : ?>

                            <?php
                            // Konversi ke gram untuk perhitungan
                            $beratGram = ($k['SatuanBerat'] == 'kg')
                                ? $k['Berat'] * 1000
                                : $k['Berat'];
                            ?>

                            <tr>

                                <!-- Nama Kemasan -->
                                <td>

                                    <strong><?= $k['NamaKemasan'] ?></strong>

                                    <input type="hidden" name="IdKemasan[]" value="<?= $k['IdKemasan'] ?>">

                                    <input type="hidden" class="berat-gram" value="<?= $beratGram ?>">

                                </td>

                                <!-- Berat -->
                                <td>

                                    <span class="badge bg-primary">

                                        <?= number_format($k['Berat'], 0) ?>
                                        <?= $k['SatuanBerat'] ?>

                                    </span>

                                </td>

                                <!-- Stok Saat Ini -->
                                <td class="text-center">

                                    <span class="badge bg-success fs-6">

                                        <?= $k['Stok'] ?>

                                    </span>

                                </td>

                                <!-- Input Tambah Stok -->
                                <td>

                                    <input
                                        type="number"
                                        name="TambahStok[]"
                                        class="form-control input-tambah-stok"
                                        value="0"
                                        min="0"
                                        step="1"
                                        placeholder="Jumlah kemasan">

                                </td>

                                <!-- Total Berat Baris -->
                                <td class="text-center">

                                    <span class="fw-bold total-berat-baris text-primary">

                                        0 gr

                                    </span>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

            <!-- ===================================================== -->
            <!-- RINGKASAN -->
            <!-- ===================================================== -->
            <div class="row mt-4">

                <div class="col-md-6">

                    <div class="border rounded p-3 bg-light h-100">

                        <div class="d-flex justify-content-between mb-2">
                            <span>Hasil Produksi</span>
                            <strong id="hasil-produksi-display">
                                <?= number_format($produksi['HasilProduksi'], 2) ?> kg
                            </strong>
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <span>Total Kemasan</span>
                            <strong id="total-kemasan">0 pcs</strong>
                        </div>

                        <div class="d-flex justify-content-between">
                            <span>Total Berat Kemasan</span>
                            <strong id="total-berat" class="text-primary">0 gr</strong>
                        </div>

                    </div>

                </div>

                <div class="col-md-6">

                    <div id="status-validasi" class="alert alert-success h-100 d-flex align-items-center mb-0">

                        <div>

                            <i class="ti ti-check-circle me-2"></i>
                            <strong>Pembagian kemasan masih dalam batas hasil produksi.</strong>

                        </div>

                    </div>

                </div>

            </div>

            <hr>

            <!-- ACTION -->
            <div class="d-flex justify-content-end gap-2">

                <a href="<?= base_url('dataproduksi') ?>" class="btn btn-secondary">
                    Batal
                </a>

                <button type="submit" class="btn btn-tambah" id="btn-simpan">

                    <i class="ti ti-device-floppy me-1"></i>
                    Simpan Update Stok

                </button>

            </div>

        </form>

    </div>
    ```

</div>

<script>
    // =====================================================
    // KONFIGURASI
    // =====================================================
    const hasilProduksiKg = <?= (float) $produksi['HasilProduksi'] ?>;
    const hasilProduksiGram = hasilProduksiKg * 1000;

    const form = document.getElementById('form-update-stok');
    const totalBeratEl = document.getElementById('total-berat');
    const totalKemasanEl = document.getElementById('total-kemasan');
    const statusValidasiEl = document.getElementById('status-validasi');
    const btnSimpan = document.getElementById('btn-simpan');

    // =====================================================
    // HITUNG TOTAL
    // =====================================================
    function hitungTotal() {

        let totalGram = 0;
        let totalKemasan = 0;

        document.querySelectorAll('#tabel-kemasan tbody tr').forEach(row => {

            const beratGram = parseFloat(
                row.querySelector('.berat-gram').value
            );

            const qty = parseInt(
                row.querySelector('.input-tambah-stok').value || 0
            );

            const totalBaris = beratGram * qty;

            // Update total per baris
            row.querySelector('.total-berat-baris').textContent =
                totalBaris.toLocaleString('id-ID') + ' gr';

            totalGram += totalBaris;
            totalKemasan += qty;

        });

        // Update ringkasan
        totalBeratEl.textContent =
            totalGram.toLocaleString('id-ID') + ' gr';

        totalKemasanEl.textContent =
            totalKemasan.toLocaleString('id-ID') + ' pcs';

        // =====================================================
        // VALIDASI
        // =====================================================
        if (totalGram > hasilProduksiGram) {

            statusValidasiEl.className =
                'alert alert-danger h-100 d-flex align-items-center mb-0';

            statusValidasiEl.innerHTML = `
                <div>
                    <i class="ti ti-alert-triangle me-2"></i>
                    <strong>Total kemasan melebihi hasil produksi!</strong>
                    <br>
                    Maksimal: ${hasilProduksiGram.toLocaleString('id-ID')} gr
                </div>
            `;

            btnSimpan.disabled = true;

        } else {

            const sisa = hasilProduksiGram - totalGram;

            statusValidasiEl.className =
                'alert alert-success h-100 d-flex align-items-center mb-0';

            statusValidasiEl.innerHTML = `
                <div>
                    <i class="ti ti-check-circle me-2"></i>
                    <strong>Pembagian kemasan valid.</strong>
                    <br>
                    Sisa hasil produksi: ${sisa.toLocaleString('id-ID')} gr
                </div>
            `;

            btnSimpan.disabled = false;
        }
    }

    // =====================================================
    // EVENT INPUT
    // =====================================================
    document.querySelectorAll('.input-tambah-stok').forEach(input => {

        input.addEventListener('input', function() {

            // Tidak boleh negatif
            if (this.value < 0) {
                this.value = 0;
            }

            hitungTotal();

        });

    });

    // =====================================================
    // VALIDASI SEBELUM SUBMIT
    // =====================================================
    form.addEventListener('submit', function(e) {

        let totalGram = 0;

        document.querySelectorAll('#tabel-kemasan tbody tr').forEach(row => {

            const beratGram = parseFloat(
                row.querySelector('.berat-gram').value
            );

            const qty = parseInt(
                row.querySelector('.input-tambah-stok').value || 0
            );

            totalGram += beratGram * qty;

        });

        if (totalGram > hasilProduksiGram) {

            e.preventDefault();

            Swal.fire({
                icon: 'error',
                title: 'Pembagian Tidak Valid',
                text: 'Total berat kemasan melebihi hasil produksi.'
            });

            return false;
        }

    });

    // =====================================================
    // HITUNG AWAL
    // =====================================================
    hitungTotal();
</script>

<?= $this->endSection() ?>