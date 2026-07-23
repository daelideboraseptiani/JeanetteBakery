<?= $this->extend('layout/dashboard') ?>

<?= $this->section('content') ?>

<div class="card card-pengguna">

```
<div class="card-header card-header-pengguna">

    <div class="d-flex justify-content-between align-items-center">

        <div>
            <h3>Edit Kemasan</h3>
            <small>Perbarui data kemasan, harga, stok, dan foto produk</small>
        </div>

        <a href="<?= base_url('datakemasan') ?>" class="btn btn-secondary">

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

    <form action="<?= base_url('datakemasan/update') ?>"
          method="post"
          enctype="multipart/form-data">

        <?= csrf_field(); ?>

        <!-- Hidden -->
        <input type="hidden" name="IdKemasan" value="<?= $kemasan['IdKemasan'] ?>">

        <div class="row">

            <!-- ID KEMASAN -->
            <div class="col-md-6 mb-3">

                <label class="form-label">ID Kemasan</label>

                <input
                    type="text"
                    class="form-control"
                    value="<?= $kemasan['IdKemasan'] ?>"
                    readonly>

            </div>

            <!-- STATUS -->
            <div class="col-md-6 mb-3">

                <label class="form-label">Status Kemasan</label>

                <select name="StatusKemasan" class="form-select" required>

                    <option value="Aktif"
                        <?= old('StatusKemasan', $kemasan['StatusKemasan']) == 'Aktif' ? 'selected' : '' ?>>

                        Aktif

                    </option>

                    <option value="Nonaktif"
                        <?= old('StatusKemasan', $kemasan['StatusKemasan']) == 'Nonaktif' ? 'selected' : '' ?>>

                        Nonaktif

                    </option>

                </select>

            </div>

            <!-- PRODUK -->
            <div class="col-md-6 mb-3">

                <label class="form-label">Produk</label>

                <select name="IdProduk" class="form-select" required>

                    <option value="">-- Pilih Produk --</option>

                    <?php foreach ($produk as $p) : ?>

                        <option value="<?= $p['IdProduk'] ?>"
                            <?= old('IdProduk', $kemasan['IdProduk']) == $p['IdProduk'] ? 'selected' : '' ?>>

                            <?= $p['NamaProduk'] ?>

                        </option>

                    <?php endforeach; ?>

                </select>

            </div>

            <!-- NAMA KEMASAN -->
            <div class="col-md-6 mb-3">

                <label class="form-label">Nama Kemasan</label>

                <input
                    type="text"
                    name="NamaKemasan"
                    class="form-control"
                    value="<?= old('NamaKemasan', $kemasan['NamaKemasan']) ?>"
                    required>

            </div>

            <!-- BERAT -->
            <div class="col-md-6 mb-3">

                <label class="form-label">Berat</label>

                <input
                    type="number"
                    step="0.01"
                    name="Berat"
                    class="form-control"
                    value="<?= old('Berat', $kemasan['Berat']) ?>"
                    required>

            </div>

            <!-- SATUAN -->
            <div class="col-md-6 mb-3">

                <label class="form-label">Satuan Berat</label>

                <select name="SatuanBerat" class="form-select" required>

                    <option value="gram"
                        <?= old('SatuanBerat', $kemasan['SatuanBerat']) == 'gram' ? 'selected' : '' ?>>

                        gram

                    </option>

                    <option value="kg"
                        <?= old('SatuanBerat', $kemasan['SatuanBerat']) == 'kg' ? 'selected' : '' ?>>

                        kg

                    </option>

                </select>

            </div>

            <!-- HARGA -->
            <div class="col-md-6 mb-3">

                <label class="form-label">Harga</label>

                <div class="input-group">

                    <span class="input-group-text">Rp</span>

                    <input
                        type="number"
                        step="1"
                        name="Harga"
                        class="form-control"
                        value="<?= old('Harga', $kemasan['Harga']) ?>"
                        required>

                </div>

            </div>

            <!-- STOK -->
            <div class="col-md-6 mb-3">

                <label class="form-label">Stok</label>

                <input
                    type="number"
                    name="Stok"
                    class="form-control"
                    value="<?= old('Stok', $kemasan['Stok']) ?>"
                    min="0"
                    required>

            </div>

            <!-- FOTO -->
            <div class="col-12 mb-3">

                <label class="form-label">Ganti Foto Kemasan</label>

                <input
                    type="file"
                    name="Foto"
                    id="foto-input"
                    class="form-control"
                    accept="image/*">

                <small class="text-muted">
                    Kosongkan jika tidak ingin mengganti foto.
                </small>

            </div>

            <!-- FOTO SAAT INI -->
            <div class="col-md-6 mb-3">

                <label class="form-label">Foto Saat Ini</label>

                <div class="border rounded p-3 text-center">

                    <?php if (!empty($kemasan['Foto'])) : ?>

                        <img
                            src="<?= base_url('storage/fotokemasan/' . $kemasan['Foto']) ?>"
                            alt="Foto Saat Ini"
                            style="max-width: 200px; max-height: 200px; object-fit: cover;"
                            class="rounded">

                    <?php else : ?>

                        <div class="text-muted py-5">

                            <i class="ti ti-photo fs-1 d-block mb-2"></i>
                            Belum ada foto

                        </div>

                    <?php endif; ?>

                </div>

            </div>

            <!-- PREVIEW FOTO BARU -->
            <div class="col-md-6 mb-3">

                <label class="form-label">Preview Foto Baru</label>

                <div class="border rounded p-3 text-center">

                    <img
                        id="preview-foto"
                        src=""
                        alt="Preview Foto Baru"
                        style="max-width: 200px; max-height: 200px; object-fit: cover; display: none;"
                        class="rounded">

                    <div id="placeholder-foto" class="text-muted py-5">

                        <i class="ti ti-upload fs-1 d-block mb-2"></i>
                        Pilih foto baru untuk melihat preview

                    </div>

                </div>

            </div>

        </div>

        <hr>

        <div class="d-flex justify-content-end gap-2">

            <a href="<?= base_url('datakemasan') ?>" class="btn btn-secondary">
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
    // PREVIEW FOTO BARU
    // =========================
    document.getElementById('foto-input').addEventListener('change', function(e) {

        const file = e.target.files[0];
        const preview = document.getElementById('preview-foto');
        const placeholder = document.getElementById('placeholder-foto');

        if (file) {

            const reader = new FileReader();

            reader.onload = function(event) {

                preview.src = event.target.result;
                preview.style.display = 'block';
                placeholder.style.display = 'none';

            };

            reader.readAsDataURL(file);

        } else {

            preview.style.display = 'none';
            placeholder.style.display = 'block';

        }

    });

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

</script>

<?= $this->endSection() ?>
