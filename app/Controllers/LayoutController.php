<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ModalUser;
use App\Models\ModalProduk;
use App\Models\ModalKemasan;

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
}
