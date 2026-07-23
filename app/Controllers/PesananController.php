<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModalPesanan;
use App\Models\ModalDetailPesanan;
use App\Models\ModalPelanggan;
use App\Models\ModalKemasan;

class PesananController extends BaseController
{
    // =====================================================
    // TAMPIL DATA PESANAN
    // =====================================================
    public function datapesanan()
    {
        $modalPesanan = new ModalPesanan();

        $data = [
            'pesanan' => $modalPesanan->getPesananWithPelanggan()
        ];

        return view('datatransaksi/v_datapesanan', $data);
    }

    // =====================================================
    // FORM TAMBAH
    // =====================================================
    public function tambah()
    {
        $modalPesanan   = new ModalPesanan();
        $modalPelanggan = new ModalPelanggan();
        $modalKemasan   = new ModalKemasan();

        $data = [
            'IdPesanan' => $modalPesanan->generateId(),
            'pelanggan' => $modalPelanggan->findAll(),
            'kemasan'   => $modalKemasan
                ->select('Kemasan.*, Produk.NamaProduk')
                ->join('Produk', 'Produk.IdProduk = Kemasan.IdProduk')
                ->where('Kemasan.StatusKemasan', 'Aktif')
                ->findAll()
        ];

        return view('datatransaksi/tambahpesanan', $data);
    }

