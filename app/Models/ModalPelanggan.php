<?php

namespace App\Models;

use CodeIgniter\Model;

class ModalPelanggan extends Model
{
    protected $table = 'Pelanggan';
    protected $primaryKey = 'IdPelanggan';

    protected $allowedFields = [
        'IdPelanggan',
        'IdUser',
        'NamaPelanggan',
        'Alamat',
        'NoHp'
    ];

    public function generateId()
    {
        $query = $this->db->query("SELECT MAX(SUBSTRING(IdPelanggan, 4, 6)) AS nourut FROM Pelanggan");
        $row = $query->getRowArray();
        $nourut = (int)$row['nourut'] + 1;
        return 'PLG' . str_pad($nourut, 6, '0', STR_PAD_LEFT);
    }
}
