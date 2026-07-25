<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Pembayaran Pesanan</title>

    <link rel="stylesheet"
        href="<?= base_url('bootstrap/css/bootstrap.min.css') ?>">

    <link rel="stylesheet"
        href="<?= base_url('fontawesome/css/all.min.css') ?>">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

</head>

<?php

/*
|--------------------------------------------------------------------------
| CEK APAKAH INI PELUNASAN
|--------------------------------------------------------------------------
|
| Controller mengirim:
| $isPelunasan = true / false
| $sisaBayar   = nominal sisa pembayaran
|
*/

$totalBayar = $isPelunasan
    ? $sisaBayar
    : $pesanan['Total'];

?>

<body>

    <div class="container my-5">

        <div class="row">

            <!-- ===================================================== -->
            <!-- DETAIL PESANAN -->
            <!-- ===================================================== -->

            <div class="col-lg-8">

                <div class="checkout-card">

                    <div class="checkout-header">

                        <i class="fa fa-shopping-basket me-2"></i>

                        Detail Pesanan

                    </div>

                    <div class="checkout-body">

                        <div class="invoice-info">

                            <div>

                                <small>No Pesanan</small>

                                <h5>

                                    <?= $pesanan['IdPesanan']; ?>

                                </h5>

                            </div>

                            <div class="text-end">

                                <small>Tanggal Pesanan</small>

                                <h6>

                                    <?= date('d F Y', strtotime($pesanan['TglPesanan'])) ?>

                                </h6>

                            </div>

                        </div>

                        <hr>

                        <?php foreach ($detail as $d) : ?>

                            <div class="produk-card">

                                <div class="produk-left">

                                    <img
                                        src="<?= base_url('storage/fotokemasan/' . $d['Foto']) ?>"
                                        class="produk-img">

                                    <div class="produk-info">

                                        <h5 class="produk-title">

                                            <?= $d['NamaProduk']; ?>

                                        </h5>

                                        <p class="produk-subtitle">

                                            <?= $d['NamaKemasan']; ?>

                                            •

                                            <?= $d['Berat']; ?>

                                            <?= $d['SatuanBerat']; ?>

                                        </p>

                                        <span class="badge bg-pink">

                                            Produk

                                        </span>

                                    </div>

                                </div>

                                <div class="produk-right">

                                    <div class="qty-box">

                                        <small>Qty</small>

                                        <strong>

                                            <?= $d['Qty']; ?>

                                        </strong>

                                    </div>

                                    <div class="harga-box">

                                        <small>Subtotal</small>

                                        <h5 class="harga">

                                            Rp <?= number_format($d['SubTotal'], 0, ",", "."); ?>

                                        </h5>

                                    </div>

                                </div>

                            </div>

                        <?php endforeach; ?>

                        <div class="total-card">

                            <div class="row align-items-center">

                                <div class="col">

                                    <h5 class="mb-0">

                                        <?php if ($isPelunasan) { ?>

                                            Sisa Pembayaran

                                        <?php } else { ?>

                                            Total Tagihan

                                        <?php } ?>

                                    </h5>

                                </div>

                                <div class="col text-end">

                                    <h3 class="text-danger mb-0">

                                        Rp <?= number_format($totalBayar, 0, ",", "."); ?>

                                    </h3>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <!-- ===================================================== -->
            <!-- FORM PEMBAYARAN -->
            <!-- ===================================================== -->

            <div class="col-lg-4">

                <form
                    action="<?= base_url('pembayaran/simpanbayar') ?>"
                    method="post"
                    enctype="multipart/form-data">

                    <?= csrf_field(); ?>

                    <input
                        type="hidden"
                        name="IdPesanan"
                        value="<?= $pesanan['IdPesanan']; ?>">

                    <input
                        type="hidden"
                        name="IsPelunasan"
                        value="<?= $isPelunasan ? 1 : 0; ?>">

                    <div class="payment-card">

                        <div class="payment-header">

                            <i class="fa fa-credit-card me-2"></i>

                            <?= $isPelunasan ? 'Pelunasan Pesanan' : 'Ringkasan Pembayaran'; ?>

                        </div>

                        <div class="payment-body">

                            <div class="summary-box">

                                <small>

                                    <?= $isPelunasan ? 'Sisa Pembayaran' : 'Total Tagihan'; ?>

                                </small>

                                <h2 id="totalTagihan">

                                    Rp <?= number_format($totalBayar, 0, ",", "."); ?>

                                </h2>

                            </div>
                            <!-- ================================================= -->
                            <!-- JENIS PEMBAYARAN (HANYA MUNCUL SAAT PEMBAYARAN AWAL) -->
                            <!-- ================================================= -->
                            <?php if (!$isPelunasan) : ?>

                                <div class="mb-4">

                                    <label class="form-label">

                                        Jenis Pembayaran

                                    </label>

                                    <select
                                        class="form-select"
                                        id="JenisPembayaran"
                                        name="JenisPembayaran"
                                        required>

                                        <option value="">
                                            -- Pilih Jenis Pembayaran --
                                        </option>

                                        <option value="DP">
                                            DP (50%)
                                        </option>

                                        <option value="Full Payment">
                                            Full Payment
                                        </option>

                                    </select>

                                </div>

                            <?php else : ?>

                                <input
                                    type="hidden"
                                    name="JenisPembayaran"
                                    value="Pelunasan">

                                <div class="mb-4">

                                    <label class="form-label">

                                        Jenis Pembayaran

                                    </label>

                                    <input
                                        type="text"
                                        class="form-control"
                                        value="Pelunasan"
                                        readonly>

                                </div>

                            <?php endif; ?>

                            <!-- ================================================= -->
                            <!-- METODE PEMBAYARAN -->
                            <!-- ================================================= -->

                            <div class="mb-4">

                                <label class="form-label">

                                    Metode Pembayaran

                                </label>

                                <select
                                    class="form-select"
                                    name="MetodePembayaran"
                                    required>

                                    <option value="Transfer">

                                        Transfer Bank

                                    </option>

                                    <option value="QRIS">

                                        QRIS

                                    </option>

                                    <option value="Cash">

                                        Cash

                                    </option>

                                </select>

                            </div>

                            <!-- ================================================= -->
                            <!-- JUMLAH PEMBAYARAN -->
                            <!-- ================================================= -->

                            <div class="mb-4">

                                <label class="form-label">

                                    Jumlah Pembayaran

                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    id="JumlahBayarView"
                                    readonly>

                                <input
                                    type="hidden"
                                    id="JumlahBayar"
                                    name="JumlahBayar"
                                    value="<?= $totalBayar ?>">

                            </div>

                            <!-- ================================================= -->
                            <!-- UPLOAD BUKTI -->
                            <!-- ================================================= -->

                            <div class="mb-4">

                                <label class="form-label">

                                    Upload Bukti Pembayaran

                                </label>

                                <div class="upload-box">

                                    <i class="fa fa-cloud-upload-alt upload-icon"></i>

                                    <p>

                                        Klik untuk memilih bukti pembayaran

                                    </p>

                                    <input
                                        type="file"
                                        class="form-control"
                                        id="BuktiPembayaran"
                                        name="BuktiPembayaran"
                                        accept="image/*"
                                        required>

                                    <small
                                        id="namaFile"
                                        class="upload-filename">

                                        Belum ada file dipilih

                                    </small>

                                </div>

                            </div>

                            <!-- ================================================= -->
                            <!-- BUTTON -->
                            <!-- ================================================= -->

                            <button
                                type="submit"
                                class="btn btn-pink w-100">

                                <i class="fa fa-paper-plane me-2"></i>

                                <?php if ($isPelunasan) : ?>

                                    Kirim Pelunasan

                                <?php else : ?>

                                    Kirim Pembayaran

                                <?php endif; ?>

                            </button>

                            <a
                                href="<?= base_url('riwayatpesanan'); ?>"
                                class="btn btn-outline-secondary w-100 mt-3">

                                <i class="fa fa-arrow-left me-2"></i>

                                Kembali

                            </a>

                        </div>

                    </div>

                </form>

                <!-- ================================================= -->
                <!-- INFORMASI REKENING -->
                <!-- ================================================= -->

                <div class="rekening-card mt-4">

                    <h5>

                        <i class="fa fa-university me-2"></i>

                        Informasi Pembayaran

                    </h5>

                    <hr>

                    <div class="rekening-item">

                        <small>Bank</small>

                        <h4>BRI</h4>

                    </div>

                    <div class="rekening-item">

                        <small>Nomor Rekening</small>

                        <h3>

                            1234567890

                        </h3>

                    </div>

                    <div class="rekening-item">

                        <small>Atas Nama</small>

                        <h5>

                            Debora Cookies

                        </h5>

                    </div>

                    <hr>

                    <div class="alert alert-warning mb-0">

                        <?php if ($isPelunasan) : ?>

                            <small>

                                Silakan transfer sesuai sisa pembayaran,
                                kemudian upload bukti pelunasan agar dapat diverifikasi oleh Admin.

                            </small>

                        <?php else : ?>

                            <small>

                                Silakan pilih jenis pembayaran (DP atau Full Payment),
                                kemudian upload bukti pembayaran agar dapat diverifikasi oleh Admin.

                            </small>

                        <?php endif; ?>

                    </div>

                </div>

            </div>

        </div>

    </div>
    <style>
        :root {
            --primary: #ec4899;
            --primary-hover: #db2777;
            --bg: #f8fafc;
            --white: #ffffff;
            --text: #1f2937;
            --muted: #6b7280;
            --border: #e5e7eb;
            --danger: #dc2626;
            --radius: 14px;
            --shadow: 0 10px 30px rgba(15, 23, 42, .06);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: var(--bg);
            font-family: 'Poppins', sans-serif;
            color: var(--text);
        }

        .checkout-card,
        .payment-card,
        .rekening-card {
            background: #fff;
            border-radius: 16px;
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
        }

        .checkout-header,
        .payment-header {
            padding: 18px 22px;
            border-bottom: 1px solid var(--border);
            font-size: 18px;
            font-weight: 600;
        }

        .checkout-body,
        .payment-body {
            padding: 24px;
        }

        .payment-card {
            position: sticky;
            top: 20px;
        }

        .invoice-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .invoice-info small {
            color: var(--muted);
        }

        .produk-card {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 18px;
            border: 1px solid var(--border);
            border-radius: 14px;
            margin-bottom: 18px;
            transition: .25s;
        }

        .produk-card:hover {
            border-color: #ec4899;
            transform: translateY(-2px);
        }

        .produk-left {
            display: flex;
            gap: 18px;
            align-items: center;
        }

        .produk-img {
            width: 90px;
            height: 90px;
            object-fit: cover;
            border-radius: 12px;
        }

        .produk-title {
            margin: 0;
            font-size: 17px;
            font-weight: 600;
        }

        .produk-subtitle {
            margin-top: 6px;
            color: var(--muted);
        }

        .bg-pink {
            background: #fde7f3;
            color: #ec4899;
            border-radius: 50px;
            padding: 4px 12px;
            display: inline-block;
            font-size: 12px;
            margin-top: 8px;
        }

        .produk-right {
            display: flex;
            gap: 45px;
        }

        .qty-box,
        .harga-box {
            text-align: right;
        }

        .qty-box small,
        .harga-box small {
            display: block;
            color: var(--muted);
        }

        .qty-box strong {
            font-size: 18px;
        }

        .harga {
            margin-top: 5px;
            color: #dc2626;
            font-weight: 700;
        }

        .total-card {
            border-top: 1px solid var(--border);
            margin-top: 25px;
            padding-top: 20px;
        }

        .summary-box {
            background: #fdf2f8;
            border: 1px solid #fbcfe8;
            border-radius: 14px;
            padding: 22px;
            text-align: center;
            margin-bottom: 22px;
        }

        .summary-box small {
            color: var(--muted);
        }

        .summary-box h2 {
            margin-top: 8px;
            color: #ec4899;
            font-size: 32px;
            font-weight: 700;
        }

        .form-label {
            font-weight: 600;
            margin-bottom: 8px;
        }

        .form-control,
        .form-select {
            height: 48px;
            border-radius: 10px;
            box-shadow: none;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #ec4899;
            box-shadow: 0 0 0 .15rem rgba(236, 72, 153, .15);
        }

        .upload-box {
            border: 2px dashed #d1d5db;
            border-radius: 12px;
            padding: 25px;
            text-align: center;
            background: #fafafa;
            transition: .25s;
        }

        .upload-box:hover {
            border-color: #ec4899;
            background: #fff7fb;
        }

        .upload-icon {
            font-size: 42px;
            color: #ec4899;
            margin-bottom: 10px;
        }

        .upload-filename {
            display: block;
            margin-top: 10px;
            color: #6b7280;
        }

        .btn-pink {
            height: 50px;
            background: #ec4899;
            color: #fff;
            border: none;
            border-radius: 10px;
            font-weight: 600;
        }

        .btn-pink:hover {
            background: #db2777;
            color: #fff;
        }

        .btn-outline-secondary {
            height: 50px;
            border-radius: 10px;
        }

        .rekening-card {
            padding: 22px;
            margin-top: 22px;
        }

        .rekening-item {
            margin-bottom: 18px;
        }

        .rekening-item small {
            display: block;
            color: #6b7280;
        }

        @media(max-width:992px) {

            .payment-card {
                position: relative;
                top: 0;
                margin-top: 20px;
            }

        }

        @media(max-width:768px) {

            .invoice-info {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .produk-card {
                flex-direction: column;
                align-items: flex-start;
            }

            .produk-left {
                width: 100%;
            }

            .produk-right {
                width: 100%;
                margin-top: 15px;
                justify-content: space-between;
            }

        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const total = <?= $totalBayar ?>;

            const jumlahView = document.getElementById("JumlahBayarView");

            const jumlahHidden = document.getElementById("JumlahBayar");

            const file = document.getElementById("BuktiPembayaran");

            const nama = document.getElementById("namaFile");

            <?php if (!$isPelunasan) { ?>

                const jenis = document.getElementById("JenisPembayaran");

                function rupiah(angka) {

                    return "Rp " + Number(angka).toLocaleString("id-ID");

                }

                function hitung() {

                    let bayar = 0;

                    if (jenis.value === "DP") {

                        bayar = Math.round(total * 0.5);

                    } else if (jenis.value === "Full Payment") {

                        bayar = total;

                    }

                    jumlahView.value = bayar == 0 ? "" : rupiah(bayar);

                    jumlahHidden.value = bayar;

                }

                jenis.addEventListener("change", hitung);

                hitung();

            <?php } else { ?>

                function rupiah(angka) {

                    return "Rp " + Number(angka).toLocaleString("id-ID");

                }

                jumlahView.value = rupiah(total);

                jumlahHidden.value = total;

            <?php } ?>

            file.addEventListener("change", function() {

                if (this.files.length) {

                    nama.innerHTML = "<i class='fa fa-check-circle text-success'></i> " + this.files[0].name;

                } else {

                    nama.innerHTML = "Belum ada file dipilih";

                }

            });

        });
    </script>

</body>

</html>