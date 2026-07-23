<?= $this->extend('layout/dashboard') ?>

<?= $this->section('content') ?>

<div class="card card-pengguna">


    <!-- HEADER -->
    <div class="card-header card-header-pengguna">

        <div class="d-flex justify-content-between align-items-center">

            <div>
                <h3>Tambah Pembayaran</h3>
                <small>Input transaksi pembayaran pelanggan</small>
            </div>

            <a href="<?= base_url('datapembayaran') ?>" class="btn btn-secondary">

                <i class="ti ti-arrow-left me-1"></i>
                Kembali

            </a>

        </div>

    </div>

    <div class="card-body">

        <!-- FLASH ERROR -->
        <?php if (session()->getFlashdata('error')) : ?>

            <div class="alert alert-danger alert-dismissible fade show">

                <?= session()->getFlashdata('error') ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>

            </div>

        <?php endif; ?>

        <!-- VALIDATION ERRORS -->
        <?php if (session()->getFlashdata('errors')) : ?>

            <div class="alert alert-danger">

                <ul class="mb-0">

                    <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>

                </ul>

            </div>

        <?php endif; ?>

        <form action="<?= base_url('datapembayaran/simpan') ?>"
            method="post"
            enctype="multipart/form-data"
            id="form-pembayaran">

            <?= csrf_field(); ?>

            <div class="row">

                <!-- ID PEMBAYARAN -->
                <div class="col-md-6 mb-3">

                    <label class="form-label">ID Pembayaran</label>

                    <input
                        type="text"
                        name="IdPembayaran"
                        class="form-control"
                        value="<?= $IdPembayaran ?>"
                        readonly>

                </div>

                <!-- TANGGAL BAYAR -->
                <div class="col-md-6 mb-3">

                    <label class="form-label">Tanggal Bayar</label>

                    <input
                        type="date"
                        name="TglBayar"
                        class="form-control"
                        value="<?= date('Y-m-d') ?>"
                        required>

                </div>

                <!-- PESANAN -->
                <div class="col-md-6 mb-3">


                    <label class="form-label">Pesanan</label>

                    <select name="IdPesanan"
                        id="select-pesanan"
                        class="form-select"
                        required>

                        <option value="">-- Pilih Pesanan --</option>

                        <?php foreach ($pesanan as $p) : ?>

                            <option
                                value="<?= $p['IdPesanan'] ?>"
                                data-pelanggan="<?= esc($p['NamaPelanggan']) ?>"
                                data-total="<?= $p['Total'] ?>"
                                data-totalbayar="<?= $p['TotalDibayar'] ?? 0 ?>"
                                <?= old('IdPesanan') == $p['IdPesanan'] ? 'selected' : '' ?>>

                                <?= $p['IdPesanan'] ?> -
                                <?= $p['NamaPelanggan'] ?>

                            </option>

                        <?php endforeach; ?>

                    </select>

                    <small class="text-muted">
                        Menampilkan pesanan yang masih dapat dilakukan pembayaran
                        (belum lunas atau masih proses DP).
                    </small>


                </div>


                <!-- NAMA PELANGGAN -->
                <div class="col-md-6 mb-3">

                    <label class="form-label">Nama Pelanggan</label>

                    <input
                        type="text"
                        id="nama-pelanggan"
                        class="form-control"
                        placeholder="Akan terisi otomatis"
                        readonly>

                </div>

                <!-- TOTAL PESANAN -->
                <div class="col-md-6 mb-3">

                    <label class="form-label">Total Pesanan</label>

                    <input
                        type="text"
                        id="total-pesanan-display"
                        class="form-control fw-bold text-success"
                        placeholder="Rp 0"
                        readonly>

                    <input type="hidden" id="total-pesanan" value="0">

                </div>

                <!-- JENIS PEMBAYARAN -->
                <div class="col-md-6 mb-3">

                    <label class="form-label">Jenis Pembayaran</label>

                    <select name="JenisPembayaran"
                        id="jenis-pembayaran"
                        class="form-select"
                        required>

                        <option value="">-- Pilih Jenis --</option>
                        <option value="DP">DP</option>
                        <option value="Pelunasan">Pelunasan</option>
                        <option value="Full Payment">Full Payment</option>

                    </select>

                    <small class="text-muted">
                        DP = pembayaran awal, Pelunasan = sisa pembayaran.
                    </small>

                </div>

                <!-- JUMLAH BAYAR -->
                <div class="col-md-6 mb-3">

                    <label class="form-label">Jumlah Bayar</label>

                    <div class="input-group">

                        <span class="input-group-text">Rp</span>

                        <input
                            type="number"
                            name="JumlahBayar"
                            id="jumlah-bayar"
                            class="form-control"
                            placeholder="Masukkan jumlah pembayaran"
                            required>

                    </div>

                    <small id="info-pembayaran" class="text-muted"></small>

                </div>

                <!-- METODE -->
                <div class="col-md-6 mb-3">

                    <label class="form-label">Metode Pembayaran</label>

                    <select name="MetodePembayaran" class="form-select" required>

                        <option value="">-- Pilih Metode --</option>
                        <option value="Transfer">Transfer</option>
                        <option value="Cash">Cash</option>
                        <option value="QRIS">QRIS</option>

                    </select>

                </div>

                <!-- STATUS -->
                <div class="col-md-6 mb-3">

                    <label class="form-label">Status Pembayaran</label>

                    <select name="StatusPembayaran" class="form-select" required>

                        <option value="Belum Bayar">Belum Bayar</option>
                        <option value="Menunggu Verifikasi" selected>
                            Menunggu Verifikasi
                        </option>
                        <option value="Terverifikasi">Terverifikasi</option>
                        <option value="Ditolak">Ditolak</option>

                    </select>

                </div>

                <!-- BUKTI -->
                <div class="col-12 mb-3">

                    <label class="form-label">Bukti Pembayaran</label>

                    <input
                        type="file"
                        name="BuktiPembayaran"
                        id="bukti-pembayaran"
                        class="form-control"
                        accept="image/*,.pdf">

                    <small class="text-muted">
                        Format: JPG, JPEG, PNG, atau PDF
                    </small>

                    <div id="preview-bukti" class="mt-2"></div>

                </div>

            </div>

            <!-- RINGKASAN -->
            <div class="card bg-light border-0 mt-3">


                <div class="card-body">

                    <div class="row text-center">

                        <!-- TOTAL PESANAN -->
                        <div class="col-md-3">

                            <small class="text-muted d-block">Total Pesanan</small>

                            <h5 id="summary-total" class="text-success mb-0">
                                Rp 0
                            </h5>

                        </div>

                        <!-- SUDAH DIBAYAR -->
                        <div class="col-md-3">

                            <small class="text-muted d-block">Sudah Dibayar</small>

                            <h5 id="summary-sebelumnya" class="text-primary mb-0">
                                Rp 0
                            </h5>

                        </div>

                        <!-- PEMBAYARAN SAAT INI -->
                        <div class="col-md-3">

                            <small class="text-muted d-block">Pembayaran Saat Ini</small>

                            <h5 id="summary-bayar" class="text-info mb-0">
                                Rp 0
                            </h5>

                        </div>

                        <!-- SISA -->
                        <div class="col-md-3">

                            <small class="text-muted d-block">Sisa Pembayaran</small>

                            <h5 id="summary-sisa" class="text-danger mb-0">
                                Rp 0
                            </h5>

                        </div>

                    </div>

                </div>


            </div>


            <hr>

            <!-- ACTION -->
            <div class="d-flex justify-content-end gap-2">

                <a href="<?= base_url('datapembayaran') ?>" class="btn btn-secondary">
                    Batal
                </a>

                <button type="submit" class="btn btn-tambah">

                    <i class="ti ti-device-floppy me-1"></i>
                    Simpan Pembayaran

                </button>

            </div>

        </form>

    </div>


