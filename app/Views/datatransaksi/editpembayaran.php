<?= $this->extend('layout/dashboard') ?>

<?= $this->section('content') ?>

<div class="card card-pengguna">

```
<!-- HEADER -->
<div class="card-header card-header-pengguna">

    <div class="d-flex justify-content-between align-items-center">

        <div>
            <h3>Edit Pembayaran</h3>
            <small>Perbarui transaksi pembayaran pelanggan</small>
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

    <form action="<?= base_url('datapembayaran/update') ?>"
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
                    value="<?= $pembayaran['IdPembayaran'] ?>"
                    readonly>

            </div>

            <!-- TANGGAL BAYAR -->
            <div class="col-md-6 mb-3">

                <label class="form-label">Tanggal Bayar</label>

                <input
                    type="date"
                    name="TglBayar"
                    class="form-control"
                    value="<?= old('TglBayar', $pembayaran['TglBayar']) ?>"
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
                            <?= old('IdPesanan', $pembayaran['IdPesanan']) == $p['IdPesanan'] ? 'selected' : '' ?>>

                            <?= $p['IdPesanan'] ?> -
                            <?= $p['NamaPelanggan'] ?>

                        </option>

                    <?php endforeach; ?>

                </select>

                <small class="text-muted">
                    Menampilkan pesanan yang masih dapat dilakukan pembayaran.
                </small>

            </div>

            <!-- NAMA PELANGGAN -->
            <div class="col-md-6 mb-3">

                <label class="form-label">Nama Pelanggan</label>

                <input
                    type="text"
                    id="nama-pelanggan"
                    class="form-control"
                    readonly>

            </div>

            <!-- TOTAL PESANAN -->
            <div class="col-md-6 mb-3">

                <label class="form-label">Total Pesanan</label>

                <input
                    type="text"
                    id="total-pesanan-display"
                    class="form-control fw-bold text-success"
                    readonly>

                <input type="hidden" id="total-pesanan" value="0">

            </div>

            <!-- JENIS PEMBAYARAN -->
            <div class="col-md-6 mb-3">

                <label class="form-label">Jenis Pembayaran</label>

                <select name="JenisPembayaran"
                        id="JenisPembayaran"
                        class="form-select"
                        required>

                    <option value="">-- Pilih Jenis --</option>

                    <option value="DP"
                        <?= old('JenisPembayaran', $pembayaran['JenisPembayaran']) == 'DP' ? 'selected' : '' ?>>
                        DP
                    </option>

                    <option value="Pelunasan"
                        <?= old('JenisPembayaran', $pembayaran['JenisPembayaran']) == 'Pelunasan' ? 'selected' : '' ?>>
                        Pelunasan
                    </option>

                    <option value="Full Payment"
                        <?= old('JenisPembayaran', $pembayaran['JenisPembayaran']) == 'Full Payment' ? 'selected' : '' ?>>
                        Full Payment
                    </option>

                </select>

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
                        value="<?= old('JumlahBayar', $pembayaran['JumlahBayar']) ?>"
                        required>

                </div>

            </div>

            <!-- METODE -->
            <div class="col-md-6 mb-3">

                <label class="form-label">Metode Pembayaran</label>

                <select name="MetodePembayaran" class="form-select" required>

                    <option value="Transfer"
                        <?= old('MetodePembayaran', $pembayaran['MetodePembayaran']) == 'Transfer' ? 'selected' : '' ?>>
                        Transfer
                    </option>

                    <option value="Cash"
                        <?= old('MetodePembayaran', $pembayaran['MetodePembayaran']) == 'Cash' ? 'selected' : '' ?>>
                        Cash
                    </option>

                </select>

            </div>

            <!-- STATUS -->
            <div class="col-md-6 mb-3">

                <label class="form-label">Status Pembayaran</label>

                <select name="StatusPembayaran" class="form-select" required>

                    <option value="Belum Bayar"
                        <?= old('StatusPembayaran', $pembayaran['StatusPembayaran']) == 'Belum Bayar' ? 'selected' : '' ?>>
                        Belum Bayar
                    </option>

                    <option value="Menunggu Verifikasi"
                        <?= old('StatusPembayaran', $pembayaran['StatusPembayaran']) == 'Menunggu Verifikasi' ? 'selected' : '' ?>>
                        Menunggu Verifikasi
                    </option>

                    <option value="Terverifikasi"
                        <?= old('StatusPembayaran', $pembayaran['StatusPembayaran']) == 'Terverifikasi' ? 'selected' : '' ?>>
                        Terverifikasi
                    </option>

                    <option value="Ditolak"
                        <?= old('StatusPembayaran', $pembayaran['StatusPembayaran']) == 'Ditolak' ? 'selected' : '' ?>>
                        Ditolak
                    </option>

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

                <?php if (!empty($pembayaran['BuktiPembayaran'])) : ?>

                    <div class="mt-2">

                        <small class="text-muted d-block mb-2">Bukti saat ini:</small>

                        <a href="<?= base_url('uploads/pembayaran/' . $pembayaran['BuktiPembayaran']) ?>"
                           target="_blank"
                           class="btn btn-outline-primary btn-sm">

                            <i class="ti ti-eye me-1"></i>
                            Lihat Bukti

                        </a>

                    </div>

                <?php endif; ?>

                <div id="preview-bukti" class="mt-2"></div>

            </div>

        </div>

        <!-- RINGKASAN -->
        <div class="card bg-light border-0 mt-3">

            <div class="card-body">

                <div class="row text-center">

                    <div class="col-md-3">

                        <small class="text-muted d-block">Total Pesanan</small>

                        <h5 id="summary-total" class="text-success mb-0">Rp 0</h5>

                    </div>

                    <div class="col-md-3">

                        <small class="text-muted d-block">Sudah Dibayar</small>

                        <h5 id="summary-sebelumnya" class="text-primary mb-0">Rp 0</h5>

                    </div>

                    <div class="col-md-3">

                        <small class="text-muted d-block">Pembayaran Saat Ini</small>

                        <h5 id="summary-bayar" class="text-info mb-0">Rp 0</h5>

                    </div>

                    <div class="col-md-3">

                        <small class="text-muted d-block">Sisa Pembayaran</small>

                        <h5 id="summary-sisa" class="text-danger mb-0">Rp 0</h5>

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
                Update Pembayaran

            </button>

        </div>

    </form>

</div>
```

