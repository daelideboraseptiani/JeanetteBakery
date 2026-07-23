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

        <tr>

            <td>Total Data</td>

            <td>:</td>

            <td><?= count($bahanbaku) ?> Bahan Baku</td>

        </tr>

    </table>

</div>

<!-- ================= TABLE ================= -->

<table>

    <thead>

        <tr>

            <th width="40">No</th>
            <th>ID Bahan Baku</th>
            <th>Nama Bahan</th>
            <th>Merk</th>
            <th>Satuan</th>
            <th>Stok</th>
            <th>Harga</th>

        </tr>

    </thead>

    <tbody>

    <?php if(!empty($bahanbaku)) : ?>

        <?php $no = 1; ?>

        <?php foreach($bahanbaku as $row) : ?>

        <tr>

            <td class="center">

                <?= $no++ ?>

            </td>

            <td>

                <?= esc($row['IdBahanBaku']) ?>

            </td>

            <td>

                <?= esc($row['NamaBahan']) ?>

            </td>

            <td>

                <?= esc($row['Merk']) ?>

            </td>

            <td class="center">

                <?= esc($row['Satuan']) ?>

            </td>

            <td class="center">

                <?= number_format($row['Stok'],2,',','.') ?>

            </td>

            <td class="right">

                Rp <?= number_format($row['Harga'],0,',','.') ?>

            </td>

        </tr>

        <?php endforeach; ?>

    <?php else : ?>

        <tr>

            <td colspan="7" class="center">

                Data bahan baku tidak tersedia.

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