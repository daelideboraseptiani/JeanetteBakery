<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModalPembayaran;
use App\Models\ModalPesanan;

class PembayaranController extends BaseController
{
    // =====================================================
    // DATA PEMBAYARAN
    // =====================================================
    public function datapembayaran()
    {
        $modalPembayaran = new ModalPembayaran();

        $data = [
            'pembayaran' => $modalPembayaran->getPembayaranLengkap()
        ];

        return view('datatransaksi/v_datapembayaran', $data);
    }

    // =====================================================
    // FORM TAMBAH
    // =====================================================
    public function tambah()
    {
        $modalPembayaran = new ModalPembayaran();
        $modalPesanan    = new ModalPesanan();


        // =====================================================
        // AMBIL SEMUA PESANAN
        // =====================================================
        $semuaPesanan = $modalPesanan
            ->select('Pesanan.*, Pelanggan.NamaPelanggan')
            ->join('Pelanggan', 'Pelanggan.IdPelanggan = Pesanan.IdPelanggan')
            ->findAll();

        $pesanan = [];

        foreach ($semuaPesanan as $p) {

            $idPesanan = $p['IdPesanan'];

            // =====================================================
            // CEK APAKAH SUDAH LUNAS
            // =====================================================

            // Full Payment terverifikasi
            $fullPayment = $modalPembayaran
                ->where('IdPesanan', $idPesanan)
                ->where('JenisPembayaran', 'Full Payment')
                ->where('StatusPembayaran', 'Terverifikasi')
                ->first();

            // Pelunasan terverifikasi
            $pelunasan = $modalPembayaran
                ->where('IdPesanan', $idPesanan)
                ->where('JenisPembayaran', 'Pelunasan')
                ->where('StatusPembayaran', 'Terverifikasi')
                ->first();

            // Jika sudah lunas, skip
            if ($fullPayment || $pelunasan) {
                continue;
            }

            // =====================================================
            // HITUNG TOTAL YANG SUDAH DIBAYAR
            // =====================================================
            $totalTerverifikasi = $modalPembayaran->getTotalTerverifikasi($idPesanan);

            // Tambahkan ke array
            $p['TotalDibayar'] = $totalTerverifikasi;

            $pesanan[] = $p;
        }

        $data = [

            'IdPembayaran' => $modalPembayaran->generateId(),
            'pesanan'      => $pesanan
        ];

        return view('datatransaksi/tambahpembayaran', $data);
    }


