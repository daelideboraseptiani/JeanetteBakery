<?= $this->extend('layout/dashboard') ?>

<?= $this->section('content') ?>

<div class="card card-pengguna">

```
<div class="card-header card-header-pengguna">

    <div class="d-flex justify-content-between align-items-center">

        <div>
            <h3>Edit User</h3>
            <small>Perbarui data user</small>
        </div>

        <a href="<?= base_url('datauser') ?>" class="btn btn-secondary">

            <i class="ti ti-arrow-left me-1"></i>
            Kembali

        </a>

    </div>

</div>

<div class="card-body">

    <!-- Error Validasi -->
    <?php if (session()->getFlashdata('error')) : ?>

        <div class="alert alert-danger alert-dismissible fade show" role="alert">

            <?= session()->getFlashdata('error') ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>

        </div>

    <?php endif; ?>

    <form action="<?= base_url('datauser/update') ?>" method="post">

        <?= csrf_field(); ?>

        <!-- ID USER (hidden untuk proses update) -->
        <input type="hidden" name="IdUser" value="<?= $user['IdUser'] ?>">

        <div class="row">

            <!-- ID USER -->
            <div class="col-md-6 mb-3">

                <label class="form-label">ID User</label>

                <input
                    type="text"
                    class="form-control"
                    value="<?= $user['IdUser'] ?>"
                    readonly>

            </div>

            <!-- NAMA LENGKAP -->
            <div class="col-md-6 mb-3">

                <label class="form-label">Nama Lengkap</label>

                <input
                    type="text"
                    name="NamaLengkap"
                    class="form-control"
                    value="<?= old('NamaLengkap', $user['NamaLengkap']) ?>"
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
                    value="<?= old('Email', $user['Email']) ?>"
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
                    value="<?= old('Username', $user['Username']) ?>"
                    placeholder="Masukkan username"
                    required>

            </div>

            <!-- PASSWORD BARU -->
            <div class="col-md-6 mb-3">

                <label class="form-label">Password Baru</label>

                <div class="input-group">

                    <input
                        type="password"
                        name="Password"
                        id="password"
                        class="form-control"
                        placeholder="Kosongkan jika tidak ingin mengubah password">

                    <button
                        type="button"
                        class="btn btn-outline-secondary"
                        onclick="togglePassword('password', this)">

                        <i class="ti ti-eye"></i>

                    </button>

                </div>

                <small class="text-muted">
                    Isi hanya jika ingin mengganti password.
                </small>

            </div>

            <!-- KONFIRMASI PASSWORD -->
            <div class="col-md-6 mb-3">

                <label class="form-label">Konfirmasi Password Baru</label>

                <div class="input-group">

                    <input
                        type="password"
                        name="KonfirmasiPassword"
                        id="konfirmasi"
                        class="form-control"
                        placeholder="Ulangi password baru">

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

                    <option value="Admin"
                        <?= old('Role', $user['Role']) == 'Admin' ? 'selected' : '' ?>>

                        Admin

                    </option>

                    <option value="Pelanggan"
                        <?= old('Role', $user['Role']) == 'Pelanggan' ? 'selected' : '' ?>>

                        Pelanggan

                    </option>

                    <option value="Pimpinan"
                        <?= old('Role', $user['Role']) == 'Pimpinan' ? 'selected' : '' ?>>

                        Pimpinan

                    </option>

                </select>

            </div>

            <!-- STATUS -->
            <div class="col-md-6 mb-3">

                <label class="form-label">Status</label>

                <select name="Status" class="form-select" required>

                    <option value="Aktif"
                        <?= old('Status', $user['Status']) == 'Aktif' ? 'selected' : '' ?>>

                        Aktif

                    </option>

                    <option value="Nonaktif"
                        <?= old('Status', $user['Status']) == 'Nonaktif' ? 'selected' : '' ?>>

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
                Update Data

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
    // VALIDASI KONFIRMASI PASSWORD
    // =========================
    document.querySelector('form').addEventListener('submit', function(e) {

        const password = document.getElementById('password').value;
        const konfirmasi = document.getElementById('konfirmasi').value;

        // Jika password diisi, maka konfirmasi harus sama
        if (password !== '' && password !== konfirmasi) {

            e.preventDefault();

            Swal.fire({
                icon: 'error',
                title: 'Password Tidak Sesuai',
                text: 'Konfirmasi password harus sama dengan password baru.'
            });

        }

    });

</script>

<?= $this->endSection() ?>