    // =====================================================
    // SIMPAN PESANAN + KURANGI STOK KEMASAN
    // =====================================================
    public function simpan()
    {
        $modalPesanan = new ModalPesanan();
        $modalDetail  = new ModalDetailPesanan();
        $modalKemasan = new ModalKemasan();

        $IdPesanan = $this->request->getPost('IdPesanan');

        $db = \Config\Database::connect();
        $db->transStart();

        try {

            // =========================
            // SIMPAN PESANAN
            // =========================
            $modalPesanan->insert([
                'IdPesanan'       => $IdPesanan,
                'IdPelanggan'     => $this->request->getPost('IdPelanggan'),
                'TglPesanan'      => $this->request->getPost('TglPesanan'),
                'StatusPesanan'   => $this->request->getPost('StatusPesanan'),
                'EstimasiSelesai' => $this->request->getPost('EstimasiSelesai'),
                'Total'           => $this->request->getPost('Total')
            ]);

            // =========================
            // DETAIL PESANAN
            // =========================
            $kemasan = $this->request->getPost('IdKemasan');
            $qty     = $this->request->getPost('Qty');
            $harga   = $this->request->getPost('Harga');
            $sub     = $this->request->getPost('SubTotal');

            foreach ($kemasan as $i => $IdKemasan) {

                if (empty($IdKemasan)) continue;

                $qtyPesan = (int) $qty[$i];

                $dataKemasan = $modalKemasan->find($IdKemasan);

                // Cek stok
                if ($dataKemasan['Stok'] < $qtyPesan) {

                    throw new \Exception(
                        'Stok ' .
                            $dataKemasan['NamaKemasan'] .
                            ' tidak mencukupi'
                    );
                }

                // Simpan detail
                $modalDetail->insert([
                    'IdDetailPesanan' => $modalDetail->generateId(),
                    'IdPesanan'       => $IdPesanan,
                    'IdKemasan'       => $IdKemasan,
                    'Qty'             => $qtyPesan,
                    'Harga'           => $harga[$i],
                    'SubTotal'        => $sub[$i]
                ]);

                // Kurangi stok kemasan
                $modalKemasan->update($IdKemasan, [
                    'Stok' => $dataKemasan['Stok'] - $qtyPesan
                ]);
            }

            $db->transComplete();

            return redirect()->to(base_url('datapesanan'))
                ->with('success', 'Pesanan berhasil ditambahkan');
        } catch (\Exception $e) {

            $db->transRollback();

            return redirect()->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    // =====================================================
    // FORM EDIT
    // =====================================================
    public function edit($IdPesanan)
    {
        $modalPesanan   = new ModalPesanan();
        $modalDetail    = new ModalDetailPesanan();
        $modalPelanggan = new ModalPelanggan();
        $modalKemasan   = new ModalKemasan();

        $pesanan = $modalPesanan->find($IdPesanan);

        $detail = $modalDetail
            ->where('IdPesanan', $IdPesanan)
            ->findAll();

        $data = [
            'pesanan'   => $pesanan,
            'detail'    => $detail,
            'pelanggan' => $modalPelanggan->findAll(),
            'kemasan'   => $modalKemasan
                ->select('Kemasan.*, Produk.NamaProduk')
                ->join('Produk', 'Produk.IdProduk = Kemasan.IdProduk')
                ->where('Kemasan.StatusKemasan', 'Aktif')
                ->findAll()
        ];

        return view('datatransaksi/editpesanan', $data);
    }

    // =====================================================
    // UPDATE PESANAN + SESUAIKAN STOK
    // =====================================================
    public function update()
    {
        $modalPesanan = new ModalPesanan();
        $modalDetail  = new ModalDetailPesanan();
        $modalKemasan = new ModalKemasan();

        $IdPesanan = $this->request->getPost('IdPesanan');

        $db = \Config\Database::connect();
        $db->transStart();

        try {

            // Kembalikan stok lama
            $detailLama = $modalDetail
                ->where('IdPesanan', $IdPesanan)
                ->findAll();

            foreach ($detailLama as $d) {

                $kemasanLama = $modalKemasan->find($d['IdKemasan']);

                $modalKemasan->update($d['IdKemasan'], [
                    'Stok' => $kemasanLama['Stok'] + $d['Qty']
                ]);
            }

            // Hapus detail lama
            $modalDetail->where('IdPesanan', $IdPesanan)->delete();

            // Update pesanan
            $modalPesanan->update($IdPesanan, [
                'IdPelanggan'     => $this->request->getPost('IdPelanggan'),
                'TglPesanan'      => $this->request->getPost('TglPesanan'),
                'StatusPesanan'   => $this->request->getPost('StatusPesanan'),
                'EstimasiSelesai' => $this->request->getPost('EstimasiSelesai'),
                'Total'           => $this->request->getPost('Total')
            ]);

            // Simpan detail baru + kurangi stok
            $kemasan = $this->request->getPost('IdKemasan');
            $qty     = $this->request->getPost('Qty');
            $harga   = $this->request->getPost('Harga');
            $sub     = $this->request->getPost('SubTotal');

            foreach ($kemasan as $i => $IdKemasan) {

                if (empty($IdKemasan)) continue;

                $qtyPesan = (int) $qty[$i];

                $dataKemasan = $modalKemasan->find($IdKemasan);

                if ($dataKemasan['Stok'] < $qtyPesan) {
                    throw new \Exception(
                        'Stok ' .
                            $dataKemasan['NamaKemasan'] .
                            ' tidak mencukupi'
                    );
                }

                $modalDetail->insert([
                    'IdDetailPesanan' => $modalDetail->generateId(),
                    'IdPesanan'       => $IdPesanan,
                    'IdKemasan'       => $IdKemasan,
                    'Qty'             => $qtyPesan,
                    'Harga'           => $harga[$i],
                    'SubTotal'        => $sub[$i]
                ]);

                $modalKemasan->update($IdKemasan, [
                    'Stok' => $dataKemasan['Stok'] - $qtyPesan
                ]);
            }

            $db->transComplete();

            return redirect()->to(base_url('datapesanan'))
                ->with('success', 'Pesanan berhasil diperbarui');
        } catch (\Exception $e) {

            $db->transRollback();

            return redirect()->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    // =====================================================
    // HAPUS PESANAN + KEMBALIKAN STOK
    // =====================================================
    public function hapus($IdPesanan)
    {
        $modalPesanan = new ModalPesanan();
        $modalDetail  = new ModalDetailPesanan();
        $modalKemasan = new ModalKemasan();

        $db = \Config\Database::connect();
        $db->transStart();

        try {

            // Ambil detail
            $detail = $modalDetail
                ->where('IdPesanan', $IdPesanan)
                ->findAll();

            // Kembalikan stok
            foreach ($detail as $d) {

                $kemasan = $modalKemasan->find($d['IdKemasan']);

                $modalKemasan->update($d['IdKemasan'], [
                    'Stok' => $kemasan['Stok'] + $d['Qty']
                ]);
            }

            // Hapus pesanan
            $modalPesanan->delete($IdPesanan);

            $db->transComplete();

            return redirect()->to(base_url('datapesanan'))
                ->with('success', 'Pesanan berhasil dihapus');
        } catch (\Exception $e) {

            $db->transRollback();

            return redirect()->to(base_url('datapesanan'))
                ->with('error', $e->getMessage());
        }
    }
}
