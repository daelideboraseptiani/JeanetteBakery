<?php

namespace App\Models;

use CodeIgniter\Model;

class ModalBahanBaku extends Model
{
    protected $table = 'BahanBaku';
    protected $primaryKey = 'IdBahanBaku';

    protected $allowedFields = [
        'IdBahanBaku',
        'NamaBahan',
        'Satuan',
        'Stok',
        'Harga',
        'Merk'
    ];

    public function generateId()
    {
        $query = $this->db->query("SELECT MAX(SUBSTRING(IdBahanBaku, 4, 6)) AS nourut FROM BahanBaku");
        $row = $query->getRowArray();
        $nourut = (int)$row['nourut'] + 1;
        return 'BBK' . str_pad($nourut, 6, '0', STR_PAD_LEFT);
    }
}
