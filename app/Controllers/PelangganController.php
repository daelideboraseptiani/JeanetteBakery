<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModalPelanggan;
use App\Models\ModalUser;
use App\Models\ModalPesanan;

class PelangganController extends BaseController
{
    // =========================
    // TAMPIL DATA PELANGGAN
    // =========================
    public function datapelanggan()
    {
        $model = new ModalPelanggan();

        $data = [
            'pelanggan' => $model->findAll()
        ];

        return view('datamaster/v_datapelanggan', $data);
    }

    // =========================
    // FORM TAMBAH PELANGGAN
    // =========================
    public function tambah()
    {
        $ModalPelanggan = new ModalPelanggan();
        $ModalUser      = new ModalUser();

        $data = [
            'IdPelanggan' => $ModalPelanggan->generateId(),
            'IdUser'      => $ModalUser->generateId()
        ];

        return view('datamaster/tambahpelanggan', $data);
    }

    // =========================
    // SIMPAN PELANGGAN
    // =========================
    public function simpan()
    {
        $ModalPelanggan = new ModalPelanggan();
        $ModalUser      = new ModalUser();


        // Validasi
        $rules = [
            'NamaPelanggan' => 'required',
            'Email'         => 'required|valid_email|is_unique[User.Email]',
            'Username'      => 'required|is_unique[User.Username]',
            'Password'      => 'required|min_length[8]',
            'NoHp'          => 'required'
        ];

        if (!$this->validate($rules)) {

            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        // =========================
        // 1. SIMPAN KE TABEL USER
        // =========================
        $dataUser = [
            'IdUser'       => $this->request->getPost('IdUser'),
            'NamaLengkap'  => $this->request->getPost('NamaPelanggan'),
            'Email'        => $this->request->getPost('Email'),
            'Username'     => $this->request->getPost('Username'),
            'Password'     => password_hash(
                $this->request->getPost('Password'),
                PASSWORD_DEFAULT
            ),
            'Role'         => 'Pelanggan',
            'Status'       => $this->request->getPost('Status')
        ];

        $ModalUser->insert($dataUser);

        // =========================
        // 2. SIMPAN KE TABEL PELANGGAN
        // =========================
        $dataPelanggan = [
            'IdPelanggan'   => $this->request->getPost('IdPelanggan'),
            'IdUser'        => $this->request->getPost('IdUser'),
            'NamaPelanggan' => $this->request->getPost('NamaPelanggan'),
            'Alamat'        => $this->request->getPost('Alamat'),
            'NoHp'          => $this->request->getPost('NoHp')
        ];

        $ModalPelanggan->insert($dataPelanggan);

        return redirect()->to(base_url('datapelanggan'))
            ->with('success', 'Data pelanggan dan akun user berhasil ditambahkan');
    }


    // =========================
    // FORM EDIT PELANGGAN
    // =========================
    public function edit($IdPelanggan)
    {
        $modalPelanggan = new ModalPelanggan();
        $modalUser      = new ModalUser();

        // Ambil data pelanggan
        $pelanggan = $modalPelanggan->find($IdPelanggan);

        // Jika pelanggan tidak ditemukan
        if (!$pelanggan) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound(
                'Data pelanggan tidak ditemukan'
            );
        }

        // Ambil data user berdasarkan IdUser di tabel pelanggan
        $user = $modalUser->find($pelanggan['IdUser']);

        // Kirim ke view
        $data = [
            'pelanggan' => $pelanggan,
            'user'      => $user
        ];

        return view('datamaster/editpelanggan', $data);
    }