    // =====================================================
    // SIMPAN
    // =====================================================
    public function simpan()
    {
        $modalPembayaran = new ModalPembayaran();
        $modalPesanan    = new ModalPesanan();

        $rules = [
            'IdPesanan'        => 'required',
            'TglBayar'         => 'required',
            'JumlahBayar'      => 'required|numeric|greater_than[0]',
            'JenisPembayaran'  => 'required',
            'MetodePembayaran' => 'required',
            'StatusPembayaran' => 'required'
        ];

        if (!$this->validate($rules)) {

            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $IdPesanan   = $this->request->getPost('IdPesanan');
        $jenis       = $this->request->getPost('JenisPembayaran');
        $jumlahBayar = (float) $this->request->getPost('JumlahBayar');
        $status      = $this->request->getPost('StatusPembayaran');

        // Ambil data pesanan
        $pesanan = $modalPesanan->find($IdPesanan);

        if (!$pesanan) {

            return redirect()->back()
                ->withInput()
                ->with('error', 'Pesanan tidak ditemukan');
        }

        $totalPesanan = (float) $pesanan['Total'];

        // Total pembayaran yang sudah terverifikasi
        $totalTerverifikasi = $modalPembayaran->getTotalTerverifikasi($IdPesanan);

        // =====================================================
        // VALIDASI FULL PAYMENT
        // =====================================================
        if ($jenis == 'Full Payment') {

            if ($totalTerverifikasi > 0) {

                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Pesanan sudah memiliki pembayaran sebelumnya.');
            }

            if ($jumlahBayar != $totalPesanan) {

                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Jumlah Full Payment harus sama dengan total pesanan.');
            }
        }

        // =====================================================
        // VALIDASI DP
        // =====================================================
        if ($jenis == 'DP') {

            if ($jumlahBayar >= $totalPesanan) {

                return redirect()->back()
                    ->withInput()
                    ->with('error', 'DP harus lebih kecil dari total pesanan.');
            }

            // Tidak boleh DP lagi jika sudah ada DP terverifikasi
            $adaDP = $modalPembayaran
                ->where('IdPesanan', $IdPesanan)
                ->where('JenisPembayaran', 'DP')
                ->where('StatusPembayaran', 'Terverifikasi')
                ->first();

            if ($adaDP) {

                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Pesanan sudah memiliki pembayaran DP.');
            }
        }

        // =====================================================
        // VALIDASI PELUNASAN
        // =====================================================
        if ($jenis == 'Pelunasan') {

            // Harus sudah ada DP
            $adaDP = $modalPembayaran
                ->where('IdPesanan', $IdPesanan)
                ->where('JenisPembayaran', 'DP')
                ->where('StatusPembayaran', 'Terverifikasi')
                ->first();

            if (!$adaDP) {

                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Pelunasan hanya bisa dilakukan setelah DP terverifikasi.');
            }

            // Tidak boleh pelunasan lebih dari sekali
            if ($modalPembayaran->sudahPelunasan($IdPesanan)) {

                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Pesanan sudah memiliki pembayaran pelunasan.');
            }

            $sisa = $totalPesanan - $totalTerverifikasi;

            if ($jumlahBayar != $sisa) {

                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Jumlah pelunasan harus sama dengan sisa pembayaran: Rp ' .
                        number_format($sisa, 0, ',', '.'));
            }
        }

        // =====================================================
        // UPLOAD BUKTI
        // =====================================================
        $namaBukti = null;

        $bukti = $this->request->getFile('BuktiPembayaran');

        if ($bukti && $bukti->isValid() && !$bukti->hasMoved()) {

            $namaBukti = $bukti->getRandomName();

            $bukti->move('storage/fotobuktipem', $namaBukti);
        }

        // =====================================================
        // SIMPAN PEMBAYARAN
        // =====================================================
        $modalPembayaran->insert([
            'IdPembayaran'     => $this->request->getPost('IdPembayaran'),
            'IdPesanan'        => $IdPesanan,
            'TglBayar'         => $this->request->getPost('TglBayar'),
            'JumlahBayar'      => $jumlahBayar,
            'JenisPembayaran'  => $jenis,
            'MetodePembayaran' => $this->request->getPost('MetodePembayaran'),
            'StatusPembayaran' => $status,
            'BuktiPembayaran'  => $namaBukti
        ]);

        // =====================================================
        // UPDATE STATUS PESANAN
        // =====================================================
        $this->updateStatusPesanan($IdPesanan);

        return redirect()->to(base_url('datapembayaran'))
            ->with('success', 'Data pembayaran berhasil ditambahkan');
    }

    // =====================================================
    // UPDATE STATUS PESANAN
    // =====================================================
    private function updateStatusPesanan($IdPesanan)
    {
        $modalPembayaran = new ModalPembayaran();
        $modalPesanan    = new ModalPesanan();

        $pesanan = $modalPesanan->find($IdPesanan);

        if (!$pesanan) return;

        $totalPesanan = (float) $pesanan['Total'];

        $totalTerverifikasi = $modalPembayaran->getTotalTerverifikasi($IdPesanan);

        // Cek apakah ada pembayaran yang masih menunggu
        $adaMenunggu = $modalPembayaran
            ->where('IdPesanan', $IdPesanan)
            ->where('StatusPembayaran', 'Menunggu Verifikasi')
            ->first();

        $statusPesanan = 'Menunggu';

        // Jika total pembayaran sudah lunas
        if ($totalTerverifikasi >= $totalPesanan) {

            $statusPesanan = 'Selesai';
        } elseif ($totalTerverifikasi > 0 || $adaMenunggu) {

            // Sudah ada DP atau pembayaran menunggu
            $statusPesanan = 'Diproses';
        }

        $modalPesanan->update($IdPesanan, [
            'StatusPesanan' => $statusPesanan
        ]);
    }

    // =====================================================
    // EDIT
    // =====================================================
    public function edit($IdPembayaran)
    {
        $modalPembayaran = new ModalPembayaran();
        $modalPesanan    = new ModalPesanan();

        $pembayaran = $modalPembayaran->find($IdPembayaran);

        if (!$pembayaran) {

            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound(
                'Data pembayaran tidak ditemukan'
            );
        }

        $pesanan = $modalPesanan
            ->select('Pesanan.*, Pelanggan.NamaPelanggan')
            ->join('Pelanggan', 'Pelanggan.IdPelanggan = Pesanan.IdPelanggan')
            ->findAll();

        $data = [
            'pembayaran' => $pembayaran,
            'pesanan'    => $pesanan
        ];

        return view('datatransaksi/editpembayaran', $data);
    }

