<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title><?= $judul ?></title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 13px;
            margin: 30px;
            color: #000;
        }

        @page {
            size: A4 portrait;
            margin: 15mm;
        }

        .header {
            border-bottom: 3px solid #000;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }

        .header-content {
            display: table;
            width: 100%;
        }

        .logo {
            display: table-cell;
            width: 90px;
            vertical-align: middle;
        }

        .logo img {
            width: 80px;
            height: 80px;
        }

        .judul {
            display: table-cell;
            text-align: center;
            vertical-align: middle;
        }

        .judul h2 {
            font-size: 24px;
            margin-bottom: 5px;
        }

        .judul h3 {
            margin-top: 10px;
            font-size: 18px;
        }

        .judul p {
            font-size: 13px;
        }

        .info {
            margin-bottom: 20px;
        }

        .info table {
            width: 100%;
            border: none;
        }

        .info td {
            border: none;
            padding: 4px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th {
            border: 1px solid #000;
            background: #e9e9e9;
            padding: 8px;
            text-align: center;
        }

        table td {
            border: 1px solid #000;
            padding: 8px;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        .footer {
            margin-top: 60px;
            width: 250px;
            float: right;
            text-align: center;
        }
    </style>

</head>

<body onload="window.print()">

    <!-- ================= HEADER ================= -->

    <div class="header">

        <div class="header-content">

            <div class="logo">

                <img src="<?= base_url('assets/img/logo.jpeg') ?>">

            </div>

            <div class="judul">

                <h2>KUE KERING JEANETTE</h2>

                <p>Jl. Aur Duri Indah VII C No.11</p>

                <p>Sistem Informasi Pengelolaan Usaha Kue Kering</p>

                <br>

                <h3><?= $judul ?></h3>

            </div>

        </div>

    </div>

    <!-- ================= INFORMASI ================= -->

    <div class="info">

        <table>

            <tr>

                <td width="150"><b>No Faktur</b></td>
                <td width="10">:</td>
                <td><?= esc($faktur['IdPembayaran']) ?></td>

                <td width="150"><b>Nama Pelanggan</b></td>
                <td width="10">:</td>
                <td><?= esc($faktur['NamaPelanggan']) ?></td>

            </tr>

            <tr>

                <td><b>ID Pesanan</b></td>
                <td>:</td>
                <td><?= esc($faktur['IdPesanan']) ?></td>

                <td><b>No HP</b></td>
                <td>:</td>
                <td><?= esc($faktur['NoHp']) ?></td>

            </tr>

            <tr>

                <td><b>Tanggal Bayar</b></td>
                <td>:</td>
                <td><?= date('d-m-Y', strtotime($faktur['TglBayar'])) ?></td>

                <td><b>Alamat</b></td>
                <td>:</td>
                <td><?= esc($faktur['Alamat']) ?></td>

            </tr>

        </table>

    </div>

    <!-- ================= DETAIL PESANAN ================= -->

    <table>

        <thead>

            <tr>

                <th width="50">No</th>
                <th>Kemasan</th>
                <th width="80">Qty</th>
                <th width="120">Harga</th>
                <th width="140">Subtotal</th>

            </tr>

        </thead>

        <tbody>

            <?php $no = 1; ?>

            <?php foreach ($detail as $row): ?>

                <tr>

                    <td class="center">

                        <?= $no++ ?>

                    </td>

                    <td>

                        <?= esc($row['NamaKemasan']) ?>

                    </td>

                    <td class="center">

                        <?= $row['Qty'] ?>

                    </td>

                    <td class="right">

                        Rp <?= number_format($row['Harga'], 0, ',', '.') ?>

                    </td>

                    <td class="right">

                        Rp <?= number_format($row['SubTotal'], 0, ',', '.') ?>

                    </td>

                </tr>

            <?php endforeach; ?>

            <tr>

                <td colspan="4" class="right">

                    <strong>Total Pesanan</strong>

                </td>

                <td class="right">

                    <strong>

                        Rp <?= number_format($faktur['Total'], 0, ',', '.') ?>

                    </strong>

                </td>

            </tr>

            <tr>

                <td colspan="4" class="right">

                    <strong>Jumlah Dibayar</strong>

                </td>

                <td class="right">

                    <strong>

                        Rp <?= number_format($faktur['JumlahBayar'], 0, ',', '.') ?>

                    </strong>

                </td>

            </tr>

        </tbody>

    </table>

    <!-- ================= FOOTER ================= -->

    <div class="footer">

        <p>

            Padang, <?= date('d F Y') ?>

        </p>

        <br><br><br><br>

        <b>Yarfinis</b>

        <br>

        <small>Pemilik Usaha</small>

    </div>

</body>

</html>