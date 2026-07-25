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

        <div class="row mb-4">

            <div class="col-md-12">

                <h2>
                    <i class="fa fa-shopping-bag text-warning"></i>
                    Riwayat Pesanan
                </h2>

                <p class="text-muted">
                    Lihat seluruh riwayat pesanan Anda.
                </p>

            </div>

        </div>

        <?php if (session()->getFlashdata('success')) : ?>

            <div class="alert alert-success alert-dismissible fade show">

                <?= session()->getFlashdata('success'); ?>

                <button class="btn-close" data-bs-dismiss="alert"></button>

            </div>

        <?php endif; ?>


        <?php if (session()->getFlashdata('error')) : ?>

            <div class="alert alert-danger alert-dismissible fade show">

                <?= session()->getFlashdata('error'); ?>

                <button class="btn-close" data-bs-dismiss="alert"></button>

            </div>

        <?php endif; ?>



        <!-- FILTER -->

        <div class="mb-4">

            <button
                class="btn btn-warning btn-filter"
                data-filter="Semua">

                Semua

            </button>

            <button
                class="btn btn-outline-warning btn-filter"
                data-filter="Menunggu">

                Menunggu

            </button>

            <button
                class="btn btn-outline-warning btn-filter"
                data-filter="Diproses">

                Diproses

            </button>

            <button
                class="btn btn-outline-warning btn-filter"
                data-filter="Selesai">

                Selesai

            </button>

            <button
                class="btn btn-outline-warning btn-filter"
                data-filter="Dibatalkan">

                Dibatalkan

            </button>

        </div>



        <?php if (empty($pesanan)) : ?>


            <div class="card shadow">

                <div class="card-body text-center py-5">

                    <i class="fa fa-shopping-cart fa-5x text-secondary mb-3"></i>

                    <h4>

                        Belum Ada Pesanan

                    </h4>

                    <p>

                        Silahkan lakukan pemesanan terlebih dahulu.

                    </p>

                    <a
                        href="<?= base_url('katalog') ?>"
                        class="btn btn-warning">

                        Belanja Sekarang

                    </a>

                </div>

            </div>


        <?php else : ?>


            <?php foreach ($pesanan as $psn) : ?>


                <div class="card shadow mb-4 card-pesanan"
                    data-status="<?= $psn['StatusPesanan'] ?>">


                    <div class="card-header bg-white">


                        <div class="row align-items-center">


                            <div class="col-md-6">

                                <h5 class="mb-1">

                                    <?= $psn['IdPesanan'] ?>

                                </h5>

                                <small>

                                    Tanggal :

                                    <?= date('d-m-Y', strtotime($psn['TglPesanan'])) ?>

                                </small>

                            </div>



                            <div class="col-md-6 text-end">

                                <?php

                                $badge = 'secondary';

                                if ($psn['StatusPesanan'] == 'Menunggu')
                                    $badge = 'warning';

                                elseif ($psn['StatusPesanan'] == 'Diproses')
                                    $badge = 'primary';

                                elseif ($psn['StatusPesanan'] == 'Selesai')
                                    $badge = 'success';

                                elseif ($psn['StatusPesanan'] == 'Dibatalkan')
                                    $badge = 'danger';

                                ?>

                                <span class="badge bg-<?= $badge ?>">

                                    <?= $psn['StatusPesanan'] ?>

                                </span>

                            </div>

                        </div>

                    </div>



                    <div class="card-body">


                        <?php foreach ($psn['detail'] as $detail) : ?>


                            <div class="row align-items-center mb-3">


                                <div class="col-md-2">

                                    <img
                                        src="<?= base_url('storage/fotokemasan/' . $detail['Foto']) ?>"
                                        class="img-fluid rounded shadow">

                                </div>



                                <div class="col-md-5">

                                    <h5>

                                        <?= $detail['NamaProduk'] ?>

                                    </h5>

                                    <small>

                                        <?= $detail['NamaKemasan'] ?>

                                        |

                                        <?= $detail['Berat'] ?>

                                        <?= $detail['SatuanBerat'] ?>

                                    </small>

                                </div>



                                <div class="col-md-2 text-center">

                                    Qty

                                    <br>

                                    <b>

                                        <?= $detail['Qty'] ?>

                                    </b>

                                </div>



                                <div class="col-md-3 text-end">

                                    <b>

                                        Rp <?= number_format($detail['SubTotal'], 0, ',', '.') ?>

                                    </b>

                                </div>


                            </div>

                            <hr>

                        <?php endforeach; ?>



                        <div class="text-end">

                            <h4>

                                Total :

                                <span class="text-danger">

                                    Rp <?= number_format($psn['Total'], 0, ',', '.') ?>

                                </span>

                            </h4>

                        </div>
                        <hr>

                        <div class="mt-3">

                            <?php if ($psn['StatusPesanan'] == 'Menunggu') : ?>

                                <div class="alert alert-warning">

                                    <i class="fa fa-clock"></i>

                                    Pesanan Anda sedang menunggu konfirmasi Admin.

                                </div>

                                <div class="text-end">

                                    <a href="<?= base_url('riwayatpesanan/batal/' . $psn['IdPesanan']) ?>"
                                        class="btn btn-danger"
                                        onclick="return confirm('Yakin ingin membatalkan pesanan ini?')">

                                        <i class="fa fa-times"></i>

                                        Batalkan Pesanan

                                    </a>

                                </div>

                            <?php elseif ($psn['StatusPesanan'] == 'Diproses') : ?>

                                <?php

                                $bayar = $psn['pembayaran'];

                                ?>

                                <?php if (empty($bayar)) : ?>

                                    <div class="alert alert-danger">

                                        Anda belum melakukan pembayaran.

                                    </div>

                                    <div class="text-end">

                                        <a href="<?= base_url('pembayaran/' . $psn['IdPesanan']) ?>"
                                            class="btn btn-primary">

                                            <i class="fa fa-credit-card"></i>

                                            Bayar

                                        </a>

                                    </div>

                                <?php else : ?>

                                    <?php if ($bayar['StatusPembayaran'] == 'Menunggu Verifikasi') : ?>

                                        <div class="alert alert-info">

                                            <i class="fa fa-spinner"></i>

                                            Pembayaran sedang diperiksa Admin.

                                            <br>

                                            Mohon tunggu proses verifikasi.

                                        </div>

                                    <?php elseif ($bayar['StatusPembayaran'] == 'Ditolak') : ?>

                                        <div class="alert alert-danger">

                                            <i class="fa fa-times-circle"></i>

                                            Pembayaran ditolak Admin.

                                            <br>

                                            Silakan upload ulang bukti pembayaran.

                                        </div>

                                        <div class="text-end">

                                            <a href="<?= base_url('pembayaran/' . $psn['IdPesanan']) ?>"
                                                class="btn btn-danger">

                                                Upload Ulang Pembayaran

                                            </a>

                                        </div>

                                    <?php elseif ($bayar['StatusPembayaran'] == 'Terverifikasi') : ?>

                                        <?php if ($bayar['JenisPembayaran'] == 'DP') : ?>

                                            <div class="alert alert-success">
                                                DP telah diverifikasi.
                                                <br>
                                                Silakan melakukan pelunasan.
                                            </div>

                                            <div class="text-end">

                                                <a href="javascript:void(0)"
                                                    onclick="window.open('<?= site_url('fakturpembayaran/' . $psn['IdPesanan']) ?>','_blank');"
                                                    class="btn btn-primary">

                                                    <i class="fa fa-print"></i>
                                                    Cetak Faktur
                                                </a>

                                                <a href="<?= base_url('pembayaran/' . $psn['IdPesanan']) ?>"
                                                    class="btn btn-success">
                                                    <i class="fa fa-wallet"></i>
                                                    Bayar Pelunasan
                                                </a>

                                            </div>

                                        <?php elseif ($bayar['JenisPembayaran'] == 'Pelunasan') : ?>

                                            <div class="alert alert-success">
                                                Pembayaran telah lunas.
                                            </div>

                                            <div class="text-end">

                                                <a href="javascript:void(0)"
                                                    onclick="window.open('<?= site_url('fakturpembayaran/' . $psn['IdPesanan']) ?>','_blank');"
                                                    class="btn btn-primary">

                                                    <i class="fa fa-print"></i>
                                                    Cetak Faktur
                                                </a>

                                            </div>

                                        <?php elseif ($bayar['JenisPembayaran'] == 'Full Payment') : ?>

                                            <div class="alert alert-success">
                                                Full Payment telah diverifikasi.
                                            </div>

                                            <div class="text-end">

                                                <a href="javascript:void(0)"
                                                    onclick="window.open('<?= site_url('fakturpembayaran/' . $psn['IdPesanan']) ?>','_blank');"
                                                    class="btn btn-primary">

                                                    <i class="fa fa-print"></i>
                                                    Cetak Faktur
                                                </a>

                                            </div>

                                        <?php endif; ?>

                                    <?php endif; ?>

                                <?php endif; ?>

                            <?php elseif ($psn['StatusPesanan'] == 'Dibatalkan') : ?>

                                <div class="alert alert-danger">

                                    <i class="fa fa-ban"></i>

                                    Pesanan ini telah dibatalkan.

                                    <br>

                                    Silakan lakukan pemesanan kembali.

                                </div>

                                <div class="text-end">

                                    <a href="<?= base_url('katalog') ?>"
                                        class="btn btn-warning">

                                        <i class="fa fa-shopping-cart"></i>

                                        Belanja Lagi

                                    </a>

                                </div>

                            <?php elseif ($psn['StatusPesanan'] == 'Selesai') : ?>

                                <div class="alert alert-success">

                                    <i class="fa fa-check-circle"></i>

                                    Pesanan telah selesai.

                                    <br>

                                    Terima kasih telah berbelanja.

                                </div>

                                <div class="text-end">

                                    <a href="<?= base_url('fakturpembayaran/' . $psn['IdPesanan']) ?>"
                                        class="btn btn-primary">

                                        <i class="fa fa-print"></i>

                                        Cetak Faktur

                                    </a>

                                </div>

                            <?php endif; ?>

                        </div>

                    </div>

                </div>

            <?php endforeach; ?>

        <?php endif; ?>
        <script>
            document.addEventListener("DOMContentLoaded", function() {

                // ============================
                // FILTER STATUS PESANAN
                // ============================

                const btnFilter = document.querySelectorAll(".btn-filter");
                const cardPesanan = document.querySelectorAll(".card-pesanan");

                btnFilter.forEach(function(btn) {

                    btn.addEventListener("click", function() {

                        // Reset tombol
                        btnFilter.forEach(function(item) {

                            item.classList.remove("btn-warning");
                            item.classList.add("btn-outline-warning");

                        });

                        // Tombol aktif
                        this.classList.remove("btn-outline-warning");
                        this.classList.add("btn-warning");

                        let status = this.dataset.filter;

                        cardPesanan.forEach(function(card) {

                            if (status == "Semua") {

                                card.style.display = "block";

                            } else {

                                if (card.dataset.status == status) {

                                    card.style.display = "block";

                                } else {

                                    card.style.display = "none";

                                }

                            }

                        });

                    });

                });

            });
        </script>


        <?php if (session()->getFlashdata('success')) : ?>

            <script>
                Swal.fire({

                    icon: 'success',

                    title: 'Berhasil',

                    text: '<?= session()->getFlashdata('success') ?>',

                    confirmButtonColor: '#ffc107'

                });
            </script>

        <?php endif; ?>


        <?php if (session()->getFlashdata('error')) : ?>

            <script>
                Swal.fire({

                    icon: 'error',

                    title: 'Oops...',

                    text: '<?= session()->getFlashdata('error') ?>',

                    confirmButtonColor: '#dc3545'

                });
            </script>

        <?php endif; ?>

        <style>
            .card-pesanan {

                transition: .3s;

            }

            .card-pesanan:hover {

                transform: translateY(-3px);

                box-shadow: 0px 8px 20px rgba(0, 0, 0, .15);

            }

            .btn-filter {

                margin-right: 6px;
                margin-bottom: 8px;

            }

            .badge {

                font-size: 14px;
                padding: 8px 15px;

            }

            .card img {

                object-fit: cover;
                height: 120px;

            }

            .alert {

                border-radius: 10px;

            }
        </style>


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