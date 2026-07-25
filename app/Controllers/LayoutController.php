<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ModalUser;
use App\Models\ModalProduk;
use App\Models\ModalKemasan;
use App\Models\ModalPelanggan;

class LayoutController extends BaseController
{
    public function index()
    {
        return view('layout/landingpage');
    }
    public function dashboard()
    {
        return view('layout/dashboard');
    }
    public function login()
    {
        return view('layout/login');
    }

    public function ceklogin()
    {
        $session = session();
        $model = new ModalUser();

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $model->ceklogin($username);

        // Username tidak ditemukan
        if (!$user) {
            $session->setFlashdata([
                'icon'  => 'warning',
                'title' => 'Username Tidak Ditemukan',
                'msg'   => 'Silakan periksa kembali username Anda.'
            ]);
            return redirect()->to('/login');
        }

        // Cek status akun
        if ($user['Status'] != 'Aktif') {
            $session->setFlashdata([
                'icon'  => 'error',
                'title' => 'Akun Nonaktif',
                'msg'   => 'Silakan hubungi admin.'
            ]);
            return redirect()->to('/login');
        }

        // Cek password
        if (!password_verify($password, $user['Password'])) {
            $session->setFlashdata([
                'icon'  => 'error',
                'title' => 'Login Gagal',
                'msg'   => 'Password salah!'
            ]);
            return redirect()->to('/login');
        }

        // Simpan session
        $session->set([
            'IdUser'       => $user['IdUser'],
            'NamaLengkap'  => $user['NamaLengkap'],
            'Username'     => $user['Username'],
            'Email'        => $user['Email'],
            'Role'         => $user['Role'],
            'masuk'        => true
        ]);

        // Redirect sesuai role
        switch ($user['Role']) {

            case 'Admin':
                return redirect()->to('/dashboard');

            case 'Pimpinan':
                return redirect()->to('/dashboard');

            case 'Pelanggan':
                return redirect()->to('/homepage');

            default:
                session()->destroy();
                return redirect()->to('/login');
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/');
    }

    public function homepage()
    {
        return view('layout/homepage');
    }

    public function katalog()
    {
        $produkModel = new ModalProduk();
        $kemasanModel = new ModalKemasan();

        $data = [
            'kategori' => $produkModel->getKategori(),
            'kemasan'  => $kemasanModel->getKatalog()
        ];

        return view('layout/katalogproduk', $data);
    }
    public function registrasi()
    {
        return view('layout/registrasi');
    }

    public function simpanregistrasi()
    {
        $session = session();

        $userModel = new ModalUser();
        $pelangganModel = new ModalPelanggan();

        // Ambil data dari form
        $nama        = trim($this->request->getPost('NamaLengkap'));
        $username    = trim($this->request->getPost('Username'));
        $email       = trim($this->request->getPost('Email'));
        $password    = $this->request->getPost('Password');
        $konfirmasi  = $this->request->getPost('KonfirmasiPassword');
        $alamat      = trim($this->request->getPost('Alamat'));
        $nohp        = trim($this->request->getPost('NoHp'));

        // ============================
        // Validasi Data Kosong
        // ============================
        if (
            empty($nama) ||
            empty($username) ||
            empty($email) ||
            empty($password) ||
            empty($konfirmasi) ||
            empty($alamat) ||
            empty($nohp)
        ) {

            $session->setFlashdata([
                'icon'  => 'warning',
                'title' => 'Data Belum Lengkap',
                'msg'   => 'Silakan lengkapi semua data.'
            ]);

            return redirect()->back()->withInput();
        }

        // ============================
        // Password Tidak Sama
        // ============================
        if ($password != $konfirmasi) {

            $session->setFlashdata([
                'icon'  => 'error',
                'title' => 'Registrasi Gagal',
                'msg'   => 'Konfirmasi password tidak sesuai.'
            ]);

            return redirect()->back()->withInput();
        }

        // ============================
        // Username Sudah Dipakai
        // ============================
        if ($userModel->cekUsername($username)) {

            $session->setFlashdata([
                'icon'  => 'warning',
                'title' => 'Username Digunakan',
                'msg'   => 'Username sudah digunakan.'
            ]);

            return redirect()->back()->withInput();
        }

        // ============================
        // Email Sudah Dipakai
        // ============================
        if ($userModel->cekEmail($email)) {

            $session->setFlashdata([
                'icon'  => 'warning',
                'title' => 'Email Digunakan',
                'msg'   => 'Email sudah digunakan.'
            ]);

            return redirect()->back()->withInput();
        }

        // ============================
        // Generate ID
        // ============================
        $idUser = $userModel->generateId();
        $idPelanggan = $pelangganModel->generateId();

        // ============================
        // Transaction
        // ============================
        $db = \Config\Database::connect();
        $db->transBegin();

        try {

            // Simpan ke USER
            $userModel->insert([
                'IdUser'        => $idUser,
                'NamaLengkap'   => $nama,
                'Username'      => $username,
                'Email'         => $email,
                'Password'      => password_hash($password, PASSWORD_DEFAULT),
                'Role'          => 'Pelanggan',
                'Status'        => 'Aktif'
            ]);

            // Simpan ke Pelanggan
            $pelangganModel->insert([
                'IdPelanggan'   => $idPelanggan,
                'IdUser'        => $idUser,
                'NamaPelanggan' => $nama,
                'Alamat'        => $alamat,
                'NoHp'          => $nohp
            ]);

            if ($db->transStatus() === false) {

                $db->transRollback();

                $session->setFlashdata([
                    'icon'  => 'error',
                    'title' => 'Registrasi Gagal',
                    'msg'   => 'Data gagal disimpan.'
                ]);

                return redirect()->back()->withInput();
            }

            $db->transCommit();

            $session->setFlashdata([
                'icon'  => 'success',
                'title' => 'Registrasi Berhasil',
                'msg'   => 'Silakan login menggunakan akun Anda.'
            ]);

            return redirect()->to('/login');
        } catch (\Exception $e) {

            $db->transRollback();

            $session->setFlashdata([
                'icon'  => 'error',
                'title' => 'Registrasi Gagal',
                'msg'   => $e->getMessage()
            ]);

            return redirect()->back()->withInput();
        }
    }
}
