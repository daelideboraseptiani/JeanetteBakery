<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title><?= $judul ?></title>

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            font-family:Arial, Helvetica, sans-serif;
            font-size:13px;
            color:#000;
            margin:30px;
        }

        /* ================= HEADER ================= */

        .header{
            border-bottom:3px solid #000;
            padding-bottom:15px;
            margin-bottom:20px;
        }

        .header-content{
            display:table;
            width:100%;
        }

        .logo{
            display:table-cell;
            width:90px;
            vertical-align:middle;
        }

        .logo img{
            width:80px;
            height:80px;
        }

        .judul{
            display:table-cell;
            text-align:center;
            vertical-align:middle;
        }

        .judul h2{
            font-size:24px;
            margin-bottom:5px;
        }

        .judul h3{
            font-size:18px;
            margin-top:10px;
        }

        .judul p{
            font-size:13px;
        }

        /* ================= INFO ================= */

        .info{
            margin-bottom:20px;
        }

        .info table{
            border:none;
        }

        .info td{
            border:none;
            padding:3px 0;
        }

        /* ================= TABLE ================= */

        table{
            width:100%;
            border-collapse:collapse;
        }

        table thead th{
            border:1px solid #000;
            background:#e9e9e9;
            padding:8px;
            text-align:center;
        }

        table tbody td{
            border:1px solid #000;
            padding:8px;
        }

        .center{
            text-align:center;
        }

        .right{
            text-align:right;
        }

        /* ================= FOOTER ================= */

        .footer{
            width:100%;
            margin-top:60px;
        }

        .ttd{
            width:260px;
            float:right;
            text-align:center;
        }

        @media print{

            @page{
                size:A4 portrait;
                margin:15mm;
            }

            body{
                margin:0;
            }

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

<!-- ================= INFO ================= -->

<div class="info">

    <table>

        <tr>

            <td width="120">Tanggal Cetak</td>

            <td width="10">:</td>

            <td><?= date('d F Y') ?></td>

        </tr>

        <?php if(!empty($status)) : ?>

        <tr>

            <td>Status</td>

            <td>:</td>

            <td><?= esc($status) ?></td>

        </tr>

        <?php endif; ?>

        <?php if(!empty($tglAwal) && !empty($tglAkhir)) : ?>

        <tr>

            <td>Periode</td>

            <td>:</td>

            <td>

                <?= date('d-m-Y', strtotime($tglAwal)) ?>

                s/d

                <?= date('d-m-Y', strtotime($tglAkhir)) ?>

            </td>

        </tr>

        <?php endif; ?>

        <tr>

            <td>Total Data</td>

            <td>:</td>

            <td><?= count($pesanan) ?> Pesanan</td>

        </tr>

    </table>

</div>

<!-- ================= TABLE ================= -->

<table>

    <thead>

        <tr>

            <th width="40">No</th>
            <th>ID Pesanan</th>
            <th>Nama Pelanggan</th>
            <th>Tanggal Pesanan</th>
            <th>Estimasi Selesai</th>
            <th>Total</th>
            <th>Status</th>

        </tr>

    </thead>

    <tbody>

    <?php if(!empty($pesanan)) : ?>

        <?php $no = 1; ?>

        <?php foreach($pesanan as $row) : ?>

        <tr>

            <td class="center">

                <?= $no++ ?>

            </td>

            <td>

                <?= esc($row['IdPesanan']) ?>

            </td>

            <td>

                <?= esc($row['NamaPelanggan']) ?>

            </td>

            <td class="center">

                <?= date('d-m-Y', strtotime($row['TglPesanan'])) ?>

            </td>

            <td class="center">

                <?= !empty($row['EstimasiSelesai']) ? date('d-m-Y', strtotime($row['EstimasiSelesai'])) : '-' ?>

            </td>

            <td class="right">

                Rp <?= number_format($row['Total'],0,',','.') ?>

            </td>

            <td class="center">

                <?= esc($row['StatusPesanan']) ?>

            </td>

        </tr>

        <?php endforeach; ?>

    <?php else : ?>

        <tr>

            <td colspan="7" class="center">

                Data pesanan tidak tersedia.

            </td>

        </tr>

    <?php endif; ?>

    </tbody>

</table>

<!-- ================= FOOTER ================= -->

<div class="footer">

    <div class="ttd">

        <p>Padang, <?= date('d F Y') ?></p>

        <br><br><br><br>

        <b>Yarfinis</b><br>

        <small>Pemilik Usaha</small>

    </div>

</div>

</body>

</html>