<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModalUser;

class UserController extends BaseController
{
    // Menampilkan data user
    public function datauser()
    {
        $model = new ModalUser();

        $data = [
            'user' => $model->findAll()
        ];

        return view('datamaster/v_datauser', $data);
    }

    // Form tambah user
    public function tambah()
    {
        $model = new ModalUser();

        $data = [
            'IdUser' => $model->generateId()
        ];

        return view('datamaster/tambahuser', $data);
    }

    // Simpan user baru
    public function simpan()
    {
        $model = new ModalUser();

        $rules = [
            'NamaLengkap' => 'required',
            'Email' => [
                'rules' => 'required|valid_email|is_unique[User.Email]',
                'errors' => [
                    'required' => 'Email wajib diisi.',
                    'valid_email' => 'Format email tidak valid.',
                    'is_unique' => 'Email sudah digunakan.'
                ]
            ],
            'Username' => [
                'rules' => 'required|is_unique[User.Username]',
                'errors' => [
                    'required' => 'Username wajib diisi.',
                    'is_unique' => 'Username sudah digunakan.'
                ]
            ],
            'Password' => [
                'rules' => 'required|min_length[8]',
                'errors' => [
                    'required' => 'Password wajib diisi.',
                    'min_length' => 'Password minimal 8 karakter.'
                ]
            ],
            'Role' => 'required',
            'Status' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data = [
            'IdUser'       => $this->request->getPost('IdUser'),
            'NamaLengkap'  => $this->request->getPost('NamaLengkap'),
            'Email'        => $this->request->getPost('Email'),
            'Username'     => $this->request->getPost('Username'),
            'Password'     => password_hash(
                $this->request->getPost('Password'),
                PASSWORD_DEFAULT
            ),
            'Role'         => $this->request->getPost('Role'),
            'Status'       => $this->request->getPost('Status')
        ];

        $model->insert($data);

        return redirect()->to(base_url('datauser'))
            ->with('success', 'Data user berhasil ditambahkan');
    }

    // Form edit user
    public function edit($IdUser)
    {
        $model = new ModalUser();

        $user = $model->find($IdUser);

        if (!$user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound(
                'Data user tidak ditemukan'
            );
        }

        $data = [
            'user' => $user
        ];

        return view('datamaster/edituser', $data);
    }

    // Update user
    public function update()
    {
        $model = new ModalUser();

        $IdUser = $this->request->getPost('IdUser');

        $data = [
            'NamaLengkap' => $this->request->getPost('NamaLengkap'),
            'Email'       => $this->request->getPost('Email'),
            'Username'    => $this->request->getPost('Username'),
            'Role'        => $this->request->getPost('Role'),
            'Status'      => $this->request->getPost('Status')
        ];

        // Jika password diisi
        $password = $this->request->getPost('Password');

        if (!empty($password)) {
            $data['Password'] = password_hash(
                $password,
                PASSWORD_DEFAULT
            );
        }

        $model->update($IdUser, $data);

        return redirect()->to(base_url('datauser'))
            ->with('success', 'Data user berhasil diperbarui');
    }

    // Hapus user
    public function hapus($IdUser)
    {
        $model = new ModalUser();

        $user = $model->find($IdUser);

        if (!$user) {
            return redirect()->to(base_url('datauser'))
                ->with('error', 'Data user tidak ditemukan');
        }

        $model->delete($IdUser);

        return redirect()->to(base_url('datauser'))
            ->with('success', 'Data user berhasil dihapus');
    }
}