</div>

<script>
const selectPesanan = document.getElementById('select-pesanan');
const namaPelanggan = document.getElementById('nama-pelanggan');
const totalDisplay = document.getElementById('total-pesanan-display');
const totalHidden = document.getElementById('total-pesanan');
const jumlahBayar = document.getElementById('jumlah-bayar');

let totalSebelumnya = 0;

// =====================================================
// UPDATE DATA PESANAN
// =====================================================
function updateDataPesanan() {

    const selected = selectPesanan.options[selectPesanan.selectedIndex];

    if (!selected || !selected.value) return;

    const pelanggan = selected.dataset.pelanggan || '';
    const total = parseInt(selected.dataset.total || 0);

    totalSebelumnya = parseInt(selected.dataset.totalbayar || 0);

    // Kurangi pembayaran yang sedang diedit agar tidak double count
    totalSebelumnya -= parseInt(jumlahBayar.value || 0);

    namaPelanggan.value = pelanggan;
    totalHidden.value = total;

    totalDisplay.value = 'Rp ' + total.toLocaleString('id-ID');

    updateRingkasan();
}

// =====================================================
// UPDATE RINGKASAN
// =====================================================
function updateRingkasan() {

    const total = parseInt(totalHidden.value || 0);
    const bayarSaatIni = parseInt(jumlahBayar.value || 0);

    const totalSetelahBayar = totalSebelumnya + bayarSaatIni;
    const sisa = Math.max(total - totalSetelahBayar, 0);

    document.getElementById('summary-total').textContent =
        'Rp ' + total.toLocaleString('id-ID');

    document.getElementById('summary-sebelumnya').textContent =
        'Rp ' + totalSebelumnya.toLocaleString('id-ID');

    document.getElementById('summary-bayar').textContent =
        'Rp ' + bayarSaatIni.toLocaleString('id-ID');

    document.getElementById('summary-sisa').textContent =
        'Rp ' + sisa.toLocaleString('id-ID');
}

// Event
selectPesanan.addEventListener('change', updateDataPesanan);
jumlahBayar.addEventListener('input', updateRingkasan);

// Preview file
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

// Inisialisasi saat halaman dibuka
window.addEventListener('load', updateDataPesanan);
</script>

<?= $this->endSection() ?>
