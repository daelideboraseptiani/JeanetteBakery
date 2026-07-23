<?= $this->extend('layout/dashboard') ?>

<?= $this->section('content') ?>

<div class="card card-pengguna">

```
<div class="card-header card-header-pengguna">

    <div class="d-flex justify-content-between align-items-center">

        <div>
            <h3>Tambah Pelanggan</h3>
            <small>Buat akun user dan data pelanggan sekaligus</small>
        </div>

        <a href="<?= base_url('datapelanggan') ?>" class="btn btn-secondary">

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

    <form action="<?= base_url('datapelanggan/simpan') ?>" method="post">

        <?= csrf_field(); ?>

        <div class="row">

            <!-- ID PELANGGAN -->
            <div class="col-md-6 mb-3">

                <label class="form-label">ID Pelanggan</label>

                <input
                    type="text"
                    name="IdPelanggan"
                    class="form-control"
                    value="<?= $IdPelanggan ?>"
                    readonly>

            </div>

            <!-- ID USER -->
            <div class="col-md-6 mb-3">

                <label class="form-label">ID User</label>

                <input
                    type="text"
                    name="IdUser"
                    class="form-control"
                    value="<?= $IdUser ?>"
                    readonly>

            </div>

            <!-- =========================
                 DATA AKUN USER
            ========================= -->
            <div class="col-12 mt-2 mb-3">

                <h5 class="text-primary">
                    Data Akun User
                </h5>

                <hr>

            </div>

            <!-- EMAIL -->
            <div class="col-md-6 mb-3">

                <label class="form-label">Email</label>

                <input
                    type="email"
                    name="Email"
                    class="form-control"
                    value="<?= old('Email') ?>"
                    placeholder="contoh@email.com"
                    required>

            </div>

            <!-- USERNAME -->
            <div class="col-md-6 mb-3">

                <label class="form-label">Username</label>

                <input
                    type="text"
                    name="Username"
                    class="form-control"
                    value="<?= old('Username') ?>"
                    placeholder="Masukkan username"
                    required>

            </div>

            <!-- PASSWORD -->
            <div class="col-md-6 mb-3">

                <label class="form-label">Password</label>

                <div class="input-group">

                    <input
                        type="password"
                        name="Password"
                        id="password"
                        class="form-control"
                        placeholder="Minimal 8 karakter"
                        required>

                    <button
                        type="button"
                        class="btn btn-outline-secondary"
                        onclick="togglePassword('password', this)">

                        <i class="ti ti-eye"></i>

                    </button>

                </div>

            </div>

            <!-- KONFIRMASI PASSWORD -->
            <div class="col-md-6 mb-3">

                <label class="form-label">Konfirmasi Password</label>

                <div class="input-group">

                    <input
                        type="password"
                        name="KonfirmasiPassword"
                        id="konfirmasi"
                        class="form-control"
                        placeholder="Ulangi password"
                        required>

                    <button
                        type="button"
                        class="btn btn-outline-secondary"
                        onclick="togglePassword('konfirmasi', this)">

                        <i class="ti ti-eye"></i>

                    </button>

                </div>

            </div>

            <!-- STATUS AKUN -->
            <div class="col-md-6 mb-3">

                <label class="form-label">Status Akun</label>

                <select name="Status" class="form-select" required>

                    <option value="Aktif" <?= old('Status', 'Aktif') == 'Aktif' ? 'selected' : '' ?>>
                        Aktif
                    </option>

                    <option value="Nonaktif" <?= old('Status') == 'Nonaktif' ? 'selected' : '' ?>>
                        Nonaktif
                    </option>

                </select>

            </div>

            <!-- ROLE -->
            <div class="col-md-6 mb-3">

                <label class="form-label">Role</label>

                <input
                    type="text"
                    class="form-control"
                    value="Pelanggan"
                    readonly>

                <input type="hidden" name="Role" value="Pelanggan">

            </div>

            <!-- =========================
                 DATA PELANGGAN
            ========================= -->
            <div class="col-12 mt-3 mb-3">

                <h5 class="text-primary">
                    Data Pelanggan
                </h5>

                <hr>

            </div>

            <!-- NAMA PELANGGAN -->
            <div class="col-md-6 mb-3">

                <label class="form-label">Nama Pelanggan</label>

                <input
                    type="text"
                    name="NamaPelanggan"
                    class="form-control"
                    value="<?= old('NamaPelanggan') ?>"
                    placeholder="Masukkan nama pelanggan"
                    required>

            </div>

            <!-- NOMOR HP -->
            <div class="col-md-6 mb-3">

                <label class="form-label">Nomor HP</label>

                <input
                    type="text"
                    name="NoHp"
                    class="form-control"
                    value="<?= old('NoHp') ?>"
                    placeholder="Contoh: 081234567890"
                    required>

            </div>

            <!-- ALAMAT -->
            <div class="col-12 mb-3">

                <label class="form-label">Alamat</label>

                <textarea
                    name="Alamat"
                    class="form-control"
                    rows="4"
                    placeholder="Masukkan alamat lengkap pelanggan"><?= old('Alamat') ?></textarea>

            </div>

        </div>

        <hr>

        <div class="d-flex justify-content-end gap-2">

            <a href="<?= base_url('datapelanggan') ?>" class="btn btn-secondary">
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
    // TAMPIL / SEMBUNYI PASSWORD
    // =========================
    function togglePassword(inputId, button) {

        const input = document.getElementById(inputId);
        const icon = button.querySelector('i');

        if (input.type === 'password') {

            input.type = 'text';
            icon.classList.remove('ti-eye');
            icon.classList.add('ti-eye-off');

        } else {

            input.type = 'password';
            icon.classList.remove('ti-eye-off');
            icon.classList.add('ti-eye');

        }

    }

    // =========================
    // VALIDASI NOMOR HP
    // =========================
    document.querySelector('input[name="NoHp"]').addEventListener('input', function() {

        this.value = this.value.replace(/[^0-9]/g, '');

    });

    // =========================
    // VALIDASI KONFIRMASI PASSWORD
    // =========================
    document.querySelector('form').addEventListener('submit', function(e) {

        const password = document.getElementById('password').value;
        const konfirmasi = document.getElementById('konfirmasi').value;

        if (password !== konfirmasi) {

            e.preventDefault();

            Swal.fire({
                icon: 'error',
                title: 'Password Tidak Sesuai',
                text: 'Konfirmasi password harus sama dengan password.'
            });

        }

    });

</script>

<?= $this->endSection() ?>
