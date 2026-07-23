<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModalProduksi;
use App\Models\ModalProduk;
use App\Models\ModalKemasan;
use App\Models\ModalBahanBaku;
use App\Models\ModalDetailProduksi;

class ProduksiController extends BaseController
{
    // =====================================================
    // TAMPIL DATA PRODUKSI
    // =====================================================
    public function dataproduksi()
    {
        $modalProduksi = new ModalProduksi();

        $data = [
            'produksi' => $modalProduksi->getProduksiWithProduk()
        ];

        return view('datatransaksi/v_dataproduksi', $data);
    }

    // =====================================================
    // FORM TAMBAH PRODUKSI
    // =====================================================
    public function tambah()
    {
        $modalProduksi = new ModalProduksi();
        $modalProduk   = new ModalProduk();
        $modalBahan    = new ModalBahanBaku();

        $data = [
            'IdProduksi' => $modalProduksi->generateId(),
            'produk'     => $modalProduk
                ->where('StatusProduk', 'Aktif')
                ->findAll(),
            'bahan'      => $modalBahan->findAll()
        ];

        return view('datatransaksi/tambahproduksi', $data);
    }

    // =====================================================
    // SIMPAN PRODUKSI + DETAIL + KURANGI STOK
    // =====================================================
    public function simpan()
    {
        $modalProduksi = new ModalProduksi();
        $modalDetail   = new ModalDetailProduksi();
        $modalBahan    = new ModalBahanBaku();

        // =========================
        // VALIDASI
        // =========================
        $rules = [
            'IdProduk'        => 'required',
            'TglProduksi'     => 'required',
            'JumlahProduksi'  => 'required|numeric',
            'HasilProduksi'   => 'required|numeric',
            'StatusProduksi'  => 'required'
        ];

        if (!$this->validate($rules)) {

            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        // =========================
        // AMBIL DATA FORM
        // =========================
        $IdProduksi = $this->request->getPost('IdProduksi');

        $bahan = $this->request->getPost('IdBahanBaku');
        $qty   = $this->request->getPost('QtyDipakai');

        // =========================
        // DATABASE TRANSACTION
        // =========================
        $db = \Config\Database::connect();
        $db->transStart();

        try {

            // =====================================================
            // 1. SIMPAN PRODUKSI
            // =====================================================
            $modalProduksi->insert([
                'IdProduksi'       => $IdProduksi,
                'IdProduk'         => $this->request->getPost('IdProduk'),
                'TglProduksi'      => $this->request->getPost('TglProduksi'),
                'JumlahProduksi'   => $this->request->getPost('JumlahProduksi'),
                'HasilProduksi'    => $this->request->getPost('HasilProduksi'),
                'StatusProduksi'   => $this->request->getPost('StatusProduksi'),
                'StatusUpdateStok' => 'Belum'
            ]);

            // =====================================================
            // 2. SIMPAN DETAIL + KURANGI STOK
            // =====================================================
            if (!empty($bahan)) {

                foreach ($bahan as $i => $IdBahanBaku) {

                    // Skip jika kosong
                    if (empty($IdBahanBaku) || empty($qty[$i])) {
                        continue;
                    }

                    $qtyDipakai = (float) $qty[$i];

                    // =========================
                    // AMBIL DATA BAHAN
                    // =========================
                    $dataBahan = $modalBahan->find($IdBahanBaku);

                    if (!$dataBahan) {
                        throw new \Exception('Bahan baku tidak ditemukan');
                    }

                    // =========================
                    // CEK STOK MENCUKUPI
                    // =========================
                    if ($dataBahan['Stok'] < $qtyDipakai) {

                        throw new \Exception(
                            'Stok bahan ' .
                                $dataBahan['NamaBahan'] .
                                ' tidak mencukupi. Stok tersedia: ' .
                                $dataBahan['Stok'] . ' ' .
                                $dataBahan['Satuan']
                        );
                    }

                    // =========================
                    // SIMPAN DETAIL PRODUKSI
                    // =========================
                    $modalDetail->insert([
                        'IdDetailProduksi' => $modalDetail->generateId(),
                        'IdProduksi'       => $IdProduksi,
                        'IdBahanBaku'      => $IdBahanBaku,
                        'QtyDipakai'       => $qtyDipakai
                    ]);

                    // =========================
                    // KURANGI STOK BAHAN
                    // =========================
                    $stokBaru = $dataBahan['Stok'] - $qtyDipakai;

                    $modalBahan->update($IdBahanBaku, [
                        'Stok' => $stokBaru
                    ]);
                }
            }

            // =========================
            // COMMIT
            // =========================
            $db->transComplete();

            if ($db->transStatus() === false) {
                throw new \Exception('Gagal menyimpan transaksi produksi');
            }

            return redirect()->to(base_url('dataproduksi'))
                ->with('success', 'Data produksi berhasil ditambahkan dan stok bahan baku berhasil diperbarui');
        } catch (\Exception $e) {

            // =========================
            // ROLLBACK
            // =========================
            $db->transRollback();

            return redirect()->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    // =====================================================
    // FORM EDIT PRODUKSI
    // =====================================================
    public function edit($IdProduksi)
    {
        $modalProduksi = new ModalProduksi();
        $modalProduk   = new ModalProduk();
        $modalBahan    = new ModalBahanBaku();
        $modalDetail   = new ModalDetailProduksi();

        $produksi = $modalProduksi->find($IdProduksi);

        if (!$produksi) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound(
                'Data produksi tidak ditemukan'
            );
        }

        // Ambil detail bahan yang dipakai
        $detail = $modalDetail
            ->select('DetailProduksi.*, BahanBaku.NamaBahan, BahanBaku.Satuan')
            ->join('BahanBaku', 'BahanBaku.IdBahanBaku = DetailProduksi.IdBahanBaku')
            ->where('IdProduksi', $IdProduksi)
            ->findAll();

        $data = [
            'produksi' => $produksi,
            'produk'   => $modalProduk
                ->where('StatusProduk', 'Aktif')
                ->findAll(),
            'bahan'    => $modalBahan->findAll(),
            'detail'   => $detail
        ];

        return view('datatransaksi/editproduksi', $data);
    }

    // =====================================================
    // UPDATE PRODUKSI
    // =====================================================
    public function update()
    {
        $modalProduksi = new ModalProduksi();
        $modalDetail   = new ModalDetailProduksi();
        $modalBahan    = new ModalBahanBaku();


        $IdProduksi = $this->request->getPost('IdProduksi');

        // =========================
        // VALIDASI
        // =========================
        $rules = [
            'IdProduk'       => 'required',
            'TglProduksi'    => 'required',
            'JumlahProduksi' => 'required|numeric',
            'HasilProduksi'  => 'required|numeric',
            'StatusProduksi' => 'required'
        ];

        if (!$this->validate($rules)) {

            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $db = \Config\Database::connect();
        $db->transStart();

        try {

            // =====================================================
            // 1. KEMBALIKAN STOK LAMA
            // =====================================================
            $detailLama = $modalDetail
                ->where('IdProduksi', $IdProduksi)
                ->findAll();

            foreach ($detailLama as $d) {

                $bahanLama = $modalBahan->find($d['IdBahanBaku']);

                if ($bahanLama) {

                    $stokKembali = $bahanLama['Stok'] + $d['QtyDipakai'];

                    $modalBahan->update($d['IdBahanBaku'], [
                        'Stok' => $stokKembali
                    ]);
                }
            }

            // =====================================================
            // 2. HAPUS DETAIL LAMA
            // =====================================================
            $modalDetail
                ->where('IdProduksi', $IdProduksi)
                ->delete();

            // =====================================================
            // 3. UPDATE DATA PRODUKSI
            // =====================================================
            $modalProduksi->update($IdProduksi, [
                'IdProduk'         => $this->request->getPost('IdProduk'),
                'TglProduksi'      => $this->request->getPost('TglProduksi'),
                'JumlahProduksi'   => $this->request->getPost('JumlahProduksi'),
                'HasilProduksi'    => $this->request->getPost('HasilProduksi'),
                'StatusProduksi'   => $this->request->getPost('StatusProduksi'),
                'StatusUpdateStok' => 'Belum'
            ]);

            // =====================================================
            // 4. SIMPAN DETAIL BARU + KURANGI STOK
            // =====================================================
            $bahanBaru = $this->request->getPost('IdBahanBaku');
            $qtyBaru   = $this->request->getPost('QtyDipakai');

            if (!empty($bahanBaru)) {

                foreach ($bahanBaru as $i => $IdBahanBaku) {

                    if (empty($IdBahanBaku) || empty($qtyBaru[$i])) {
                        continue;
                    }

                    $qtyDipakai = (float) $qtyBaru[$i];

                    $dataBahan = $modalBahan->find($IdBahanBaku);

                    if (!$dataBahan) {
                        throw new \Exception('Bahan baku tidak ditemukan');
                    }

                    // Cek stok setelah dikembalikan
                    if ($dataBahan['Stok'] < $qtyDipakai) {

                        throw new \Exception(
                            'Stok bahan ' .
                                $dataBahan['NamaBahan'] .
                                ' tidak mencukupi'
                        );
                    }

                    // Simpan detail baru
                    $modalDetail->insert([
                        'IdDetailProduksi' => $modalDetail->generateId(),
                        'IdProduksi'       => $IdProduksi,
                        'IdBahanBaku'      => $IdBahanBaku,
                        'QtyDipakai'       => $qtyDipakai
                    ]);

                    // Kurangi stok
                    $stokBaru = $dataBahan['Stok'] - $qtyDipakai;

                    $modalBahan->update($IdBahanBaku, [
                        'Stok' => $stokBaru
                    ]);
                }
            }

            $db->transComplete();

            if ($db->transStatus() === false) {
                throw new \Exception('Gagal memperbarui produksi');
            }

            return redirect()->to(base_url('dataproduksi'))
                ->with('success', 'Data produksi dan penggunaan bahan baku berhasil diperbarui');
        } catch (\Exception $e) {

            $db->transRollback();

            return redirect()->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }


    // =====================================================
    // HAPUS PRODUKSI
    // =====================================================
    public function hapus($IdProduksi)
    {
        $modalProduksi = new ModalProduksi();
        $modalDetail   = new ModalDetailProduksi();
        $modalBahan    = new ModalBahanBaku();


        // =====================================================
        // CEK DATA PRODUKSI
        // =====================================================
        $produksi = $modalProduksi->find($IdProduksi);

        if (!$produksi) {

            return redirect()->to(base_url('dataproduksi'))
                ->with('error', 'Data produksi tidak ditemukan');
        }

        // =====================================================
        // DATABASE TRANSACTION
        // =====================================================
        $db = \Config\Database::connect();
        $db->transStart();

        try {

            // =====================================================
            // 1. AMBIL DETAIL PRODUKSI
            // =====================================================
            $detailProduksi = $modalDetail
                ->where('IdProduksi', $IdProduksi)
                ->findAll();

            // =====================================================
            // 2. KEMBALIKAN STOK BAHAN
            // =====================================================
            foreach ($detailProduksi as $detail) {

                $bahan = $modalBahan->find($detail['IdBahanBaku']);

                if ($bahan) {

                    // Tambahkan kembali stok yang pernah dipakai
                    $stokKembali = $bahan['Stok'] + $detail['QtyDipakai'];

                    $modalBahan->update($detail['IdBahanBaku'], [
                        'Stok' => $stokKembali
                    ]);
                }
            }

            // =====================================================
            // 3. HAPUS DATA PRODUKSI
            // DetailProduksi ikut terhapus karena ON DELETE CASCADE
            // =====================================================
            $modalProduksi->delete($IdProduksi);

            // =====================================================
            // COMMIT
            // =====================================================
            $db->transComplete();

            if ($db->transStatus() === false) {

                throw new \Exception('Gagal menghapus data produksi');
            }

            return redirect()->to(base_url('dataproduksi'))
                ->with(
                    'success',
                    'Data produksi berhasil dihapus dan stok bahan baku berhasil dikembalikan'
                );
        } catch (\Exception $e) {

            // =====================================================
            // ROLLBACK
            // =====================================================
            $db->transRollback();

            return redirect()->to(base_url('dataproduksi'))
                ->with('error', $e->getMessage());
        }
    }

    public function formUpdateStok($IdProduksi)
    {
        $modalProduksi = new ModalProduksi();
        $modalKemasan  = new \App\Models\ModalKemasan();


        // Ambil data produksi
        $produksi = $modalProduksi
            ->select('Produksi.*, Produk.NamaProduk')
            ->join('Produk', 'Produk.IdProduk = Produksi.IdProduk')
            ->find($IdProduksi);

        if (!$produksi) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound(
                'Data produksi tidak ditemukan'
            );
        }

        // Ambil HANYA kemasan dari produk yang sama
        $kemasan = $modalKemasan
            ->where('IdProduk', $produksi['IdProduk'])
            ->findAll();

        $data = [
            'produksi' => $produksi,
            'kemasan'  => $kemasan
        ];

        return view('datatransaksi/update_stok_kemasan', $data);
    }

    public function simpanUpdateStok()
    {
        $modalKemasan  = new ModalKemasan();
        $modalProduksi = new ModalProduksi();

        $IdProduksi = $this->request->getPost('IdProduksi');
        $IdKemasan  = $this->request->getPost('IdKemasan');
        $TambahStok = $this->request->getPost('TambahStok');

        if (!empty($IdKemasan)) {

            foreach ($IdKemasan as $i => $id) {

                $qtyTambah = (int) ($TambahStok[$i] ?? 0);

                if ($qtyTambah <= 0) {
                    continue;
                }

                $kemasan = $modalKemasan->find($id);

                if ($kemasan) {

                    $stokBaru = $kemasan['Stok'] + $qtyTambah;

                    $modalKemasan->update($id, [
                        'Stok' => $stokBaru
                    ]);
                }
            }
        }

        // Tandai sudah update stok kemasan
        $modalProduksi->update($IdProduksi, [
            'StatusUpdateStok' => 'Sudah',
            'StatusProduksi' => 'Selesai'
        ]);

        return redirect()->to(base_url('dataproduksi'))
            ->with('success', 'Stok kemasan berhasil diperbarui');
    }
}
