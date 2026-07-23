<?= $this->extend('layout/dashboard') ?>

<?= $this->section('content') ?>

<div class="card card-pengguna">

```
<div class="card-header card-header-pengguna">

    <div class="d-flex justify-content-between align-items-center">

        <div>
            <h3>Edit Bahan Baku</h3>
            <small>Perbarui data bahan baku untuk kebutuhan produksi</small>
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

    <form action="<?= base_url('databahanbaku/update') ?>" method="post">

        <?= csrf_field(); ?>

        <!-- Hidden ID -->
        <input type="hidden" name="IdBahanBaku" value="<?= $bahan['IdBahanBaku'] ?>">

        <div class="row">

            <!-- ID BAHAN -->
            <div class="col-md-6 mb-3">

                <label class="form-label">ID Bahan Baku</label>

                <input
                    type="text"
                    class="form-control"
                    value="<?= $bahan['IdBahanBaku'] ?>"
                    readonly>

            </div>

            <!-- SATUAN -->
            <div class="col-md-6 mb-3">

                <label class="form-label">Satuan</label>

                <select name="Satuan" class="form-select" required>

                    <option value="kg"
                        <?= old('Satuan', $bahan['Satuan']) == 'kg' ? 'selected' : '' ?>>

                        Kilogram (kg)

                    </option>

                    <option value="gram"
                        <?= old('Satuan', $bahan['Satuan']) == 'gram' ? 'selected' : '' ?>>

                        Gram (gram)

                    </option>

                    <option value="liter"
                        <?= old('Satuan', $bahan['Satuan']) == 'liter' ? 'selected' : '' ?>>

                        Liter

                    </option>

                    <option value="ml"
                        <?= old('Satuan', $bahan['Satuan']) == 'ml' ? 'selected' : '' ?>>

                        Mililiter (ml)

                    </option>

                    <option value="pcs"
                        <?= old('Satuan', $bahan['Satuan']) == 'pcs' ? 'selected' : '' ?>>

                        Pcs

                    </option>

                    <option value="bungkus"
                        <?= old('Satuan', $bahan['Satuan']) == 'bungkus' ? 'selected' : '' ?>>

                        Bungkus

                    </option>

                    <option value="toples"
                        <?= old('Satuan', $bahan['Satuan']) == 'toples' ? 'selected' : '' ?>>

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
                    value="<?= old('NamaBahan', $bahan['NamaBahan']) ?>"
                    required>

            </div>

            <!-- MERK -->
            <div class="col-md-6 mb-3">

                <label class="form-label">Merk</label>

                <input
                    type="text"
                    name="Merk"
                    class="form-control"
                    value="<?= old('Merk', $bahan['Merk']) ?>"
                    placeholder="Masukkan merk bahan">

            </div>

            <!-- STOK -->
            <div class="col-md-6 mb-3">

                <label class="form-label">Stok</label>

                <input
                    type="number"
                    step="0.01"
                    name="Stok"
                    class="form-control"
                    value="<?= old('Stok', $bahan['Stok']) ?>"
                    min="0"
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
                        value="<?= old('Harga', $bahan['Harga']) ?>"
                        min="0"
                        required>

                </div>

                <small class="text-muted">
                    Sesuaikan harga dengan satuan bahan yang dipilih.
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
                Update Data

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
