<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class LaporanController extends BaseController
{
    // =====================================================
    // LAPORAN USER
    // =====================================================
    public function laporanuser()
    {
        $model = new \App\Models\ModalUser();


        $data = [
            'user' => $model->findAll()
        ];

        return view('laporan/v_laporanuser', $data);
    }

    // =====================================================
    // CETAK LAPORAN USER
    // =====================================================
    public function cetakuser()
    {
        $model = new \App\Models\ModalUser();


        // Ambil parameter status dari URL
        $status = $this->request->getGet('status');

        // Filter data berdasarkan status
        if ($status == 'Aktif') {

            $user = $model->where('Status', 'Aktif')->findAll();

            $judul = 'Laporan Data User Aktif';
        } elseif ($status == 'Nonaktif') {

            $user = $model->where('Status', 'Nonaktif')->findAll();

            $judul = 'Laporan Data User Nonaktif';
        } else {

            $user = $model->findAll();

            $judul = 'Laporan Data User';
        }

        $data = [
            'user'   => $user,
            'judul'  => $judul,
            'status' => $status
        ];

        return view('laporan/laporanuser', $data);
    }

    // =====================================================
    // LAPORAN PELANGGAN
    // =====================================================
    public function laporanpelanggan()
    {
        $db = \Config\Database::connect();

        $user = $db->table('Pelanggan')
            ->select('Pelanggan.*, USER.Email, USER.Status')
            ->join('USER', 'USER.IdUser = Pelanggan.IdUser')
            ->get()
            ->getResultArray();

        $data = [
            'pelanggan' => $user
        ];

        return view('laporan/v_laporanpelanggan', $data);
    }

    // =====================================================
    // CETAK LAPORAN PELANGGAN
    // =====================================================
    public function cetakpelanggan()
    {
        $db = \Config\Database::connect();

        $status = $this->request->getGet('status');

        $builder = $db->table('Pelanggan');
        $builder->select('Pelanggan.*, USER.Email, USER.Status');
        $builder->join('USER', 'USER.IdUser = Pelanggan.IdUser');

        if ($status == 'Aktif') {

            $builder->where('USER.Status', 'Aktif');
            $judul = 'Laporan Data Pelanggan Aktif';
        } elseif ($status == 'Nonaktif') {

            $builder->where('USER.Status', 'Nonaktif');
            $judul = 'Laporan Data Pelanggan Nonaktif';
        } else {

            $judul = 'Laporan Data Pelanggan';
        }

        $data = [
            'pelanggan' => $builder->get()->getResultArray(),
            'judul'     => $judul,
            'status'    => $status
        ];

        return view('laporan/laporanpelanggan', $data);
    }

    // =====================================================
    // LAPORAN PRODUK
    // =====================================================
    public function laporanproduk()
    {
        $model = new \App\Models\ModalProduk();

        $data = [
            'produk' => $model->findAll()
        ];

        return view('laporan/v_laporanproduk', $data);
    }

    // =====================================================
    // CETAK LAPORAN PRODUK
    // =====================================================
    public function cetakproduk()
    {
        $model = new \App\Models\ModalProduk();

        $status = $this->request->getGet('status');

        if ($status == 'Aktif') {

            $produk = $model->where('StatusProduk', 'Aktif')->findAll();

            $judul = 'Laporan Data Produk Aktif';
        } elseif ($status == 'Nonaktif') {

            $produk = $model->where('StatusProduk', 'Nonaktif')->findAll();

            $judul = 'Laporan Data Produk Nonaktif';
        } else {

            $produk = $model->findAll();

            $judul = 'Laporan Data Produk';
        }

        $data = [
            'produk' => $produk,
            'judul' => $judul,
            'status' => $status
        ];

        return view('laporan/laporanproduk', $data);
    }

    // =====================================================
    // LAPORAN KEMASAN
    // =====================================================
    public function laporankemasan()
    {
        $db = \Config\Database::connect();

        $kemasan = $db->table('Kemasan')
            ->select('Kemasan.*, Produk.NamaProduk')
            ->join('Produk', 'Produk.IdProduk = Kemasan.IdProduk')
            ->get()
            ->getResultArray();

        $data = [
            'kemasan' => $kemasan
        ];

        return view('laporan/v_laporankemasan', $data);
    }

    // =====================================================
    // CETAK LAPORAN KEMASAN
    // =====================================================
    public function cetakkemasan()
    {
        $db = \Config\Database::connect();

        $status = $this->request->getGet('status');

        $builder = $db->table('Kemasan');
        $builder->select('Kemasan.*, Produk.NamaProduk');
        $builder->join('Produk', 'Produk.IdProduk = Kemasan.IdProduk');

        if ($status == 'Aktif') {

            $builder->where('Kemasan.StatusKemasan', 'Aktif');

            $judul = 'Laporan Data Kemasan Aktif';
        } elseif ($status == 'Nonaktif') {

            $builder->where('Kemasan.StatusKemasan', 'Nonaktif');

            $judul = 'Laporan Data Kemasan Nonaktif';
        } else {

            $judul = 'Laporan Data Kemasan';
        }

        $data = [
            'kemasan' => $builder->get()->getResultArray(),
            'judul'   => $judul,
            'status'  => $status
        ];

        return view('laporan/laporankemasan', $data);
    }

    // =====================================================
    // LAPORAN BAHAN BAKU
    // =====================================================
    public function laporanbahanbaku()
    {
        $model = new \App\Models\ModalBahanBaku();

        $data = [
            'bahanbaku' => $model->findAll()
        ];

        return view('laporan/v_laporanbahanbaku', $data);
    }

    // =====================================================
    // CETAK LAPORAN BAHAN BAKU
    // =====================================================
    public function cetakbahanbaku()
    {
        $model = new \App\Models\ModalBahanBaku();

        $bahanbaku = $model->findAll();

        $data = [
            'bahanbaku' => $bahanbaku,
            'judul'     => 'Laporan Data Bahan Baku'
        ];

        return view('laporan/laporanbahanbaku', $data);
    }

    // =====================================================
    // LAPORAN PRODUKSI
    // =====================================================
    public function laporanproduksi()
    {
        $db = \Config\Database::connect();

        $produksi = $db->table('Produksi')
            ->select('Produksi.*, Produk.NamaProduk')
            ->join('Produk', 'Produk.IdProduk = Produksi.IdProduk')
            ->get()
            ->getResultArray();

        $data = [
            'produksi' => $produksi
        ];

        return view('laporan/v_laporanproduksi', $data);
    }

    // =====================================================
    // CETAK LAPORAN PRODUKSI
    // =====================================================
    // =====================================================
    // CETAK LAPORAN PRODUKSI
    // =====================================================
    public function cetakproduksi()
    {
        $db = \Config\Database::connect();

        $status = $this->request->getGet('status');
        $tglAwal = $this->request->getGet('tgl_awal');
        $tglAkhir = $this->request->getGet('tgl_akhir');

        $builder = $db->table('Produksi');
        $builder->select('Produksi.*, Produk.NamaProduk');
        $builder->join('Produk', 'Produk.IdProduk = Produksi.IdProduk');

        // Filter Status
        if (!empty($status)) {
            $builder->where('Produksi.StatusProduksi', $status);
        }

        // Filter Tanggal
        if (!empty($tglAwal) && !empty($tglAkhir)) {
            $builder->where('Produksi.TglProduksi >=', $tglAwal);
            $builder->where('Produksi.TglProduksi <=', $tglAkhir);
        }

        // Judul
        if ($status == 'Diproduksi') {

            $judul = 'Laporan Data Produksi Diproduksi';
        } elseif ($status == 'Selesai') {

            $judul = 'Laporan Data Produksi Selesai';
        } else {

            $judul = 'Laporan Data Produksi';
        }

        $data = [
            'produksi' => $builder->get()->getResultArray(),
            'judul'    => $judul,
            'status'   => $status,
            'tglAwal'  => $tglAwal,
            'tglAkhir' => $tglAkhir
        ];

        return view('laporan/laporanproduksi', $data);
    }

    // =====================================================
    // LAPORAN PESANAN
    // =====================================================
    public function laporanpesanan()
    {
        $db = \Config\Database::connect();

        $pesanan = $db->table('Pesanan')
            ->select('Pesanan.*, Pelanggan.NamaPelanggan')
            ->join('Pelanggan', 'Pelanggan.IdPelanggan = Pesanan.IdPelanggan')
            ->get()
            ->getResultArray();

        $data = [
            'pesanan' => $pesanan
        ];

        return view('laporan/v_laporanpesanan', $data);
    }

    // =====================================================
    // CETAK LAPORAN PESANAN
    // =====================================================
    public function cetakpesanan()
    {
        $db = \Config\Database::connect();

        $status = $this->request->getGet('status');
        $tglAwal = $this->request->getGet('tgl_awal');
        $tglAkhir = $this->request->getGet('tgl_akhir');

        $builder = $db->table('Pesanan');
        $builder->select('Pesanan.*, Pelanggan.NamaPelanggan');
        $builder->join('Pelanggan', 'Pelanggan.IdPelanggan = Pesanan.IdPelanggan');

        // Filter Status
        if (!empty($status)) {

            $builder->where('Pesanan.StatusPesanan', $status);
        }

        // Filter Periode
        if (!empty($tglAwal) && !empty($tglAkhir)) {

            $builder->where('Pesanan.TglPesanan >=', $tglAwal);
            $builder->where('Pesanan.TglPesanan <=', $tglAkhir);
        }

        // Judul Laporan
        switch ($status) {

            case 'Menunggu':
                $judul = 'Laporan Data Pesanan Menunggu';
                break;

            case 'Diproses':
                $judul = 'Laporan Data Pesanan Diproses';
                break;

            case 'Selesai':
                $judul = 'Laporan Data Pesanan Selesai';
                break;

            case 'Dibatalkan':
                $judul = 'Laporan Data Pesanan Dibatalkan';
                break;

            default:
                $judul = 'Laporan Data Pesanan';
                break;
        }

        $data = [
            'pesanan' => $builder->get()->getResultArray(),
            'judul'   => $judul,
            'status'  => $status,
            'tglAwal' => $tglAwal,
            'tglAkhir' => $tglAkhir
        ];

        return view('laporan/laporanpesanan', $data);
    }

    // =====================================================
    // LAPORAN PENJUALAN
    // =====================================================
    public function laporanpenjualan()
    {
        $db = \Config\Database::connect();

        $penjualan = $db->table('Pembayaran')
            ->select('
            Pembayaran.*,
            Pesanan.IdPesanan,
            Pesanan.TglPesanan,
            Pesanan.Total,
            Pelanggan.NamaPelanggan
        ')
            ->join('Pesanan', 'Pesanan.IdPesanan = Pembayaran.IdPesanan')
            ->join('Pelanggan', 'Pelanggan.IdPelanggan = Pesanan.IdPelanggan')
            ->where('Pembayaran.StatusPembayaran', 'Terverifikasi')
            ->get()
            ->getResultArray();

        return view('laporan/v_laporanpenjualan', [
            'penjualan' => $penjualan
        ]);
    }


    // =====================================================
    // CETAK LAPORAN PENJUALAN
    // =====================================================
    public function cetakpenjualan()
    {
        $db = \Config\Database::connect();

        $tglAwal  = $this->request->getGet('tgl_awal');
        $tglAkhir = $this->request->getGet('tgl_akhir');

        $builder = $db->table('Pembayaran');

        $builder->select('
        Pembayaran.*,
        Pesanan.IdPesanan,
        Pesanan.TglPesanan,
        Pesanan.Total,
        Pelanggan.NamaPelanggan
    ');

        $builder->join('Pesanan', 'Pesanan.IdPesanan = Pembayaran.IdPesanan');
        $builder->join('Pelanggan', 'Pelanggan.IdPelanggan = Pesanan.IdPelanggan');

        // Hanya transaksi yang sudah berhasil
        $builder->where('Pembayaran.StatusPembayaran', 'Terverifikasi');

        if (!empty($tglAwal) && !empty($tglAkhir)) {

            $builder->where('Pembayaran.TglBayar >=', $tglAwal);
            $builder->where('Pembayaran.TglBayar <=', $tglAkhir);
        }

        $data = [
            'penjualan' => $builder->get()->getResultArray(),
            'judul'     => 'Laporan Penjualan',
            'tglAwal'   => $tglAwal,
            'tglAkhir'  => $tglAkhir
        ];

        return view('laporan/laporanpenjualan', $data);
    }

    // =====================================================
    // LAPORAN PEMAKAIAN BAHAN BAKU
    // =====================================================
    public function pemakaianbahanbaku()
    {
        $db = \Config\Database::connect();

        $pemakaian = $db->table('DetailProduksi')
            ->select('
            DetailProduksi.*,
            Produksi.IdProduksi,
            Produksi.TglProduksi,
            BahanBaku.NamaBahan
        ')
            ->join('Produksi', 'Produksi.IdProduksi = DetailProduksi.IdProduksi')
            ->join('BahanBaku', 'BahanBaku.IdBahanBaku = DetailProduksi.IdBahanBaku')
            ->orderBy('Produksi.TglProduksi', 'DESC')
            ->get()
            ->getResultArray();

        return view('laporan/v_pemakaianbahanbaku', [
            'pemakaian' => $pemakaian
        ]);
    }


    // =====================================================
    // CETAK LAPORAN PEMAKAIAN BAHAN BAKU
    // =====================================================
    public function cetakpemakaianbahanbaku()
    {
        $db = \Config\Database::connect();

        $tglAwal  = $this->request->getGet('tgl_awal');
        $tglAkhir = $this->request->getGet('tgl_akhir');

        $builder = $db->table('DetailProduksi');

        $builder->select('
        DetailProduksi.*,
        Produksi.IdProduksi,
        Produksi.TglProduksi,
        BahanBaku.NamaBahan
    ');

        $builder->join(
            'Produksi',
            'Produksi.IdProduksi = DetailProduksi.IdProduksi'
        );

        $builder->join(
            'BahanBaku',
            'BahanBaku.IdBahanBaku = DetailProduksi.IdBahanBaku'
        );

        if (!empty($tglAwal) && !empty($tglAkhir)) {

            $builder->where('Produksi.TglProduksi >=', $tglAwal);
            $builder->where('Produksi.TglProduksi <=', $tglAkhir);
        }

        $builder->orderBy('Produksi.TglProduksi', 'DESC');

        return view('laporan/pemakaianbahanbaku', [

            'pemakaian' => $builder->get()->getResultArray(),

            'judul' => 'Laporan Data Pemakaian Bahan Baku',

            'tglAwal' => $tglAwal,

            'tglAkhir' => $tglAkhir

        ]);
    }

    // =====================================================
    // HALAMAN PILIH ID PESANAN
    // =====================================================
    public function fakturpembayaran()
    {
        $db = \Config\Database::connect();

        $pesanan = $db->table('Pesanan')
            ->select('IdPesanan')
            ->orderBy('IdPesanan', 'ASC')
            ->get()
            ->getResultArray();

        return view('laporan/v_fakturpembayaran', [
            'pesanan' => $pesanan
        ]);
    }


    // =====================================================
    // CETAK FAKTUR PEMBAYARAN
    // =====================================================
    public function cetakfaktur()
    {
        $db = \Config\Database::connect();

        $idPesanan = $this->request->getPost('idpesanan');

        // ================= HEADER FAKTUR =================
        $faktur = $db->table('Pembayaran')
            ->select('
            Pembayaran.*,
            Pesanan.IdPesanan,
            Pesanan.TglPesanan,
            Pesanan.Total,
            Pelanggan.NamaPelanggan,
            Pelanggan.NoHp,
            Pelanggan.Alamat
        ')
            ->join('Pesanan', 'Pesanan.IdPesanan = Pembayaran.IdPesanan')
            ->join('Pelanggan', 'Pelanggan.IdPelanggan = Pesanan.IdPelanggan')
            ->where('Pesanan.IdPesanan', $idPesanan)
            ->get()
            ->getRowArray();

        // ================= DETAIL PESANAN =================
        $detail = $db->table('DetailPesanan')
            ->select('
            DetailPesanan.*,
            Kemasan.NamaKemasan,
            Produk.NamaProduk
        ')
            ->join('Kemasan', 'Kemasan.IdKemasan = DetailPesanan.IdKemasan')
            ->join('Produk', 'Produk.IdProduk = Kemasan.IdProduk')
            ->where('DetailPesanan.IdPesanan', $idPesanan)
            ->get()
            ->getResultArray();

        $data = [
            'judul'  => 'Faktur Pembayaran',
            'faktur' => $faktur,
            'detail' => $detail
        ];

        return view('laporan/fakturpembayaran', $data);
    }
}