    // =====================================================
    // UPDATE
    // =====================================================
    public function update()
    {
        $modalPembayaran = new ModalPembayaran();
        $db = \Config\Database::connect();

        $IdPembayaran = $this->request->getPost('IdPembayaran');

        // Ambil data lama
        $pembayaranLama = $modalPembayaran->find($IdPembayaran);

        if (!$pembayaranLama) {
            return redirect()->to(base_url('datapembayaran'))
                ->with('error', 'Data pembayaran tidak ditemukan.');
        }

        // ==========================
        // VALIDASI
        // ==========================
        if (!$this->validate([

            'StatusPembayaran' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Status pembayaran wajib dipilih.'
                ]
            ],

            'MetodePembayaran' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Metode pembayaran wajib dipilih.'
                ]
            ],

            'BuktiPembayaran' => [
                'rules' => 'permit_empty|max_size[BuktiPembayaran,2048]|ext_in[BuktiPembayaran,jpg,jpeg,png,pdf]',
                'errors' => [
                    'max_size' => 'Ukuran file maksimal 2 MB.',
                    'ext_in'   => 'Format file harus JPG, JPEG, PNG atau PDF.'
                ]
            ]

        ])) {

            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        // ==========================
        // UPLOAD BUKTI BARU
        // ==========================
        $namaBukti = $pembayaranLama['BuktiPembayaran'];

        $bukti = $this->request->getFile('BuktiPembayaran');

        if ($bukti && $bukti->isValid() && !$bukti->hasMoved()) {

            // Hapus file lama
            if (!empty($namaBukti) && file_exists(FCPATH . 'storage/fotobuktipem/' . $namaBukti)) {
                unlink(FCPATH . 'storage/fotobuktipem/' . $namaBukti);
            }

            $namaBukti = $bukti->getRandomName();

            $bukti->move(
                FCPATH . 'storage/fotobuktipem/',
                $namaBukti
            );
        }

        // ==========================
        // TRANSAKSI DATABASE
        // ==========================
        $db->transStart();

        $modalPembayaran->update($IdPembayaran, [

            'IdPesanan'          => $this->request->getPost('IdPesanan'),
            'TglBayar'           => $this->request->getPost('TglBayar'),
            'JumlahBayar'        => $this->request->getPost('JumlahBayar'),
            'JenisPembayaran'    => $this->request->getPost('JenisPembayaran'),
            'StatusPembayaran'   => $this->request->getPost('StatusPembayaran'),
            'MetodePembayaran'   => $this->request->getPost('MetodePembayaran'),
            'BuktiPembayaran'    => $namaBukti

        ]);

        // Update status pesanan berdasarkan total pembayaran terverifikasi
        $this->updateStatusPesanan($pembayaranLama['IdPesanan']);

        $db->transComplete();

        // ==========================
        // HASIL TRANSAKSI
        // ==========================
        if (!$db->transStatus()) {

            return redirect()->back()
                ->withInput()
                ->with('error', 'Data pembayaran gagal diperbarui.');
        }

        return redirect()->to(base_url('datapembayaran'))
            ->with('success', 'Data pembayaran berhasil diperbarui.');
    }

    // =====================================================
    // HAPUS
    // =====================================================
    public function hapus($IdPembayaran)
    {
        $modalPembayaran = new ModalPembayaran();

        $pembayaran = $modalPembayaran->find($IdPembayaran);

        if (!$pembayaran) {

            return redirect()->to(base_url('datapembayaran'))
                ->with('error', 'Data pembayaran tidak ditemukan');
        }

        // Hapus file
        if (
            $pembayaran['BuktiPembayaran'] &&
            file_exists(FCPATH . 'storage/fotobuktipem/' . $pembayaran['BuktiPembayaran'])
        ) {
            unlink(FCPATH . 'storage/fotobuktipem/' . $pembayaran['BuktiPembayaran']);
        }

        $IdPesanan = $pembayaran['IdPesanan'];

        $modalPembayaran->delete($IdPembayaran);

        // Rehitung status pesanan
        $this->updateStatusPesanan($IdPesanan);

        return redirect()->to(base_url('datapembayaran'))
            ->with('success', 'Data pembayaran berhasil dihapus');
    }
}
