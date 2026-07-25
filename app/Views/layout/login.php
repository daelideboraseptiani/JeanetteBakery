<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login Pelanggan</title>

  <link rel="shortcut icon" type="image/png"
    href="<?= base_url() ?>/assetsdashboard/images/logos/favicon.png" />

  <link rel="stylesheet"
    href="<?= base_url() ?>/assetsdashboard/css/styles.min.css">

  <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

  <style>
    body {
      background: #f8f9fa;
    }

    .logo-img img {
      width: 150px;
    }

    .card {
      border-radius: 18px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, .08);
    }

    .form-control {
      border-radius: 10px;
      height: 48px;
    }

    .btn-primary {
      border-radius: 10px;
      height: 48px;
      font-weight: 600;
    }

    h3 {
      font-weight: bold;
    }

    a {
      text-decoration: none;
    }

    .forgot {
      font-size: 14px;
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

          <div class="col-lg-5 col-md-7">

            <div class="card">

              <div class="card-body p-5">

                <div class="text-center">

                  <a href="<?= base_url('/') ?>" class="logo-img">

                    <img src="<?= base_url() ?>/assetsdashboard/images/logos/logo.svg">

                  </a>

                  <h3 class="mt-3">
                    Login Pelanggan
                  </h3>

                  <p class="text-muted">
                    Silakan login untuk melanjutkan.
                  </p>

                </div>

                <form action="<?= base_url('ceklogin') ?>" method="post">

                  <?= csrf_field(); ?>
                  <?php if (session()->getFlashdata('error')) : ?>

                    <div class="alert alert-danger">

                      <?= session()->getFlashdata('error'); ?>

                    </div>

                  <?php endif; ?>

                  <div class="mb-3">

                    <label class="form-label">

                      Username / Email

                    </label>

                    <input
                      type="text"
                      name="username"
                      class="form-control"
                      placeholder="Masukkan username atau email"
                      value="<?= old('username') ?>"
                      required>

                  </div>

                  <div class="mb-3">

                    <label class="form-label">

                      Password

                    </label>

                    <div class="input-group">

                      <input
                        type="password"
                        name="password"
                        id="password"
                        class="form-control"
                        placeholder="Masukkan password"
                        required>

                      <button
                        class="btn btn-outline-secondary"
                        type="button"
                        id="togglePassword">

                        <i class="fa fa-eye"></i>

                      </button>

                    </div>

                  </div>

                  <div class="d-flex justify-content-end mb-4">

                    <a
                      href="#"
                      class="forgot">

                      Lupa Password?

                    </a>

                  </div>

                  <button
                    type="submit"
                    class="btn btn-primary w-100">

                    Login

                  </button>

                  <div class="text-center mt-4">

                    <span class="text-muted">

                      Belum punya akun?

                    </span>

                    <a
                      href="<?= base_url('registrasi') ?>"
                      class="fw-bold ms-2">

                      Sign Up

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

<script>
document.getElementById('togglePassword').addEventListener('click', function () {

    let password = document.getElementById('password');

    let icon = this.querySelector('i');

    if (password.type === 'password') {

        password.type = 'text';

        icon.classList.remove('fa-eye');

        icon.classList.add('fa-eye-slash');

    } else {

        password.type = 'password';

        icon.classList.remove('fa-eye-slash');

        icon.classList.add('fa-eye');

    }

});
</script>

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