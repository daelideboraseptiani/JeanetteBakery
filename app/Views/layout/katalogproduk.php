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
                <a href="product.html" class="nav-item nav-link">Products</a>

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

            <!-- Tombol Login & Registrasi -->
            <div class="d-none d-lg-flex gap-2">
                <a href="<?= base_url('katalog') ?>" class="btn btn-primary rounded-pill px-4">
                    Pesan Sekarang
                </a>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->

    <!-- Kategori Produk -->
    <section class="kategori-section">

        <div class="container">

            <div class="text-center mb-4">
                <h2 class="kategori-title">Kategori Produk</h2>
                <p class="kategori-subtitle">
                    Pilih kategori kue kering favorit Anda
                </p>
            </div>

            <div class="kategori-wrapper">

                <button
                    class="kategori-btn active"
                    data-kategori="all">
                    Semua
                </button>

                <?php foreach ($kategori as $k) : ?>

                    <button
                        class="kategori-btn"
                        data-kategori="<?= $k['IdProduk']; ?>">

                        <?= esc($k['NamaProduk']); ?>

                    </button>

                <?php endforeach; ?>

            </div>

        </div>

    </section>

    <section id="katalog" class="new-arrivals">

        <div class="container">

            <div class="new-arrivals-content">

                <div class="row" id="produk-container">

                    <?php if (!empty($kemasan)) : ?>

                        <?php foreach ($kemasan as $row) : ?>

                            <div
                                class="col-lg-3 col-md-4 col-sm-6 mb-4 produk-item"
                                data-kategori="<?= $row['IdProduk']; ?>">

                                <div class="single-new-arrival">

                                    <div class="single-new-arrival-bg">

                                        <img src="<?= base_url('storage/fotokemasan/' . $row['Foto']); ?>"
                                            alt="<?= esc($row['NamaProduk']); ?>">

                                    </div>

                                    <div class="product-info">

                                        <h4><?= esc($row['NamaProduk']); ?></h4>

                                        <p class="kemasan">
                                            <?= esc($row['NamaKemasan']); ?>
                                            (<?= $row['Berat']; ?> <?= $row['SatuanBerat']; ?>)
                                        </p>

                                        <p class="arrival-product-price">
                                            Rp <?= number_format($row['Harga'], 0, ',', '.'); ?>
                                        </p>

                                        <div class="product-action">

                                            <span class="stok-produk">

                                                <i class="fa fa-cubes"></i>

                                                Stok :
                                                <strong><?= $row['Stok']; ?></strong>

                                            </span>

                                            <button
                                                class="btn-detail"

                                                data-id="<?= $row['IdKemasan']; ?>"
                                                data-produk="<?= esc($row['NamaProduk']); ?>"
                                                data-kemasan="<?= esc($row['NamaKemasan']); ?>"
                                                data-berat="<?= $row['Berat']; ?>"
                                                data-satuan="<?= $row['SatuanBerat']; ?>"
                                                data-harga="<?= $row['Harga']; ?>"
                                                data-deskripsi="<?= esc($row['Deskripsi']); ?>"
                                                data-foto="<?= base_url('storage/fotokemasan/' . $row['Foto']); ?>">

                                                <i class="fa fa-eye"></i>
                                                Detail

                                            </button>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        <?php endforeach; ?>

                    <?php else : ?>

                        <div class="col-12 text-center">

                            <h4>Produk belum tersedia.</h4>

                        </div>

                    <?php endif; ?>

                </div>

            </div>

        </div>

    </section>

    <!-- Modal Detail Kemasan -->
    <div class="modal fade" id="modalDetailKemasan" tabindex="-1">

        <div class="modal-dialog modal-lg modal-dialog-centered">

            <div class="modal-content">

                <div class="modal-header">

                    <h4 class="modal-title">

                        <i class="fa fa-gift"></i>
                        Detail Produk

                    </h4>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <div class="row">

                        <!-- FOTO -->
                        <div class="col-md-5">

                            <img
                                id="modalFoto"
                                src=""
                                class="img-fluid rounded shadow-sm w-100">

                        </div>

                        <!-- INFORMASI -->
                        <div class="col-md-7">

                            <h3 id="modalProduk"></h3>

                            <hr>

                            <table class="table table-borderless">

                                <tr>
                                    <th width="35%">Kemasan</th>
                                    <td id="modalKemasan"></td>
                                </tr>

                                <tr>
                                    <th>Berat</th>
                                    <td id="modalBerat"></td>
                                </tr>

                                <tr>
                                    <th>Harga</th>
                                    <td id="modalHarga"></td>
                                </tr>

                            </table>

                            <h5>Deskripsi</h5>

                            <p id="modalDeskripsi"></p>

                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">

                        Tutup

                    </button>

                    <a
                        href="#"
                        id="btnKeranjang"
                        class="btn btn-warning">

                        <i class="fa fa-shopping-cart"></i>
                        Tambah Keranjang

                    </a>

                </div>

            </div>

        </div>

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

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            // ================================
            // FILTER KATEGORI
            // ================================
            const kategoriBtn = document.querySelectorAll(".kategori-btn");
            const produkItem = document.querySelectorAll(".produk-item");

            kategoriBtn.forEach(function(btn) {

                btn.addEventListener("click", function() {

                    // Menghapus class active
                    kategoriBtn.forEach(function(b) {
                        b.classList.remove("active");
                    });

                    // Menambahkan active
                    this.classList.add("active");

                    let kategori = this.getAttribute("data-kategori");

                    produkItem.forEach(function(item) {

                        if (kategori === "all") {

                            item.style.display = "block";

                        } else {

                            if (item.getAttribute("data-kategori") === kategori) {

                                item.style.display = "block";

                            } else {

                                item.style.display = "none";

                            }

                        }

                    });

                });

            });



            // ================================
            // MODAL DETAIL
            // ================================
            const detailButtons = document.querySelectorAll(".btn-detail");

            detailButtons.forEach(function(btn) {

                btn.addEventListener("click", function() {

                    document.getElementById("modalProduk").innerHTML =
                        this.dataset.produk;

                    document.getElementById("modalKemasan").innerHTML =
                        this.dataset.kemasan;

                    document.getElementById("modalBerat").innerHTML =
                        this.dataset.berat;

                    document.getElementById("modalHarga").innerHTML =
                        "Rp " + this.dataset.harga;

                    document.getElementById("modalDeskripsi").innerHTML =
                        this.dataset.deskripsi;

                    document.getElementById("modalFoto").src =
                        this.dataset.foto;

                    // Nanti saat fitur keranjang dibuat
                    document.getElementById("btnKeranjang").href =
                        "<?= base_url('keranjang/tambah/') ?>" + this.dataset.id;

                    let modal = new bootstrap.Modal(
                        document.getElementById("modalDetailKemasan")
                    );

                    modal.show();

                });

            });

        });
    </script>
</body>

</html>