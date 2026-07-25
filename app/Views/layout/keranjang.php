<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Baker - Bakery Website Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="<?= base_url() ?>/assets/lib/animate/animate.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>/assets/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="<?= base_url() ?>/assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="<?= base_url() ?>/assets/css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" role="status"></div>
    </div>
    <!-- Spinner End -->


    <!-- Topbar Start -->
    <div class="container-fluid top-bar bg-dark text-light px-0 wow fadeIn" data-wow-delay="0.1s">
        <div class="row gx-0 align-items-center d-none d-lg-flex">
            <div class="col-lg-6 px-5 text-start">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a class="small text-light" href="#">Home</a></li>
                    <li class="breadcrumb-item"><a class="small text-light" href="#">Career</a></li>
                    <li class="breadcrumb-item"><a class="small text-light" href="#">Terms</a></li>
                    <li class="breadcrumb-item"><a class="small text-light" href="#">Privacy</a></li>
                </ol>
            </div>
            <div class="col-lg-6 px-5 text-end">
                <small>Follow us:</small>
                <div class="h-100 d-inline-flex align-items-center">
                    <a class="btn-lg-square text-primary border-end rounded-0" href=""><i class="fab fa-facebook-f"></i></a>
                    <a class="btn-lg-square text-primary border-end rounded-0" href=""><i class="fab fa-twitter"></i></a>
                    <a class="btn-lg-square text-primary border-end rounded-0" href=""><i class="fab fa-linkedin-in"></i></a>
                    <a class="btn-lg-square text-primary pe-0" href=""><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
    </div>
    <!-- Topbar End -->


    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top py-lg-0 px-lg-5 wow fadeIn" data-wow-delay="0.1s">
        <a href="index.html" class="navbar-brand ms-4 ms-lg-0">
            <h1 class="text-primary m-0">Baker</h1>
        </a>

        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav mx-auto p-4 p-lg-0">
                <a href="index.html" class="nav-item nav-link active">Home</a>
                <a href="about.html" class="nav-item nav-link">About</a>
                <a href="service.html" class="nav-item nav-link">Services</a>
                <a href="<?= base_url('katalog') ?>" class="nav-item nav-link">Products</a>

                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                    <div class="dropdown-menu m-0">
                        <a href="team.html" class="dropdown-item">Our Team</a>
                        <a href="testimonial.html" class="dropdown-item">Testimonial</a>
                        <a href="404.html" class="dropdown-item">404 Page</a>
                    </div>
                </div>

                <a href="contact.html" class="nav-item nav-link">Contact</a>
            </div>

            <!-- Keranjang + Profil -->
            <div class="d-none d-lg-flex align-items-center gap-3">

                <!-- Icon Keranjang -->
                <a href="<?= base_url('keranjang') ?>" class="position-relative text-dark">
                    <i class="bi bi-cart3 fs-3"></i>

                    <!-- Badge jumlah item -->
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        <?= isset($jumlahKeranjang) ? $jumlahKeranjang : 0 ?>
                    </span>
                </a>

                <!-- Dropdown Profil -->
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none"
                        id="profileDropdown"
                        data-bs-toggle="dropdown"
                        aria-expanded="false">

                        <img src="<?= base_url('assetsdashboard/images/profile/user-1.jpg') ?>"
                            alt="Profile"
                            width="40"
                            height="40"
                            class="rounded-circle border border-2 border-light">
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2"
                        aria-labelledby="profileDropdown">

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <i class="ti ti-user me-2"></i>
                                Profile
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="<?= base_url('riwayatpesanan') ?>">
                                <i class="ti ti-mail me-2"></i>
                                Riwayat Pesanan
                            </a>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li class="px-3 pb-2">
                            <a href="<?= base_url('logout') ?>" class="btn btn-outline-primary w-100 rounded-pill">
                                Logout
                            </a>
                        </li>

                    </ul>
                </div>

            </div>
        </div>
    </nav>
    <!-- Navbar End -->
     <br>
     <br>
     <br>

    <div class="container py-5">

        <h2 class="mb-4">
            <i class="fa fa-shopping-cart text-warning"></i>
            Keranjang Belanja
        </h2>

        <?php if (session()->getFlashdata('success')) : ?>

            <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
            </div>

        <?php endif; ?>

        <?php if (empty($keranjang)) : ?>

            <div class="card shadow-sm">

                <div class="card-body text-center py-5">

                    <i class="fa fa-shopping-cart fa-5x text-secondary mb-3"></i>

                    <h4>Keranjang Masih Kosong</h4>

                    <p>Silahkan pilih produk terlebih dahulu.</p>

                    <a href="<?= base_url('katalog') ?>" class="btn btn-warning">
                        Belanja Sekarang
                    </a>

                </div>

            </div>

        <?php else : ?>

            <div class="row">

                <!-- LIST PRODUK -->
                <div class="col-lg-8">

                    <?php foreach ($keranjang as $row) : ?>

                        <div class="card shadow-sm mb-3">

                            <div class="card-body">

                                <div class="row align-items-center">

                                    <!-- FOTO -->
                                    <div class="col-md-3 text-center">

                                        <img
                                            src="<?= base_url('storage/fotokemasan/' . $row['Foto']) ?>"
                                            class="img-fluid rounded"
                                            style="height:130px; object-fit:cover;">

                                    </div>

                                    <!-- DETAIL -->
                                    <div class="col-md-5">

                                        <h5><?= $row['NamaProduk']; ?></h5>

                                        <div class="text-muted">

                                            <?= $row['NamaKemasan']; ?>

                                            (<?= $row['Berat']; ?>

                                            <?= $row['SatuanBerat']; ?>)

                                        </div>

                                        <div class="fw-bold text-danger mt-2">

                                            Rp <?= number_format($row['Harga'], 0, ',', '.'); ?>

                                        </div>

                                    </div>

                                    <!-- QTY -->
                                    <div class="col-md-2">

                                        <div class="d-flex justify-content-center align-items-center">

                                            <a
                                                href="<?= base_url('keranjang/kurangqty/' . $row['IdKeranjang']) ?>"
                                                class="btn btn-outline-secondary btn-sm">

                                                <i class="fa fa-minus"></i>

                                            </a>

                                            <input
                                                type="text"
                                                value="<?= $row['Qty']; ?>"
                                                class="form-control text-center mx-2"
                                                style="width:55px;"
                                                readonly>

                                            <a
                                                href="<?= base_url('keranjang/tambahqty/' . $row['IdKeranjang']) ?>"
                                                class="btn btn-outline-secondary btn-sm">

                                                <i class="fa fa-plus"></i>

                                            </a>

                                        </div>

                                    </div>

                                    <!-- SUBTOTAL -->
                                    <div class="col-md-2 text-end">

                                        <div class="fw-bold mb-3">

                                            Rp <?= number_format($row['SubTotal'], 0, ',', '.'); ?>

                                        </div>

                                        <a
                                            href="<?= base_url('keranjang/hapus/' . $row['IdKeranjang']) ?>"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Hapus produk ini?')">

                                            <i class="fa fa-trash"></i>

                                        </a>

                                    </div>

                                </div>

                            </div>

                        </div>

                    <?php endforeach; ?>

                </div>

                <!-- TOTAL -->
                <div class="col-lg-4">

                    <div class="card shadow">

                        <div class="card-header bg-warning text-dark">

                            <h5 class="mb-0">

                                Ringkasan Belanja

                            </h5>

                        </div>

                        <div class="card-body">

                            <table class="table">

                                <tr>

                                    <th>Total Belanja</th>

                                    <td class="text-end">

                                        Rp <?= number_format($total['SubTotal'] ?? 0, 0, ',', '.'); ?>

                                    </td>

                                </tr>

                            </table>

                            <form action="<?= base_url('keranjang/checkout') ?>" method="post">

                                <?= csrf_field(); ?>

                                <button
                                    class="btn btn-success w-100">

                                    <i class="fa fa-credit-card"></i>

                                    Checkout

                                </button>

                            </form>

                            <a
                                href="<?= base_url('katalog') ?>"
                                class="btn btn-outline-warning w-100 mt-2">

                                <i class="fa fa-arrow-left"></i>

                                Lanjut Belanja

                            </a>

                        </div>

                    </div>

                </div>

            </div>

        <?php endif; ?>

    </div>


    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light footer my-6 mb-0 py-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-light mb-4">Office Address</h4>
                    <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>123 Street, New York, USA</p>
                    <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+012 345 67890</p>
                    <p class="mb-2"><i class="fa fa-envelope me-3"></i>info@example.com</p>
                    <div class="d-flex pt-2">
                        <a class="btn btn-square btn-outline-light rounded-circle me-1" href=""><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-square btn-outline-light rounded-circle me-1" href=""><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-square btn-outline-light rounded-circle me-1" href=""><i class="fab fa-youtube"></i></a>
                        <a class="btn btn-square btn-outline-light rounded-circle me-0" href=""><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-light mb-4">Quick Links</h4>
                    <a class="btn btn-link" href="">About Us</a>
                    <a class="btn btn-link" href="">Contact Us</a>
                    <a class="btn btn-link" href="">Our Services</a>
                    <a class="btn btn-link" href="">Terms & Condition</a>
                    <a class="btn btn-link" href="">Support</a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-light mb-4">Quick Links</h4>
                    <a class="btn btn-link" href="">About Us</a>
                    <a class="btn btn-link" href="">Contact Us</a>
                    <a class="btn btn-link" href="">Our Services</a>
                    <a class="btn btn-link" href="">Terms & Condition</a>
                    <a class="btn btn-link" href="">Support</a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-light mb-4">Photo Gallery</h4>
                    <div class="row g-2">
                        <div class="col-4">
                            <img class="img-fluid bg-light rounded p-1" src="<?= base_url() ?>/assets/img/product-1.jpg" alt="Image">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid bg-light rounded p-1" src="<?= base_url() ?>/assets/img/product-2.jpg" alt="Image">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid bg-light rounded p-1" src="<?= base_url() ?>/assets/img/product-3.jpg" alt="Image">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid bg-light rounded p-1" src="<?= base_url() ?>/assets/img/product-2.jpg" alt="Image">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid bg-light rounded p-1" src="<?= base_url() ?>/assets/img/product-3.jpg" alt="Image">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid bg-light rounded p-1" src="<?= base_url() ?>/assets/img/product-1.jpg" alt="Image">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->


    <!-- Copyright Start -->
    <div class="container-fluid copyright text-light py-4 wow fadeIn" data-wow-delay="0.1s">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    &copy; <a href="#">Your Site Name</a>, All Right Reserved.
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                    Designed By <a href="https://htmlcodex.com">HTML Codex</a>
                    <br>Distributed By: <a class="border-bottom" href="https://themewagon.com" target="_blank">ThemeWagon</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Copyright End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square rounded-circle back-to-top"><i class="bi bi-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() ?>/assets/lib/wow/wow.min.js"></script>
    <script src="<?= base_url() ?>/assets/lib/easing/easing.min.js"></script>
    <script src="<?= base_url() ?>/assets/lib/waypoints/waypoints.min.js"></script>
    <script src="<?= base_url() ?>/assets/lib/counterup/counterup.min.js"></script>
    <script src="<?= base_url() ?>/assets/lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="<?= base_url() ?>/assets/js/main.js"></script>

</body>

</html>