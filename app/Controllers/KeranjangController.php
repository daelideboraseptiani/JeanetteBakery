<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ModalKeranjang;
use App\Models\ModalPelanggan;
use App\Models\ModalPesanan;
use App\Models\ModalDetailPesanan;

class KeranjangController extends BaseController
{
    public function simpan()
    {
        $modelKeranjang = new ModalKeranjang();
        $modelPelanggan = new ModalPelanggan();

        // Ambil IdUser dari session login
        $IdUser = session()->get('IdUser');

        if (!$IdUser) {
            return redirect()->to('/login');
        }

        // Cari data pelanggan berdasarkan IdUser
        $pelanggan = $modelPelanggan
            ->where('IdUser', $IdUser)
            ->first();

        if (!$pelanggan) {
            return redirect()->back()->with('error', 'Data pelanggan tidak ditemukan.');
        }

        $IdPelanggan = $pelanggan['IdPelanggan'];

        // Ambil data dari form
        $IdKemasan = $this->request->getPost('IdKemasan');
        $Qty       = (int)$this->request->getPost('Qty');
        $Harga     = (float)$this->request->getPost('Harga');

        $SubTotal = $Qty * $Harga;

        // Cek apakah produk sudah ada di keranjang
        $cek = $modelKeranjang->cekKeranjang($IdPelanggan, $IdKemasan);

        if ($cek) {

            // Update qty jika sudah ada
            $QtyBaru = $cek['Qty'] + $Qty;

            $modelKeranjang->update($cek['IdKeranjang'], [
                'Qty'      => $QtyBaru,
                'SubTotal' => $QtyBaru * $Harga
            ]);
        } else {

            // Simpan data baru
            $modelKeranjang->insert([
                'IdPelanggan' => $IdPelanggan,
                'IdKemasan'   => $IdKemasan,
                'Tanggal'     => date('Y-m-d'),
                'Qty'         => $Qty,
                'Harga'       => $Harga,
                'SubTotal'    => $SubTotal,
                'Status'      => 'Aktif'
            ]);
        }
        return redirect()->to('/katalog')->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    public function index()
    {
        $modelKeranjang = new ModalKeranjang();
        $modelPelanggan = new ModalPelanggan();

        $pelanggan = $modelPelanggan
            ->where('IdUser', session()->get('IdUser'))
            ->first();

        $IdPelanggan = $pelanggan['IdPelanggan'];

        $data = [
            'keranjang' => $modelKeranjang->getKeranjang($IdPelanggan),
            'total'     => $modelKeranjang->totalKeranjang($IdPelanggan)
        ];

        return view('layout/keranjang', $data);
    }

    public function tambahQty($IdKeranjang)
    {
        $modelKeranjang = new ModalKeranjang();

        $modelKeranjang->tambahQty($IdKeranjang);

        return redirect()->back();
    }

    public function kurangQty($IdKeranjang)
    {
        $modelKeranjang = new ModalKeranjang();

        $modelKeranjang->kurangQty($IdKeranjang);

        return redirect()->back();
    }

    public function hapus($IdKeranjang)
    {
        $modelKeranjang = new ModalKeranjang();

        $modelKeranjang->hapusKeranjang($IdKeranjang);

        return redirect()->back()->with('success', 'Produk berhasil dihapus dari keranjang.');
    }

    public function checkout()
    {
        $db = \Config\Database::connect();

        $modelKeranjang      = new ModalKeranjang();
        $modelPelanggan      = new ModalPelanggan();
        $modelPesanan        = new ModalPesanan();
        $modelDetailPesanan  = new ModalDetailPesanan();

        // Ambil pelanggan dari session
        $pelanggan = $modelPelanggan
            ->where('IdUser', session()->get('IdUser'))
            ->first();

        if (!$pelanggan) {
            return redirect()->back()->with('error', 'Data pelanggan tidak ditemukan.');
        }

        $IdPelanggan = $pelanggan['IdPelanggan'];

        // Ambil semua item keranjang yang masih aktif
        $keranjang = $modelKeranjang
            ->where('IdPelanggan', $IdPelanggan)
            ->where('Status', 'Aktif')
            ->findAll();

        if (empty($keranjang)) {
            return redirect()->back()->with('error', 'Keranjang masih kosong.');
        }

        $db->transBegin();

        try {

            // ============================
            // Generate ID Pesanan
            // ============================

            $IdPesanan = $modelPesanan->generateId();

            // ============================
            // Hitung Total
            // ============================

            $total = 0;

            foreach ($keranjang as $item) {
                $total += $item['SubTotal'];
            }

            // ============================
            // Simpan Pesanan
            // ============================

            $modelPesanan->insert([
                'IdPesanan'       => $IdPesanan,
                'IdPelanggan'     => $IdPelanggan,
                'TglPesanan'      => date('Y-m-d'),
                'StatusPesanan'   => 'Menunggu',
                'EstimasiSelesai' => null,
                'Total'           => $total
            ]);

            // ============================
            // Simpan Detail Pesanan
            // ============================

            foreach ($keranjang as $item) {

                $modelDetailPesanan->insert([

                    'IdDetailPesanan' => $modelDetailPesanan->generateId(),

                    'IdPesanan' => $IdPesanan,

                    'IdKemasan' => $item['IdKemasan'],

                    'Qty' => $item['Qty'],

                    'Harga' => $item['Harga'],

                    'SubTotal' => $item['SubTotal']

                ]);

                // Ubah status keranjang
                $modelKeranjang->update($item['IdKeranjang'], [
                    'Status' => 'Checkout'
                ]);
            }

            $db->transCommit();

            return redirect()->to('/homepage')
                ->with('success', 'Checkout berhasil.');
        } catch (\Exception $e) {

            $db->transRollback();

            return redirect()->back()
                ->with('error', $e->getMessage());
        }
    }
}
