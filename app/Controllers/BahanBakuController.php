<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModalBahanBaku;

class BahanBakuController extends BaseController
{
    // =====================================================
    // TAMPIL DATA BAHAN BAKU
    // =====================================================
    public function databahanbaku()
    {
        $modalBahanBaku = new ModalBahanBaku();

        $data = [
            'bahanbaku' => $modalBahanBaku->findAll()
        ];

        return view('datamaster/v_databahanbaku', $data);
    }

    // =====================================================
    // FORM TAMBAH BAHAN BAKU
    // =====================================================
    public function tambah()
    {
        $modalBahanBaku = new ModalBahanBaku();

        $data = [
            'IdBahanBaku' => $modalBahanBaku->generateId()
        ];

        return view('datamaster/tambahbahanbaku', $data);
    }

    // =====================================================
    // SIMPAN BAHAN BAKU
    // =====================================================
    public function simpan()
    {
        $modalBahanBaku = new ModalBahanBaku();

        // Validasi
        $rules = [
            'NamaBahan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama bahan wajib diisi.'
                ]
            ],
            'Satuan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Satuan wajib dipilih.'
                ]
            ],
            'Stok' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'Stok wajib diisi.',
                    'numeric'  => 'Stok harus berupa angka.'
                ]
            ],
            'Harga' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'Harga wajib diisi.',
                    'numeric'  => 'Harga harus berupa angka.'
                ]
            ]
        ];

        if (!$this->validate($rules)) {

            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        // Simpan data
        $data = [
            'IdBahanBaku' => $this->request->getPost('IdBahanBaku'),
            'NamaBahan'   => $this->request->getPost('NamaBahan'),
            'Satuan'      => $this->request->getPost('Satuan'),
            'Stok'        => $this->request->getPost('Stok'),
            'Harga'       => $this->request->getPost('Harga'),
            'Merk'        => $this->request->getPost('Merk')
        ];

        $modalBahanBaku->insert($data);

        return redirect()->to(base_url('databahanbaku'))
            ->with('success', 'Data bahan baku berhasil ditambahkan');
    }

    // =====================================================
    // FORM EDIT BAHAN BAKU
    // =====================================================
    public function edit($IdBahanBaku)
    {
        $modalBahanBaku = new ModalBahanBaku();

        $bahan = $modalBahanBaku->find($IdBahanBaku);

        if (!$bahan) {

            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound(
                'Data bahan baku tidak ditemukan'
            );
        }

        $data = [
            'bahan' => $bahan
        ];

        return view('datamaster/editbahanbaku', $data);
    }

    // =====================================================
    // UPDATE BAHAN BAKU
    // =====================================================
    public function update()
    {
        $modalBahanBaku = new ModalBahanBaku();

        $IdBahanBaku = $this->request->getPost('IdBahanBaku');

        // Validasi
        $rules = [
            'NamaBahan' => 'required',
            'Satuan'    => 'required',
            'Stok'      => 'required|numeric',
            'Harga'     => 'required|numeric'
        ];

        if (!$this->validate($rules)) {

            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data = [
            'NamaBahan' => $this->request->getPost('NamaBahan'),
            'Satuan'    => $this->request->getPost('Satuan'),
            'Stok'      => $this->request->getPost('Stok'),
            'Harga'     => $this->request->getPost('Harga'),
            'Merk'      => $this->request->getPost('Merk')
        ];

        $modalBahanBaku->update($IdBahanBaku, $data);

        return redirect()->to(base_url('databahanbaku'))
            ->with('success', 'Data bahan baku berhasil diperbarui');
    }

    // =====================================================
    // HAPUS BAHAN BAKU
    // =====================================================
    public function hapus($IdBahanBaku)
    {
        $modalBahanBaku = new ModalBahanBaku();

        $bahan = $modalBahanBaku->find($IdBahanBaku);

        if (!$bahan) {

            return redirect()->to(base_url('databahanbaku'))
                ->with('error', 'Data bahan baku tidak ditemukan');
        }

        $modalBahanBaku->delete($IdBahanBaku);

        return redirect()->to(base_url('databahanbaku'))
            ->with('success', 'Data bahan baku berhasil dihapus');
    }
}
