<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Faktur Pembayaran</title>

    <style>
        body{
            font-family: Arial, Helvetica, sans-serif;
            font-size:14px;
            color:#000;
        }

        .container{
            width:90%;
            margin:auto;
        }

        .header{
            text-align:center;
            margin-bottom:20px;
        }

        .header h2{
            margin:0;
        }

        table{
            width:100%;
            border-collapse:collapse;
        }

        table td,
        table th{
            border:1px solid #000;
            padding:8px;
        }

        .table-borderless td{
            border:none;
            padding:3px;
        }

        .text-right{
            text-align:right;
        }

        .text-center{
            text-align:center;
        }

        .mt{
            margin-top:20px;
        }

        .no-border{
            border:none!important;
        }

        @media print{
            .btn-print{
                display:none;
            }
        }
    </style>
</head>

<body>

<?php

$totalBayar = 0;
$jenisPembayaran = "-";

foreach($pembayaran as $row){

    if($row['StatusPembayaran']=="Terverifikasi"){

        $totalBayar += $row['JumlahBayar'];

    }

    $jenisPembayaran = $row['JenisPembayaran'];
}

$sisa = $pesanan['Total'] - $totalBayar;

?>

<div class="container">

    <div class="header">

        <h2>FAKTUR PEMBAYARAN</h2>

        <?php if($jenisPembayaran=="DP"): ?>

            <h3>PEMBAYARAN DOWN PAYMENT (DP)</h3>

        <?php elseif($jenisPembayaran=="Pelunasan"): ?>

            <h3>PEMBAYARAN PELUNASAN</h3>

        <?php else: ?>

            <h3>FULL PAYMENT</h3>

        <?php endif; ?>

    </div>

    <table class="table-borderless">

        <tr>

            <td width="20%">No Pesanan</td>
            <td width="2%">:</td>
            <td><?= $pesanan['IdPesanan']; ?></td>

            <td width="20%">Tanggal</td>
            <td width="2%">:</td>
            <td><?= date('d-m-Y',strtotime($pesanan['TglPesanan'])) ?></td>

        </tr>

        <tr>

            <td>Status Pesanan</td>
            <td>:</td>
            <td><?= $pesanan['StatusPesanan']; ?></td>

            <td>Status Pembayaran</td>
            <td>:</td>

            <td>

                <?= ($sisa <= 0) ? "Lunas" : "Belum Lunas"; ?>

            </td>

        </tr>

    </table>

    <br>

    <table>

        <thead>

            <tr>

                <th width="5%">No</th>
                <th>Produk</th>
                <th>Kemasan</th>
                <th width="10%">Qty</th>
                <th width="20%">Subtotal</th>

            </tr>

        </thead>

        <tbody>

        <?php
        $no=1;

        foreach($detail as $d):
        ?>

        <tr>

            <td class="text-center"><?= $no++ ?></td>

            <td><?= $d['NamaProduk']; ?></td>

            <td>

                <?= $d['NamaKemasan']; ?>

                (<?= $d['Berat']; ?>

                <?= $d['SatuanBerat']; ?>)

            </td>

            <td class="text-center">

                <?= $d['Qty']; ?>

            </td>

            <td class="text-right">

                Rp <?= number_format($d['SubTotal'],0,',','.'); ?>

            </td>

        </tr>

        <?php endforeach; ?>
                <tr>

            <td colspan="4" class="text-right">

                <b>Total Pesanan</b>

            </td>

            <td class="text-right">

                <b>

                    Rp <?= number_format($pesanan['Total'],0,',','.'); ?>

                </b>

            </td>

        </tr>

        </tbody>

    </table>

    <br>

    <h3>Riwayat Pembayaran</h3>

    <table>

        <thead>

            <tr>

                <th width="5%">No</th>

                <th width="20%">Tanggal</th>

                <th width="20%">Jenis Pembayaran</th>

                <th width="25%">Nominal</th>

                <th>Status</th>

            </tr>

        </thead>

        <tbody>

        <?php

        $no = 1;

        foreach($pembayaran as $row):

        ?>

        <tr>

            <td class="text-center">

                <?= $no++ ?>

            </td>

            <td class="text-center">

                <?= date('d-m-Y', strtotime($row['TglBayar'])) ?>

            </td>

            <td class="text-center">

                <?= $row['JenisPembayaran'] ?>

            </td>

            <td class="text-right">

                Rp <?= number_format($row['JumlahBayar'],0,',','.') ?>

            </td>

            <td class="text-center">

                <?= $row['StatusPembayaran'] ?>

            </td>

        </tr>

        <?php endforeach; ?>

        </tbody>

    </table>

    <br>

    <table>

        <tr>

            <th width="70%" class="text-right">

                Total Dibayar

            </th>

            <th class="text-right">

                Rp <?= number_format($totalBayar,0,',','.') ?>

            </th>

        </tr>

        <tr>

            <th class="text-right">

                Sisa Pembayaran

            </th>

            <th class="text-right">

                Rp <?= number_format($sisa,0,',','.') ?>

            </th>

        </tr>

        <tr>

            <th class="text-right">

                Status

            </th>

            <th class="text-center">

                <?php if($sisa <= 0): ?>

                    <span style="color:green">

                        LUNAS

                    </span>

                <?php else: ?>

                    <span style="color:orange">

                        BELUM LUNAS

                    </span>

                <?php endif; ?>

            </th>

        </tr>

    </table>
        <div class="mt">

        <table class="table-borderless">

            <tr>

                <td width="65%">

                    <b>Keterangan :</b>

                    <br><br>

                    <?php if($sisa > 0): ?>

                        Faktur ini merupakan bukti pembayaran yang telah diterima.

                        <br>

                        Pelanggan telah membayar sebesar

                        <b>

                            Rp <?= number_format($totalBayar,0,',','.') ?>

                        </b>

                        dari total pesanan sebesar

                        <b>

                            Rp <?= number_format($pesanan['Total'],0,',','.') ?>

                        </b>.

                        <br>

                        Sisa pembayaran yang harus dilunasi adalah

                        <b>

                            Rp <?= number_format($sisa,0,',','.') ?>

                        </b>.

                    <?php else: ?>

                        Faktur ini merupakan bukti bahwa seluruh pembayaran pesanan telah diterima.

                        <br>

                        Total pembayaran sebesar

                        <b>

                            Rp <?= number_format($totalBayar,0,',','.') ?>

                        </b>

                        telah dinyatakan

                        <b>LUNAS</b>.

                    <?php endif; ?>

                </td>

                <td width="35%" class="text-center">

                    Mengetahui,

                    <br><br><br><br><br>

                    ______________________

                    <br>

                    Admin

                </td>

            </tr>

        </table>

    </div>

    <br>

    <div class="text-center btn-print">

        <button onclick="window.print()"
            style="
                padding:10px 20px;
                border:none;
                background:#0d6efd;
                color:#fff;
                border-radius:5px;
                cursor:pointer;
                font-size:15px;">

            Cetak Faktur

        </button>

    </div>

</div>

</body>

</html>