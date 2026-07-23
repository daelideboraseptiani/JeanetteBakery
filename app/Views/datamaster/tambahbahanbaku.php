<?= $this->extend('layout/dashboard') ?>

<?= $this->section('content') ?>

<div class="card card-pengguna">

```
<div class="card-header card-header-pengguna">

    <div class="d-flex justify-content-between align-items-center">

        <div>
            <h3>Tambah Bahan Baku</h3>
            <small>Masukkan data bahan baku untuk kebutuhan produksi</small>
        </div>

        <a href="<?= base_url('databahanbaku') ?>" class="btn btn-secondary">

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

    <form action="<?= base_url('databahanbaku/simpan') ?>" method="post">

        <?= csrf_field(); ?>

        <div class="row">

            <!-- ID BAHAN -->
            <div class="col-md-6 mb-3">

                <label class="form-label">ID Bahan Baku</label>

                <input
                    type="text"
                    name="IdBahanBaku"
                    class="form-control"
                    value="<?= $IdBahanBaku ?>"
                    readonly>

            </div>

            <!-- SATUAN -->
            <div class="col-md-6 mb-3">

                <label class="form-label">Satuan</label>

                <select name="Satuan" class="form-select" required>

                    <option value="">-- Pilih Satuan --</option>

                    <option value="kg" <?= old('Satuan') == 'kg' ? 'selected' : '' ?>>
                        Kilogram (kg)
                    </option>

                    <option value="gram" <?= old('Satuan') == 'gram' ? 'selected' : '' ?>>
                        Gram (gram)
                    </option>

                    <option value="liter" <?= old('Satuan') == 'liter' ? 'selected' : '' ?>>
                        Liter
                    </option>

                    <option value="ml" <?= old('Satuan') == 'ml' ? 'selected' : '' ?>>
                        Mililiter (ml)
                    </option>

                    <option value="pcs" <?= old('Satuan') == 'pcs' ? 'selected' : '' ?>>
                        Pcs
                    </option>

                    <option value="bungkus" <?= old('Satuan') == 'bungkus' ? 'selected' : '' ?>>
                        Bungkus
                    </option>

                    <option value="toples" <?= old('Satuan') == 'toples' ? 'selected' : '' ?>>
                        Toples
                    </option>

                </select>

            </div>

            <!-- NAMA BAHAN -->
            <div class="col-md-6 mb-3">

                <label class="form-label">Nama Bahan</label>

                <input
                    type="text"
                    name="NamaBahan"
                    class="form-control"
                    value="<?= old('NamaBahan') ?>"
                    placeholder="Contoh: Tepung Terigu, Gula Halus, Margarin"
                    required>

            </div>

            <!-- MERK -->
            <div class="col-md-6 mb-3">

                <label class="form-label">Merk</label>

                <input
                    type="text"
                    name="Merk"
                    class="form-control"
                    value="<?= old('Merk') ?>"
                    placeholder="Contoh: Segitiga Biru, Blue Band">

                <small class="text-muted">
                    Opsional, isi jika bahan memiliki merk tertentu.
                </small>

            </div>

            <!-- STOK -->
            <div class="col-md-6 mb-3">

                <label class="form-label">Stok Awal</label>

                <input
                    type="number"
                    step="0.01"
                    name="Stok"
                    class="form-control"
                    value="<?= old('Stok', 0) ?>"
                    min="0"
                    placeholder="Masukkan jumlah stok"
                    required>

                <small class="text-muted">
                    Gunakan desimal jika diperlukan, contoh: 10.50 kg.
                </small>

            </div>

            <!-- HARGA -->
            <div class="col-md-6 mb-3">

                <label class="form-label">Harga per Satuan</label>

                <div class="input-group">

                    <span class="input-group-text">Rp</span>

                    <input
                        type="number"
                        step="1"
                        name="Harga"
                        class="form-control"
                        value="<?= old('Harga') ?>"
                        min="0"
                        placeholder="Masukkan harga"
                        required>

                </div>

                <small class="text-muted">
                    Contoh: harga per kg, per liter, atau per pcs sesuai satuan.
                </small>

            </div>

        </div>

        <hr>

        <div class="d-flex justify-content-end gap-2">

            <a href="<?= base_url('databahanbaku') ?>" class="btn btn-secondary">
                Batal
            </a>

            <button type="submit" class="btn btn-tambah">

                <i class="ti ti-device-floppy me-1"></i>
                Simpan Data

            </button>

        </div>

    </form>

</div>
```

</div>

<script>

    // =========================
    // VALIDASI ANGKA POSITIF
    // =========================
    document.querySelectorAll('input[type="number"]').forEach(input => {

        input.addEventListener('input', function() {

            if (this.value < 0) {
                this.value = 0;
            }

        });

    });

    // =========================
    // FOKUS OTOMATIS
    // =========================
    window.addEventListener('load', function() {

        document.querySelector('input[name="NamaBahan"]').focus();

    });

</script>

<?= $this->endSection() ?>