    // =========================
    // UPDATE PELANGGAN
    // =========================
    public function update()
    {
        $modalPelanggan = new ModalPelanggan();
        $modalUser      = new ModalUser();


        $IdPelanggan = $this->request->getPost('IdPelanggan');
        $IdUser      = $this->request->getPost('IdUser');

        // =========================
        // VALIDASI
        // =========================
        $rules = [
            'NamaPelanggan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama pelanggan wajib diisi.'
                ]
            ],
            'Email' => [
                'rules' => 'required|valid_email',
                'errors' => [
                    'required'    => 'Email wajib diisi.',
                    'valid_email' => 'Format email tidak valid.'
                ]
            ],
            'Username' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Username wajib diisi.'
                ]
            ],
            'NoHp' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nomor HP wajib diisi.'
                ]
            ]
        ];

        if (!$this->validate($rules)) {

            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        // =========================
        // UPDATE TABEL USER
        // =========================
        $dataUser = [
            'NamaLengkap' => $this->request->getPost('NamaPelanggan'),
            'Email'       => $this->request->getPost('Email'),
            'Username'    => $this->request->getPost('Username'),
            'Status'      => $this->request->getPost('Status')
        ];

        // Password opsional
        $password   = $this->request->getPost('Password');
        $konfirmasi = $this->request->getPost('KonfirmasiPassword');

        if (!empty($password)) {

            // Cek konfirmasi password
            if ($password != $konfirmasi) {

                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Konfirmasi password tidak sesuai');
            }

            // Hash password baru
            $dataUser['Password'] = password_hash(
                $password,
                PASSWORD_DEFAULT
            );
        }

        // Update user
        $modalUser->update($IdUser, $dataUser);

        // =========================
        // UPDATE TABEL PELANGGAN
        // =========================
        $dataPelanggan = [
            'NamaPelanggan' => $this->request->getPost('NamaPelanggan'),
            'Alamat'        => $this->request->getPost('Alamat'),
            'NoHp'          => $this->request->getPost('NoHp')
        ];

        // Update pelanggan
        $modalPelanggan->update($IdPelanggan, $dataPelanggan);

        // =========================
        // REDIRECT
        // =========================
        return redirect()->to(base_url('datapelanggan'))
            ->with('success', 'Data pelanggan berhasil diperbarui');
    }


    // =========================
    // HAPUS PELANGGAN
    // =========================
    public function hapus($IdPelanggan)
    {
        $modalPelanggan = new ModalPelanggan();
        $modalUser      = new ModalUser();


        // Ambil data pelanggan
        $pelanggan = $modalPelanggan->find($IdPelanggan);

        // Jika tidak ditemukan
        if (!$pelanggan) {

            return redirect()->to(base_url('datapelanggan'))
                ->with('error', 'Data pelanggan tidak ditemukan');
        }

        // Simpan IdUser sebelum pelanggan dihapus
        $IdUser = $pelanggan['IdUser'];

        // =========================
        // HAPUS DATA PELANGGAN
        // =========================
        $modalPelanggan->delete($IdPelanggan);

        // =========================
        // HAPUS AKUN USER
        // =========================
        if (!empty($IdUser)) {

            $modalUser->delete($IdUser);
        }

        return redirect()->to(base_url('datapelanggan'))
            ->with('success', 'Data pelanggan dan akun user berhasil dihapus');
    }

    public function fakturPembayaran($idPesanan)
    {
        $modelPesanan = new ModalPesanan();
        $modelPelanggan = new ModalPelanggan();

        // pelanggan login
        $pelanggan = $modelPelanggan
            ->where('IdUser', session()->get('IdUser'))
            ->first();

        if (!$pelanggan) {
            return redirect()->to('/homepage')
                ->with('error', 'Data pelanggan tidak ditemukan.');
        }

        // data pesanan
        $pesanan = $modelPesanan->getPesanan($idPesanan);

        if (!$pesanan) {
            return redirect()->back()
                ->with('error', 'Pesanan tidak ditemukan.');
        }

        // keamanan
        if ($pesanan['IdPelanggan'] != $pelanggan['IdPelanggan']) {
            return redirect()->back()
                ->with('error', 'Anda tidak memiliki akses.');
        }

        // detail produk
        $detail = $modelPesanan->getDetailPesanan($idPesanan);

        // pembayaran terakhir
        $pembayaran = $modelPesanan->getPembayaranByPesanan($idPesanan);

        $data = [
            'title'      => 'Faktur Pembayaran',
            'pesanan'    => $pesanan,
            'detail'     => $detail,
            'pembayaran' => $pembayaran,
        ];

        return view('layout/fakturpembayaran', $data);
    }
}