</div>

<script>
    const selectPesanan = document.getElementById('select-pesanan');
    const namaPelanggan = document.getElementById('nama-pelanggan');
    const totalDisplay = document.getElementById('total-pesanan-display');
    const totalHidden = document.getElementById('total-pesanan');
    const jenisPembayaran = document.getElementById('jenis-pembayaran');
    const jumlahBayar = document.getElementById('jumlah-bayar');
    const infoPembayaran = document.getElementById('info-pembayaran');

    // Total pembayaran yang SUDAH terverifikasi
    let totalSebelumnya = 0;


    // =====================================================
    // PILIH PESANAN
    // =====================================================
    selectPesanan.addEventListener('change', function() {


        const selected = this.options[this.selectedIndex];

        const pelanggan = selected.dataset.pelanggan || '';
        const total = parseInt(selected.dataset.total || 0);

        // Ambil total yang sudah dibayar
        totalSebelumnya = parseInt(selected.dataset.totalbayar || 0);

        namaPelanggan.value = pelanggan;
        totalHidden.value = total;

        totalDisplay.value =
            'Rp ' + total.toLocaleString('id-ID');

        // =====================================================
        // AUTO ISI BERDASARKAN JENIS
        // =====================================================

        // Full Payment
        if (jenisPembayaran.value === 'Full Payment') {

            jumlahBayar.value = total;

        }

        // Pelunasan
        if (jenisPembayaran.value === 'Pelunasan') {

            const sisa = total - totalSebelumnya;

            jumlahBayar.value = sisa > 0 ? sisa : 0;

        }

        updateRingkasan();


    });


    // =====================================================
    // JENIS PEMBAYARAN
    // =====================================================
    jenisPembayaran.addEventListener('change', function() {


        const total = parseInt(totalHidden.value || 0);

        // =====================================================
        // FULL PAYMENT
        // =====================================================
        if (this.value === 'Full Payment') {

            jumlahBayar.value = total;

            infoPembayaran.textContent =
                'Jumlah otomatis sama dengan total pesanan.';

        }

        // =====================================================
        // DP
        // =====================================================
        else if (this.value === 'DP') {

            jumlahBayar.value = '';

            infoPembayaran.textContent =
                'Masukkan jumlah DP yang dibayarkan pelanggan.';

        }

        // =====================================================
        // PELUNASAN
        // =====================================================
        else if (this.value === 'Pelunasan') {

            const sisa = total - totalSebelumnya;

            jumlahBayar.value = sisa > 0 ? sisa : 0;

            infoPembayaran.textContent =
                'Jumlah otomatis diisi sesuai sisa pembayaran.';

        } else {

            infoPembayaran.textContent = '';

        }

        updateRingkasan();


    });


    // =====================================================
    // INPUT JUMLAH BAYAR
    // =====================================================
    jumlahBayar.addEventListener('input', updateRingkasan);

    // =====================================================
    // UPDATE RINGKASAN
    // =====================================================
    function updateRingkasan() {


        const total = parseInt(totalHidden.value || 0);

        // Pembayaran yang sedang diinput
        const bayarSaatIni = parseInt(jumlahBayar.value || 0);

        // Pembayaran yang SUDAH ada sebelumnya
        const sebelumnya = totalSebelumnya;

        // Total setelah pembayaran saat ini
        const totalSetelahBayar = sebelumnya + bayarSaatIni;

        // Sisa pembayaran
        const sisa = Math.max(total - totalSetelahBayar, 0);

        // =====================================================
        // TAMPILKAN KE CARD
        // =====================================================

        // Total Pesanan
        document.getElementById('summary-total').textContent =
            'Rp ' + total.toLocaleString('id-ID');

        // Sudah Dibayar
        document.getElementById('summary-sebelumnya').textContent =
            'Rp ' + sebelumnya.toLocaleString('id-ID');

        // Pembayaran Saat Ini
        document.getElementById('summary-bayar').textContent =
            'Rp ' + bayarSaatIni.toLocaleString('id-ID');

        // Sisa
        document.getElementById('summary-sisa').textContent =
            'Rp ' + sisa.toLocaleString('id-ID');


    }


    // =====================================================
    // PREVIEW FILE
    // =====================================================
    document.getElementById('bukti-pembayaran')
        .addEventListener('change', function() {

            const preview = document.getElementById('preview-bukti');

            preview.innerHTML = '';

            if (this.files.length > 0) {

                const file = this.files[0];

                preview.innerHTML = `
                    <div class="alert alert-info py-2 mb-0">
                        <i class="ti ti-file me-1"></i>
                        <strong>File dipilih:</strong> ${file.name}
                    </div>
                `;
            }

        });

    // =====================================================
    // VALIDASI SUBMIT
    // =====================================================
    document.getElementById('form-pembayaran')
        .addEventListener('submit', function(e) {

            const total = parseInt(totalHidden.value || 0);
            const bayar = parseInt(jumlahBayar.value || 0);
            const jenis = jenisPembayaran.value;

            if (bayar <= 0) {

                e.preventDefault();

                Swal.fire({
                    icon: 'error',
                    title: 'Jumlah Tidak Valid',
                    text: 'Jumlah pembayaran harus lebih dari 0.'
                });

                return false;

            }

            if (jenis === 'Full Payment' && bayar !== total) {

                e.preventDefault();

                Swal.fire({
                    icon: 'error',
                    title: 'Full Payment Tidak Sesuai',
                    text: 'Jumlah pembayaran harus sama dengan total pesanan.'
                });

                return false;

            }

            if (jenis === 'DP' && bayar >= total) {

                e.preventDefault();

                Swal.fire({
                    icon: 'error',
                    title: 'DP Tidak Valid',
                    text: 'Jumlah DP harus lebih kecil dari total pesanan.'
                });

                return false;

            }

        });

    // Inisialisasi
    updateRingkasan();
</script>

<?= $this->endSection() ?>