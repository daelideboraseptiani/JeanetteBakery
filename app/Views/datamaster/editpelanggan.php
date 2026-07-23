<?= $this->extend('layout/dashboard') ?>

<?= $this->section('content') ?>

<div class="card card-pengguna">

```
<div class="card-header card-header-pengguna">

    <div class="d-flex justify-content-between align-items-center">

        <div>
            <h3>Edit Pelanggan</h3>
            <small>Perbarui data pelanggan dan akun user</small>
        </div>

        <a href="<?= base_url('datapelanggan') ?>" class="btn btn-secondary">

            <i class="ti ti-arrow-left me-1"></i>
            Kembali

        </a>

    </div>

</div>

<div class="card-body">

    <!-- Flash Error -->
    <?php if (session()->getFlashdata('error')) : ?>

        <div class="alert alert-danger alert-dismissible fade show" role="alert">

            <?= session()->getFlashdata('error') ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>

        </div>

    <?php endif; ?>

    <form action="<?= base_url('datapelanggan/update') ?>" method="post">

        <?= csrf_field(); ?>

        <!-- Hidden -->
        <input type="hidden" name="IdPelanggan" value="<?= $pelanggan['IdPelanggan'] ?>">
        <input type="hidden" name="IdUser" value="<?= $pelanggan['IdUser'] ?>">

        <div class="row">

            <!-- ID PELANGGAN -->
            <div class="col-md-6 mb-3">

                <label class="form-label">ID Pelanggan</label>

                <input
                    type="text"
                    class="form-control"
                    value="<?= $pelanggan['IdPelanggan'] ?>"
                    readonly>

            </div>

            <!-- ID USER -->
            <div class="col-md-6 mb-3">

                <label class="form-label">ID User</label>

                <input
                    type="text"
                    class="form-control"
                    value="<?= $pelanggan['IdUser'] ?>"
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
                    value="<?= old('Email', $user['Email']) ?>"
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

            <!-- STATUS -->
            <div class="col-md-6 mb-3">

                <label class="form-label">Status Akun</label>

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

            <!-- ROLE -->
            <div class="col-md-6 mb-3">

                <label class="form-label">Role</label>

                <input
                    type="text"
                    class="form-control"
                    value="Pelanggan"
                    readonly>

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
                    value="<?= old('NamaPelanggan', $pelanggan['NamaPelanggan']) ?>"
                    required>

            </div>

            <!-- NOMOR HP -->
            <div class="col-md-6 mb-3">

                <label class="form-label">Nomor HP</label>

                <input
                    type="text"
                    name="NoHp"
                    class="form-control"
                    value="<?= old('NoHp', $pelanggan['NoHp']) ?>"
                    required>

            </div>

            <!-- ALAMAT -->
            <div class="col-12 mb-3">

                <label class="form-label">Alamat</label>

                <textarea
                    name="Alamat"
                    class="form-control"
                    rows="4"
                    placeholder="Masukkan alamat lengkap pelanggan"><?= old('Alamat', $pelanggan['Alamat']) ?></textarea>

            </div>

        </div>

        <hr>

        <div class="d-flex justify-content-end gap-2">

            <a href="<?= base_url('datapelanggan') ?>" class="btn btn-secondary">
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
