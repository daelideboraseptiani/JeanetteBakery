<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrasi Pelanggan</title>

    <link rel="shortcut icon" type="image/png"
        href="<?= base_url() ?>/assetsdashboard/images/logos/favicon.png" />

    <link rel="stylesheet"
        href="<?= base_url() ?>/assetsdashboard/css/styles.min.css">

    <style>
        body{
            background:#f8f9fa;
        }

        .logo-img img{
            width:150px;
        }

        .card{
            border-radius:18px;
            box-shadow:0 10px 30px rgba(0,0,0,.08);
        }

        .form-control{
            border-radius:10px;
            height:48px;
        }

        textarea.form-control{
            height:90px;
        }

        .btn-primary{
            border-radius:10px;
            height:48px;
            font-weight:600;
        }

        h3{
            font-weight:bold;
        }
    </style>

</head>

<body>

<div
class="page-wrapper"
id="main-wrapper">

<div
class="position-relative overflow-hidden text-bg-light min-vh-100 d-flex align-items-center justify-content-center">

<div class="container">

<div class="row justify-content-center">

<div class="col-lg-6 col-md-8">

<div class="card">

<div class="card-body p-5">

<div class="text-center">

<a href="<?= base_url('/') ?>" class="logo-img">

<img src="<?= base_url()?>/assetsdashboard/images/logos/logo.svg">

</a>

<h3 class="mt-3">
Registrasi Pelanggan
</h3>

<p class="text-muted">
Silakan lengkapi data berikut untuk membuat akun.
</p>

</div>

<form action="<?= base_url('registrasi/simpan') ?>" method="post">

<?= csrf_field(); ?>

<div class="mb-3">
    <label class="form-label">Nama Lengkap</label>
    <input
        type="text"
        name="NamaLengkap"
        class="form-control"
        value="<?= old('NamaLengkap') ?>"
        placeholder="Masukkan nama lengkap"
        required>
</div>

<div class="mb-3">
    <label class="form-label">Username</label>
    <input
        type="text"
        name="Username"
        class="form-control"
        value="<?= old('Username') ?>"
        placeholder="Masukkan username"
        required>
</div>

<div class="mb-3">
    <label class="form-label">Email</label>
    <input
        type="email"
        name="Email"
        class="form-control"
        value="<?= old('Email') ?>"
        placeholder="Masukkan email"
        required>
</div>

<div class="mb-3">
    <label class="form-label">Nomor HP</label>
    <input
        type="text"
        name="NoHp"
        class="form-control"
        value="<?= old('NoHp') ?>"
        placeholder="Contoh : 081234567890"
        required>
</div>

<div class="mb-3">
    <label class="form-label">Alamat</label>
    <textarea
        name="Alamat"
        class="form-control"
        placeholder="Masukkan alamat lengkap"
        required><?= old('Alamat') ?></textarea>
</div>

<div class="mb-3">
    <label class="form-label">Password</label>
    <input
        type="password"
        name="Password"
        class="form-control"
        placeholder="Masukkan password"
        required>
</div>

<div class="mb-4">
    <label class="form-label">Konfirmasi Password</label>
    <input
        type="password"
        name="KonfirmasiPassword"
        class="form-control"
        placeholder="Ulangi password"
        required>
</div>

<button
    type="submit"
    class="btn btn-primary w-100 mb-3">

    Registrasi

</button>

<div class="text-center">

    <span class="text-muted">
        Sudah memiliki akun?
    </span>

    <a
        href="<?= base_url('login') ?>"
        class="text-primary fw-bold">

        Login

    </a>

</div>
</form>

</div>

</div>

</div>

</div>

</div>

</div>

</div>

<script src="<?= base_url() ?>/assetsdashboard/libs/jquery/dist/jquery.min.js"></script>

<script src="<?= base_url() ?>/assetsdashboard/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php if(session()->getFlashdata('icon')) : ?>

<script>
Swal.fire({
    icon: '<?= session()->getFlashdata('icon'); ?>',
    title: '<?= session()->getFlashdata('title'); ?>',
    text: '<?= session()->getFlashdata('msg'); ?>',
    confirmButtonColor: '#5D87FF'
});
</script>

<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>

</body>
</html>