<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModalProduk;

class ProdukController extends BaseController
{
    // =========================
    // TAMPIL DATA PRODUK
    // =========================
    public function dataproduk()
    {
        $modalProduk = new ModalProduk();

        $data = [
            'produk' => $modalProduk->findAll()
        ];

        return view('datamaster/v_dataproduk', $data);
    }

    // =========================
    // FORM TAMBAH PRODUK
    // =========================
    public function tambah()
    {
        $modalProduk = new ModalProduk();

        $data = [
            'IdProduk' => $modalProduk->generateId()
        ];

        return view('datamaster/tambahproduk', $data);
    }

    // =========================
    // SIMPAN PRODUK
    // =========================
    public function simpan()
    {
        $modalProduk = new ModalProduk();

        // Validasi
        $rules = [
            'NamaProduk' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama produk wajib diisi.'
                ]
            ],
            'StatusProduk' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Status produk wajib dipilih.'
                ]
            ]
        ];

        if (!$this->validate($rules)) {

            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        // Data yang disimpan
        $data = [
            'IdProduk'     => $this->request->getPost('IdProduk'),
            'NamaProduk'   => $this->request->getPost('NamaProduk'),
            'Deskripsi'    => $this->request->getPost('Deskripsi'),
            'StatusProduk' => $this->request->getPost('StatusProduk')
        ];

        $modalProduk->insert($data);

        return redirect()->to(base_url('dataproduk'))
            ->with('success', 'Data produk berhasil ditambahkan');
    }

    // =========================
    // FORM EDIT PRODUK
    // =========================
    public function edit($IdProduk)
    {
        $modalProduk = new ModalProduk();

        $produk = $modalProduk->find($IdProduk);

        if (!$produk) {

            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound(
                'Data produk tidak ditemukan'
            );
        }

        $data = [
            'produk' => $produk
        ];

        return view('datamaster/editproduk', $data);
    }

    // =========================
    // UPDATE PRODUK
    // =========================
    public function update()
    {
        $modalProduk = new ModalProduk();

        $IdProduk = $this->request->getPost('IdProduk');

        // Validasi
        $rules = [
            'NamaProduk' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama produk wajib diisi.'
                ]
            ],
            'StatusProduk' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Status produk wajib dipilih.'
                ]
            ]
        ];

        if (!$this->validate($rules)) {

            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data = [
            'NamaProduk'   => $this->request->getPost('NamaProduk'),
            'Deskripsi'    => $this->request->getPost('Deskripsi'),
            'StatusProduk' => $this->request->getPost('StatusProduk')
        ];

        $modalProduk->update($IdProduk, $data);

        return redirect()->to(base_url('dataproduk'))
            ->with('success', 'Data produk berhasil diperbarui');
    }

    // =========================
    // HAPUS PRODUK
    // =========================
    public function hapus($IdProduk)
    {
        $modalProduk = new ModalProduk();

        $produk = $modalProduk->find($IdProduk);

        if (!$produk) {

            return redirect()->to(base_url('dataproduk'))
                ->with('error', 'Data produk tidak ditemukan');
        }

        $modalProduk->delete($IdProduk);

        return redirect()->to(base_url('dataproduk'))
            ->with('success', 'Data produk berhasil dihapus');
    }
}
