<?= $this->extend('layout/dashboard') ?>

<?= $this->section('content') ?>

<div class="card card-pengguna">

```
<div class="card-header card-header-pengguna">
    <div class="d-flex justify-content-between align-items-center">

        <div>
            <h3>Tambah User</h3>
            <small>Masukkan data user baru</small>
        </div>

        <a href="<?= base_url('datauser') ?>" class="btn btn-secondary">
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

    <form action="<?= base_url('datauser/simpan') ?>" method="post">

        <?= csrf_field(); ?>

        <div class="row">

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

            <!-- NAMA LENGKAP -->
            <div class="col-md-6 mb-3">

                <label class="form-label">Nama Lengkap</label>

                <input
                    type="text"
                    name="NamaLengkap"
                    class="form-control"
                    value="<?= old('NamaLengkap') ?>"
                    placeholder="Masukkan nama lengkap"
                    required>

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

            <!-- ROLE -->
            <div class="col-md-6 mb-3">

                <label class="form-label">Role</label>

                <select name="Role" class="form-select" required>

                    <option value="">-- Pilih Role --</option>

                    <option value="Admin" <?= old('Role') == 'Admin' ? 'selected' : '' ?>>
                        Admin
                    </option>

                    <option value="Pelanggan" <?= old('Role') == 'Pelanggan' ? 'selected' : '' ?>>
                        Pelanggan
                    </option>

                    <option value="Pimpinan" <?= old('Role') == 'Pimpinan' ? 'selected' : '' ?>>
                        Pimpinan
                    </option>

                </select>

            </div>

            <!-- STATUS -->
            <div class="col-md-6 mb-3">

                <label class="form-label">Status</label>

                <select name="Status" class="form-select" required>

                    <option value="Aktif" <?= old('Status', 'Aktif') == 'Aktif' ? 'selected' : '' ?>>
                        Aktif
                    </option>

                    <option value="Nonaktif" <?= old('Status') == 'Nonaktif' ? 'selected' : '' ?>>
                        Nonaktif
                    </option>

                </select>

            </div>

        </div>

        <hr>

        <div class="d-flex justify-content-end gap-2">

            <a href="<?= base_url('datauser') ?>" class="btn btn-secondary">
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

    // Tampilkan / sembunyikan password
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

    // Validasi konfirmasi password
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
