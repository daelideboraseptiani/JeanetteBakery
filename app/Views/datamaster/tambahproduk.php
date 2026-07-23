<?= $this->extend('layout/dashboard') ?>

<?= $this->section('content') ?>

<div class="card card-pengguna">

```
<div class="card-header card-header-pengguna">

    <div class="d-flex justify-content-between align-items-center">

        <div>
            <h3>Tambah Produk</h3>
            <small>Masukkan data produk kue kering baru</small>
        </div>

        <a href="<?= base_url('dataproduk') ?>" class="btn btn-secondary">

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

    <form action="<?= base_url('dataproduk/simpan') ?>" method="post">

        <?= csrf_field(); ?>

        <div class="row">

            <!-- ID PRODUK -->
            <div class="col-md-6 mb-3">

                <label class="form-label">ID Produk</label>

                <input
                    type="text"
                    name="IdProduk"
                    class="form-control"
                    value="<?= $IdProduk ?>"
                    readonly>

            </div>

            <!-- STATUS PRODUK -->
            <div class="col-md-6 mb-3">

                <label class="form-label">Status Produk</label>

                <select name="StatusProduk" class="form-select" required>

                    <option value="Aktif" <?= old('StatusProduk', 'Aktif') == 'Aktif' ? 'selected' : '' ?>>
                        Aktif
                    </option>

                    <option value="Nonaktif" <?= old('StatusProduk') == 'Nonaktif' ? 'selected' : '' ?>>
                        Nonaktif
                    </option>

                </select>

            </div>

            <!-- NAMA PRODUK -->
            <div class="col-12 mb-3">

                <label class="form-label">Nama Produk</label>

                <input
                    type="text"
                    name="NamaProduk"
                    class="form-control"
                    value="<?= old('NamaProduk') ?>"
                    placeholder="Contoh: Nastar, Kastengel, Putri Salju"
                    required>

            </div>

            <!-- DESKRIPSI -->
            <div class="col-12 mb-3">

                <label class="form-label">Deskripsi Produk</label>

                <textarea
                    name="Deskripsi"
                    class="form-control"
                    rows="5"
                    placeholder="Masukkan deskripsi singkat produk, bahan utama, atau informasi tambahan lainnya"><?= old('Deskripsi') ?></textarea>

                <small class="text-muted">
                    Deskripsi bersifat opsional, tetapi disarankan untuk informasi produk.
                </small>

            </div>

        </div>

        <hr>

        <div class="d-flex justify-content-end gap-2">

            <a href="<?= base_url('dataproduk') ?>" class="btn btn-secondary">
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

    // Fokus otomatis ke nama produk saat halaman dibuka
    window.addEventListener('load', function() {

        document.querySelector('input[name="NamaProduk"]').focus();

    });

</script>

<?= $this->endSection() ?>
