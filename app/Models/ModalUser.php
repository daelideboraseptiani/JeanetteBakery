<?php

namespace App\Models;

use CodeIgniter\Model;

class ModalUser extends Model
{
    protected $table = 'User';
    protected $primaryKey = 'IdUser';

    protected $allowedFields = [
        'IdUser',
        'NamaLengkap',
        'Email',
        'Username',
        'Password',
        'Role',
        'Status'
    ];

    // Generate ID otomatis
    public function generateId()
    {
        $query = $this->db->query(
            "SELECT MAX(SUBSTRING(IdUser, 4, 6)) AS nourut FROM User"
        );

        $row = $query->getRowArray();

        $nourut = (int) ($row['nourut'] ?? 0) + 1;

        return 'USR' . str_pad($nourut, 6, '0', STR_PAD_LEFT);
    }

    // Cek login berdasarkan username atau email
    public function ceklogin($login)
    {
        return $this->db->table('USER')
            ->groupStart()
            ->where('Username', $login)
            ->orWhere('Email', $login)
            ->groupEnd()
            ->get()
            ->getRowArray();
    }
}
