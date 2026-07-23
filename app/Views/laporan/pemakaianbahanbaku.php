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
            color: #000;
            margin: 30px;
        }


        /* ================= HEADER ================= */

        .header {

            border-bottom: 3px solid #000;
            padding-bottom: 15px;
            margin-bottom: 20px;

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

            font-size: 18px;
            margin-top: 10px;

        }


        .judul p {

            font-size: 13px;

        }


        /* ================= INFO ================= */


        .info {

            margin-bottom: 20px;

        }


        .info table {

            border: none;

        }


        .info td {

            border: none;
            padding: 3px 0;

        }


        /* ================= TABLE ================= */


        table {

            width: 100%;
            border-collapse: collapse;

        }


        table thead th {

            border: 1px solid #000;
            background: #e9e9e9;
            padding: 8px;
            text-align: center;

        }


        table tbody td {

            border: 1px solid #000;
            padding: 8px;

        }


        .produksi {

            background: #e9e9e9;
            font-weight: bold;

        }


        .center {

            text-align: center;

        }


        /* ================= FOOTER ================= */


        .footer {

            width: 100%;
            margin-top: 60px;

        }


        .ttd {

            width: 260px;
            float: right;
            text-align: center;

        }


        @media print {

            @page {

                size: A4 portrait;
                margin: 15mm;

            }


            body {

                margin: 0;

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

                <td width="120">
                    Tanggal Cetak
                </td>


                <td width="10">
                    :
                </td>


                <td>
                    <?= date('d F Y') ?>
                </td>


            </tr>



            <tr>

                <td>
                    Total Produksi
                </td>


                <td>
                    :
                </td>


                <td>

                    <?= count(array_unique(array_column($pemakaian, 'IdProduksi'))) ?>
                    Produksi

                </td>


            </tr>



        </table>


    </div>





    <!-- ================= TABLE ================= -->


    <table>


        <thead>


            <tr>

                <th width="40">
                    No
                </th>


                <th>
                    ID Produksi
                </th>


                <th>
                    Nama Bahan Baku
                </th>


                <th>
                    Qty Dipakai
                </th>


            </tr>


        </thead>



        <tbody>



            <?php if (!empty($pemakaian)) : ?>


                <?php

                $no = 1;

                $produksiSebelumnya = '';

                ?>


                <?php foreach ($pemakaian as $row) : ?>



                    <?php if ($produksiSebelumnya != $row['IdProduksi']) : ?>



                        <tr class="produksi">


                            <td colspan="4">

                                Produksi :
                                <?= esc($row['IdProduksi']) ?>

                            </td>


                        </tr>



                        <?php

                        $produksiSebelumnya = $row['IdProduksi'];

                        ?>



                    <?php endif; ?>





                    <tr>


                        <td class="center">

                            <?= $no++ ?>

                        </td>


                        <td>

                        </td>


                        <td>

                            <?= esc($row['NamaBahan']) ?>

                        </td>


                        <td class="center">

                            <?= number_format($row['QtyDipakai'], 2, ',', '.') ?>

                        </td>


                    </tr>




                <?php endforeach; ?>



            <?php else : ?>


                <tr>

                    <td colspan="4" class="center">

                        Data pemakaian bahan baku tidak tersedia.

                    </td>


                </tr>


            <?php endif; ?>



        </tbody>


    </table>






    <!-- ================= FOOTER ================= -->


    <div class="footer">


        <div class="ttd">


            <p>

                Padang, <?= date('d F Y') ?>

            </p>


            <br><br><br><br>


            <b>Yarfinis</b>


            <br>


            <small>Pemilik Usaha</small>


        </div>


    </div>



</body>


</html>