<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModalKemasan;
use App\Models\ModalProduk;

class KemasanController extends BaseController
{
    // =====================================================
    // TAMPIL DATA KEMASAN
    // =====================================================
    public function datakemasan()
    {
        $modalKemasan = new ModalKemasan();

        $data = [
            'kemasan' => $modalKemasan->getKemasanWithProduk()
        ];

        return view('datamaster/v_datakemasan', $data);
    }

    // =====================================================
    // FORM TAMBAH KEMASAN
    // =====================================================
    public function tambah()
    {
        $modalKemasan = new ModalKemasan();
        $modalProduk  = new ModalProduk();

        $data = [
            'IdKemasan' => $modalKemasan->generateId(),
            'produk'    => $modalProduk
                ->where('StatusProduk', 'Aktif')
                ->findAll()
        ];

        return view('datamaster/tambahkemasan', $data);
    }

    // =====================================================
    // SIMPAN KEMASAN
    // =====================================================
    public function simpan()
    {
        $modalKemasan = new ModalKemasan();

        // Validasi
        $rules = [
            'IdProduk' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Produk wajib dipilih.'
                ]
            ],
            'NamaKemasan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama kemasan wajib diisi.'
                ]
            ],
            'Berat' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'Berat wajib diisi.',
                    'numeric'  => 'Berat harus berupa angka.'
                ]
            ],
            'Harga' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'Harga wajib diisi.',
                    'numeric'  => 'Harga harus berupa angka.'
                ]
            ],
            'Stok' => [
                'rules' => 'required|integer',
                'errors' => [
                    'required' => 'Stok wajib diisi.',
                    'integer'  => 'Stok harus berupa bilangan bulat.'
                ]
            ]
        ];

        if (!$this->validate($rules)) {

            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        // Upload Foto
        $foto = $this->request->getFile('Foto');
        $namaFoto = null;

        if ($foto && $foto->isValid() && !$foto->hasMoved()) {

            $namaFoto = $foto->getRandomName();

            $foto->move(
                FCPATH . 'storage/fotokemasan',
                $namaFoto
            );
        }

        // Simpan Data
        $data = [
            'IdKemasan'     => $this->request->getPost('IdKemasan'),
            'IdProduk'      => $this->request->getPost('IdProduk'),
            'NamaKemasan'   => $this->request->getPost('NamaKemasan'),
            'Berat'         => $this->request->getPost('Berat'),
            'SatuanBerat'   => $this->request->getPost('SatuanBerat'),
            'Harga'         => $this->request->getPost('Harga'),
            'Stok'          => $this->request->getPost('Stok'),
            'Foto'          => $namaFoto,
            'StatusKemasan' => $this->request->getPost('StatusKemasan')
        ];

        $modalKemasan->insert($data);

        return redirect()->to(base_url('datakemasan'))
            ->with('success', 'Data kemasan berhasil ditambahkan');
    }

    // =====================================================
    // FORM EDIT KEMASAN
    // =====================================================
    public function edit($IdKemasan)
    {
        $modalKemasan = new ModalKemasan();
        $modalProduk  = new ModalProduk();

        $kemasan = $modalKemasan->find($IdKemasan);

        if (!$kemasan) {

            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound(
                'Data kemasan tidak ditemukan'
            );
        }

        $data = [
            'kemasan' => $kemasan,
            'produk'  => $modalProduk
                ->where('StatusProduk', 'Aktif')
                ->findAll()
        ];

        return view('datamaster/editkemasan', $data);
    }

    // =====================================================
    // UPDATE KEMASAN
    // =====================================================
    public function update()
    {
        $modalKemasan = new ModalKemasan();

        $IdKemasan = $this->request->getPost('IdKemasan');

        // Ambil data lama
        $kemasanLama = $modalKemasan->find($IdKemasan);

        // Data yang diupdate
        $data = [
            'IdProduk'      => $this->request->getPost('IdProduk'),
            'NamaKemasan'   => $this->request->getPost('NamaKemasan'),
            'Berat'         => $this->request->getPost('Berat'),
            'SatuanBerat'   => $this->request->getPost('SatuanBerat'),
            'Harga'         => $this->request->getPost('Harga'),
            'Stok'          => $this->request->getPost('Stok'),
            'StatusKemasan' => $this->request->getPost('StatusKemasan')
        ];

        // Upload foto baru
        $foto = $this->request->getFile('Foto');

        if ($foto && $foto->isValid() && !$foto->hasMoved()) {

            // Hapus foto lama
            if (!empty($kemasanLama['Foto']) &&
                file_exists(FCPATH . 'storage/fotokemasan/' . $kemasanLama['Foto'])) {

                unlink(FCPATH . 'storage/fotokemasan/' . $kemasanLama['Foto']);
            }

            // Simpan foto baru
            $namaFoto = $foto->getRandomName();

            $foto->move(
                FCPATH . 'storage/fotokemasan',
                $namaFoto
            );

            $data['Foto'] = $namaFoto;
        }

        $modalKemasan->update($IdKemasan, $data);

        return redirect()->to(base_url('datakemasan'))
            ->with('success', 'Data kemasan berhasil diperbarui');
    }

    // =====================================================
    // HAPUS KEMASAN
    // =====================================================
    public function hapus($IdKemasan)
    {
        $modalKemasan = new ModalKemasan();

        $kemasan = $modalKemasan->find($IdKemasan);

        if (!$kemasan) {

            return redirect()->to(base_url('datakemasan'))
                ->with('error', 'Data kemasan tidak ditemukan');
        }

        // Hapus file foto
        if (!empty($kemasan['Foto']) &&
            file_exists(FCPATH . 'storage/fotokemasan/' . $kemasan['Foto'])) {

            unlink(FCPATH . 'storage/fotokemasan/' . $kemasan['Foto']);
        }

        // Hapus data
        $modalKemasan->delete($IdKemasan);

        return redirect()->to(base_url('datakemasan'))
            ->with('success', 'Data kemasan berhasil dihapus');
    }
}
